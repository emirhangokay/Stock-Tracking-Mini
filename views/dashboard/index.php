<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Dashboard</h3>
</div>
<div class="row g-3 mb-4">
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Toplam Urun</div><h4><?= e((string)$metrics['total_products']) ?></h4></div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Kritik Stok</div><h4><?= e((string)$metrics['critical_count']) ?></h4></div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Bugunku Satis</div><h4><?= e((string)$metrics['today_sales_count']) ?></h4></div></div></div>
  <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-muted">Bugunku Ciro</div><h4><?= number_format((float)$metrics['today_revenue'], 2, ',', '.') ?> TL</h4></div></div></div>
</div>
<div class="card">
  <div class="card-header">Kritik Stok Listesi</div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead><tr><th>Urun</th><th>SKU</th><th>Mevcut Stok</th><th>Kritik Seviye</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($criticalProducts as $p): ?>
          <tr>
            <td><?= e($p['name']) ?></td>
            <td><?= e($p['sku']) ?></td>
            <td><?= e((string)$p['current_stock']) ?></td>
            <td><?= e((string)$p['critical_stock_level']) ?></td>
            <td><a class="btn btn-sm btn-outline-primary" href="/index.php?route=products.show&id=<?= (int)$p['id'] ?>">Detay</a></td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$criticalProducts): ?>
          <tr><td colspan="5" class="text-center py-3">Kritik stokta urun yok.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
