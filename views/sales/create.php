<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
  <div>
    <h3 class="page-title">Yeni Satış</h3>
    <div class="section-subtitle">Müşteri ve ürün satırlarını girerek satış işlemini tamamlayın</div>
  </div>
  <a href="/index.php?route=sales" class="btn btn-outline-secondary btn-sm">
    <i class="bi bi-arrow-left me-1"></i>Satış Listesi
  </a>
</div>

<div class="card">
  <div class="card-body">
    <form method="post" action="/index.php?route=sales.store">
      <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

      <div class="mb-3 col-md-6">
        <label class="form-label">Müşteri Adı</label>
        <input name="customer_name" class="form-control" placeholder="Örn: ABC Teknoloji" required>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-3">
          <thead>
            <tr>
              <th>Ürün</th>
              <th>Miktar</th>
              <th>Birim Fiyat</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="sale-lines">
            <tr>
              <td>
                <select name="product_id[]" class="form-select" required>
                  <option value="">Seçiniz</option>
                  <?php foreach ($products as $p): ?>
                    <option value="<?= (int)$p['id'] ?>"><?= e($p['name']) ?> (Stok: <?= e((string)$p['current_stock']) ?>)</option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td><input type="number" step="0.01" min="0.01" name="qty[]" class="form-control" required></td>
              <td><input type="number" step="0.01" min="0" name="unit_price[]" class="form-control" required></td>
              <td>
                <button type="button" onclick="removeSaleRow(this)" class="btn btn-sm btn-outline-danger">Sil</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="d-flex flex-wrap gap-2">
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addSaleRow()">
          <i class="bi bi-plus-circle me-1"></i>Satır Ekle
        </button>
        <button class="btn btn-primary btn-sm">
          <i class="bi bi-check2-circle me-1"></i>Satışı Kaydet
        </button>
      </div>
    </form>
  </div>
</div>
