<?php $flashes = pull_flashes(); ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? 'Stok Takip Mini ERP') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f7f8fa; }
    .navbar-brand { font-weight: 600; }
  </style>
</head>
<body>
<?php include BASE_PATH . '/views/partials/navbar.php'; ?>
<div class="container py-4">
  <?php foreach ($flashes as $msg): ?>
    <div class="alert alert-<?= e($msg['type']) ?> alert-dismissible fade show" role="alert">
      <?= e($msg['message']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endforeach; ?>

  <?php include $viewFile; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function addSaleRow() {
    const tbody = document.getElementById('sale-lines');
    if (!tbody) return;
    const row = tbody.querySelector('tr').cloneNode(true);
    row.querySelectorAll('input').forEach(i => i.value = '');
    row.querySelector('select').selectedIndex = 0;
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
