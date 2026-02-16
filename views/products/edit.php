<div class="card col-lg-7">
  <div class="card-body">
    <h4 class="mb-3">Urun Duzenle</h4>
    <form method="post" action="/index.php?route=products.update&id=<?= (int)$product['id'] ?>">
      <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$product['id'] ?>">
      <?php include BASE_PATH . '/views/products/form.php'; ?>
      <button class="btn btn-primary">Guncelle</button>
      <a href="/index.php?route=products" class="btn btn-light">Iptal</a>
    </form>
  </div>
</div>
