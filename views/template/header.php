<?php 
//Condicion para recargar paginas si sesion ya esta abierta
if(!isset($_SESSION)){
  session_start();
}

//Obtengo los datos de la sesion
$nombre = $_SESSION['usuario'];
$idUsuario = $_SESSION['idUsuario'];
$nombre = ucfirst($nombre);
$inicial = substr($nombre, 0, 1);
$tipoUsuario = $_SESSION['tipoUsuario'];
$tipoUsuario = ucfirst($tipoUsuario);

require_once "../../config/config.php";
  //Conexion a BD
  function conect()
  {
    $mysql = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $mysql->set_charset(DB_CHARSET);
    if (mysqli_connect_errno()) {
      echo "Error en la conexion: " . mysqli_connect_errno();
    }
    return $mysql;
  }

  $mysql = conect(); //Variable que nos conecta 

  $sql = "SELECT idCliente FROM cliente WHERE '{$idUsuario}' = idUsuarios";
  $result = $mysql->query($sql);
  if($result->num_rows > 0){
    $idCliente = $result->fetch_assoc();
    $idCliente = $idCliente['idCliente'];
  }
  
// var_dump($idCliente);
// exit;
?>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center">
        <img src="<?php echo $baseUrl; ?>/assets/img/logoSigmaroller.jpg" alt="logo Sigmaroller" class="rounded-circle">
        <span class="d-none d-lg-block">appSigmaroller</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- Fin Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span style="display: inline-block; width: 45px; height: 45px; line-height: 45px; border-radius: 50%; background-color: rgb(71, 201, 197); color: white; text-align: center; font-size: 24px;">
            <?php echo $inicial; ?>
            </span>
            <span class="d-none d-md-block dropdown-toggle ps-2 text-light"><?php echo $nombre; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $nombre; ?></h6>
              <span><?php echo $tipoUsuario; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#cambioContra">
                <i class="bi bi-gear"></i>
                <span>Cambiar contraseña</span>
              </a>
            </li>
            <li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?php echo $baseUrl; ?>/views/template/cerrarsesion.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar sesión</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?php echo $baseUrl; ?>/views/legajos/main.php">
          <i class="bi bi-grid"></i>
          <span>Menu Principal</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <?php if($tipoUsuario == 'Administrador'){; ?>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#legajos" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Clientes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="legajos" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo $baseUrl; ?>/views/legajos/ver-todos.php">
              <i class="bi bi-circle"></i><span>Ver Clientes</span>
            </a>
          </li>
          
          <li>
            <a href="<?php echo $baseUrl; ?>/views/legajos/nuevo-legajo.php">
              <i class="bi bi-circle"></i><span>Nuevo Cliente</span>
            </a>
          </li>
        </ul>
      </li>



      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-folder2-open"></i><span>Configuraciones</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">  
          <li>
            <a href="<?php echo $baseUrl; ?>/views/productos/configuracion-cortinas.php">
              <i class="bi bi-circle"></i><span>Cortinas-globales</span>
            </a>
          </li>
          <li>
            <a href="<?php echo $baseUrl; ?>/views/productos/configuracion-cbv.php">
              <i class="bi bi-circle"></i><span>Cortinas-B.V.</span>
            </a>
          </li>
          <li>
            <a href="<?php echo $baseUrl; ?>/views/productos/configuracion-cr.php">
              <i class="bi bi-circle"></i><span>Cortinas-Roller</span>
            </a>
          </li>
          <li>
            <a href="<?php echo $baseUrl; ?>/views/productos/productos.php">
              <i class="bi bi-circle"></i><span>Productos</span>
            </a>
          </li>
        </ul>
      </li>
      <?php }; ?>

      <li class="nav-item">
        <a class="nav-link " href="<?php echo $baseUrl; ?>/views/pedidos/pedido.php">
          <i class="bi bi-cart3"></i>
          <span>Pedidos</span>
        </a>
      </li>
      <?php if($tipoUsuario != 'Administrador'){; ?>
      <li class="nav-item">
        <a class="nav-link " href="<?php echo $baseUrl; ?>/views/comprobantes/comprobantes.php?p=<?php echo $idCliente; ?>">
          <i class="bi bi-file-earmark-text"></i>
          <span>Cuenta Corriente</span>
        </a>
      </li>
      <?php } ; ?>
    </ul>

  </aside><!-- End Sidebar -->

  <!-- Comienzo Ventana Modal Cambiar Contraseña-->
  <div class="modal fade" id="cambioContra" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cambiar Contraseña</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="frmCambioContra">
            <div class="row mb-3 px-4">
              <label for="idUsuario" class="form-label"></label>
              <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $idUsuario; ?>">
            </div>
            <div class="row mb-3 px-4">
              <label for="nuevaContra" class="form-label">Nueva contraseña</label>
              <input type="text" class="form-control" id="txtNuevaContra" name="txtNuevaContra" placeholder="Nueva contraseña" required>
            </div>
            <div class="row mb-3 px-4">
              <label for="repNuevaContra" class="form-label">Reingresar nueva contraseña</label>
              <input type="text" class="form-control" id="txtRepNuevaContra" name="txtRepNuevaContra" placeholder="Repetir nueva contraseña" required>
            </div>


            <div class="row mb-3 px-4">
              <button type="submit" class="btn btn-success ">CONFIRMAR</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button"  name="btnCerrarModal" id="btnCerrarModal" data-bs-dismiss="modal"  class="btn btn-danger"  onclick="resetFrmContra()">CANCELAR</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fin Ventana Modal cambiar contraseña-->
  <script src="../template/js/functions-contrasena.js"></script>
 <script >
    function resetFrmContra(){
    let form = document.getElementById("frmCambioContra");
    form.reset();
    }
 </script>
