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
  if (isset($_GET['p'])) {
    $nroPedido = $_GET['p'];
  }

  ?>
  <!-- Main -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1> Ver Pedido</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= $baseUrl; ?>/views/pedidos/ver-pedidos.php">Pedido</a></li>
          <li class="breadcrumb-item active">Ver Pedido</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="text-center">
         <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger bi bi-box-arrow-left"> Atras</a>
      </div>
    
      <div class="container">
        <div class="d-flex justify-content-center mb-4">
          <img src="../../assets/img/logoSigmaroller.jpg" alt="logo" style="border-radius: 10px; width: 60px; height: 60px;" class="mx-3">
          <h1 class="text-center ms-3 me-1 pt-2"><strong>sigma</strong>roller</h1><p class="pt-2">&reg</p>
        </div>
        
        <h2 class="text-center mb-3"><strong>VER PEDIDO</strong></h2>
        <input type="hidden" id="nroPedido" value="<?php echo $nroPedido; ?>">
        <div class="d-flex justify-content-around mb-3" id="ordenPedido" name="ordenPedido">
          
        </div>

        <h3 class="mb-3 ms-2">Detalle de Productos:</h3>
        <ul class="detallesOrden " id="detallesOrden" name="detallesOrden">
       
        </ul>

      </div>

      <div class="text-center">
         <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger bi bi-box-arrow-left"> Atras</a>
      </div>

    </section>

  </main><!-- End #main -->

  <?php
    require "../template/footer.php";
  ?>

  <script src="../template/js/functions-items.js"></script>