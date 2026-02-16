<div class="row g-3">
  <div class="col-lg-4">
    <div class="card"><div class="card-body">
      <h5>Stok Hareketi Ekle</h5>
      <form method="post" action="/index.php?route=movements.store">
        <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
        <div class="mb-2"><label class="form-label">Urun</label>
          <select name="product_id" class="form-select" required>
            <option value="">Seciniz</option>
            <?php foreach ($products as $p): ?>
              <option value="<?= (int)$p['id'] ?>"><?= e($p['name']) ?> (Stok: <?= e((string)$p['current_stock']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-2"><label class="form-label">Tip</label>
          <select name="movement_type" class="form-select">
            <option value="IN">IN (Giris)</option>
            <option value="OUT">OUT (Cikis)</option>
          </select>
        </div>
        <div class="mb-2"><label class="form-label">Miktar</label><input type="number" step="0.01" min="0.01" name="qty" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Not</label><textarea name="note" class="form-control" rows="2"></textarea></div>
        <button class="btn btn-primary btn-sm">Kaydet</button>
      </form>
    </div></div>
  </div>
  <div class="col-lg-8">
    <div class="card"><div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead><tr><th>Tarih</th><th>Urun</th><th>SKU</th><th>Tip</th><th>Miktar</th><th>Kullanici</th><th>Referans Satis</th></tr></thead>
        <tbody>
        <?php foreach ($movements as $m): ?>
          <tr>
            <td><?= e($m['movement_date']) ?></td><td><?= e($m['product_name']) ?></td><td><?= e($m['sku']) ?></td>
            <td><?= e($m['movement_type']) ?></td><td><?= e((string)$m['qty']) ?></td><td><?= e($m['user_name']) ?></td>
            <td><?= $m['reference_sale_id'] ? '#' . (int)$m['reference_sale_id'] : '-' ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div></div>
  </div>
</div>
