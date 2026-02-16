<div class="card col-lg-7">
  <div class="card-body">
    <h4 class="mb-3">Urun Ekle</h4>
    <form method="post" action="/index.php?route=products.store">
      <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
      <?php include BASE_PATH . '/views/products/form.php'; ?>
      <button class="btn btn-primary">Kaydet</button>
      <a href="/index.php?route=products" class="btn btn-light">Iptal</a>
    </form>
  </div>
</div>
