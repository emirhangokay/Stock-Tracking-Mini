<nav class="navbar navbar-expand-lg bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand" href="/index.php?route=dashboard">Stok Takip Mini ERP</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <?php if (is_logged_in()): ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/index.php?route=dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=products">Urunler</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=brands">Markalar</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=categories">Kategoriler</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=movements">Stok Hareketleri</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=sales">Satislar</a></li>
        <li class="nav-item"><a class="nav-link" href="/index.php?route=reports">Raporlar</a></li>
        <?php if (is_admin()): ?>
          <li class="nav-item"><a class="nav-link" href="/index.php?route=users">Kullanicilar</a></li>
        <?php endif; ?>
      </ul>
      <div class="d-flex align-items-center gap-3">
        <span class="text-muted small"><?= e(current_user()['name']) ?> (<?= e(current_user()['role']) ?>)</span>
        <a href="/index.php?route=logout" class="btn btn-outline-danger btn-sm">Cikis</a>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
