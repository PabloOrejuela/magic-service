  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars btn-collapse"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url(); ?>ventas" class="btn btn-primary" id="btn-pedido" data-id="<?= session('id') ?>">Registrar Nuevo Pedido</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block px-3">
        <a href="<?= base_url(); ?>cotizador" class="btn btn-primary" id="btn-cotizador">Cotizador</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block px-1">
        <a href="<?= base_url(); ?>pedidos" class="btn btn-primary" id="btn-cotizador">Pedidos</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item px-3">
        <a href="<?= base_url(); ?>logout" class="nav-link">Salir</a>
      </li>
    </ul>
  </nav>
  <script src="<?= site_url(); ?>public/js/navbar.js"></script>