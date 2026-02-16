<div class="row g-3">
  <div class="col-md-4">
    <div class="card"><div class="card-body">
      <h5>Kategori Ekle</h5>
      <form method="post" action="/index.php?route=categories.store">
        <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Kategori adi" required></div>
        <button class="btn btn-primary btn-sm">Kaydet</button>
      </form>
    </div></div>
  </div>
  <div class="col-md-8">
    <div class="card"><div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead><tr><th>ID</th><th>Ad</th><th>Durum</th><th>Islem</th></tr></thead>
        <tbody>
        <?php foreach ($categories as $cat): ?>
          <tr>
            <td><?= (int)$cat['id'] ?></td>
            <td>
              <form class="d-flex gap-2" method="post" action="/index.php?route=categories.update">
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$cat['id'] ?>">
                <input class="form-control form-control-sm" name="name" value="<?= e($cat['name']) ?>">
                <button class="btn btn-sm btn-outline-primary">Guncelle</button>
              </form>
            </td>
            <td><?= (int)$cat['is_active'] === 1 ? 'Aktif' : 'Pasif' ?></td>
            <td>
              <form method="post" action="/index.php?route=categories.toggle">
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="id" value="<?= (int)$cat['id'] ?>">
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
