<meta name="viewport" content="width=device-width, initial-scale=1">

<!--select2
<link rel="stylesheet" href="../css/select2.css">
sweetalert2
<link rel="stylesheet" href="../css/sweetalert2.min.css">
-->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../css/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../vista/adm_catalogo.php" class="nav-link">Home</a>
      </li>
      
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <a href="../controlador/logout.php"> Cerrar Sesion</a>
      
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../vista/adm_catalogo.php" class="brand-link">
      <img src="../img/doctor.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Farmacia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img id="avatar4" src="../img/avatar04.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">    
                <?php 
                echo $_SESSION['nombre_us']; 
                ?>
            </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         <li class="nav-header">Usuario</li>
          <li class="nav-item">
            <a href="editar_datos_personales.php" class="nav-link">
              <i class="nav-icon far fa-user-cog"></i>
              <p>
                Datos personales
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adm_usuario.php" class="nav-link">
              <i class="nav-icon far fa-users"></i>
              <p>
                Gestion Usuario
              </p>
            </a>
          </li>
          <li class="nav-header">Ventas</li>
          
          <li class="nav-item">
            <a href="adm_venta.php" class="nav-link">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Nueva Venta
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="adm_venta_historial.php" class="nav-link"> <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>
                Historial Ventas
              </p>
            </a>
          </li>

        </ul> </nav>
          ```
          <li class="nav-header">Almacen</li>
          <li class="nav-item">
            <a href="adm_proveedor.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i> <p>
                Gestión Proveedor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adm_producto.php" class="nav-link">
              <i class="nav-icon fas fa-pills"></i>
              <p>
                Gestionar producto
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="adm_atributo.php" class="nav-link">
              <i class="nav-icon fas fa-vials"></i>
              <p>
                Gestion atributo
              </p>
            </a>
          </li>
          <!-- AGREGAR ESTO: GESTIÓN DE LOTES -->
          <li class="nav-item">
            <a href="adm_lote.php" class="nav-link">
              <i class="nav-icon fas fa-cubes"></i> <!-- Icono de cubos/lotes -->
              <p>Gestión Lote</p>
            </a>
          </li>
          <li class="nav-item">
              <a href="adm_reporte_venta.php" class="nav-link">
                  <i class="nav-icon fas fa-chart-line"></i>
                  <p>
                      Reporte de Ventas
                  </p>
              </a>
          </li>
          <!-- FIN DEL BLOQUE NUEVO -->

          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>