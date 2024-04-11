<?php
require "../template/funciones.php";

$acceso = accesoAdmin();


if (!$acceso) {
  header('Location: /');
}

if(!isset($_SESSION)){
  session_start();
}
//Obtengo los datos de la sesion
$nombre = $_SESSION['usuario'];
$nombre = ucfirst($nombre);
$tipoUsuario = $_SESSION['tipoUsuario'];
$tipoUsuario = ucfirst($tipoUsuario);

require "../template/head.php";
?>

<body>
  <?php
  require "../template/header.php";
  ?>
  <!-- Main -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Menu Principal</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $baseUrl; ?>/views/legajos/main.php">Inicio</a></li>
          <li class="breadcrumb-item active">Menu principal</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!-- Section Menu Principal -->
    <section class="section">
    <div class="row">
      <div class="col">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p class="text-start">BIENVENIDO!</p>
          <p>Hola <?php echo $nombre; ?>, ingresaste al gestor de personal de SigmaRoller, tu ultima sesion fue el dia: (ultima sesion)</p>
        </div>
      </div>
    </div>    
   <!-- card accesos frecuentes -->
    <!-- <div class="row">
      <div class="col ms-3">
        <div class="row">

          <div class="card-body ">
            <h5 class="card-title ms-2">Qué desea hacer?<span>| Accesos frecuentes</span></h5>

            <div class="">
              <a href="#" class="btn btn-danger  col-3 mt-2 ms-5">Legajos</a>
              <a href="#" class="btn btn-danger col-3 mt-2 ms-2">Licencias</a>
              <a href="#" class="btn btn-danger col-3 mt-2 ms-2">Francos</a>
            </div>

          </div>

        </div>
      </div>


      <div class="col ms-2 me-3">
        <div class="row">

          <div class="card-body ">
            <h5 class="card-title ms-2">Qué desea hacer?<span>| Accesos frecuentes</span></h5>

            <div class="">
              <a href="#" class="btn btn-danger  col-3 mt-2 ms-5">Pendientes</a>
              <a href="#" class="btn btn-danger col-3 mt-2 ms-2">Config.</a>
              <a href="#" class="btn btn-danger col-3 mt-2 ms-2">Informes</a>
            </div>

          </div>

        </div>
      </div>
    </div> -->
    </section>

  </main><!-- End #main -->

  <?php
  require "../template/footer.php";
  ?>