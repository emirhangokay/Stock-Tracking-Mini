<div class="row justify-content-center align-items-center" style="min-height: calc(100vh - 130px);">
  <div class="col-xl-10">
    <div class="login-shell">
      <div class="row g-0">
        <div class="col-lg-6 login-hero p-4 p-md-5 d-flex flex-column justify-content-between">
          <div>
            <span class="badge text-bg-light text-primary-emphasis px-3 py-2 mb-3">Stok Takip Mini ERP</span>
            <h2 class="fw-bold mb-3" style="line-height: 1.2;">Stok, satış ve operasyon takibini tek panelden yönetin.</h2>
            <p class="mb-0" style="opacity: 0.92;">Hızlı giriş yapın, ürün ve stok hareketlerinizi güvenli şekilde yönetin.</p>
          </div>

          <ul class="list-unstyled mt-4 mb-0 small">
            <li class="mb-2"><i class="bi bi-check2-circle me-2"></i>Rol bazlı yetkilendirme</li>
            <li class="mb-2"><i class="bi bi-check2-circle me-2"></i>Transaction güvenli satış işlemleri</li>
            <li><i class="bi bi-check2-circle me-2"></i>Kritik stok ve günlük ciro takibi</li>
          </ul>
        </div>

        <div class="col-lg-6 bg-white p-4 p-md-5">
          <h4 class="mb-1 fw-bold">Giriş Yap</h4>
          <p class="section-subtitle mb-4">Hesabınızla devam edin.</p>

          <form method="post" action="/index.php?route=login.post" class="d-grid gap-3">
            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

            <div>
              <label class="form-label">E-posta</label>
              <input type="email" name="email" class="form-control" placeholder="ornek@firma.com" required>
            </div>

            <div>
              <label class="form-label">Şifre</label>
              <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button class="btn btn-primary mt-2">
              <i class="bi bi-box-arrow-in-right me-1"></i>Giriş Yap
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
