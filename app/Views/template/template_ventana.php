<?php echo view('includes/header');?>
<body class="">
<div class="content mt-5">
    <?= $this->renderSection('content'); ?>
  </div>
<!-- ./wrapper -->

<!-- jQuery -->

<script src="<?= site_url(); ?>public/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
            if(tecla.charCode < 48 || tecla.charCode > 57){
                return false;
            }
        });
    });
</script>
</body>
</html>
