import os

new_admin_content = """<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM Avanzado - Grupo Empresarial 180°</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="innovative-features.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Reset & Base Setup */
    body {
      background: var(--bg-color, #050505);
      color: var(--text, #f5f2e8);
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    
    /* Variables for Score Colors */
    :root {
      --score-high: #10b981; /* Green */
      --score-med: #f59e0b;  /* Orange */
      --score-low: #ef4444;  /* Red */
    }

    /* Animations */
    @keyframes slideInRight {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes pulseGlow {
      0% { box-shadow: 0 0 5px rgba(212,175,55,0.2); }
      50% { box-shadow: 0 0 15px rgba(212,175,55,0.6); border-color: var(--gold); }
      100% { box-shadow: 0 0 5px rgba(212,175,55,0.2); }
    }
    @keyframes shimmer {
      0% { background-position: -400px 0; }
      100% { background-position: 400px 0; }
    }

    .stagger-item { opacity: 0; animation: fadeIn 0.4s ease forwards; }

    /* Login Overlay */
    #login-overlay {
      position: fixed; inset: 0; background: rgba(5, 5, 5, 0.95);
      z-index: 10000; display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      backdrop-filter: blur(20px); transition: opacity 0.5s ease;
    }
    .login-box {
      background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(212, 175, 55, 0.2);
      border-radius: 20px; padding: 50px; text-align: center;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .login-box h2 { color: var(--gold, #d4af37); margin-bottom: 20px; font-size: 2rem; }
    .login-input {
      background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1);
      color: white; padding: 15px 20px; border-radius: 8px; width: 100%; max-width: 300px;
      margin-bottom: 20px; outline: none; font-size: 1.1rem; transition: 0.3s;
    }
    .login-input:focus { border-color: var(--gold, #d4af37); }
    
    /* Layout */
    .dashboard { display: none; height: 100vh; grid-template-columns: 250px 1fr; }
    .sidebar {
      background: rgba(10, 10, 10, 0.9); border-right: 1px solid rgba(255,255,255,0.05);
      padding: 30px 20px; display: flex; flex-direction: column; gap: 30px;
    }
    .sidebar-logo { width: 150px; margin: 0 auto; }
    .nav-item {
      padding: 15px 20px; border-radius: 8px; color: #aaa; cursor: pointer;
      transition: all 0.3s ease; display: flex; align-items: center; gap: 15px; font-weight: 500;
    }
    .nav-item:hover, .nav-item.active { background: rgba(212, 175, 55, 0.1); color: var(--gold, #d4af37); }
    .main-content { padding: 40px; overflow-y: auto; position: relative; }
    
    /* Header & Stats */
    .header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; flex-wrap: wrap; gap: 20px; }
    .header h1 { font-size: 2.5rem; margin: 0; color: white; }
    .stats { display: flex; gap: 15px; flex-wrap: wrap; }
    .stat-card {
      background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);
      padding: 15px 25px; border-radius: 12px; display: flex; flex-direction: column; gap: 5px; min-width: 120px;
    }
    .stat-card span { color: #888; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-card strong { color: var(--gold, #d4af37); font-size: 1.8rem; }

    /* CRM Toolbar */
    .crm-toolbar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .search-input, .filter-select {
      background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1);
      color: white; padding: 12px 18px; border-radius: 8px; outline: none; font-size: 0.9rem;
    }
    .search-input:focus, .filter-select:focus { border-color: var(--gold, #d4af37); }
    .search-wrap { flex: 1; min-width: 250px; }
    .search-input { width: 100%; box-sizing: border-box; }
    
    .btn {
      display: inline-flex; align-items: center; justify-content: center;
      padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; transition: 0.2s;
    }
    .btn.primary { background: linear-gradient(135deg, #d4af37, #b8962e); color: #050505; }
    .btn.primary:hover { opacity: 0.9; transform: translateY(-1px); }
    .action-btn {
      padding: 6px 12px; border-radius: 6px; font-size: 0.8rem;
      border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.4); color: #ccc; cursor: pointer; transition: 0.2s;
    }
    .action-btn:hover { border-color: var(--gold, #d4af37); color: var(--gold, #d4af37); }

    /* Skeleton Loader */
    .skeleton {
      background: #1a1a1a;
      background-image: linear-gradient(to right, #1a1a1a 0%, #2a2a2a 20%, #1a1a1a 40%, #1a1a1a 100%);
      background-repeat: no-repeat;
      background-size: 800px 100%;
      animation: shimmer 1.5s infinite linear forwards;
    }
    .skeleton-card { height: 120px; border-radius: 8px; margin-bottom: 15px; }

    /* Table View */
    .table-wrap {
      background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);
      border-radius: 12px; overflow-x: auto; margin-bottom: 40px;
    }
    .leads-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
    .leads-table th { padding: 15px 20px; text-align: left; color: #aaa; font-weight: 500; font-size: 0.8rem; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.3); }
    .leads-table td { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.05); color: #eee; }
    .leads-table tr:hover td { background: rgba(255,255,255,0.02); }
    
    .badge { padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: bold; }
    .badge-nuevos { background: rgba(59, 130, 246, 0.2); color: #93c5fd; }
    .badge-contactados { background: rgba(245, 158, 11, 0.2); color: #fcd34d; }
    .badge-negociacion { background: rgba(168, 85, 247, 0.2); color: #d8b4fe; }
    .badge-cerrados { background: rgba(16, 185, 129, 0.2); color: #6ee7b7; }

    /* Score Indicator */
    .score-circle {
      display: inline-flex; align-items: center; justify-content: center;
      width: 32px; height: 32px; border-radius: 50%; font-size: 0.75rem; font-weight: bold;
      background: rgba(255,255,255,0.05); border: 2px solid;
    }

    /* Kanban Board */
    .kanban-board { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; overflow-x: auto; padding-bottom: 20px; }
    .kanban-column { background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; display: flex; flex-direction: column; min-height: 400px; }
    .column-header { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; }
    .column-header h3 { margin: 0; font-size: 1.05rem; color: #ddd; }
    .column-count { background: rgba(212, 175, 55, 0.2); color: var(--gold, #d4af37); padding: 2px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; }
    .column-body { padding: 15px; flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 15px; }
    
    /* Lead Card */
    .lead-card {
      background: rgba(20, 20, 20, 0.8); border: 1px solid rgba(255,255,255,0.08);
      padding: 15px; border-radius: 8px; cursor: grab; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      position: relative; overflow: hidden;
    }
    .lead-card:active { cursor: grabbing; transform: scale(0.98); }
    .lead-card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.4); border-color: rgba(212, 175, 55, 0.4); }
    /* Animated success pulse on drop */
    .lead-card.success-drop { animation: pulseGlow 1s ease; }
    
    .lead-card h4 { margin: 0 0 8px 0; color: white; font-size: 1rem; }
    .lead-card p { margin: 0 0 10px 0; font-size: 0.85rem; color: #aaa; line-height: 1.4; }
    .lead-footer { display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; color: #666; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 10px; }
    .tag { background: rgba(255,255,255,0.1); padding: 3px 8px; border-radius: 4px; color: #ddd; font-size: 0.7rem; }

    /* Offcanvas Side Panel (Replaces simple modal) */
    .offcanvas-backdrop {
      display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6);
      z-index: 1000; backdrop-filter: blur(4px); opacity: 0; transition: opacity 0.3s ease;
    }
    .offcanvas-backdrop.open { display: block; opacity: 1; }
    
    .offcanvas {
      position: fixed; top: 0; right: 0; bottom: 0; width: 600px; max-width: 100vw;
      background: #111; border-left: 1px solid rgba(212,175,55,0.2);
      box-shadow: -10px 0 40px rgba(0,0,0,0.5); z-index: 1001;
      transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
      display: flex; flex-direction: column;
    }
    .offcanvas.open { transform: translateX(0); }
    
    .offcanvas-header { padding: 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; }
    .offcanvas-title { color: var(--gold, #d4af37); font-size: 1.5rem; margin: 0; }
    .offcanvas-close { background: none; border: none; color: #aaa; font-size: 1.5rem; cursor: pointer; transition: 0.2s; }
    .offcanvas-close:hover { color: white; transform: rotate(90deg); }
    
    .offcanvas-body { padding: 30px; overflow-y: auto; flex: 1; }
    
    /* Tabs inside Offcanvas */
    .tabs { display: flex; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 25px; }
    .tab { padding: 10px 20px; cursor: pointer; color: #888; border-bottom: 2px solid transparent; transition: 0.2s; font-weight: 500; }
    .tab.active { color: var(--gold); border-bottom-color: var(--gold); }
    .tab-content { display: none; animation: fadeIn 0.3s; }
    .tab-content.active { display: block; }

    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; color: #aaa; margin-bottom: 5px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em;}
    .form-group input, .form-group select, .form-group textarea {
      width: 100%; box-sizing: border-box; padding: 12px; background: rgba(0,0,0,0.5);
      border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 6px; outline: none; font-size: 0.95rem; transition: 0.2s;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--gold, #d4af37); background: rgba(0,0,0,0.8); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

    /* Timeline */
    .timeline { position: relative; padding-left: 20px; margin-top: 20px; }
    .timeline::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px; background: rgba(255,255,255,0.1); }
    .timeline-item { position: relative; margin-bottom: 20px; }
    .timeline-icon { position: absolute; left: -26px; top: 0; width: 14px; height: 14px; border-radius: 50%; background: var(--gold); border: 3px solid #111; }
    .timeline-content { background: rgba(255,255,255,0.03); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); }
    .timeline-date { font-size: 0.75rem; color: #888; margin-bottom: 5px; display: block; }
    .interaction-input { display: flex; gap: 10px; margin-bottom: 20px; }
    
    .offcanvas-footer { padding: 20px 30px; border-top: 1px solid rgba(255,255,255,0.05); display: flex; gap: 15px; background: rgba(0,0,0,0.3); }

    /* Analytics View */
    #view-analytics { display: none; }
    .chart-container { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; padding: 20px; margin-bottom: 30px; }

  </style>
</head>
<body>

  <!-- Login Screen -->
  <div id="login-overlay">
    <div class="login-box">
      <h2>180° CRM Avanzado</h2>
      <p style="color: #aaa; margin-bottom: 30px;">Plataforma inteligente de gestión comercial.</p>
      <input type="password" id="admin-pass" class="login-input" placeholder="Contraseña de acceso" />
      <br>
      <button class="btn primary" onclick="login()">Acceder al Sistema</button>
      <p id="login-error" style="color: #ff4444; margin-top: 15px; display: none;">Contraseña incorrecta.</p>
      <p style="font-size: 0.8rem; color: #666; margin-top: 20px;">Pista: 123456789</p>
    </div>
  </div>

  <!-- Dashboard -->
  <div class="dashboard" id="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="./IMG/LOGO GRUPO EMPRESARIAL NEGATIVO.svg" alt="Logo" class="sidebar-logo">
      <div style="margin-top: 40px;">
        <div class="nav-item active" onclick="switchView('crm', this)">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
          Pipeline de Ventas
        </div>
        <div class="nav-item" onclick="switchView('analytics', this)">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
          Analíticas IA
        </div>
        <div class="nav-item" onclick="window.location.href='index.php'">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
          Volver a la Web
        </div>
      </div>
    </aside>

    <!-- Main Content wrapper -->
    <main class="main-content">
      
      <!-- CRM VIEW -->
      <div id="view-crm">
        <div class="header">
          <div>
            <h1>Pipeline Inteligente</h1>
            <p style="color: #888; margin-top: 5px;">Lead Scoring Automático y Gestión Avanzada.</p>
          </div>
          <div class="stats">
            <div class="stat-card"><span>Total Leads</span><strong id="stat-total">0</strong></div>
            <div class="stat-card"><span>Nuevos</span><strong id="stat-nuevos">0</strong></div>
            <div class="stat-card"><span>Cerrados</span><strong id="stat-cerrados" style="color: var(--score-high);">0</strong></div>
            <button class="btn primary" onclick="openOffcanvas()" style="margin-left: 10px; height: 100%;">+ Nuevo Prospecto</button>
          </div>
        </div>

        <div class="crm-toolbar">
          <div class="search-wrap">
            <input class="search-input" id="crm-search" placeholder="🔍 Buscar por nombre, email o fuente..." oninput="renderData()" />
          </div>
          <select class="filter-select" id="crm-filter" onchange="renderData()">
            <option value="">Todos los estados</option>
            <option value="nuevos">Nuevos</option>
            <option value="contactados">Contactados</option>
            <option value="negociacion">En Negociación</option>
            <option value="cerrados">Cerrados</option>
          </select>
          <button class="action-btn" style="padding: 10px 20px; font-size: 0.9rem;" onclick="exportCSV()">⬇ Exportar CSV</button>
        </div>

        <!-- Kanban View -->
        <h3 style="color: var(--gold); margin-top: 20px; margin-bottom: 15px;">Tablero Activo</h3>
        <div class="kanban-board">
          <div class="kanban-column" id="col-nuevos">
            <div class="column-header"><h3>Nuevos</h3><span class="column-count" id="count-nuevos">0</span></div>
            <div class="column-body" ondragover="allowDrop(event)" ondrop="drop(event, 'nuevos')"></div>
          </div>
          <div class="kanban-column" id="col-contactados">
            <div class="column-header"><h3>Contactados</h3><span class="column-count" id="count-contactados">0</span></div>
            <div class="column-body" ondragover="allowDrop(event)" ondrop="drop(event, 'contactados')"></div>
          </div>
          <div class="kanban-column" id="col-negociacion">
            <div class="column-header"><h3>En Negociación</h3><span class="column-count" id="count-negociacion">0</span></div>
            <div class="column-body" ondragover="allowDrop(event)" ondrop="drop(event, 'negociacion')"></div>
          </div>
          <div class="kanban-column" id="col-cerrados">
            <div class="column-header" style="border-top: 2px solid var(--score-high);"><h3>Cerrados</h3><span class="column-count" id="count-cerrados">0</span></div>
            <div class="column-body" ondragover="allowDrop(event)" ondrop="drop(event, 'cerrados')"></div>
          </div>
        </div>
      </div>

      <!-- ANALYTICS VIEW -->
      <div id="view-analytics">
        <div class="header">
          <div>
            <h1>Analíticas del Sistema</h1>
            <p style="color: #888; margin-top: 5px;">Estadísticas de conversión y estado de leads.</p>
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
          <div class="chart-container">
            <h3 style="color: #ddd; margin-top:0; text-align:center;">Embudo de Ventas</h3>
            <canvas id="funnelChart"></canvas>
          </div>
          <div class="chart-container">
            <h3 style="color: #ddd; margin-top:0; text-align:center;">Origen de Leads (Fuentes)</h3>
            <canvas id="sourceChart"></canvas>
          </div>
        </div>
      </div>

    </main>
  </div>

  <!-- Offcanvas Panel (Add / Edit Lead) -->
  <div class="offcanvas-backdrop" id="offcanvas-backdrop" onclick="closeOffcanvasOutside(event)"></div>
  <div class="offcanvas" id="offcanvas-panel">
    <div class="offcanvas-header">
      <h2 class="offcanvas-title" id="offcanvas-title-text">Nuevo Lead</h2>
      <button class="offcanvas-close" onclick="closeOffcanvas()">✕</button>
    </div>
    
    <div class="offcanvas-body">
      <div class="tabs" id="lead-tabs" style="display:none;">
        <div class="tab active" onclick="switchTab('info')">Información</div>
        <div class="tab" onclick="switchTab('timeline')">Historial & Notas</div>
      </div>

      <!-- Tab: Info -->
      <div id="tab-info" class="tab-content active">
        <div class="form-row">
          <div class="form-group"><label>Nombre Completo</label><input type="text" id="m-name" placeholder="Ej: María García" /></div>
          <div class="form-group"><label>Email</label><input type="email" id="m-email" placeholder="maria@empresa.com" /></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Teléfono (Opcional)</label><input type="text" id="m-phone" placeholder="+57 300 000 0000" /></div>
          <div class="form-group"><label>Empresa (Opcional)</label><input type="text" id="m-company" placeholder="Nombre de su empresa" /></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Presupuesto (COP)</label><input type="number" id="m-budget" placeholder="Ej: 2000000" /></div>
          <div class="form-group"><label>Estado</label>
            <select id="m-status">
              <option value="nuevos">Nuevo</option>
              <option value="contactados">Contactado</option>
              <option value="negociacion">En Negociación</option>
              <option value="cerrados">Cerrado</option>
            </select>
          </div>
        </div>
        <div class="form-group"><label>Fuente / Origen</label><input type="text" id="m-source" placeholder="Web, Referido, Facebook..." /></div>
        <div class="form-group"><label>Mensaje Inicial</label><textarea id="m-message" rows="4" placeholder="Requerimientos del cliente..."></textarea></div>
      </div>

      <!-- Tab: Timeline -->
      <div id="tab-timeline" class="tab-content">
        <div class="interaction-input">
          <input type="text" id="note-input" class="search-input" placeholder="Agregar nota de interacción..." />
          <button class="btn primary" style="padding: 10px 20px;" onclick="addInteraction()">Guardar</button>
        </div>
        <div class="timeline" id="timeline-container">
          <!-- Timeline items injected here -->
        </div>
      </div>
    </div>
    
    <div class="offcanvas-footer">
      <button class="btn-cancel" style="flex:1" onclick="closeOffcanvas()">Cancelar</button>
      <button class="btn-save" style="flex:2" onclick="saveLead()">Guardar Información</button>
    </div>
  </div>

  <script>
    let allLeads = [];
    let editingId = null;
    let chart1, chart2;

    const labelMap = { 'nuevos': 'Nuevo', 'contactados': 'Contactado', 'negociacion': 'En Negociación', 'cerrados': 'Cerrado' };

    // --- Login Logic ---
    function login() {
      const pass = document.getElementById('admin-pass').value;
      if(pass === '123456789') {
        document.getElementById('login-overlay').style.opacity = '0';
        setTimeout(() => {
          document.getElementById('login-overlay').style.display = 'none';
          document.getElementById('dashboard').style.display = 'grid';
          initApp();
        }, 500);
      } else {
        document.getElementById('login-error').style.display = 'block';
      }
    }
    document.getElementById('admin-pass').addEventListener('keypress', e => { if(e.key==='Enter') login(); });

    // --- App Init ---
    function initApp() {
      showSkeletons();
      loadLeads();
    }

    // --- View Switcher ---
    function switchView(viewId, el) {
      document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
      el.classList.add('active');
      document.getElementById('view-crm').style.display = 'none';
      document.getElementById('view-analytics').style.display = 'none';
      document.getElementById('view-' + viewId).style.display = 'block';
      
      if(viewId === 'analytics') renderCharts();
    }

    function switchTab(tabId) {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
      event.target.classList.add('active');
      document.getElementById('tab-' + tabId).classList.add('active');
      if (tabId === 'timeline') loadInteractions(editingId);
    }

    // --- Skeleton Loaders ---
    function showSkeletons() {
      ['nuevos', 'contactados', 'negociacion', 'cerrados'].forEach(status => {
        document.querySelector(`#col-${status} .column-body`).innerHTML = `
          <div class="skeleton skeleton-card"></div>
          <div class="skeleton skeleton-card"></div>
        `;
      });
    }

    // --- Data Fetch ---
    async function loadLeads() {
      try {
        const response = await fetch('api/leads.php');
        allLeads = await response.json();
        renderData();
      } catch (err) { console.error('Error fetching leads:', err); }
    }

    function renderData() {
      const q = (document.getElementById('crm-search').value || '').toLowerCase();
      const f = document.getElementById('crm-filter').value;
      const filtered = allLeads.filter(l => {
        const matchQ = !q || (l.name&&l.name.toLowerCase().includes(q)) || (l.email&&l.email.toLowerCase().includes(q)) || (l.source&&l.source.toLowerCase().includes(q));
        const matchF = !f || l.status === f;
        return matchQ && matchF;
      });
      renderKanban(filtered);
      updateStats(allLeads);
    }

    function getScoreColor(score) {
      if(score >= 70) return 'var(--score-high)';
      if(score >= 40) return 'var(--score-med)';
      return 'var(--score-low)';
    }

    function renderKanban(leads) {
      ['nuevos', 'contactados', 'negociacion', 'cerrados'].forEach(status => {
        document.querySelector(`#col-${status} .column-body`).innerHTML = '';
        document.getElementById(`count-${status}`).innerText = '0';
      });

      leads.forEach((lead, index) => {
        const card = document.createElement('div');
        card.className = 'lead-card stagger-item';
        card.style.animationDelay = `${index * 0.05}s`;
        card.id = 'lead_' + lead.id;
        card.draggable = true;
        card.ondragstart = drag;

        const scoreColor = getScoreColor(lead.score || 0);

        card.innerHTML = `
          <div style="display: flex; justify-content: space-between; align-items:center; margin-bottom: 12px;">
            <span class="tag">${esc(lead.source)}</span>
            <div class="score-circle" style="color: ${scoreColor}; border-color: ${scoreColor};" title="Lead Score">${lead.score||0}</div>
          </div>
          <h4>${esc(lead.name)}</h4>
          <p style="margin-bottom:5px;">${esc(lead.company||'Sin empresa')}</p>
          <div class="lead-footer">
            <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:140px;" title="${esc(lead.email)}">${esc(lead.email)}</span>
            <button onclick="editLead(${lead.id})" style="background:none; border:none; color: var(--gold); cursor:pointer; font-size:0.85rem; font-weight:bold;">Ver Info ➜</button>
          </div>
        `;
        
        const colBody = document.querySelector(`#col-${lead.status} .column-body`);
        if(colBody) {
          colBody.appendChild(card);
          document.getElementById(`count-${lead.status}`).innerText = parseInt(document.getElementById(`count-${lead.status}`).innerText) + 1;
        }
      });
    }

    function updateStats(leads) {
      document.getElementById('stat-total').innerText = leads.length;
      document.getElementById('stat-nuevos').innerText = leads.filter(l => l.status === 'nuevos').length;
      document.getElementById('stat-cerrados').innerText = leads.filter(l => l.status === 'cerrados').length;
    }

    // --- Offcanvas Logic ---
    function openOffcanvas(id = null) {
      editingId = id;
      const b = document.getElementById('offcanvas-backdrop');
      const p = document.getElementById('offcanvas-panel');
      const tabs = document.getElementById('lead-tabs');
      
      document.getElementById('offcanvas-title-text').textContent = id ? 'Gestión de Lead' : 'Nuevo Prospecto';
      
      if (id) {
        tabs.style.display = 'flex';
        const l = allLeads.find(x => parseInt(x.id) === parseInt(id));
        if (!l) return;
        document.getElementById('m-name').value = l.name || '';
        document.getElementById('m-email').value = l.email || '';
        document.getElementById('m-phone').value = l.phone || '';
        document.getElementById('m-company').value = l.company || '';
        document.getElementById('m-budget').value = l.budget || '';
        document.getElementById('m-source').value = l.source || '';
        document.getElementById('m-message').value = l.message || '';
        document.getElementById('m-status').value = l.status || 'nuevos';
      } else {
        tabs.style.display = 'none';
        ['m-name', 'm-email', 'm-phone', 'm-company', 'm-budget', 'm-source', 'm-message'].forEach(i => document.getElementById(i).value = '');
        document.getElementById('m-status').value = 'nuevos';
      }
      
      // Select first tab
      document.querySelectorAll('.tab')[0].click();
      
      b.classList.add('open');
      p.classList.add('open');
    }

    function closeOffcanvas() {
      document.getElementById('offcanvas-backdrop').classList.remove('open');
      document.getElementById('offcanvas-panel').classList.remove('open');
    }

    function closeOffcanvasOutside(e) { if(e.target.id === 'offcanvas-backdrop') closeOffcanvas(); }

    function editLead(id) { openOffcanvas(id); }

    async function saveLead() {
      const name = document.getElementById('m-name').value.trim();
      const email = document.getElementById('m-email').value.trim();
      if (!name || !email) { alert('Nombre y email obligatorios.'); return; }
      
      const payload = {
        name, email,
        phone: document.getElementById('m-phone').value.trim(),
        company: document.getElementById('m-company').value.trim(),
        budget: document.getElementById('m-budget').value.trim(),
        source: document.getElementById('m-source').value.trim(),
        message: document.getElementById('m-message').value.trim(),
        status: document.getElementById('m-status').value
      };

      try {
        if (editingId) {
          payload.id = editingId;
          const res = await fetch('api/leads.php', { method: 'PUT', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) });
          const data = await res.json();
          if(data.success) {
            const i = allLeads.findIndex(l => parseInt(l.id) === parseInt(editingId));
            if(i > -1) {
               allLeads[i] = { ...allLeads[i], ...payload, score: data.score };
            }
          }
        } else {
          const res = await fetch('api/leads.php', { method: 'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) });
          const data = await res.json();
          if(data.success) {
            payload.id = data.id;
            payload.score = data.score;
            payload.date = new Date().toISOString().replace('T', ' ').substring(0, 19);
            allLeads.unshift(payload);
          }
        }
        closeOffcanvas();
        renderData();
        if(chart1) renderCharts();
      } catch (e) { console.error(e); }
    }

    // --- Timeline Interactions ---
    async function loadInteractions(id) {
      if(!id) return;
      document.getElementById('timeline-container').innerHTML = '<p style="color:#888;">Cargando historial...</p>';
      try {
        const res = await fetch(`api/interactions.php?lead_id=${id}`);
        const interactions = await res.json();
        
        let html = '';
        interactions.forEach(int => {
           let typeColor = 'var(--gold)';
           if(int.type === 'status_change') typeColor = '#3b82f6';
           
           html += `
             <div class="timeline-item">
               <div class="timeline-icon" style="background: ${typeColor}"></div>
               <div class="timeline-content">
                 <span class="timeline-date">${fmtDate(int.date)}</span>
                 <p style="margin:0; font-size: 0.9rem;">${esc(int.content)}</p>
               </div>
             </div>
           `;
        });
        if(html === '') html = '<p style="color:#888;">No hay interacciones registradas.</p>';
        document.getElementById('timeline-container').innerHTML = html;
      } catch(e) { console.error(e); }
    }

    async function addInteraction() {
      const txt = document.getElementById('note-input').value.trim();
      if(!txt || !editingId) return;
      try {
        await fetch('api/interactions.php', {
          method: 'POST', headers: {'Content-Type':'application/json'},
          body: JSON.stringify({ lead_id: editingId, type: 'note', content: txt })
        });
        document.getElementById('note-input').value = '';
        loadInteractions(editingId); // Refresh timeline
      } catch(e) { console.error(e); }
    }


    // --- Drag & Drop ---
    function allowDrop(ev) { ev.preventDefault(); }
    function drag(ev) { ev.dataTransfer.setData("text", ev.target.id); }

    async function drop(ev, newStatus) {
      ev.preventDefault();
      const data = ev.dataTransfer.getData("text");
      const numericId = data.replace('lead_', '');
      
      const lead = allLeads.find(l => parseInt(l.id) === parseInt(numericId));
      if (lead && lead.status !== newStatus) {
        lead.status = newStatus;
        renderData(); // Re-render for visual immediate feedback
        
        // Add visual pulse effect on dropped card
        setTimeout(() => {
           const card = document.getElementById('lead_'+numericId);
           if(card) {
               card.classList.add('success-drop');
               setTimeout(()=> card.classList.remove('success-drop'), 1000);
           }
        }, 50);

        try {
          const res = await fetch('api/leads.php', { method: 'PUT', headers: {'Content-Type':'application/json'}, body: JSON.stringify({ id: numericId, status: newStatus }) });
          const d = await res.json();
          if(d.success) lead.score = d.score; // Update score visually next time
        } catch(e) { console.error(e); }
      }
    }

    // --- CSV Export ---
    function exportCSV() {
      const rows = allLeads.map(l => [ l.id, l.name, l.email, l.phone, l.company, l.budget, l.score, l.source, labelMap[l.status]||l.status, l.date ].map(v => `"${(v||'').toString().replace(/"/g, '""')}"`).join(','));
      const csv = ['ID,Nombre,Email,Telefono,Empresa,Presupuesto,Score,Fuente,Estado,Fecha', ...rows].join('\\n');
      const a = document.createElement('a'); a.href = 'data:text/csv;charset=utf-8,\\uFEFF' + encodeURIComponent(csv);
      a.download = `leads_crm.csv`; a.click();
    }

    // --- Utils ---
    function esc(s) { if (!s) return ''; const d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
    function fmtDate(d) { if (!d) return ''; const p = d.split(' '); if(p.length > 0) { const dP = p[0].split('-'); if(dP.length === 3) return `${dP[2]}/${dP[1]}/${dP[0]} ${p[1]||''}`; } return d; }

    // --- Analytics ---
    function renderCharts() {
      const counts = { nuevos:0, contactados:0, negociacion:0, cerrados:0 };
      const sources = {};
      allLeads.forEach(l => { 
          counts[l.status] = (counts[l.status]||0)+1; 
          sources[l.source] = (sources[l.source]||0)+1;
      });

      const ctx1 = document.getElementById('funnelChart').getContext('2d');
      if(chart1) chart1.destroy();
      chart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
          labels: ['Nuevos', 'Contactados', 'Negociación', 'Cerrados'],
          datasets: [{ label: 'Prospectos', data: [counts.nuevos, counts.contactados, counts.negociacion, counts.cerrados], backgroundColor: ['#3b82f6', '#f59e0b', '#a855f7', '#10b981'], borderRadius: 6 }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' } }, x: { grid: { display: false } } } }
      });

      const ctx2 = document.getElementById('sourceChart').getContext('2d');
      if(chart2) chart2.destroy();
      chart2 = new Chart(ctx2, {
        type: 'doughnut',
        data: {
          labels: Object.keys(sources),
          datasets: [{ data: Object.values(sources), backgroundColor: ['#d4af37', '#b8962e', '#f59e0b', '#10b981', '#3b82f6'], borderWidth: 0 }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { color: '#ccc' } } }, cutout: '70%' }
      });
    }

  </script>
</body>
</html>
"""

with open(r"c:\Users\lizar\Desktop\download\admin.php", "w", encoding="utf-8") as f:
    f.write(new_admin_content)

print("Admin v2 generated successfully!")
