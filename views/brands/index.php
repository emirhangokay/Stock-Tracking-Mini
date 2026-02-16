<div class="row g-3">
  <div class="col-md-4">
    <div class="card"><div class="card-body">
      <h5>Marka Ekle</h5>
      <form method="post" action="/index.php?route=brands.store">
        <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Marka adi" required></div>
        <button class="btn btn-primary btn-sm">Kaydet</button>
      </form>
    </div></div>
  </div>
  <div class="col-md-8">
    <div class="card"><div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead><tr><th>ID</th><th>Ad</th><th>Durum</th><th>Islem</th></tr></thead>
        <tbody>
        <?php foreach ($brands as $brand): ?>
          <tr>
            <td><?= (int)$brand['id'] ?></td>
            <td>
              <form class="d-flex gap-2" method="post" action="/index.php?route=brands.update">
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$brand['id'] ?>">
                <input class="form-control form-control-sm" name="name" value="<?= e($brand['name']) ?>">
                <button class="btn btn-sm btn-outline-primary">Guncelle</button>
              </form>
            </td>
            <td><?= (int)$brand['is_active'] === 1 ? 'Aktif' : 'Pasif' ?></td>
            <td>
              <form method="post" action="/index.php?route=brands.toggle">
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$brand['id'] ?>">
                <button class="btn btn-sm btn-outline-warning">Degistir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div></div>
  </div>
</div>
