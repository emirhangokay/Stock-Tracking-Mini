<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h4 class="mb-3">Giris Yap</h4>
        <form method="post" action="/index.php?route=login.post">
          <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
          <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Sifre</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Giris</button>
        </form>
      </div>
    </div>
  </div>
</div>
