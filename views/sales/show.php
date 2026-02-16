<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Satis #<?= (int)$sale['id'] ?></h3>
  <a href="/index.php?route=sales" class="btn btn-light btn-sm">Geri</a>
</div>
<div class="card mb-3"><div class="card-body">
  <div><strong>Musteri:</strong> <?= e($sale['customer_name']) ?></div>
  <div><strong>Tarih:</strong> <?= e($sale['sale_date']) ?></div>
  <div><strong>Olusturan:</strong> <?= e($sale['created_by_name']) ?></div>
  <div><strong>Toplam:</strong> <?= number_format((float)$sale['total_amount'], 2, ',', '.') ?> TL</div>
</div></div>
<div class="card"><div class="table-responsive">
  <table class="table table-striped mb-0">
    <thead><tr><th>Urun</th><th>SKU</th><th>Miktar</th><th>Birim Fiyat</th><th>Satir Toplami</th></tr></thead>
    <tbody>
    <?php foreach ($sale['items'] as $item): ?>
      <tr>
        <td><?= e($item['product_name']) ?></td>
        <td><?= e($item['sku']) ?></td>
        <td><?= e((string)$item['qty']) ?></td>
        <td><?= number_format((float)$item['unit_price'], 2, ',', '.') ?></td>
        <td><?= number_format((float)$item['line_total'], 2, ',', '.') ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
