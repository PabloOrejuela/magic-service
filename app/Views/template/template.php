<?php echo view('includes/header');?>
<body class="hold-transition sidebar-mini layout-fixed" >
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= base_url(); ?>public/images/logo-magic-small.png" alt="logo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
  <?php echo view('includes/navbar');?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #00514e;">
    <!-- Brand Logo -->
    <a href="<?= base_url(); ?>" class="brand-link">
      <img src="<?= base_url(); ?>public/images/logo-magic-small.png" alt="magic Service Logo" class="brand-image img-circle elevation-3" style="opacity: .8" id="business-logo">
      <span class="brand-text font-weight-light">Magic Service</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url(); ?>public/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $session->nombre;?></a>
          <p style="color: #FFF;"><?= $session->rol?></p>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <?php echo view('includes/side-menu');?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?= $this->renderSection('content'); ?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer mt-3">
    <strong class="px-3">Versión del sistema  <?= session('version')[0]->version; ?></strong>
    <strong class="px-3">Copyright &copy; 2014-2021 <a href="https://appdvp.com">Magic service</a>.</strong>
    Derechos reservados.
    <div class="float-right d-none d-sm-inline-block px-5">
    </div>
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script src="<?= site_url(); ?>public/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= site_url(); ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= site_url(); ?>public/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= site_url(); ?>public/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= site_url(); ?>public/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= site_url(); ?>public/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= site_url(); ?>public/plugins/moment/moment.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= site_url(); ?>public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= site_url(); ?>public/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= site_url(); ?>public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= site_url(); ?>public/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= site_url(); ?>public/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<!-- <script src="<?= site_url(); ?>public/dist/js/pages/dashboard.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<!-- DataTables  & Plugins -->
<script src="<?= site_url(); ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/jszip/jszip.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= site_url(); ?>public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(document).ready(function(){

        jQuery('.number').keypress(function(tecla){
            if(tecla.charCode != 46 && tecla.charCode < 48 || tecla.charCode > 57 ){
              return false
            }
        });
    });

    // window.addEventListener('beforeunload', function() {
    //     // milisegundos que espera el navegador antes de cerrar la pagina
        
    //     var x = 3000;
    //     var a = (new Date()).getTime() + x;
    //     alert("vas a cerrar la app")

    //     // -----------
    //     // Llamadas asincronas o AJAX aqui, diciendole 
    //     // al servidor que la ventana del cliente se va a cerrar
    //     // -----------

    //     // Aqui el navegador va a esperar el valor de X milisegundos dandole 
    //     // tiempo a la consulta asincrona a ser enviada. 
    //     // Si ese tiempo no se usa, el navegador cierra la
    //     // ventana desechando la llamada asincrona
    //     while ((new Date()).getTime() < a) {}
    // }, false)

</script>
</body>
</html>
