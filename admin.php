<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM Inteligente - Grupo Empresarial 180°</title>
  <link rel="stylesheet" href="styles.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --gold: #d4af37;
      --gold-dark: #b8962e;
      --bg: #050505;
      --bg2: #0a0a0a;
      --bg3: #111;
      --border: rgba(255,255,255,0.07);
      --text: #f0ede4;
      --muted: #888;
      --score-high: #10b981;
      --score-med: #f59e0b;
      --score-low: #ef4444;
      --blue: #3b82f6;
      --purple: #a855f7;
    }
    * { box-sizing: border-box; }
    body { background: var(--bg); color: var(--text); font-family: 'Inter', system-ui, sans-serif; margin: 0; padding: 0; overflow-x: hidden; }

    /* ── Animations ────────────────── */
    @keyframes fadeIn      { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:none; } }
    @keyframes slideRight  { from { transform:translateX(100%); } to { transform:translateX(0); } }
    @keyframes shimmer     { 0% { background-position:-600px 0; } 100% { background-position:600px 0; } }
    @keyframes pulseGold   { 0%,100% { box-shadow:0 0 0 rgba(212,175,55,0); } 50% { box-shadow:0 0 18px rgba(212,175,55,0.55); } }
    @keyframes spin        { to { transform:rotate(360deg); } }
    @keyframes dropBounce  { 0%{transform:scale(1)} 40%{transform:scale(1.04)} 100%{transform:scale(1)} }
    .fade-in  { animation: fadeIn .35s ease forwards; }
    .stagger  { opacity:0; animation: fadeIn .4s ease forwards; }

    /* ── Login ────────────────────── */
    #login-overlay {
      position:fixed; inset:0; background:rgba(5,5,5,.96);
      z-index:10000; display:flex; align-items:center; justify-content:center;
      backdrop-filter:blur(24px); transition:opacity .5s;
    }
    .login-box {
      background:rgba(255,255,255,.025); border:1px solid rgba(212,175,55,.25);
      border-radius:24px; padding:55px 60px; text-align:center;
      box-shadow:0 30px 80px rgba(0,0,0,.6);
    }
    .login-box h2 { color:var(--gold); font-size:2.2rem; margin:0 0 8px; }
    .login-box p  { color:var(--muted); margin:0 0 32px; }
    .login-input  {
      background:rgba(0,0,0,.6); border:1px solid rgba(255,255,255,.12);
      color:#fff; padding:15px 22px; border-radius:10px; width:300px;
      outline:none; font-size:1.05rem; transition:.3s; display:block; margin:0 auto 20px;
    }
    .login-input:focus { border-color:var(--gold); }

    /* ── Layout ──────────────────── */
    .dashboard { display:none; height:100vh; grid-template-columns:240px 1fr; }
    .sidebar {
      background:var(--bg2); border-right:1px solid var(--border);
      padding:28px 16px; display:flex; flex-direction:column; gap:6px; overflow-y:auto;
    }
    .sidebar-logo { width:140px; margin:0 auto 36px; display:block; }
    .sidebar-section { font-size:.7rem; color:#444; text-transform:uppercase; letter-spacing:.1em; padding:16px 12px 6px; }
    .nav-item {
      padding:13px 16px; border-radius:10px; color:#999; cursor:pointer;
      transition:.25s; display:flex; align-items:center; gap:12px; font-size:.9rem; font-weight:500;
    }
    .nav-item:hover, .nav-item.active { background:rgba(212,175,55,.1); color:var(--gold); }
    .nav-item svg { flex-shrink:0; }

    .main-content { padding:36px 40px; overflow-y:auto; position:relative; }

    /* ── Header ──────────────────── */
    .page-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:32px; flex-wrap:wrap; gap:16px; }
    .page-header h1 { font-size:2.2rem; margin:0; background:linear-gradient(135deg,#fff,#ccc); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
    .page-header p  { color:var(--muted); margin:6px 0 0; font-size:.9rem; }

    /* ── Stat Cards ──────────────── */
    .stats-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:14px; margin-bottom:28px; }
    .stat-card {
      background:var(--bg3); border:1px solid var(--border); border-radius:14px;
      padding:18px 20px; transition:.3s;
    }
    .stat-card:hover { border-color:rgba(212,175,55,.25); transform:translateY(-2px); }
    .stat-card .label { font-size:.75rem; color:var(--muted); text-transform:uppercase; letter-spacing:.07em; margin-bottom:8px; }
    .stat-card .value { font-size:2rem; font-weight:700; color:var(--gold); }
    .stat-card .sub   { font-size:.75rem; color:var(--muted); margin-top:4px; }

    /* ── Toolbar ─────────────────── */
    .toolbar { display:flex; gap:10px; margin-bottom:20px; flex-wrap:wrap; align-items:center; }
    .search-box {
      flex:1; min-width:220px; background:rgba(0,0,0,.5); border:1px solid var(--border);
      color:#fff; padding:11px 16px; border-radius:9px; outline:none; font-size:.9rem; transition:.25s;
    }
    .search-box:focus { border-color:var(--gold); }
    .filter-select {
      background:rgba(0,0,0,.5); border:1px solid var(--border); color:#fff;
      padding:11px 14px; border-radius:9px; outline:none; font-size:.88rem; cursor:pointer;
    }

    /* ── Buttons ─────────────────── */
    .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; padding:11px 22px; border-radius:9px; font-weight:600; cursor:pointer; border:none; transition:.2s; font-size:.88rem; }
    .btn-primary { background:linear-gradient(135deg,var(--gold),var(--gold-dark)); color:#050505; }
    .btn-primary:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 6px 18px rgba(212,175,55,.3); }
    .btn-outline { background:transparent; border:1px solid var(--border); color:#ccc; }
    .btn-outline:hover { border-color:var(--gold); color:var(--gold); }
    .btn-danger  { background:rgba(239,68,68,.15); border:1px solid rgba(239,68,68,.3); color:#f87171; }
    .btn-danger:hover  { background:rgba(239,68,68,.25); }
    .btn-sm { padding:7px 14px; font-size:.8rem; border-radius:7px; }

    /* ── View Toggle ─────────────── */
    .view-toggle { display:flex; background:rgba(0,0,0,.4); border-radius:9px; border:1px solid var(--border); overflow:hidden; }
    .view-btn { padding:10px 16px; cursor:pointer; color:var(--muted); border:none; background:none; font-size:.85rem; transition:.2s; display:flex; align-items:center; gap:6px; }
    .view-btn.active { background:rgba(212,175,55,.15); color:var(--gold); }

    /* ── Table View ──────────────── */
    .table-wrap { background:var(--bg3); border:1px solid var(--border); border-radius:14px; overflow:hidden; margin-bottom:30px; }
    .leads-table { width:100%; border-collapse:collapse; }
    .leads-table th { padding:14px 18px; text-align:left; font-size:.75rem; color:var(--muted); text-transform:uppercase; letter-spacing:.07em; background:rgba(0,0,0,.3); border-bottom:1px solid var(--border); }
    .leads-table td { padding:14px 18px; border-bottom:1px solid rgba(255,255,255,.03); font-size:.88rem; vertical-align:middle; }
    .leads-table tr:last-child td { border-bottom:none; }
    .leads-table tr:hover td { background:rgba(255,255,255,.02); }
    .leads-table input[type="checkbox"] { accent-color:var(--gold); width:15px; height:15px; cursor:pointer; }

    /* ── Badges ──────────────────── */
    .badge { padding:4px 11px; border-radius:20px; font-size:.73rem; font-weight:600; white-space:nowrap; }
    .badge-nuevos      { background:rgba(59,130,246,.2); color:#93c5fd; }
    .badge-contactados { background:rgba(245,158,11,.2); color:#fcd34d; }
    .badge-negociacion { background:rgba(168,85,247,.2); color:#d8b4fe; }
    .badge-cerrados    { background:rgba(16,185,129,.2); color:#6ee7b7; }

    /* ── Score Ring ──────────────── */
    .score-ring {
      display:inline-flex; align-items:center; justify-content:center;
      width:34px; height:34px; border-radius:50%; font-size:.72rem; font-weight:700; border:2.5px solid;
    }

    /* ── Kanban ──────────────────── */
    .kanban-board { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; padding-bottom:20px; }
    .kanban-col { background:rgba(255,255,255,.015); border:1px solid var(--border); border-radius:14px; display:flex; flex-direction:column; min-height:420px; }
    .col-header { padding:18px 20px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .col-header h3 { margin:0; font-size:.95rem; }
    .col-count { background:rgba(212,175,55,.18); color:var(--gold); padding:2px 10px; border-radius:14px; font-size:.78rem; font-weight:700; }
    .col-body { padding:12px; flex:1; display:flex; flex-direction:column; gap:12px; overflow-y:auto; }
    .col-body.drag-over { background:rgba(212,175,55,.05); border:2px dashed rgba(212,175,55,.4); border-radius:10px; }

    /* ── Lead Card ───────────────── */
    .lead-card {
      background:rgba(18,18,18,.9); border:1px solid rgba(255,255,255,.07);
      padding:14px; border-radius:10px; cursor:grab; transition:all .25s cubic-bezier(.25,.8,.25,1); position:relative;
    }
    .lead-card:hover { transform:translateY(-3px); box-shadow:0 10px 24px rgba(0,0,0,.5); border-color:rgba(212,175,55,.35); }
    .lead-card:active { cursor:grabbing; transform:scale(.98); }
    .lead-card.drop-success { animation:pulseGold .8s ease, dropBounce .4s ease; }
    .lead-card h4 { margin:0 0 6px; font-size:.95rem; color:#fff; }
    .lead-card .company { font-size:.8rem; color:var(--muted); margin-bottom:10px; }
    .lead-footer { display:flex; justify-content:space-between; align-items:center; border-top:1px solid rgba(255,255,255,.05); padding-top:10px; margin-top:8px; }
    .tag { background:rgba(255,255,255,.08); padding:3px 9px; border-radius:5px; font-size:.72rem; color:#ccc; }

    /* ── Skeleton ────────────────── */
    .skeleton { background:#1a1a1a; background-image:linear-gradient(90deg,#1a1a1a 0%,#272727 40%,#1a1a1a 80%); background-size:600px 100%; animation:shimmer 1.4s infinite linear; border-radius:10px; }
    .sk-card { height:110px; margin-bottom:12px; }

    /* ── Offcanvas ───────────────── */
    .oc-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.65); z-index:1000; backdrop-filter:blur(4px); }
    .oc-backdrop.open { display:block; animation:fadeIn .3s; }
    .offcanvas {
      position:fixed; top:0; right:0; bottom:0; width:580px; max-width:100vw;
      background:#0e0e0e; border-left:1px solid rgba(212,175,55,.2);
      box-shadow:-15px 0 50px rgba(0,0,0,.6); z-index:1001;
      transform:translateX(100%); transition:transform .4s cubic-bezier(.2,.8,.2,1);
      display:flex; flex-direction:column;
    }
    .offcanvas.open { transform:translateX(0); }
    .oc-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
    .oc-title  { color:var(--gold); font-size:1.4rem; margin:0; }
    .oc-close  { background:none; border:none; color:var(--muted); font-size:1.4rem; cursor:pointer; transition:.25s; line-height:1; }
    .oc-close:hover { color:#fff; transform:rotate(90deg); }
    .oc-body   { flex:1; overflow-y:auto; padding:24px 28px; }
    .oc-footer { padding:18px 28px; border-top:1px solid var(--border); display:flex; gap:12px; background:rgba(0,0,0,.25); }

    /* ── Tabs ────────────────────── */
    .tabs { display:flex; border-bottom:1px solid var(--border); margin-bottom:24px; }
    .tab  { padding:10px 20px; cursor:pointer; color:var(--muted); border-bottom:2px solid transparent; transition:.2s; font-size:.88rem; font-weight:500; }
    .tab.active { color:var(--gold); border-bottom-color:var(--gold); }
    .tab-pane { display:none; animation:fadeIn .3s; }
    .tab-pane.active { display:block; }

    /* ── Form Fields ─────────────── */
    .form-row   { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .form-group { margin-bottom:16px; }
    .form-group label { display:block; color:var(--muted); font-size:.78rem; text-transform:uppercase; letter-spacing:.07em; margin-bottom:6px; }
    .form-group input, .form-group select, .form-group textarea {
      width:100%; padding:11px 14px; background:rgba(0,0,0,.55); border:1px solid var(--border);
      color:#fff; border-radius:8px; outline:none; font-size:.92rem; transition:.2s; resize:vertical;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color:var(--gold); background:rgba(0,0,0,.8); }

    /* ── Timeline ────────────────── */
    .timeline { padding-left:22px; position:relative; margin-top:10px; }
    .timeline::before { content:''; position:absolute; left:0; top:0; bottom:0; width:2px; background:var(--border); }
    .tl-item { position:relative; margin-bottom:18px; }
    .tl-dot { position:absolute; left:-29px; top:4px; width:14px; height:14px; border-radius:50%; background:var(--gold); border:3px solid #0e0e0e; }
    .tl-dot.note   { background:var(--blue); }
    .tl-dot.status { background:var(--purple); }
    .tl-body { background:rgba(255,255,255,.03); padding:12px 16px; border-radius:9px; border:1px solid var(--border); }
    .tl-date { font-size:.73rem; color:var(--muted); margin-bottom:4px; display:block; }
    .tl-text { font-size:.88rem; margin:0; }
    .note-box { display:flex; gap:10px; margin-bottom:20px; }

    /* ── CSV Import Modal ────────── */
    .modal-back { display:none; position:fixed; inset:0; background:rgba(0,0,0,.75); z-index:2000; align-items:center; justify-content:center; backdrop-filter:blur(6px); }
    .modal-back.open { display:flex; animation:fadeIn .3s; }
    .modal { background:#111; border:1px solid rgba(212,175,55,.25); border-radius:18px; padding:36px; width:620px; max-width:95vw; max-height:90vh; overflow-y:auto; box-shadow:0 30px 80px rgba(0,0,0,.7); animation:fadeIn .35s; }
    .modal h2 { color:var(--gold); margin:0 0 6px; }
    .modal p.sub { color:var(--muted); font-size:.88rem; margin:0 0 24px; }

    /* Drop Zone */
    .drop-zone {
      border:2px dashed rgba(212,175,55,.35); border-radius:14px; padding:50px 30px;
      text-align:center; cursor:pointer; transition:.3s; position:relative;
    }
    .drop-zone:hover, .drop-zone.dragover { border-color:var(--gold); background:rgba(212,175,55,.04); }
    .drop-zone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .drop-zone .dz-icon { font-size:2.8rem; display:block; margin-bottom:12px; }
    .drop-zone p { color:var(--muted); margin:0; font-size:.9rem; }
    .drop-zone p strong { color:var(--gold); }

    /* Import Preview Table */
    .import-preview { margin-top:22px; }
    .import-preview h3 { color:#ddd; font-size:1rem; margin-bottom:12px; }
    .preview-wrap { background:var(--bg3); border:1px solid var(--border); border-radius:10px; overflow:auto; max-height:250px; }
    .preview-table { width:100%; border-collapse:collapse; font-size:.82rem; }
    .preview-table th { background:rgba(0,0,0,.4); padding:10px 14px; text-align:left; color:var(--muted); border-bottom:1px solid var(--border); white-space:nowrap; }
    .preview-table td { padding:9px 14px; border-bottom:1px solid rgba(255,255,255,.03); white-space:nowrap; max-width:200px; overflow:hidden; text-overflow:ellipsis; }
    .preview-table tr:last-child td { border:none; }
    .preview-row-ok { border-left:3px solid var(--score-high); }
    .preview-row-skip { border-left:3px solid var(--score-low); opacity:.6; }

    /* Import Result */
    .import-result { background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.3); border-radius:10px; padding:18px 22px; margin-top:16px; }
    .import-result h3 { color:var(--score-high); margin:0 0 6px; }
    .import-result p { margin:3px 0; font-size:.88rem; color:#ccc; }

    /* Bulk action bar */
    .bulk-bar {
      display:none; align-items:center; gap:12px; background:rgba(212,175,55,.08);
      border:1px solid rgba(212,175,55,.25); border-radius:10px; padding:12px 18px; margin-bottom:14px;
    }
    .bulk-bar.visible { display:flex; animation:fadeIn .25s; }
    .bulk-label { color:var(--gold); font-weight:600; font-size:.9rem; flex:1; }

    /* Analytics */
    .analytics-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
    .chart-card { background:var(--bg3); border:1px solid var(--border); border-radius:14px; padding:24px; }
    .chart-card h3 { color:#ddd; margin:0 0 20px; font-size:1rem; }

    /* Hot Leads panel */
    .hot-leads { background:var(--bg3); border:1px solid rgba(239,68,68,.2); border-radius:14px; padding:22px; margin-top:24px; }
    .hot-leads h3 { color:#f87171; margin:0 0 16px; display:flex; align-items:center; gap:8px; font-size:1rem; }

    /* Toast notification */
    #toast-container { position:fixed; bottom:28px; right:28px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
    .toast {
      background:#1a1a1a; border:1px solid rgba(255,255,255,.1); border-radius:10px;
      padding:14px 20px; min-width:260px; font-size:.88rem; animation:fadeIn .3s;
      box-shadow:0 10px 30px rgba(0,0,0,.5); display:flex; align-items:center; gap:12px;
    }
    .toast.success { border-left:3px solid var(--score-high); }
    .toast.error   { border-left:3px solid var(--score-low); }
    .toast.info    { border-left:3px solid var(--gold); }
    .toast-icon { font-size:1.2rem; }
  </style>
</head>
<body>

<!-- DB Error Overlay -->
<div id="db-error-overlay" style="display:none; position:fixed; inset:0; background:#050505; z-index:20000; align-items:center; justify-content:center; flex-direction:column; gap:20px; text-align:center; backdrop-filter:blur(24px);">
  <span style="font-size:4rem;">⚠️</span>
  <h2 style="color:var(--score-low); font-size:2rem; margin:0;">Base de Datos Desconectada</h2>
  <p style="color:var(--muted); max-width:450px; line-height:1.6; margin:0 20px;" id="db-error-msg">
    No se pudo establecer conexión con MySQL. Asegúrate de tener XAMPP/MySQL encendido y la base de datos creada.
  </p>
  <div style="display:flex; gap:12px;">
    <button class="btn btn-primary" onclick="window.location.reload()">🔄 Reintentar Conexión</button>
    <a href="api/setup_db.php" target="_blank" class="btn btn-outline" style="text-decoration:none;">🔧 Configurar Base de Datos</a>
  </div>
</div>

<!-- Login -->
<div id="login-overlay">
  <div class="login-box" style="width: 420px; max-width: 90vw;">
    <h2>180° CRM Pro</h2>
    <p>Plataforma Inteligente de Gestión Comercial</p>
    <input type="email" id="admin-email" class="login-input" style="width:100%;" placeholder="Correo electrónico" value="admin@grupo180.com">
    <input type="password" id="admin-pass" class="login-input" style="width:100%;" placeholder="Contraseña de acceso">
    <button class="btn btn-primary" style="width:100%; margin-top: 10px;" onclick="login()">Acceder al Sistema</button>
    <p id="login-error" style="color:#f87171;margin-top:12px;display:none;"></p>
    <p style="font-size:.78rem;color:#555;margin-top:20px;">Email: admin@grupo180.com · Clave: 123456789</p>
  </div>
</div>

<!-- Dashboard -->
<div class="dashboard" id="dashboard">

  <!-- Sidebar -->
  <aside class="sidebar">
    <img src="./IMG/LOGO GRUPO EMPRESARIAL NEGATIVO.svg" alt="Logo" class="sidebar-logo">
    <div class="sidebar-section">Principal</div>
    <div class="nav-item active" onclick="switchView('pipeline',this)">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
      Pipeline CRM
    </div>
    <div class="nav-item" onclick="switchView('analytics',this)">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      Analíticas
    </div>
    <div class="sidebar-section" style="margin-top:10px;">Herramientas</div>
    <div class="nav-item" onclick="openImportModal()">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      Importar CSV
    </div>
    <div class="nav-item" onclick="exportCSV()">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      Exportar CSV
    </div>
    <div class="nav-item" onclick="logout()" style="margin-top:auto;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Cerrar Sesión
    </div>
    <div class="nav-item" onclick="window.location.href='index.php'">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
      Volver al Sitio Web
    </div>
  </aside>

  <!-- Main -->
  <main class="main-content">

    <!-- ═══════ PIPELINE VIEW ═══════ -->
    <div id="view-pipeline">
      <div class="page-header">
        <div>
          <h1>Pipeline de Ventas</h1>
          <p>Gestión inteligente de prospectos · Lead Scoring Automático</p>
        </div>
        <button class="btn btn-primary" onclick="openOffcanvas()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Nuevo Prospecto
        </button>
      </div>

      <!-- Stats -->
      <div class="stats-grid">
        <div class="stat-card"><div class="label">Total Leads</div><div class="value" id="st-total">0</div><div class="sub">En el sistema</div></div>
        <div class="stat-card"><div class="label">Nuevos</div><div class="value" id="st-nuevos">0</div><div class="sub">Sin contactar</div></div>
        <div class="stat-card"><div class="label">Negociación</div><div class="value" id="st-neg">0</div><div class="sub">En proceso</div></div>
        <div class="stat-card"><div class="label" >Cerrados</div><div class="value" id="st-cerrados" style="color:var(--score-high)">0</div><div class="sub">Conversiones</div></div>
        <div class="stat-card"><div class="label">Score Promedio</div><div class="value" id="st-score">0</div><div class="sub">Calidad de leads</div></div>
      </div>

      <!-- Toolbar -->
      <div class="toolbar">
        <input class="search-box" id="crm-search" placeholder="🔍 Buscar por nombre, empresa, email..." oninput="renderData()">
        <select class="filter-select" id="crm-filter" onchange="renderData()">
          <option value="">Todos los estados</option>
          <option value="nuevos">Nuevos</option>
          <option value="contactados">Contactados</option>
          <option value="negociacion">En Negociación</option>
          <option value="cerrados">Cerrados</option>
        </select>
        <select class="filter-select" id="score-filter" onchange="renderData()">
          <option value="">Todos los scores</option>
          <option value="high">🟢 Alto (70+)</option>
          <option value="med">🟡 Medio (40-69)</option>
          <option value="low">🔴 Bajo (&lt;40)</option>
        </select>
        <div class="view-toggle">
          <button class="view-btn active" id="btn-kanban" onclick="setViewMode('kanban')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="18"/><rect x="14" y="3" width="7" height="10"/></svg> Kanban
          </button>
          <button class="view-btn" id="btn-table" onclick="setViewMode('table')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg> Lista
          </button>
        </div>
      </div>

      <!-- Bulk Actions Bar -->
      <div class="bulk-bar" id="bulk-bar">
        <span class="bulk-label" id="bulk-label">0 seleccionados</span>
        <select class="filter-select" id="bulk-status-sel">
          <option value="">Cambiar estado a...</option>
          <option value="nuevos">Nuevo</option>
          <option value="contactados">Contactado</option>
          <option value="negociacion">En Negociación</option>
          <option value="cerrados">Cerrado</option>
        </select>
        <button class="btn btn-sm btn-outline" onclick="bulkChangeStatus()">Aplicar</button>
        <button class="btn btn-sm btn-danger" onclick="bulkDelete()">🗑 Eliminar</button>
        <button class="btn btn-sm btn-outline" onclick="clearSelection()">Cancelar</button>
      </div>

      <!-- Kanban View -->
      <div id="kanban-view">
        <div class="kanban-board">
          <div class="kanban-col" id="col-nuevos">
            <div class="col-header"><h3>Nuevos</h3><span class="col-count" id="cnt-nuevos">0</span></div>
            <div class="col-body" ondragover="onDragOver(event)" ondragleave="onDragLeave(event)" ondrop="onDrop(event,'nuevos')"></div>
          </div>
          <div class="kanban-col" id="col-contactados">
            <div class="col-header"><h3>Contactados</h3><span class="col-count" id="cnt-contactados">0</span></div>
            <div class="col-body" ondragover="onDragOver(event)" ondragleave="onDragLeave(event)" ondrop="onDrop(event,'contactados')"></div>
          </div>
          <div class="kanban-col" id="col-negociacion">
            <div class="col-header"><h3>En Negociación</h3><span class="col-count" id="cnt-negociacion">0</span></div>
            <div class="col-body" ondragover="onDragOver(event)" ondragleave="onDragLeave(event)" ondrop="onDrop(event,'negociacion')"></div>
          </div>
          <div class="kanban-col" id="col-cerrados">
            <div class="col-header" style="border-top:2px solid var(--score-high)"><h3>Cerrados ✓</h3><span class="col-count" id="cnt-cerrados">0</span></div>
            <div class="col-body" ondragover="onDragOver(event)" ondragleave="onDragLeave(event)" ondrop="onDrop(event,'cerrados')"></div>
          </div>
        </div>
      </div>

      <!-- Table View -->
      <div id="table-view" style="display:none">
        <div class="table-wrap">
          <table class="leads-table">
            <thead>
              <tr>
                <th><input type="checkbox" id="select-all" onchange="toggleSelectAll(this)"></th>
                <th>Lead / Empresa</th>
                <th>Contacto</th>
                <th>Score</th>
                <th>Fuente</th>
                <th>Presupuesto</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="leads-tbody"></tbody>
          </table>
          <div id="empty-state" style="display:none;text-align:center;padding:50px;color:var(--muted);">
            No hay leads que coincidan con los filtros.
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════ ANALYTICS VIEW ═══════ -->
    <div id="view-analytics" style="display:none">
      <div class="page-header">
        <div>
          <h1>Analíticas</h1>
          <p>Métricas de rendimiento y conversión</p>
        </div>
        <button class="btn btn-outline" onclick="renderCharts()">↺ Actualizar</button>
      </div>
      <div class="analytics-grid">
        <div class="chart-card"><h3>Embudo de Conversión</h3><canvas id="funnelChart"></canvas></div>
        <div class="chart-card"><h3>Distribución de Orígenes</h3><canvas id="sourceChart"></canvas></div>
      </div>
      <div class="analytics-grid" style="margin-top:24px;">
        <div class="chart-card"><h3>Distribución de Lead Score</h3><canvas id="scoreChart"></canvas></div>
        <div class="hot-leads">
          <h3><span>🔥</span> Leads Calientes (Score ≥ 70)</h3>
          <div id="hot-leads-list"></div>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- ═══ OFFCANVAS PANEL ═══ -->
<div class="oc-backdrop" id="oc-backdrop" onclick="closeOC()"></div>
<div class="offcanvas" id="offcanvas">
  <div class="oc-header">
    <h2 class="oc-title" id="oc-title">Nuevo Prospecto</h2>
    <button class="oc-close" onclick="closeOC()">✕</button>
  </div>
  <div class="oc-body">
    <div class="tabs" id="oc-tabs" style="display:none">
      <div class="tab active" onclick="switchTab('info',this)">Información</div>
      <div class="tab" onclick="switchTab('timeline',this)">Historial</div>
      <div class="tab" onclick="switchTab('tasks',this)">Tareas <span id="oc-task-badge" class="badge" style="background:var(--score-low); color:white; font-size:0.65rem; padding:2px 6px; margin-left:4px; display:none; vertical-align:middle;">0</span></div>
    </div>

    <!-- Tab Info -->
    <div id="pane-info" class="tab-pane active">
      <div class="form-row">
        <div class="form-group"><label>Nombre Completo *</label><input type="text" id="m-name" placeholder="María García"></div>
        <div class="form-group"><label>Email *</label><input type="email" id="m-email" placeholder="maria@empresa.com"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Teléfono</label><input type="text" id="m-phone" placeholder="+57 300 000 0000"></div>
        <div class="form-group"><label>Empresa</label><input type="text" id="m-company" placeholder="Nombre de la empresa"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Presupuesto (COP)</label><input type="number" id="m-budget" placeholder="2000000"></div>
        <div class="form-group"><label>Estado</label>
          <select id="m-status">
            <option value="nuevos">Nuevo</option>
            <option value="contactados">Contactado</option>
            <option value="negociacion">En Negociación</option>
            <option value="cerrados">Cerrado</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Fuente / Origen</label><input type="text" id="m-source" placeholder="Web, Referido, Facebook Ads..."></div>
        <div class="form-group"><label>Agente Responsable</label>
          <select id="m-assigned_to">
            <option value="">— Sin Asignar —</option>
          </select>
        </div>
      </div>
      <div class="form-group"><label>Mensaje / Notas iniciales</label><textarea id="m-message" rows="4" placeholder="Requerimientos del cliente..."></textarea></div>

      <!-- Live score preview -->
      <div id="score-preview" style="background:rgba(0,0,0,.3);border-radius:10px;padding:14px;border:1px solid var(--border);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
          <span style="font-size:.85rem;color:var(--muted)">Lead Score estimado</span>
          <span id="score-val" style="color:var(--gold);font-weight:700;font-size:1.2rem">10</span>
        </div>
        <div style="background:rgba(255,255,255,.06);border-radius:4px;height:6px;">
          <div id="score-bar" style="background:var(--gold);height:100%;border-radius:4px;width:10%;transition:.4s;"></div>
        </div>
      </div>
    </div>

    <!-- Tab Timeline -->
    <div id="pane-timeline" class="tab-pane">
      <div class="note-box">
        <input type="text" id="note-input" class="search-box" style="flex:1" placeholder="Escribir nota de seguimiento...">
        <button class="btn btn-primary btn-sm" onclick="addNote()">+ Agregar</button>
      </div>
      <div class="timeline" id="timeline-container">
        <p style="color:var(--muted);font-size:.88rem;">Cargando historial...</p>
      </div>
    </div>

    <!-- Tab Tareas -->
    <div id="pane-tasks" class="tab-pane">
      <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border); padding: 18px; border-radius: 12px; margin-bottom: 20px;">
        <h4 style="margin: 0 0 14px; font-size: 0.95rem; color: var(--gold); display: flex; align-items: center; gap: 8px;">
          <span>📅</span> Programar Recordatorio / Tarea
        </h4>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <input type="text" id="task-title-input" class="search-box" style="width: 100%;" placeholder="¿Qué se debe hacer? (ej: Llamar a cliente, enviar propuesta...)">
          <div style="display: flex; gap: 10px; align-items: center;">
            <div style="flex: 1; display: flex; flex-direction: column; gap: 4px;">
              <label style="font-size: 0.72rem; color: var(--muted); text-transform: uppercase;">Fecha Límite</label>
              <input type="datetime-local" id="task-due-input" class="filter-select" style="width: 100%; padding: 8px 12px;">
            </div>
            <button class="btn btn-primary" style="align-self: flex-end; padding: 9px 18px;" onclick="addTask()">+ Añadir</button>
          </div>
        </div>
      </div>
      
      <h4 style="font-size: 0.88rem; text-transform: uppercase; color: var(--muted); letter-spacing: 0.05em; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
        <span>Lista de Tareas</span>
        <span id="task-summary-text" style="text-transform: none; font-size: 0.78rem; font-weight: normal; color: var(--muted);">0 de 0 completadas</span>
      </h4>
      <div id="tasks-container" style="display: flex; flex-direction: column; gap: 10px;">
        <p style="color:var(--muted); font-size: 0.88rem;">Cargando tareas...</p>
      </div>
    </div>
  </div>
  <div class="oc-footer">
    <button class="btn btn-outline" style="flex:1" onclick="closeOC()">Cancelar</button>
    <button class="btn btn-primary" style="flex:2" onclick="saveLead()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      Guardar Prospecto
    </button>
  </div>
</div>

<!-- ═══ CSV IMPORT MODAL ═══ -->
<div class="modal-back" id="import-modal">
  <div class="modal">
    <h2>📂 Importar Leads desde CSV</h2>
    <p class="sub">Arrastra o selecciona un archivo CSV. El sistema detectará automáticamente las columnas y evitará duplicados.</p>

    <div class="drop-zone" id="drop-zone">
      <input type="file" id="csv-file" accept=".csv" onchange="handleFile(this.files[0])">
      <span class="dz-icon">📄</span>
      <p><strong>Haz clic o arrastra</strong> tu archivo CSV aquí</p>
      <p style="margin-top:6px;font-size:.8rem;">Columnas esperadas: name, email, phone, company, source, budget, status, message</p>
    </div>

    <!-- Column Mapper -->
    <div id="col-mapper" style="display:none;margin-top:20px;">
      <h3 style="color:#ddd;font-size:.95rem;margin-bottom:12px;">Mapear Columnas del CSV</h3>
      <div id="mapper-rows" style="display:grid;grid-template-columns:1fr 1fr;gap:10px;"></div>
    </div>

    <div class="import-preview" id="import-preview" style="display:none;">
      <h3 id="preview-title">Vista previa</h3>
      <div class="preview-wrap">
        <table class="preview-table">
          <thead id="preview-head"></thead>
          <tbody id="preview-body"></tbody>
        </table>
      </div>
    </div>

    <div id="import-result" style="display:none;" class="import-result">
      <h3>✅ Importación Completada</h3>
      <p id="result-text"></p>
    </div>

    <div style="display:flex;gap:12px;margin-top:24px;">
      <button class="btn btn-outline" style="flex:1" onclick="closeImportModal()">Cancelar</button>
      <button class="btn btn-primary" style="flex:2" id="import-btn" onclick="doImport()" disabled>
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        Importar Leads
      </button>
    </div>
  </div>
</div>

<!-- Toast Container -->
<div id="toast-container"></div>

<script>
// ═══════════════════════════════════════════════
//  STATE
// ═══════════════════════════════════════════════
let allLeads = [];
let editingId = null;
let viewMode = 'kanban';
let selectedIds = new Set();
let parsedCSVData = [];
let csvHeaders = [];
let colMap = {};
let charts = {};

const FIELDS = ['name','email','phone','company','source','budget','status','message','assigned_to'];
const LABELS = { nuevos:'Nuevo', contactados:'Contactado', negociacion:'En Negociación', cerrados:'Cerrado' };

// ═══════════════════════════════════════════════
//  LOGIN
// ═══════════════════════════════════════════════
function login() {
  const p = document.getElementById('admin-pass').value;
  if(p === '123456789') {
    document.getElementById('login-overlay').style.opacity = '0';
    setTimeout(() => {
      document.getElementById('login-overlay').style.display = 'none';
      document.getElementById('dashboard').style.display = 'grid';
      initApp();
    }, 500);
  } else {
    document.getElementById('login-error').style.display = 'block';
    document.getElementById('admin-pass').style.borderColor = 'var(--score-low)';
  }
}
document.getElementById('admin-pass').addEventListener('keypress', e => { if(e.key==='Enter') login(); });

// ═══════════════════════════════════════════════
//  INIT
// ═══════════════════════════════════════════════
async function initApp() { showSkeletons(); await loadAgents(); loadLeads(); }

// ═══════════════════════════════════════════════
//  VIEW SWITCHER
// ═══════════════════════════════════════════════
function switchView(view, el) {
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  el.classList.add('active');
  ['pipeline','analytics'].forEach(v => document.getElementById('view-'+v).style.display = v===view?'block':'none');
  if(view === 'analytics') renderCharts();
}

function setViewMode(mode) {
  viewMode = mode;
  document.getElementById('kanban-view').style.display = mode==='kanban' ? 'block' : 'none';
  document.getElementById('table-view').style.display  = mode==='table'  ? 'block' : 'none';
  document.getElementById('btn-kanban').classList.toggle('active', mode==='kanban');
  document.getElementById('btn-table').classList.toggle('active', mode==='table');
  renderData();
}

// ═══════════════════════════════════════════════
//  SKELETON
// ═══════════════════════════════════════════════
function showSkeletons() {
  ['nuevos','contactados','negociacion','cerrados'].forEach(s => {
    document.querySelector(`#col-${s} .col-body`).innerHTML = '<div class="skeleton sk-card"></div><div class="skeleton sk-card"></div>';
  });
}

// ═══════════════════════════════════════════════
//  SCORE
// ═══════════════════════════════════════════════
function scoreColor(s) {
  if(s>=70) return 'var(--score-high)';
  if(s>=40) return 'var(--score-med)';
  return 'var(--score-low)';
}
function calcLocalScore(data) {
  let s = 10;
  if(data.phone?.trim()) s += 20;
  if(data.company?.trim()) s += 15;
  const b = parseFloat(data.budget||0);
  if(b > 1000000) s += 25;
  if(b > 5000000) s += 15;
  if(['contactados','negociacion'].includes(data.status)) s += 15;
  if(data.status === 'cerrados') s = 100;
  return Math.min(100, s);
}
function updateScorePreview() {
  const d = {
    phone: document.getElementById('m-phone').value,
    company: document.getElementById('m-company').value,
    budget: document.getElementById('m-budget').value,
    status: document.getElementById('m-status').value
  };
  const s = calcLocalScore(d);
  document.getElementById('score-val').textContent = s;
  document.getElementById('score-bar').style.width = s + '%';
  document.getElementById('score-bar').style.background = scoreColor(s);
}
['m-phone','m-company','m-budget','m-status'].forEach(id => {
  document.getElementById(id).addEventListener('input', updateScorePreview);
  document.getElementById(id).addEventListener('change', updateScorePreview);
});

// ═══════════════════════════════════════════════
//  DATA
// ═══════════════════════════════════════════════
async function loadLeads() {
  try {
    const r = await fetch('api/leads.php');
    allLeads = await r.json();
    if (!Array.isArray(allLeads)) allLeads = [];
    renderData();
  } catch(e) { showToast('Error al cargar leads','error'); }
}

function getFiltered() {
  const q = (document.getElementById('crm-search').value||'').toLowerCase();
  const f = document.getElementById('crm-filter').value;
  const sf = document.getElementById('score-filter').value;
  return allLeads.filter(l => {
    const mQ = !q || [l.name,l.email,l.company,l.source].some(v => v&&v.toLowerCase().includes(q));
    const mF = !f || l.status === f;
    const sc = parseInt(l.score||0);
    const mS = !sf || (sf==='high'&&sc>=70) || (sf==='med'&&sc>=40&&sc<70) || (sf==='low'&&sc<40);
    return mQ && mF && mS;
  });
}

function renderData() {
  const leads = getFiltered();
  if(viewMode==='kanban') renderKanban(leads);
  else renderTable(leads);
  updateStats();
}

// ═══════════════════════════════════════════════
//  KANBAN
// ═══════════════════════════════════════════════
function renderKanban(leads) {
  ['nuevos','contactados','negociacion','cerrados'].forEach(s => {
    document.querySelector(`#col-${s} .col-body`).innerHTML = '';
    document.getElementById(`cnt-${s}`).textContent = '0';
  });
  leads.forEach((lead, i) => {
    const sc = parseInt(lead.score||0);
    const c = scoreColor(sc);
    const agentName = getAgentName(lead.assigned_to);
    const agentInitials = agentName ? agentName.split(' ').slice(0,2).map(n=>n[0]).join('').toUpperCase() : '';
    const agentBadge = agentName ? `<div title="Asignado a: ${esc(agentName)}" style="width:24px;height:24px;border-radius:50%;background:rgba(212,175,55,.15);color:var(--gold);display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:bold;border:1px solid rgba(212,175,55,.3);">${agentInitials}</div>` : '';

    const pendingTasks = parseInt(lead.pending_tasks||0);
    const totalTasks = parseInt(lead.total_tasks||0);
    const taskBadge = totalTasks > 0 ? `<div title="Tareas: ${totalTasks - pendingTasks}/${totalTasks} completadas" style="font-size:0.7rem; color:${pendingTasks>0 ? 'var(--score-med)' : 'var(--score-high)'}; background:rgba(255,255,255,0.05); padding:2px 6px; border-radius:4px; display:inline-flex; align-items:center; gap:4px;">📋 ${totalTasks - pendingTasks}/${totalTasks}</div>` : '';

    const card = document.createElement('div');
    card.className = 'lead-card stagger';
    card.id = 'card_'+lead.id;
    card.style.animationDelay = (i*0.04)+'s';
    card.draggable = true;
    card.ondragstart = e => { e.dataTransfer.setData('text', lead.id); };
    card.innerHTML = `
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
        <div style="display:flex; gap:8px; align-items:center;">
          <span class="tag">${esc(lead.source||'—')}</span>
          ${agentBadge}
        </div>
        <div class="score-ring" style="color:${c};border-color:${c}">${sc}</div>
      </div>
      <h4>${esc(lead.name)}</h4>
      <p class="company">${esc(lead.company||'Sin empresa')} ${lead.budget>0?'· $'+fmtNum(lead.budget):''}</p>
      <div class="lead-footer">
        <span style="color:var(--muted);font-size:.78rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:140px" title="${esc(lead.email)}">${esc(lead.email)}</span>
        <div style="display:flex; gap:8px; align-items:center;">
          ${taskBadge}
          <button onclick="openOffcanvas(${lead.id})" style="background:none;border:none;color:var(--gold);cursor:pointer;font-size:.82rem;font-weight:600">Ver ➜</button>
        </div>
      </div>`;
    const body = document.querySelector(`#col-${lead.status} .col-body`);
    if(body) {
      body.appendChild(card);
      document.getElementById(`cnt-${lead.status}`).textContent = parseInt(document.getElementById(`cnt-${lead.status}`).textContent)+1;
    }
  });
}

// ═══════════════════════════════════════════════
//  TABLE
// ═══════════════════════════════════════════════
function renderTable(leads) {
  const tbody = document.getElementById('leads-tbody');
  document.getElementById('empty-state').style.display = leads.length ? 'none' : 'block';
  tbody.innerHTML = leads.map(l => {
    const sc = parseInt(l.score||0);
    const c = scoreColor(sc);
    const checked = selectedIds.has(parseInt(l.id)) ? 'checked' : '';
    const agentName = getAgentName(l.assigned_to);
    const pendingTasks = parseInt(l.pending_tasks||0);
    const totalTasks = parseInt(l.total_tasks||0);
    
    return `<tr>
      <td><input type="checkbox" ${checked} onchange="toggleSelect(${l.id},this)"></td>
      <td>
        <div style="font-weight:600;color:#fff">${esc(l.name)}</div>
        <div style="font-size:.78rem;color:var(--muted)">${esc(l.company||'—')}</div>
        ${totalTasks > 0 ? `<div style="font-size:0.75rem; color:${pendingTasks>0 ? 'var(--score-med)' : 'var(--score-high)'}; margin-top:4px;">📋 ${totalTasks - pendingTasks}/${totalTasks} tareas</div>` : ''}
      </td>
      <td>
        <div style="font-size:.85rem">${esc(l.email)}</div>
        <div style="font-size:.78rem;color:var(--muted)">${esc(l.phone||'—')}</div>
      </td>
      <td><div class="score-ring" style="color:${c};border-color:${c};font-size:.7rem">${sc}</div></td>
      <td style="color:var(--muted);font-size:.85rem">
        ${esc(l.source||'—')}
        ${agentName ? `<div style="font-size:0.75rem; color:var(--gold); margin-top:4px;">👤 ${esc(agentName)}</div>` : ''}
      </td>
      <td style="font-size:.85rem">${l.budget>0?'$'+fmtNum(l.budget):'—'}</td>
      <td><span class="badge badge-${l.status}">${LABELS[l.status]||l.status}</span></td>
      <td style="font-size:.82rem;color:var(--muted)">${fmtDate(l.date)}</td>
      <td style="white-space:nowrap;display:flex;gap:6px;">
        <button class="btn btn-sm btn-outline" onclick="openOffcanvas(${l.id})">Editar</button>
        <button class="btn btn-sm btn-danger" onclick="deleteLead(${l.id})">✕</button>
      </td>
    </tr>`;
  }).join('');
}

// ═══════════════════════════════════════════════
//  STATS
// ═══════════════════════════════════════════════
function updateStats() {
  document.getElementById('st-total').textContent = allLeads.length;
  document.getElementById('st-nuevos').textContent = allLeads.filter(l=>l.status==='nuevos').length;
  document.getElementById('st-neg').textContent = allLeads.filter(l=>l.status==='negociacion').length;
  document.getElementById('st-cerrados').textContent = allLeads.filter(l=>l.status==='cerrados').length;
  const avg = allLeads.length ? Math.round(allLeads.reduce((a,l)=>a+(parseInt(l.score)||0),0)/allLeads.length) : 0;
  document.getElementById('st-score').textContent = avg;
}

// ═══════════════════════════════════════════════
//  BULK ACTIONS
// ═══════════════════════════════════════════════
function toggleSelect(id, cb) {
  id = parseInt(id);
  if(cb.checked) selectedIds.add(id); else selectedIds.delete(id);
  updateBulkBar();
}
function toggleSelectAll(cb) {
  document.querySelectorAll('#leads-tbody input[type="checkbox"]').forEach(c => {
    c.checked = cb.checked;
    const id = parseInt(c.closest('tr').querySelector('.btn').getAttribute('onclick').match(/\d+/)[0]);
    if(cb.checked) selectedIds.add(id); else selectedIds.delete(id);
  });
  updateBulkBar();
}
function updateBulkBar() {
  const bar = document.getElementById('bulk-bar');
  if(selectedIds.size > 0) { bar.classList.add('visible'); document.getElementById('bulk-label').textContent = selectedIds.size + ' seleccionados'; }
  else { bar.classList.remove('visible'); }
}
function clearSelection() { selectedIds.clear(); document.querySelectorAll('#leads-tbody input[type="checkbox"]').forEach(c=>c.checked=false); document.getElementById('select-all').checked=false; updateBulkBar(); }

async function bulkChangeStatus() {
  const ns = document.getElementById('bulk-status-sel').value;
  if(!ns) { showToast('Selecciona un estado','error'); return; }
  for(const id of selectedIds) {
    await fetch('api/leads.php', { method:'PUT', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id, status:ns}) });
    const l = allLeads.find(x=>parseInt(x.id)===id);
    if(l) l.status = ns;
  }
  showToast(`${selectedIds.size} leads actualizados`,'success');
  clearSelection(); renderData();
}

async function bulkDelete() {
  if(!confirm(`¿Eliminar ${selectedIds.size} leads seleccionados?`)) return;
  for(const id of selectedIds) {
    await fetch('api/leads.php', { method:'DELETE', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id}) });
  }
  allLeads = allLeads.filter(l => !selectedIds.has(parseInt(l.id)));
  showToast(`${selectedIds.size} leads eliminados`,'info');
  clearSelection(); renderData();
}

// ═══════════════════════════════════════════════
//  DRAG & DROP
// ═══════════════════════════════════════════════
function onDragOver(e) { e.preventDefault(); e.currentTarget.classList.add('drag-over'); }
function onDragLeave(e) { e.currentTarget.classList.remove('drag-over'); }
async function onDrop(e, newStatus) {
  e.preventDefault(); e.currentTarget.classList.remove('drag-over');
  const id = e.dataTransfer.getData('text');
  const lead = allLeads.find(l => parseInt(l.id)===parseInt(id));
  if(!lead || lead.status===newStatus) return;
  lead.status = newStatus;
  renderData();
  setTimeout(() => { const c = document.getElementById('card_'+id); if(c) { c.classList.add('drop-success'); setTimeout(()=>c.classList.remove('drop-success'),900); } }, 30);
  const r = await fetch('api/leads.php', { method:'PUT', headers:{'Content-Type':'application/json'}, body:JSON.stringify({id, status:newStatus}) });
  const d = await r.json();
  if(d.success && d.score !== undefined) lead.score = d.score;
  showToast('Estado actualizado → '+LABELS[newStatus],'success');
}

// ═══════════════════════════════════════════════
//  OFFCANVAS
// ═══════════════════════════════════════════════
function openOffcanvas(id=null) {
  editingId = id;
  document.getElementById('oc-title').textContent = id ? 'Editar Prospecto' : 'Nuevo Prospecto';
  document.getElementById('oc-tabs').style.display = id ? 'flex' : 'none';
  switchTab('info', document.querySelector('.tab'));
  if(id) {
    const l = allLeads.find(x=>parseInt(x.id)===parseInt(id));
    if(!l) return;
    document.getElementById('m-name').value = l.name||'';
    document.getElementById('m-email').value = l.email||'';
    document.getElementById('m-phone').value = l.phone||'';
    document.getElementById('m-company').value = l.company||'';
    document.getElementById('m-budget').value = l.budget||'';
    document.getElementById('m-source').value = l.source||'';
    document.getElementById('m-assigned_to').value = l.assigned_to||'';
    document.getElementById('m-message').value = l.message||'';
    document.getElementById('m-status').value = l.status||'nuevos';
  } else {
    FIELDS.forEach(f => { const el=document.getElementById('m-'+f); if(el) el.value=''; });
    document.getElementById('m-status').value = 'nuevos';
  }
  updateScorePreview();
  document.getElementById('oc-backdrop').classList.add('open');
  document.getElementById('offcanvas').classList.add('open');
}
function closeOC() {
  document.getElementById('oc-backdrop').classList.remove('open');
  document.getElementById('offcanvas').classList.remove('open');
}

function switchTab(tab, el) {
  document.querySelectorAll('.tab').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));
  if(el) el.classList.add('active'); else document.querySelector('.tab').classList.add('active');
  document.getElementById('pane-'+tab).classList.add('active');
  if(tab==='timeline') loadTimeline(editingId);
  if(tab==='tasks') loadTasks(editingId);
}

// ═══════════════════════════════════════════════
//  SAVE LEAD
// ═══════════════════════════════════════════════
async function saveLead() {
  const name = document.getElementById('m-name').value.trim();
  const email = document.getElementById('m-email').value.trim();
  if(!name||!email) { showToast('Nombre y email son obligatorios','error'); return; }
  const payload = {
    name, email,
    phone: document.getElementById('m-phone').value.trim(),
    company: document.getElementById('m-company').value.trim(),
    budget: document.getElementById('m-budget').value.trim(),
    source: document.getElementById('m-source').value.trim(),
    assigned_to: document.getElementById('m-assigned_to').value,
    message: document.getElementById('m-message').value.trim(),
    status: document.getElementById('m-status').value
  };
  try {
    if(editingId) {
      payload.id = editingId;
      const r = await fetch('api/leads.php',{method:'PUT',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
      const d = await r.json();
      if(d.success) {
        const i = allLeads.findIndex(l=>parseInt(l.id)===parseInt(editingId));
        if(i>-1) {
          if (allLeads[i].assigned_to != payload.assigned_to) {
            const oldAgent = getAgentName(allLeads[i].assigned_to) || 'Sin Asignar';
            const newAgent = getAgentName(payload.assigned_to) || 'Sin Asignar';
            await fetch('api/interactions.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({lead_id:editingId,type:'status_change',content:`Agente reasignado: ${oldAgent} ➜ ${newAgent}`})});
          }
          allLeads[i] = {...allLeads[i],...payload, score: d.score};
        }
        showToast('Prospecto actualizado','success');
      }
    } else {
      const r = await fetch('api/leads.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
      const d = await r.json();
      if(d.success) {
        payload.id = d.id; payload.score = d.score; payload.date = new Date().toISOString().slice(0,19).replace('T',' ');
        allLeads.unshift(payload);
        showToast('Nuevo prospecto creado 🎉','success');
        if (payload.assigned_to) {
          const newAgent = getAgentName(payload.assigned_to);
          await fetch('api/interactions.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({lead_id:d.id,type:'status_change',content:`Agente inicial asignado: ${newAgent}`})});
        }
      }
    }
    closeOC(); renderData();
  } catch(e) { showToast('Error al guardar','error'); }
}

// ═══════════════════════════════════════════════
//  DELETE
// ═══════════════════════════════════════════════
async function deleteLead(id) {
  if(!confirm('¿Eliminar este lead?')) return;
  const r = await fetch('api/leads.php',{method:'DELETE',headers:{'Content-Type':'application/json'},body:JSON.stringify({id})});
  const d = await r.json();
  if(d.success) { allLeads=allLeads.filter(l=>parseInt(l.id)!==parseInt(id)); renderData(); showToast('Lead eliminado','info'); }
}

// ═══════════════════════════════════════════════
//  TIMELINE
// ═══════════════════════════════════════════════
async function loadTimeline(id) {
  if(!id) return;
  document.getElementById('timeline-container').innerHTML = '<p style="color:var(--muted)">Cargando...</p>';
  const r = await fetch('api/interactions.php?lead_id='+id);
  const items = await r.json();
  if(!items.length) { document.getElementById('timeline-container').innerHTML = '<p style="color:var(--muted);font-size:.88rem;">Sin interacciones aún.</p>'; return; }
  document.getElementById('timeline-container').innerHTML = items.map(it => {
    const cls = it.type==='note' ? 'note' : it.type==='status_change' ? 'status' : '';
    return `<div class="tl-item fade-in">
      <div class="tl-dot ${cls}"></div>
      <div class="tl-body">
        <span class="tl-date">${fmtDate(it.date)}</span>
        <p class="tl-text">${esc(it.content)}</p>
      </div>
    </div>`;
  }).join('');
}

async function addNote() {
  const txt = document.getElementById('note-input').value.trim();
  if(!txt||!editingId) return;
  await fetch('api/interactions.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({lead_id:editingId,type:'note',content:txt})});
  document.getElementById('note-input').value = '';
  loadTimeline(editingId);
  showToast('Nota agregada','success');
}

// ═══════════════════════════════════════════════
//  AGENTS / USERS
// ═══════════════════════════════════════════════
let allAgents = [];
function getAgentName(id) {
  if(!id) return null;
  const a = allAgents.find(x => x.id == id);
  return a ? a.name : null;
}
async function loadAgents() {
  try {
    const r = await fetch('api/users.php');
    allAgents = await r.json();
    const sel = document.getElementById('m-assigned_to');
    if(sel) {
      sel.innerHTML = '<option value="">— Sin Asignar —</option>' + 
        allAgents.map(a => `<option value="${a.id}">${esc(a.name)}</option>`).join('');
    }
  } catch(e) { console.error('Error al cargar agentes:', e); }
}

// ═══════════════════════════════════════════════
//  TASKS
// ═══════════════════════════════════════════════
async function loadTasks(id) {
  if(!id) return;
  const container = document.getElementById('tasks-container');
  container.innerHTML = '<p style="color:var(--muted); font-size: 0.88rem;">Cargando tareas...</p>';
  try {
    const r = await fetch('api/tasks.php?lead_id=' + id);
    const tasks = await r.json();
    if(!tasks.length) {
      container.innerHTML = '<p style="color:var(--muted); font-size: 0.88rem;">No hay tareas pendientes.</p>';
      document.getElementById('oc-task-badge').style.display = 'none';
      document.getElementById('task-summary-text').textContent = '0 de 0 completadas';
      return;
    }
    const completed = tasks.filter(t => parseInt(t.is_completed) === 1).length;
    document.getElementById('task-summary-text').textContent = `${completed} de ${tasks.length} completadas`;
    
    const pending = tasks.length - completed;
    const badge = document.getElementById('oc-task-badge');
    if(pending > 0) {
      badge.textContent = pending;
      badge.style.display = 'inline-block';
    } else {
      badge.style.display = 'none';
    }
    
    container.innerHTML = tasks.map(t => {
      const isDone = parseInt(t.is_completed) === 1;
      return `
      <div style="background:rgba(255,255,255,.03); border:1px solid ${isDone ? 'var(--score-high)' : 'var(--border)'}; padding:12px; border-radius:10px; display:flex; align-items:center; gap:12px; opacity: ${isDone ? '0.6' : '1'}; transition: .3s;">
        <input type="checkbox" ${isDone ? 'checked' : ''} onchange="toggleTask(${t.id}, this.checked)" style="width:18px;height:18px;accent-color:var(--score-high);cursor:pointer; flex-shrink:0;">
        <div style="flex:1;">
          <div style="font-size: 0.9rem; font-weight: 500; ${isDone ? 'text-decoration:line-through; color:var(--muted);' : 'color:#fff;'}">${esc(t.title)}</div>
          <div style="font-size: 0.75rem; color:var(--score-med); margin-top:4px;">${t.due_date ? '⏳ ' + fmtDate(t.due_date) : ''}</div>
        </div>
        <button class="btn btn-sm btn-danger" onclick="deleteTask(${t.id})" style="padding: 5px 10px;">✕</button>
      </div>`;
    }).join('');
  } catch(e) {
    container.innerHTML = '<p style="color:var(--score-low); font-size: 0.88rem;">Error al cargar tareas.</p>';
  }
}

async function addTask() {
  const title = document.getElementById('task-title-input').value.trim();
  const due = document.getElementById('task-due-input').value;
  if(!title) { showToast('Ingresa un título para la tarea','error'); return; }
  if(!editingId) { showToast('Primero guarda el prospecto','error'); return; }
  
  try {
    const r = await fetch('api/tasks.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ lead_id: editingId, title: title, due_date: due })
    });
    const d = await r.json();
    if(d.success) {
      document.getElementById('task-title-input').value = '';
      document.getElementById('task-due-input').value = '';
      showToast('Tarea agregada', 'success');
      loadTasks(editingId);
      loadTimeline(editingId); // Reload timeline since a note might have been added
    } else {
      showToast('Error al agregar tarea', 'error');
    }
  } catch(e) { showToast('Error de conexión', 'error'); }
}

async function toggleTask(id, isCompleted) {
  try {
    await fetch('api/tasks.php', {
      method: 'PUT',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ id: id, is_completed: isCompleted ? 1 : 0 })
    });
    if (editingId) {
       loadTasks(editingId);
       loadTimeline(editingId);
    }
  } catch(e) { showToast('Error al actualizar tarea', 'error'); }
}

async function deleteTask(id) {
  if(!confirm('¿Eliminar esta tarea?')) return;
  try {
    await fetch('api/tasks.php', {
      method: 'DELETE',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ id: id })
    });
    showToast('Tarea eliminada', 'info');
    if (editingId) loadTasks(editingId);
  } catch(e) { showToast('Error al eliminar tarea', 'error'); }
}

// ═══════════════════════════════════════════════
//  CSV IMPORT
// ═══════════════════════════════════════════════
function openImportModal() { document.getElementById('import-modal').classList.add('open'); resetImport(); }
function closeImportModal() { document.getElementById('import-modal').classList.remove('open'); }
function resetImport() {
  parsedCSVData = []; csvHeaders = [];
  document.getElementById('import-preview').style.display = 'none';
  document.getElementById('import-result').style.display = 'none';
  document.getElementById('col-mapper').style.display = 'none';
  document.getElementById('import-btn').disabled = true;
  document.getElementById('csv-file').value = '';
}

// Drag & Drop on drop zone
const dz = document.getElementById('drop-zone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('dragover'); });
dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
dz.addEventListener('drop', e => { e.preventDefault(); dz.classList.remove('dragover'); if(e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]); });

function handleFile(file) {
  if(!file || !file.name.endsWith('.csv')) { showToast('Selecciona un archivo .csv válido','error'); return; }
  const reader = new FileReader();
  reader.onload = e => parseCSV(e.target.result);
  reader.readAsText(file, 'UTF-8');
}

function parseCSV(text) {
  const lines = text.trim().split(/\r?\n/).filter(l=>l.trim());
  if(!lines.length) return;
  csvHeaders = lines[0].split(',').map(h => h.trim().replace(/^"|"$/g,'').toLowerCase());
  parsedCSVData = lines.slice(1).map(line => {
    const vals = [];
    let inQ=false, cur='';
    for(let i=0;i<line.length;i++){
      if(line[i]==='"') inQ=!inQ;
      else if(line[i]===','&&!inQ){ vals.push(cur.trim()); cur=''; }
      else cur+=line[i];
    }
    vals.push(cur.trim());
    return vals;
  });

  // Auto-map columns
  colMap = {};
  FIELDS.forEach(f => {
    const idx = csvHeaders.findIndex(h => h===f || h.includes(f) || f.includes(h));
    if(idx>=0) colMap[f] = idx;
  });

  buildMapper();
  buildPreview();
  document.getElementById('import-btn').disabled = false;
}

function buildMapper() {
  const container = document.getElementById('mapper-rows');
  container.innerHTML = FIELDS.map(f => `
    <div>
      <label style="font-size:.78rem;color:var(--muted);display:block;margin-bottom:4px;">${f}</label>
      <select class="filter-select" style="width:100%" id="map-${f}" onchange="updateColMap()">
        <option value="">— Ignorar —</option>
        ${csvHeaders.map((h,i)=>`<option value="${i}" ${colMap[f]===i?'selected':''}>${h}</option>`).join('')}
      </select>
    </div>
  `).join('');
  document.getElementById('col-mapper').style.display = 'block';
}

function updateColMap() {
  FIELDS.forEach(f => {
    const v = document.getElementById('map-'+f)?.value;
    if(v!=='') colMap[f] = parseInt(v); else delete colMap[f];
  });
  buildPreview();
}

function buildPreview() {
  const preview = parsedCSVData.slice(0,5);
  document.getElementById('preview-head').innerHTML = '<tr>'+FIELDS.filter(f=>colMap[f]!==undefined).map(f=>`<th>${f}</th>`).join('')+'</tr>';
  document.getElementById('preview-body').innerHTML = preview.map(row => {
    const cells = FIELDS.filter(f=>colMap[f]!==undefined).map(f=>`<td>${esc(row[colMap[f]]||'')}</td>`).join('');
    return `<tr class="preview-row-ok">${cells}</tr>`;
  }).join('');
  document.getElementById('preview-title').textContent = `Vista previa (${parsedCSVData.length} filas detectadas)`;
  document.getElementById('import-preview').style.display = 'block';
}

async function doImport() {
  const btn = document.getElementById('import-btn');
  btn.disabled = true; btn.textContent = 'Importando...';
  const leads = parsedCSVData.map(row => {
    const obj = {};
    FIELDS.forEach(f => { if(colMap[f]!==undefined) obj[f] = (row[colMap[f]]||'').trim(); });
    return obj;
  }).filter(l => l.name && l.email);

  try {
    const r = await fetch('api/import.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({leads})});
    const d = await r.json();
    const res = document.getElementById('import-result');
    document.getElementById('result-text').innerHTML = `✅ <strong>${d.imported}</strong> leads importados&nbsp;&nbsp;|&nbsp;&nbsp;⚠️ <strong>${d.skipped}</strong> omitidos (duplicados o inválidos)${d.errors?.length?'<br><small>'+d.errors.slice(0,3).join('<br>')+'</small>':''}`;
    res.style.display = 'block';
    showToast(`${d.imported} leads importados exitosamente`,'success');
    loadLeads();
  } catch(e) { showToast('Error en la importación','error'); }
  btn.disabled = false; btn.textContent = 'Importar Leads';
}

// ═══════════════════════════════════════════════
//  EXPORT CSV
// ═══════════════════════════════════════════════
function exportCSV() {
  const cols = ['ID','Nombre','Email','Teléfono','Empresa','Presupuesto','Score','Fuente','Estado','Fecha'];
  const rows = allLeads.map(l => [l.id,l.name,l.email,l.phone,l.company,l.budget,l.score,l.source,LABELS[l.status]||l.status,l.date].map(v=>`"${(v||'').toString().replace(/"/g,'""')}"`).join(','));
  const csv = [cols.join(','),...rows].join('\n');
  const a = document.createElement('a');
  a.href = 'data:text/csv;charset=utf-8,\uFEFF'+encodeURIComponent(csv);
  a.download = `leads_${new Date().toISOString().slice(0,10)}.csv`;
  a.click();
  showToast('CSV exportado correctamente','success');
}

// ═══════════════════════════════════════════════
//  ANALYTICS
// ═══════════════════════════════════════════════
function renderCharts() {
  const counts = {nuevos:0,contactados:0,negociacion:0,cerrados:0};
  const sources = {};
  let scoreHigh=0, scoreMed=0, scoreLow=0;
  allLeads.forEach(l => {
    counts[l.status] = (counts[l.status]||0)+1;
    sources[l.source||'Desconocido'] = (sources[l.source||'Desconocido']||0)+1;
    const s = parseInt(l.score||0);
    if(s>=70) scoreHigh++; else if(s>=40) scoreMed++; else scoreLow++;
  });

  const chartOpts = { plugins:{ legend:{ labels:{ color:'#aaa' } } }, scales:{ y:{ grid:{ color:'rgba(255,255,255,.05)' }, ticks:{color:'#888'}, beginAtZero:true }, x:{ grid:{display:false}, ticks:{color:'#888'} } } };
  
  if(charts.funnel) charts.funnel.destroy();
  charts.funnel = new Chart(document.getElementById('funnelChart').getContext('2d'), {
    type:'bar', data:{ labels:['Nuevos','Contactados','Negociación','Cerrados'],
    datasets:[{label:'Leads', data:[counts.nuevos,counts.contactados,counts.negociacion,counts.cerrados],
    backgroundColor:['#3b82f6','#f59e0b','#a855f7','#10b981'], borderRadius:8}] }, options:{...chartOpts, plugins:{legend:{display:false}}}
  });

  if(charts.source) charts.source.destroy();
  charts.source = new Chart(document.getElementById('sourceChart').getContext('2d'), {
    type:'doughnut', data:{ labels:Object.keys(sources), datasets:[{data:Object.values(sources), backgroundColor:['#d4af37','#3b82f6','#10b981','#a855f7','#f59e0b','#ef4444'], borderWidth:0}] },
    options:{ plugins:{ legend:{ position:'bottom', labels:{color:'#aaa',padding:16} } }, cutout:'65%' }
  });

  if(charts.score) charts.score.destroy();
  charts.score = new Chart(document.getElementById('scoreChart').getContext('2d'), {
    type:'bar', data:{ labels:['Alto (70+)','Medio (40-69)','Bajo (<40)'],
    datasets:[{data:[scoreHigh,scoreMed,scoreLow], backgroundColor:['#10b981','#f59e0b','#ef4444'], borderRadius:8}] },
    options:{...chartOpts, plugins:{legend:{display:false}}}
  });

  // Hot Leads
  const hot = allLeads.filter(l=>parseInt(l.score||0)>=70).sort((a,b)=>b.score-a.score).slice(0,5);
  document.getElementById('hot-leads-list').innerHTML = hot.length ? hot.map(l=>`
    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);">
      <div>
        <div style="font-weight:600;font-size:.9rem">${esc(l.name)}</div>
        <div style="font-size:.78rem;color:var(--muted)">${esc(l.company||l.email)}</div>
      </div>
      <div style="display:flex;align-items:center;gap:10px;">
        <span class="badge badge-${l.status}">${LABELS[l.status]||l.status}</span>
        <div class="score-ring" style="color:var(--score-high);border-color:var(--score-high);font-size:.7rem">${l.score}</div>
      </div>
    </div>`).join('') : '<p style="color:var(--muted);font-size:.88rem;">No hay leads calientes aún.</p>';
}

// ═══════════════════════════════════════════════
//  TOAST
// ═══════════════════════════════════════════════
function showToast(msg, type='info') {
  const icons = {success:'✅',error:'❌',info:'ℹ️'};
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.innerHTML = `<span class="toast-icon">${icons[type]}</span>${msg}`;
  document.getElementById('toast-container').appendChild(t);
  setTimeout(()=>{t.style.opacity='0';t.style.transition='.4s';setTimeout(()=>t.remove(),400);},3000);
}

// ═══════════════════════════════════════════════
//  UTILS
// ═══════════════════════════════════════════════
function esc(s) { if(!s) return ''; const d=document.createElement('div'); d.textContent=s; return d.innerHTML; }
function fmtDate(d) { if(!d) return '—'; const p=d.split(' '); const dp=p[0].split('-'); return dp.length===3?`${dp[2]}/${dp[1]}/${dp[0]} ${p[1]||''}`:d; }
function fmtNum(n) { return Number(n).toLocaleString('es-CO'); }
</script>
</body>
</html>