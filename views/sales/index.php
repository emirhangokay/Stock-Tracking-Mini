<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Satislar</h3>
  <a href="/index.php?route=sales.create" class="btn btn-primary btn-sm">Yeni Satis</a>
</div>
<div class="card"><div class="table-responsive">
  <table class="table table-striped mb-0">
    <thead><tr><th>ID</th><th>Tarih</th><th>Musteri</th><th>Tutar</th><th>Olusturan</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($sales as $sale): ?>
      <tr>
        <td>#<?= (int)$sale['id'] ?></td>
        <td><?= e($sale['sale_date']) ?></td>
        <td><?= e($sale['customer_name']) ?></td>
        <td><?= number_format((float)$sale['total_amount'], 2, ',', '.') ?> TL</td>
        <td><?= e($sale['created_by_name']) ?></td>
        <td><a class="btn btn-sm btn-outline-primary" href="/index.php?route=sales.show&id=<?= (int)$sale['id'] ?>">Detay</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
