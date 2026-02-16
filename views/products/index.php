<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
  <div>
    <h3 class="page-title">Ürünler</h3>
    <div class="section-subtitle">Katalogdaki tüm ürünleri, stok ve durum bilgileriyle yönetin</div>
  </div>
  <a href="/index.php?route=products.create" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-circle me-1"></i>Yeni Ürün
  </a>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-striped table-hover mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Ad</th>
          <th>SKU</th>
          <th>Marka</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Kritik</th>
          <th>Durum</th>
          <th>İşlem</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?= (int)$p['id'] ?></td>
          <td><?= e($p['name']) ?></td>
          <td><?= e($p['sku']) ?></td>
          <td><?= e($p['brand_name']) ?></td>
          <td><?= e($p['category_name']) ?></td>
          <td><?= e((string)$p['current_stock']) ?></td>
          <td><?= e((string)$p['critical_stock_level']) ?></td>
          <td>
            <?php if ((int)$p['is_active'] === 1): ?>
              <span class="badge text-bg-success-subtle text-success-emphasis border">Aktif</span>
            <?php else: ?>
              <span class="badge text-bg-secondary-subtle text-secondary-emphasis border">Pasif</span>
            <?php endif; ?>
          </td>
          <td class="d-flex gap-1">
            <a class="btn btn-sm btn-outline-primary" href="/index.php?route=products.show&id=<?= (int)$p['id'] ?>">Detay</a>
            <a class="btn btn-sm btn-outline-secondary" href="/index.php?route=products.edit&id=<?= (int)$p['id'] ?>">Düzenle</a>
            <form method="post" action="/index.php?route=products.toggle">
              <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
              <button class="btn btn-sm btn-outline-warning">Durum</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
