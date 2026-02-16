<?php
$currentRoute = (string)($_GET['route'] ?? 'dashboard');
if ($currentRoute === '') {
    $currentRoute = 'dashboard';
}

$isActive = static function (array $prefixes) use ($currentRoute): string {
    foreach ($prefixes as $prefix) {
        if ($currentRoute === $prefix || str_starts_with($currentRoute, $prefix . '.')) {
            return 'active';
        }
    }
    return '';
};
?>
<nav class="navbar navbar-expand-lg">
  <div class="container content-wrap">
    <a class="navbar-brand" href="/index.php?route=dashboard">
      <span class="brand-dot"></span>
      <span>Stok Takip Mini ERP</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <?php if (is_logged_in()): ?>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1 mt-2 mt-lg-0">
          <li class="nav-item"><a class="nav-link <?= $isActive(['dashboard']) ?>" href="/index.php?route=dashboard"><i class="bi bi-grid-1x2-fill me-1"></i>Dashboard</a></li>
          <li class="nav-item"><a class="nav-link <?= $isActive(['products']) ?>" href="/index.php?route=products"><i class="bi bi-box-seam me-1"></i>Ürünler</a></li>
          <li class="nav-item"><a class="nav-link <?= $isActive(['brands']) ?>" href="/index.php?route=brands"><i class="bi bi-bookmark-check me-1"></i>Markalar</a></li>
          <li class="nav-item"><a class="nav-link <?= $isActive(['categories']) ?>" href="/index.php?route=categories"><i class="bi bi-diagram-3 me-1"></i>Kategoriler</a></li>
          <li class="nav-item"><a class="nav-link <?= $isActive(['movements']) ?>" href="/index.php?route=movements"><i class="bi bi-arrow-left-right me-1"></i>Stok Hareketleri</a></li>
          <li class="nav-item"><a class="nav-link <?= $isActive(['sales']) ?>" href="/index.php?route=sales"><i class="bi bi-receipt me-1"></i>Satışlar</a></li>
          <li class="nav-item"><a class="nav-link <?= $isActive(['reports']) ?>" href="/index.php?route=reports"><i class="bi bi-graph-up-arrow me-1"></i>Raporlar</a></li>
          <?php if (is_admin()): ?>
            <li class="nav-item"><a class="nav-link <?= $isActive(['users']) ?>" href="/index.php?route=users"><i class="bi bi-people me-1"></i>Kullanıcılar</a></li>
          <?php endif; ?>
        </ul>

        <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
          <span class="badge text-bg-light border text-secondary-emphasis px-3 py-2">
            <?= e(current_user()['name']) ?> · <?= e(current_user()['role']) ?>
          </span>
          <a href="/index.php?route=logout" class="btn btn-outline-danger btn-sm px-3">
            <i class="bi bi-box-arrow-right me-1"></i>Çıkış
          </a>
        </div>
      <?php else: ?>
        <div class="ms-auto mt-2 mt-lg-0">
          <span class="badge text-bg-light border text-secondary-emphasis px-3 py-2">Demo Uygulama</span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
