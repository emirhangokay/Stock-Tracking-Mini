<div class="card col-md-6">
  <div class="card-body">
    <h4 class="mb-3">Yeni Kullanici</h4>
    <form method="post" action="/index.php?route=users.store">
      <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
      <div class="mb-3"><label class="form-label">Ad Soyad</label><input type="text" name="name" class="form-control" required></div>
      <div class="mb-3"><label class="form-label">E-posta</label><input type="email" name="email" class="form-control" required></div>
      <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="role" class="form-select">
          <option value="Personel">Personel</option>
          <option value="Admin">Admin</option>
        </select>
      </div>
      <button class="btn btn-primary">Kaydet</button>
      <a href="/index.php?route=users" class="btn btn-light">Iptal</a>
    </form>
  </div>
</div>
