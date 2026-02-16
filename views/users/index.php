<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Kullanici Yonetimi</h3>
  <a href="/index.php?route=users.create" class="btn btn-primary btn-sm">Yeni Kullanici</a>
</div>
<div class="card">
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead><tr><th>ID</th><th>Ad</th><th>E-posta</th><th>Rol</th><th>Durum</th><th>Islem</th></tr></thead>
      <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= (int)$u['id'] ?></td>
          <td><?= e($u['name']) ?></td>
          <td><?= e($u['email']) ?></td>
          <td><?= e($u['role']) ?></td>
          <td><?= (int)$u['is_active'] === 1 ? 'Aktif' : 'Pasif' ?></td>
          <td class="d-flex gap-2">
            <form method="post" action="/index.php?route=users.toggle">
              <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
              <button class="btn btn-sm btn-outline-warning">Aktif/Pasif</button>
            </form>
            <form method="post" action="/index.php?route=users.reset-password">
              <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
              <button class="btn btn-sm btn-outline-secondary">Sifre Sifirla</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
