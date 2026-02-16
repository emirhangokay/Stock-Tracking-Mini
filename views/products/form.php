<?php $item = $product ?? []; ?>
<div class="mb-3"><label class="form-label">Urun Adi</label><input name="name" class="form-control" value="<?= e((string)($item['name'] ?? '')) ?>" required></div>
<div class="mb-3"><label class="form-label">SKU / Seri</label><input name="sku" class="form-control" value="<?= e((string)($item['sku'] ?? '')) ?>" required></div>
<div class="row g-3">
  <div class="col-md-6"><label class="form-label">Marka</label><select name="brand_id" class="form-select" required>
    <option value="">Seciniz</option>
    <?php foreach ($brands as $b): ?>
      <option value="<?= (int)$b['id'] ?>" <?= (int)($item['brand_id'] ?? 0)===(int)$b['id']?'selected':'' ?>><?= e($b['name']) ?></option>
    <?php endforeach; ?>
  </select></div>
  <div class="col-md-6"><label class="form-label">Kategori</label><select name="category_id" class="form-select" required>
    <option value="">Seciniz</option>
    <?php foreach ($categories as $c): ?>
      <option value="<?= (int)$c['id'] ?>" <?= (int)($item['category_id'] ?? 0)===(int)$c['id']?'selected':'' ?>><?= e($c['name']) ?></option>
    <?php endforeach; ?>
  </select></div>
</div>
<div class="row g-3 mt-1">
  <div class="col-md-4"><label class="form-label">Birim</label><input name="unit" class="form-control" value="<?= e((string)($item['unit'] ?? 'adet')) ?>"></div>
  <div class="col-md-4"><label class="form-label">Kritik Stok</label><input type="number" step="0.01" min="0" name="critical_stock_level" class="form-control" value="<?= e((string)($item['critical_stock_level'] ?? '0')) ?>"></div>
  <div class="col-md-4"><label class="form-label">Durum</label>
    <select name="is_active" class="form-select">
      <option value="1" <?= ((string)($item['is_active'] ?? '1')==='1')?'selected':'' ?>>Aktif</option>
      <option value="0" <?= ((string)($item['is_active'] ?? '1')==='0')?'selected':'' ?>>Pasif</option>
    </select>
  </div>
</div>
