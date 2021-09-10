<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index" class="brand-link">

    <img src="img/icon.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">

    <span class="brand-text font-weight-light">POS COMPER</span>

  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="image">

        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">

      </div>

      <div class="info">

        <a href="#" class="d-block"><?php echo $_SESSION["login_user"]; ?></a>

      </div>

    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class  with font-awesome or any other icon font library -->
        <!--=======================
            MENU VENTAS  
        ========================-->
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cash-register"></i>
            <p> Ventas <i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cabecera.php" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p>Facturación</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="listar-factura.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ver Facturas</p>
              </a>
            </li>

          </ul>

        </li>
        <!--=======================
            MENU FINANZAS  
        ========================-->
        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cash-register"></i>
            <p>Finanzas <i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cobros-cabecera.php" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Cobros</p>
              </a>
            </li>

          </ul>

        </li>
        <!--=======================
            MENU UTILS  
        ========================-->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cash-register"></i>
            <p> Utilitidades<i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="visor-facturas.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Visor Facturas</p>
              </a>
            </li>
          </ul>

        </li>

        <li class="nav-item">
          <a href="salir.php" class="nav-link">
          <i class="far fa-window-close nav-icon"></i>
            <p>Salir</p>
          </a>
        </li>
      </ul>

    </nav>

  </div>

</aside>