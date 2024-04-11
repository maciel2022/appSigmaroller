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
  // require "../template/header.php";
  if (isset($_GET['p'])) {
    $nroPedido = $_GET['p'];
  }

  ?>
  <!-- Main -->
  <!-- <main id="main" class="main"> -->

    <!-- <div class="pagetitle">
      <h1> Imprimir Pedido</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= $baseUrl; ?>/views/pedidos/pedido.php">Pedido</a></li>
          <li class="breadcrumb-item active">Imprimir Pedido</li>
        </ol>
      </nav>
    </div>End Page Title -->

    <!-- <section class="section dashboard"> -->
      <div class="text-center mt-4">
        <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger bi bi-box-arrow-left"> Atras</a>
        <button class="btn btn-secondary bi bi-printer" onclick="imprimir()"> Imprimir</button>
      </div>

      <div class="container" id="container">
        <div class="d-flex justify-content-center mb-4">
          <img src="../../assets/img/logoSigmaroller.jpg" alt="logo" style="border-radius: 10px; width: 60px; height: 60px;" class="mx-3">
          <h1 class="text-center ms-3 me-1 pt-2"><strong>sigma</strong>roller</h1>
          <p class="pt-2">&reg</p>
        </div>

        <h2 class="text-center mb-3"><strong>ORDEN DE TRABAJO</strong></h2>
        <input type="hidden" id="nroPedido" value="<?php echo $nroPedido; ?>">
        <div class="d-flex justify-content-around mb-3" id="ordenPedido" name="ordenPedido">

        </div>

        <h3 class="mb-3 ms-2">Detalle de Productos:</h3>
        <ul class="detallesOrden " id="detallesOrden" name="detallesOrden">

        </ul>

      </div>

      <div class="text-center mb-4">
        <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger bi bi-box-arrow-left"> Atras</a>
        <button class="btn btn-secondary bi bi-printer" onclick="imprimir()"> Imprimir</button>
      </div>

    <!-- </section>

  </main>End #main -->

  <!-- Vendor JS Files -->
  <script src="<?php echo $baseUrl; ?>/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo $baseUrl; ?>/assets/vendor/php-email-form/validate.js"></script>

<!-- Main JS File -->
<script>
  const base_url = "<?php echo $baseUrl; ?>/";
</script>
<script src="<?php echo $baseUrl; ?>/assets/js/main.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo $baseUrl; ?>/assets/js/functions.js">  </script>
</body>

</html>

  <script src="../template/js/functions-items.js"></script>
  <script>
    function imprimir() {
      window.print();
    }
  </script>