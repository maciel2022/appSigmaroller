<?php

if (!isset($_SESSION)) {
  session_start();
}
//Obtengo los datos de la sesion
$nombre = $_SESSION['usuario'];
$nombre = ucfirst($nombre);
$tipoUsuario = $_SESSION['tipoUsuario'];
$tipoUsuario = ucfirst($tipoUsuario);
$idUsuario = $_SESSION['idUsuario'];

require "../template/head.php";
?>

<body>
  <?php
  require "../template/header.php";

  ?>
  <!-- Main -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Pedidos</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Pedidos</li>
          <li class="breadcrumb-item active">Ver Pedidos</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <!-- Seccion Ver Todos Legajos-->
    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ver Todos los Pedidos</h5>
              <div class="d-flex justify-content-between mx-4">
                <!-- Boton Crear Nuevo Pedido-->
                <div>
                  <button type="button" class="btn btn-success" <?php if ($tipoUsuario == 'Administrador') {; ?> data-bs-toggle="modal" data-bs-target="#modalNuevoPedido" <?php } else if ($tipoUsuario == 'Cliente') {
                                                                                                                                                                            // Consulta a la base de datos para obtener idCliente
                                                                                                                                                                            $sql = "SELECT idCliente FROM cliente WHERE idUsuarios = {$idUsuario}";
                                                                                                                                                                            $result = $mysql->query($sql);
                                                                                                                                                                            // Iterar sobre los resultados y generar las opciones
                                                                                                                                                                            if ($result->num_rows > 0) {
                                                                                                                                                                              while ($row = $result->fetch_assoc()) {
                                                                                                                                                                                $idCliente = $row["idCliente"];
                                                                                                                                                                              }
                                                                                                                                                                            }; ?> onclick="fntGuardarPed(<?= $idCliente; ?>)" <?php }; ?>>Nuevo Pedido</button>
                  <a href="<?= $baseUrl; ?>/views/legajos/main.php" class="btn btn-danger">Atras</a>
                </div>
                <!-- Boton de eliminar todos los borradores de Clientes -->
                <?php if ($tipoUsuario == 'Administrador') {; ?>
                  <div>
                    <button class="btn btn-secondary" onclick="eliminarBorradores()">Eliminar Borradores</button>
                  </div>
                <?php }; ?>
                <!-- Buscador -->
                <div>
                  <form class="d-flex align-items-center" id="frmBuscarPed">
                    <input class="form-control" type="text" name="searchPedido" id="searchPedido" placeholder="Buscar Pedido..." title="Buscar Pedido">
                    <button type="submit" class="btn btn-success bi bi-search"></button>
                  </form>
                </div>
              </div>
              <br>
              <!-- Desde Hasta para seleccionar el listado -->
              <div class="d-flex justify-content-center mb-3">
                <div class="me-2">
                  <label for="desde" id="desdeLabel" class="form-label ms-2 mt-2">Desde:</label>
                  <input type="date" class="form-control" id="desde" name="desde" min="<?php echo date('2023-01-01'); ?>" max="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="me-4">
                  <label for="hasta" id="hastaLabel"  class="form-label ms-2 mt-2">Hasta:</label>
                  <input type="date" class="form-control" id="hasta" name="hasta" min="<?php echo date('2023-01-01'); ?>" max="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="ms-4 mt-2">
                  <label for="filtro" class="form-label ms-2">Filtar por:</label>
                  <select class="form-select" id="filtro" name="filtro" aria-label="Default select example" required>
                    <option disabled selected>Seleccione un Estado</option>
                    <option value="Creado">Creado</option>
                    <option value="En Proceso">En Proceso</option>
                    <option value="Finalizado">Finalizado</option>
                    <option value="Entregado">Entregado</option>
                    <option value="Todo">Ver Todos</option>
                  </select>
                </div>
              </div>
              <div class="table-responsive">
                <table id="tblPedidos" class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col" style="display: none;">#</th>
                      <th style="text-align: center;">Cliente</th>
                      <th style="text-align: center;">Nro Pedido</th>
                      <th scope="col" style="display: none;">idComprobante</th>
                      <th scope="col" 
                          style="text-align: center; cursor: pointer;" 
                          title="Cambiar orden Fecha"     
                          onclick="ordenarPorFecha()"
                          onmouseover="this.style.color='blue'" 
                          onmouseout="this.style.color='black'" 
                      >
                          <span>Fecha</span><i class="bi bi-arrow-down-up ms-2"></i>   
                      </th>
                      <th style="text-align: center;">Valor Total</th>
                      <th style="text-align: center" ;>Estado</th>
                      <th style="text-align: center" ;>Opciones</th>
                    </tr>
                  </thead>
                  <tbody id="tblBodyPedidos">

                  </tbody>
                </table>

                <!-- Comienzo Ventana Modal Nuevo Pedido-->
                <div class="modal fade" id="modalNuevoPedido" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Nuevo Pedido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form id="frmNuevoPedido" method="POST">
                          <div class="row mb-3 px-4">
                            <label for="txtIdCliente" class="form-label">Cliente</label>
                            <div class="col-sm-14">
                              <select class="form-select" id="txtIdCliente" name="txtIdCliente" aria-label="Default select example" required>
                                <option value="">Cliente - Nombre</option>
                                <?php
                                // Consulta a la base de datos para obtener los nombres de cliente
                                $sql = "SELECT * FROM cliente WHERE estado = 0";
                                $result = $mysql->query($sql);
                                // Iterar sobre los resultados y generar las opciones
                                if ($result->num_rows > 0) {
                                  while ($row = $result->fetch_assoc()) {
                                    $id = $row["idCliente"];
                                    $nombre = $row["nombreCliente"];
                                    echo "<option value='$id'>$id - $nombre</option>";
                                  }
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                          <div class="row mb-3 px-4">
                            <button type="submit" class="btn btn-success ">Comenzar Pedido</button>
                          </div>
                          <div class="row mb-3 px-4">
                            <a href="<?= $baseUrl; ?>/views/legajos/nuevo-legajo.php" class="btn btn-warning">Nuevo Cliente</a>
                          </div>

                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Fin Ventana Modal Nuevo Pedido-->
              </div>

              <!-- Paginador -->
              <div class="d-flex justify-content-center mb-2">
                <div id="paginador"></div>
              </div>

              <div class="d-flex justify-content-center">
                <a href="<?= $baseUrl; ?>/views/legajos/main.php" class="btn btn-danger">Atras</a>
              </div>
            </div>
          </div>
    </section>

  </main><!-- End #main -->

  <?php
  require "../template/footer.php";
  ?>
  <script src="../template/js/functions-pedidos.js"></script>