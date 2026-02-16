<?php $flashes = pull_flashes(); ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? 'Stok Takip Mini ERP') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    :root {
      --brand-900: #0f2c49;
      --brand-700: #1c4f80;
      --brand-500: #2d78be;
      --accent-500: #1f9d7a;
      --bg-main: #f3f7fc;
      --bg-alt: #eef6f2;
      --surface: #ffffff;
      --text-main: #1b2735;
      --text-muted: #6c7b8f;
      --border-soft: #dfe8f2;
      --radius-md: 14px;
      --radius-lg: 18px;
    }

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Manrope', 'Segoe UI', sans-serif;
      color: var(--text-main);
      background:
        radial-gradient(1000px 500px at -10% -10%, #dbeafe 0%, transparent 60%),
        radial-gradient(900px 450px at 110% -10%, #d6f4ea 0%, transparent 60%),
        linear-gradient(180deg, var(--bg-main) 0%, var(--bg-alt) 100%);
      min-height: 100vh;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: radial-gradient(rgba(28, 79, 128, 0.08) 0.6px, transparent 0.6px);
      background-size: 18px 18px;
      opacity: 0.45;
      pointer-events: none;
      z-index: -1;
    }

    .navbar {
      background: rgba(255, 255, 255, 0.9) !important;
      border-bottom: 1px solid var(--border-soft) !important;
      backdrop-filter: blur(8px);
      position: sticky;
      top: 0;
      z-index: 1020;
    }

    .navbar-brand {
      display: inline-flex;
      align-items: center;
      gap: 0.65rem;
      font-weight: 800;
      color: var(--brand-900) !important;
      letter-spacing: 0.2px;
    }

    .brand-dot {
      width: 1.3rem;
      height: 1.3rem;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--brand-500), var(--accent-500));
      box-shadow: 0 6px 14px rgba(31, 105, 171, 0.35);
    }

    .nav-link {
      color: #33475f !important;
      font-weight: 600;
      border-radius: 10px;
      padding: 0.45rem 0.75rem !important;
      transition: all 0.18s ease;
    }

    .nav-link:hover {
      color: var(--brand-700) !important;
      background: #ebf3fb;
    }

    .nav-link.active {
      color: var(--brand-700) !important;
      background: linear-gradient(135deg, #e8f1fb, #ecf8f3);
    }

    .app-shell {
      padding-top: 1.6rem;
      padding-bottom: 2rem;
      animation: app-enter 0.35s ease-out;
    }

    .content-wrap {
      max-width: 1180px;
    }

    .card {
      border: 1px solid var(--border-soft);
      border-radius: var(--radius-lg);
      box-shadow: 0 12px 28px rgba(13, 44, 73, 0.07);
      background: var(--surface);
    }

    .card-header {
      border-bottom: 1px solid var(--border-soft);
      background: linear-gradient(180deg, #fbfdff 0%, #f5f9ff 100%);
      font-weight: 700;
      color: #30445d;
      border-top-left-radius: var(--radius-lg) !important;
      border-top-right-radius: var(--radius-lg) !important;
    }

    .table {
      margin-bottom: 0;
    }

    .table thead th {
      text-transform: uppercase;
      letter-spacing: 0.04em;
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 700;
      background: #f7fbff;
      border-bottom-width: 1px;
      border-color: #e6edf5;
      white-space: nowrap;
    }

    .table tbody td {
      border-color: #edf2f7;
      vertical-align: middle;
    }

    .table-striped > tbody > tr:nth-of-type(odd) > * {
      --bs-table-accent-bg: #fcfdff;
    }

    .table-hover > tbody > tr:hover > * {
      --bs-table-accent-bg: #f4f9ff;
    }

    .form-control,
    .form-select,
    .form-control-sm {
      border-radius: 10px;
      border-color: #d8e3ef;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #7caedb;
      box-shadow: 0 0 0 0.2rem rgba(45, 120, 190, 0.15);
    }

    .btn {
      border-radius: 10px;
      font-weight: 700;
    }

    .btn-primary {
      border: none;
      background: linear-gradient(135deg, var(--brand-500), var(--brand-700));
      box-shadow: 0 8px 18px rgba(28, 79, 128, 0.25);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      filter: brightness(0.97);
    }

    .btn-outline-primary {
      border-color: #93bde1;
      color: var(--brand-700);
    }

    .btn-outline-primary:hover {
      background: #e9f3fb;
      color: var(--brand-700);
    }

    .flash-stack .alert {
      border-radius: 12px;
      border-width: 1px;
      box-shadow: 0 8px 20px rgba(18, 41, 68, 0.08);
    }

    .page-title {
      font-weight: 800;
      color: var(--brand-900);
      margin-bottom: 0;
    }

    .section-subtitle {
      color: var(--text-muted);
      font-size: 0.93rem;
    }

    .metric-card {
      position: relative;
      overflow: hidden;
      border: 1px solid #dfe8f3;
      border-radius: var(--radius-lg);
      transition: transform 0.2s ease;
    }

    .metric-card:hover {
      transform: translateY(-2px);
    }

    .metric-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.05rem;
      margin-bottom: 0.75rem;
    }

    .metric-products {
      background: #eaf3fd;
      color: #2a72b7;
    }

    .metric-critical {
      background: #fdeeed;
      color: #cb554f;
    }

    .metric-sales {
      background: #ebf8f3;
      color: #1e9774;
    }

    .metric-revenue {
      background: #fff4e8;
      color: #ba6a1d;
    }

    .metric-label {
      color: var(--text-muted);
      font-size: 0.84rem;
      font-weight: 600;
    }

    .metric-value {
      font-size: 1.7rem;
      line-height: 1.1;
      font-weight: 800;
      color: var(--brand-900);
      margin-top: 0.15rem;
    }

    .login-shell {
      border-radius: 22px;
      overflow: hidden;
      border: 1px solid var(--border-soft);
      box-shadow: 0 18px 40px rgba(13, 44, 73, 0.12);
      background: #fff;
    }

    .login-hero {
      background: linear-gradient(160deg, #1f4f7e 0%, #0f2c49 100%);
      color: #f4f9ff;
      position: relative;
      overflow: hidden;
    }

    .login-hero::after {
      content: '';
      position: absolute;
      right: -80px;
      bottom: -80px;
      width: 220px;
      height: 220px;
      background: radial-gradient(circle, rgba(255, 255, 255, 0.28), transparent 70%);
      border-radius: 50%;
    }

    @keyframes app-enter {
      from {
        opacity: 0;
        transform: translateY(8px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 991.98px) {
      .app-shell {
        padding-top: 1.15rem;
      }

      .navbar .badge {
        display: none;
      }
    }
  </style>
</head>
<body>
<?php include BASE_PATH . '/views/partials/navbar.php'; ?>

<main class="container content-wrap app-shell">
  <div class="flash-stack">
    <?php foreach ($flashes as $msg): ?>
      <div class="alert alert-<?= e($msg['type']) ?> alert-dismissible fade show" role="alert">
        <?= e($msg['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endforeach; ?>
  </div>

  <?php include $viewFile; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function addSaleRow() {
    const tbody = document.getElementById('sale-lines');
    if (!tbody) return;

    const row = tbody.querySelector('tr').cloneNode(true);
    row.querySelectorAll('input').forEach((input) => {
      input.value = '';
    });
    const select = row.querySelector('select');
    if (select) {
      select.selectedIndex = 0;
    }

    tbody.appendChild(row);
  }

  function removeSaleRow(btn) {
    const tbody = document.getElementById('sale-lines');
    if (!tbody) return;
    if (tbody.querySelectorAll('tr').length === 1) return;
    btn.closest('tr').remove();
  }
</script>
</body>
</html>
