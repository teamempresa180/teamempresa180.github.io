<?php
// api/import.php - Bulk CSV Import endpoint
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

if ($method !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Only POST allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['leads']) || !is_array($input['leads'])) {
    echo json_encode(['success' => false, 'error' => 'Missing leads array']);
    exit;
}

function calculateScore($lead) {
    $score = 10;
    if (!empty($lead['phone'])) $score += 20;
    if (!empty($lead['company'])) $score += 15;
    if (isset($lead['budget']) && floatval($lead['budget']) > 1000000) $score += 25;
    if (isset($lead['budget']) && floatval($lead['budget']) > 5000000) $score += 15;
    if (in_array($lead['status'] ?? 'nuevos', ['contactados', 'negociacion'])) $score += 15;
    if (($lead['status'] ?? '') === 'cerrados') $score = 100;
    return min(100, $score);
}

$imported = 0;
$skipped = 0;
$errors = [];

$stmt = $pdo->prepare('INSERT INTO leads (name, email, phone, company, message, source, budget, score, status, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
$interStmt = $pdo->prepare('INSERT INTO interactions (lead_id, type, content, date) VALUES (?, ?, ?, NOW())');

// Check for existing emails to detect duplicates
$existingEmails = [];
$res = $pdo->query("SELECT email FROM leads");
while ($row = $res->fetch()) {
    $existingEmails[] = strtolower($row['email']);
}

foreach ($input['leads'] as $i => $lead) {
    $name = trim($lead['name'] ?? '');
    $email = trim($lead['email'] ?? '');
    
    if (empty($name) || empty($email)) {
        $skipped++;
        continue;
    }
    
    // Duplicate detection
    if (in_array(strtolower($email), $existingEmails)) {
        $skipped++;
        $errors[] = "Fila " . ($i+1) . ": $email ya existe";
        continue;
    }
    
    $phone = trim($lead['phone'] ?? '');
    $company = trim($lead['company'] ?? '');
    $message = trim($lead['message'] ?? '');
    $source = trim($lead['source'] ?? 'Importación CSV');
    $budget = floatval($lead['budget'] ?? 0);
    $status = trim($lead['status'] ?? 'nuevos');
    
    // Normalize status
    $validStatuses = ['nuevos', 'contactados', 'negociacion', 'cerrados'];
    if (!in_array($status, $validStatuses)) $status = 'nuevos';
    
    $score = calculateScore($lead);
    
    try {
        $stmt->execute([$name, $email, $phone, $company, $message, $source, $budget, $score, $status]);
        $leadId = $pdo->lastInsertId();
        $interStmt->execute([$leadId, 'system', 'Lead importado desde archivo CSV']);
        $imported++;
        $existingEmails[] = strtolower($email);
    } catch (Exception $e) {
        $skipped++;
        $errors[] = "Fila " . ($i+1) . ": " . $e->getMessage();
    }
}

echo json_encode([
    'success' => true,
    'imported' => $imported,
    'skipped' => $skipped,
    'errors' => $errors
]);
?>
