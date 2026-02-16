<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Urun Detayi</h3>
  <a href="/index.php?route=products" class="btn btn-light btn-sm">Geri</a>
</div>
<div class="row g-3 mb-3">
  <div class="col-md-6"><div class="card"><div class="card-body">
    <h5><?= e($product['name']) ?></h5>
    <div>SKU: <strong><?= e($product['sku']) ?></strong></div>
    <div>Marka: <?= e($product['brand_name']) ?></div>
    <div>Kategori: <?= e($product['category_name']) ?></div>
    <div>Mevcut Stok: <strong><?= e((string)$product['current_stock']) ?></strong></div>
    <div>Kritik Seviye: <?= e((string)$product['critical_stock_level']) ?></div>
  </div></div></div>
</div>
<div class="row g-3">
  <div class="col-lg-6">
    <div class="card"><div class="card-header">Son Stok Hareketleri</div>
      <div class="table-responsive"><table class="table table-sm mb-0"><thead><tr><th>Tarih</th><th>Tip</th><th>Miktar</th><th>Kullanici</th><th>Not</th></tr></thead><tbody>
        <?php foreach ($movements as $m): ?>
          <tr><td><?= e($m['movement_date']) ?></td><td><?= e($m['movement_type']) ?></td><td><?= e((string)$m['qty']) ?></td><td><?= e($m['user_name']) ?></td><td><?= e((string)$m['note']) ?></td></tr>
        <?php endforeach; ?>
        <?php if (!$movements): ?><tr><td colspan="5" class="text-center">Kayit yok.</td></tr><?php endif; ?>
      </tbody></table></div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card"><div class="card-header">Son Satislar</div>
      <div class="table-responsive"><table class="table table-sm mb-0"><thead><tr><th>Tarih</th><th>Satis ID</th><th>Musteri</th><th>Miktar</th><th>Fiyat</th></tr></thead><tbody>
        <?php foreach ($sales as $s): ?>
          <tr><td><?= e($s['sale_date']) ?></td><td>#<?= (int)$s['sale_id'] ?></td><td><?= e($s['customer_name']) ?></td><td><?= e((string)$s['qty']) ?></td><td><?= number_format((float)$s['unit_price'], 2, ',', '.') ?></td></tr>
        <?php endforeach; ?>
        <?php if (!$sales): ?><tr><td colspan="5" class="text-center">Kayit yok.</td></tr><?php endif; ?>
      </tbody></table></div>
    </div>
  </div>
</div>
