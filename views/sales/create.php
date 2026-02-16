<div class="card">
  <div class="card-body">
    <h4 class="mb-3">Yeni Satis</h4>
    <form method="post" action="/index.php?route=sales.store">
      <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
      <div class="mb-3 col-md-6">
        <label class="form-label">Musteri Adi</label>
        <input name="customer_name" class="form-control" required>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead><tr><th>Urun</th><th>Miktar</th><th>Birim Fiyat</th><th></th></tr></thead>
          <tbody id="sale-lines">
            <tr>
              <td>
                <select name="product_id[]" class="form-select" required>
                  <option value="">Seciniz</option>
                  <?php foreach ($products as $p): ?>
                    <option value="<?= (int)$p['id'] ?>"><?= e($p['name']) ?> (Stok: <?= e((string)$p['current_stock']) ?>)</option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td><input type="number" step="0.01" min="0.01" name="qty[]" class="form-control" required></td>
              <td><input type="number" step="0.01" min="0" name="unit_price[]" class="form-control" required></td>
              <td><button type="button" onclick="removeSaleRow(this)" class="btn btn-sm btn-outline-danger">Sil</button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addSaleRow()">Satir Ekle</button>
      <button class="btn btn-primary btn-sm">Satisi Kaydet</button>
    </form>
  </div>
</div>
