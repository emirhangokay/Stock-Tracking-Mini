<div class="card mb-3"><div class="card-body">
  <form method="get" action="/index.php" class="row g-3 align-items-end">
    <input type="hidden" name="route" value="reports">
    <div class="col-md-3">
      <label class="form-label">Baslangic</label>
      <input type="date" name="start_date" class="form-control" value="<?= e($start) ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Bitis</label>
      <input type="date" name="end_date" class="form-control" value="<?= e($end) ?>">
    </div>
    <div class="col-md-2"><button class="btn btn-primary">Filtrele</button></div>
  </form>
</div></div>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="card"><div class="card-header">Gunluk Ciro</div>
      <div class="table-responsive"><table class="table table-sm mb-0">
        <thead><tr><th>Tarih</th><th>Satis Adedi</th><th>Ciro</th></tr></thead>
        <tbody>
        <?php foreach ($dailyRevenue as $row): ?>
          <tr><td><?= e($row['day']) ?></td><td><?= e((string)$row['sales_count']) ?></td><td><?= number_format((float)$row['revenue'], 2, ',', '.') ?> TL</td></tr>
        <?php endforeach; ?>
        <?php if (!$dailyRevenue): ?><tr><td colspan="3" class="text-center">Veri yok</td></tr><?php endif; ?>
        </tbody>
      </table></div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card"><div class="card-header">En Cok Satilan 10 Urun (Adet)</div>
      <div class="table-responsive"><table class="table table-sm mb-0">
        <thead><tr><th>Urun</th><th>SKU</th><th>Toplam Miktar</th></tr></thead>
        <tbody>
        <?php foreach ($topProducts as $row): ?>
          <tr><td><?= e($row['name']) ?></td><td><?= e($row['sku']) ?></td><td><?= e((string)$row['total_qty']) ?></td></tr>
        <?php endforeach; ?>
        <?php if (!$topProducts): ?><tr><td colspan="3" class="text-center">Veri yok</td></tr><?php endif; ?>
        </tbody>
      </table></div>
    </div>
  </div>
</div>
