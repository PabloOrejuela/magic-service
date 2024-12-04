<link rel="stylesheet" href="<?= site_url() ?>public/css/side-menu.css">
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
    
  <?php

    if ($session->ventas == 1) {
      echo '
        <li class="nav-item">
        <a href="#" class="nav-link" id="btnVentas">
          <i class="fa-brands fa-shopify menu-icon"></i>
          <p>
            Ventas
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item subItem">
            <a href="'.base_url().'ventas" class="nav-link" id="btn-pedido-nuevo" data-id="'.session('id').'">
              <i class="far fa-circle nav-icon"></i>
              <p>Registrar pedido</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'pedidos" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Pedidos</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'estadistica-ventas" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Estadística de ventas</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'productos" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Productos</p>
            </a>
          </li>
        </ul>
      </li>';
    }
    if ($session->clientes == 1) {
      echo '
        <li class="nav-item">
        <a href="#" class="nav-link" id="btnVentas">
          <i class="fa-solid fa-users menu-icon"></i>
          <p>
            Clientes
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item subItem">
            <a href="'.base_url().'clientes" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Lista de Clientes</p>
            </a>
          </li>
        </ul>
      </li>';
    }
    if ($session->admin == 1) {
      echo '
      <li class="nav-item">
        <a href="#" class="nav-link" >
          <i class="fa-solid fa-toolbox menu-icon"></i>
          <p>
             Administración
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item subItem">
            <a href="'.base_url().'items" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Items</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'formas-pago" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Formas de pago</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'institucion-financiera" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Instituciones financieras</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'usuarios" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Usuarios</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'roles" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Roles</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'sucursales" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Sucursales</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'sectores-entrega" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Sectores de entrega</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'variables-sistema" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Variables del sistema</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'estado" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Estado del sistema</p>
            </a>
          </li>
        </ul>
      </li>';
    }

    if ($session->proveedores == 1) {
      echo '
      <li class="nav-item" onclick="activeFunc()">
        <a href="#" class="nav-link">
          <i class="fa-solid fa-truck-field menu-icon"></i>
          <p>
            Proveedores
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview" id="btnAdmin">
          <li class="nav-item subItem">
            <a href="'.base_url().'proveedores" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Proveedores</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'gastos" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Gastos</p>
            </a>
          </li>
        </ul>
      </li>';
    }

    if ($session->proveedores == 1) {
      echo '
      <li class="nav-item" onclick="activeFunc()">
        <a href="#" class="nav-link">
          <i class="fa-solid fa-warehouse menu-icon"></i>
          <p>
            Inventario
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview" id="btnAdmin">
          <li class="nav-item subItem">
            <a href="'.base_url().'gestion-inventario" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Gestion de Inventario</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="'.base_url().'inventario" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inventario</p>
            </a>
          </li>
        </ul>
      </li>';
    }

    if ($session->reportes == 1) {
      echo '
      <li class="nav-item" onclick="activeFunc()">
        <a href="#" class="nav-link">
          <i class="fa-solid fa-chart-simple menu-icon"></i>
          <p>
            Reportes
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item subItem">
            <a href="'.base_url().'reporte" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Control diario de ventas</p>
            </a>
          </li>
          <li class="nav-item subItem">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Reporte de Procedencias</p>
            </a>
          </li>
        </ul>
      </li>';
    }
  ?>
  </ul>
</nav>
<script src="https://kit.fontawesome.com/90e597c088.js" crossorigin="anonymous"></script>
<script src="<?= site_url(); ?>public/js/side-menu.js"></script>
