<style>
  #wrap {
      margin: 0 auto 0 auto;
      width: 30%;
      min-width: 350px;
  }
</style>
<div class="col-md-12 mt-5" id="wrap">
  <div class="login-box">
    <div class="login-logo">
      <a href="#">
        <img src="<?= base_url(); ?>public/images/logo-magic-small.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
        <b>Magic</b>Service
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <h3 class="login-box-msg">Ingreso al sistema</h3>
          <?= '<p>'.$mensaje.'</p>'; ?>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>