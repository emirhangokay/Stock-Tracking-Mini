<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Urunler</h3>
  <a href="/index.php?route=products.create" class="btn btn-primary btn-sm">Yeni Urun</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead><tr><th>ID</th><th>Ad</th><th>SKU</th><th>Marka</th><th>Kategori</th><th>Stok</th><th>Kritik</th><th>Durum</th><th>Islem</th></tr></thead>
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
          <td><?= (int)$p['is_active'] === 1 ? 'Aktif' : 'Pasif' ?></td>
          <td class="d-flex gap-1">
            <a class="btn btn-sm btn-outline-primary" href="/index.php?route=products.show&id=<?= (int)$p['id'] ?>">Detay</a>
            <a class="btn btn-sm btn-outline-secondary" href="/index.php?route=products.edit&id=<?= (int)$p['id'] ?>">Duzenle</a>
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
