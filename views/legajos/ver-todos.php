<?php

if (!isset($_SESSION)) {
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
      <h1>Clientes</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Clientes</li>
          <li class="breadcrumb-item active">Ver Clientes</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!-- Seccion Ver Todos Legajos-->
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ver Todos los Clientes</h5>
              <div class="d-flex justify-content-between mx-4">
                <!-- Boton Crear Nuevo Legajo-->
                <div>
                  <a href="<?= $baseUrl; ?>/views/legajos/nuevo-legajo.php" class="btn btn-success">Nuevo Cliente</a>
                  <a href="<?= $baseUrl; ?>/views/legajos/main.php" class="btn btn-danger">Atras</a>
                </div>
                <!-- Buscador -->
                <div>
                  <form class="d-flex align-items-center" id="frmBuscador">
                    <input class="form-control" type="text" id="txtBuscador" name="txtBuscador" placeholder="Buscar...." title="buscador">
                    <button type="submit" class="btn btn-success bi bi-search"></button>
                  </form>
                </div>
              </div>
              <br>
              <div class="table-responsive">
                <table id="tblLegajos" class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col" style="display: none;">Id</th>
                      <th style="text-align: center">Cliente - Nombre</th>
                      <th style="text-align: center">Razon Social</th>
                      <th style="text-align: center">Saldo Cta. Corr.</th>
                      <th style="text-align: center">Estado</th>
                      <th style="text-align: center">Editar</th>
                    </tr>
                  </thead>
                  <tbody id="tblBodyLegajos">

                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  <a href="<?= $baseUrl; ?>/views/legajos/main.php" class="btn btn-danger">Atras</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php
  require "../template/footer.php";
  ?>

  <script src="../template/js/functions-legajos.js"></script>