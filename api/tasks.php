<?php
// api/tasks.php - CRUD endpoint for lead tasks
header('Content-Type: application/json');
require_once 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'unauthorized', 'message' => 'Acceso denegado. Inicie sesión.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'GET') {
    if (isset($_GET['lead_id'])) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM tasks WHERE lead_id = ? ORDER BY is_completed ASC, due_date ASC');
            $stmt->execute([$_GET['lead_id']]);
            echo json_encode($stmt->fetchAll());
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Missing lead_id']);
    }
} 
elseif ($method === 'POST') {
    if (isset($input['lead_id'], $input['title'], $input['due_date'])) {
        try {
            $stmt = $pdo->prepare('INSERT INTO tasks (lead_id, user_id, title, due_date, is_completed, created_at) VALUES (?, ?, ?, ?, 0, NOW())');
            $stmt->execute([
                $input['lead_id'],
                $_SESSION['user_id'],
                $input['title'],
                $input['due_date']
            ]);
            $task_id = $pdo->lastInsertId();
            
            // Log interaction
            $logStmt = $pdo->prepare('INSERT INTO interactions (lead_id, type, content, date) VALUES (?, "system", ?, NOW())');
            $logStmt->execute([
                $input['lead_id'],
                "Nueva tarea creada: '" . $input['title'] . "' vencimiento el " . date('d/m/Y H:i', strtotime($input['due_date']))
            ]);

            echo json_encode(['success' => true, 'id' => $task_id]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    }
} 
elseif ($method === 'PUT') {
    if (isset($input['id'])) {
        try {
            $is_completed = isset($input['is_completed']) ? intval($input['is_completed']) : 0;
            $stmt = $pdo->prepare('UPDATE tasks SET is_completed = ? WHERE id = ?');
            $stmt->execute([$is_completed, $input['id']]);
            
            // Log interaction if marked completed
            $taskQuery = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
            $taskQuery->execute([$input['id']]);
            $task = $taskQuery->fetch();
            
            if ($task) {
                $statusText = $is_completed ? "completada" : "marcada como pendiente";
                $logStmt = $pdo->prepare('INSERT INTO interactions (lead_id, type, content, date) VALUES (?, "system", ?, NOW())');
                $logStmt->execute([
                    $task['lead_id'],
                    "Tarea '" . $task['title'] . "' " . $statusText
                ]);
            }

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing id']);
    }
} 
elseif ($method === 'DELETE') {
    if (isset($input['id'])) {
        try {
            // Get lead_id for logging
            $taskQuery = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
            $taskQuery->execute([$input['id']]);
            $task = $taskQuery->fetch();
            
            $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
            $stmt->execute([$input['id']]);
            
            if ($task) {
                $logStmt = $pdo->prepare('INSERT INTO interactions (lead_id, type, content, date) VALUES (?, "system", ?, NOW())');
                $logStmt->execute([
                    $task['lead_id'],
                    "Tarea '" . $task['title'] . "' eliminada"
                ]);
            }
            
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing id']);
    }
} 
else {
    echo json_encode(['error' => 'Method not allowed']);
}
?>
