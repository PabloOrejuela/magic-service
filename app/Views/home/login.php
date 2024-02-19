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
        <p class="login-box-msg">Ingreso al sistema</p>
        <?php 
          //session()->getFlashdata('error'); 
        ?>
        <form action="<?= base_url(); ?>validate_login" method="post" class="form">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="user" placeholder="usuario" value="wolf">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <p id="error-message"><?= session('errors.user');?> </p>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" value="wolfabadon">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <p id="error-message"><?= session('errors.password');?> </p>
          <div class="row">
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
            <!-- /.col -->
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <?php
                
                if (session('mensaje')) {
                  echo'<div class="alert alert-danger mt-2" role="alert">'.session('mensaje').'</div>';
                }
              ?>
              
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center mb-3">
          <p> o tal vés...</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Ingresar usando Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Ingresar usando Google+
          </a>
        </div> -->
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
          <a href="forgot-password.html">Olvidé mi password</a>
        </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
</div>