<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
  <div>
    <h3 class="page-title">Dashboard</h3>
    <div class="section-subtitle">Stok ve satış performansının anlık özeti</div>
  </div>
  <span class="badge text-bg-light border text-secondary-emphasis px-3 py-2">
    <i class="bi bi-calendar3 me-1"></i><?= date('d.m.Y') ?>
  </span>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card metric-card h-100">
      <div class="card-body">
        <span class="metric-icon metric-products"><i class="bi bi-box-seam"></i></span>
        <div class="metric-label">Toplam Ürün</div>
        <div class="metric-value"><?= e((string)$metrics['total_products']) ?></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card metric-card h-100">
      <div class="card-body">
        <span class="metric-icon metric-critical"><i class="bi bi-exclamation-triangle"></i></span>
        <div class="metric-label">Kritik Stok</div>
        <div class="metric-value"><?= e((string)$metrics['critical_count']) ?></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card metric-card h-100">
      <div class="card-body">
        <span class="metric-icon metric-sales"><i class="bi bi-receipt"></i></span>
        <div class="metric-label">Bugünkü Satış</div>
        <div class="metric-value"><?= e((string)$metrics['today_sales_count']) ?></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card metric-card h-100">
      <div class="card-body">
        <span class="metric-icon metric-revenue"><i class="bi bi-currency-dollar"></i></span>
        <div class="metric-label">Bugünkü Ciro</div>
        <div class="metric-value"><?= number_format((float)$metrics['today_revenue'], 2, ',', '.') ?> TL</div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <span><i class="bi bi-activity me-2"></i>Kritik Stok Listesi</span>
    <span class="badge text-bg-warning-subtle text-warning-emphasis border"><?= count($criticalProducts) ?> ürün</span>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead>
          <tr>
            <th>Ürün</th>
            <th>SKU</th>
            <th>Mevcut Stok</th>
            <th>Kritik Seviye</th>
            <th>Durum</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($criticalProducts as $p): ?>
            <tr>
              <td><?= e($p['name']) ?></td>
              <td><?= e($p['sku']) ?></td>
              <td><?= e((string)$p['current_stock']) ?></td>
              <td><?= e((string)$p['critical_stock_level']) ?></td>
              <td>
                <span class="badge text-bg-danger-subtle text-danger-emphasis border">Kritik</span>
              </td>
              <td>
                <a class="btn btn-sm btn-outline-primary" href="/index.php?route=products.show&id=<?= (int)$p['id'] ?>">Detay</a>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (!$criticalProducts): ?>
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Kritik stokta ürün yok.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
