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
            MENU DATOS / ABM  
        ========================-->
        <!-- <li class="nav-item has-treeview menu-open"> -->
          <!-- Agregar menu-open para desplegar al abrir -->
          <!-- <a href="#" class="nav-link">
            <i class="nav-icon far fa-clipboard"></i>
            <p> Datos <i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview"> -->
            <!-- <li class="nav-item">
              <a href="personas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Personas</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="clientes" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Clientes</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="usuarios" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Usuarios</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="productos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Productos</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="categorias" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Categorias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="vendedores" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vendedores</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="depositos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Depositos</p>
              </a>
            </li> -->

          <!-- </ul> -->

        <!-- </li> -->
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

            <li class="nav-item">
              <a href="visor-facturas.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Visor Facturas</p>
              </a>
            </li>
          </ul>

        </li>
        <!--=======================
            MENU FINANZAS  
        ========================-->
        <!-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-money-bill-alt"></i>
            <p> Finanzas <i class="right fas fa-angle-left"></i> </p>
          </a> -->

          <!-- <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cajas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Cajas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="apertura-cierre" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Abrir/Cerrar Cajas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="movimiento-caja" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Movimiento de Efectivo</p>
              </a>
            </li>

          </ul> -->
          <!--=======================
            MENU UTILIDADES  
          ========================-->
        <!-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-tools"></i>
            <p> Utilidades <i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="ficha-mercaderia" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Ficha de Mercaderias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="stock-inicial" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock Inicial</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="ajuste-stock" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>Ajuste de Stock</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cambiar-contrasenha" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>Cambiar contraseña</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pruebas" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>PRUEBAS</p>
              </a>
            </li>

          </ul>
        </li> -->
          <!--=======================
            MENU REPORTES  
          ========================-->
          <!-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon far fa-chart-bar"></i>
            <p> Reportes <i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="reporte-ventas" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Reporte de ventas</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="reporte-ajuste-stock" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>Ajustes de Stock</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="reporte-stock" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>Stock de Productos</p>
              </a>
            </li> -->

          <!-- </ul>
        </li> -->

          <!--=======================
            MENU LISTADOS  
          ========================-->
          <!-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link ">
            <i class="nav-icon fas fa-list-ol"></i>
            <p> Listados <i class="right fas fa-angle-left"></i> </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="listado-productos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Listado productos</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="listado-stock-inicial" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Listado Stock Inicial</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="listado-clientes" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>Listado Clientes</p>
              </a>
            </li> -->

            <!-- <li class="nav-item">
              <a href="listado-categorias" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
                <p>Listado Categorias</p>
              </a>
            </li> -->

          <!-- </ul>
        </li> -->

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