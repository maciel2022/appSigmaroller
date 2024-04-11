<?php

if (!isset($_SESSION)) {
    session_start();
}
//Obtengo los datos de la sesion
$nombre = $_SESSION['usuario'];
$nombre = ucfirst($nombre);
$tipoUsuario = $_SESSION['tipoUsuario'];


require "../template/head.php";

?>

<body>

    <?php
    require "../template/header.php";

    if (isset($_GET['p'])) {
        // Obtiene el valor del parámetro 'p'
        $idCliente = $_GET['p'];
    }

    $query1 = "SELECT nombreCliente FROM cliente WHERE idCliente = '{$idCliente}'";
    $sql1 = $mysql->query($query1);
    $result1 = $sql1->fetch_assoc();
    $nombreCliente = $result1['nombreCliente'];
    ?>


    <!-- Main -->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Cuenta Corriente</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Cuenta Corriente</li>
                    <li class="breadcrumb-item active">Comprobantes</li>
                </ol>
            </nav>
        </div><!-- Fin Titulo -->

        <section class="section">
            <div class="row">

                <!-- Comienzo tabla Comprobantes-->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cliente: <?php echo $idCliente . "-" . $nombreCliente; ?> // Comprobantes</h5>
                            <div class="d-flex justify-content-around mx-4">
                                <!-- Boton Atras -->
                                <?php if ($tipoUsuario == 'Administrador') { ?>
                                    <a href="<?= $baseUrl; ?>/views/legajos/ver-todos.php" class="btn btn-danger bi bi-box-arrow-left"> Atras</a>
                                    <!-- Boton Nuevo Credito-->
                                    <div>
                                        <button type="button" class="btn btn-success bi bi-cash-coin" data-bs-toggle="modal" data-bs-target="#modalNuevoCredito"> Nuevo Crédito</button>
                                    </div>
                                    <!-- Boton Nuevo Debito-->
                                    <div>
                                        <button type="button" class="btn btn-secondary bi bi-credit-card-2-back" data-bs-toggle="modal" data-bs-target="#modalNuevoDebito"> Nuevo Débito</button>
                                    </div>
                                <?php } else {; ?>
                                    <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger bi bi-box-arrow-left"> Pedidos</a>
                                <?php }; ?>

                            </div>
                            <br>
                            <!-- Desde Hasta para seleccionar el listado -->
                            <div class="d-flex justify-content-center mb-3">
                                <div class="me-2">
                                    <label for="" class="form-label ms-2 mt-2">Desde:</label>
                                    <input type="date" class="form-control" id="desde" name="desde" min="<?php echo date('2023-01-01'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="me-4">
                                    <label for="" class="form-label ms-2 mt-2">Hasta:</label>
                                    <input type="date" class="form-control" id="hasta" name="hasta" min="<?php echo date('2023-01-01'); ?>" max="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="ms-4 mt-2">
                                    <label for="filtro" class="form-label ms-2">Filtar por:</label>
                                    <select class="form-select" id="filtro" name="filtro" aria-label="Default select example" required>
                                        <option disabled selected>Seleccione un Estado</option>
                                        <option value="En Proceso">En Proceso</option>
                                        <option value="Finalizado">Finalizado</option>
                                        <option value="Entregado">Entregado</option>
                                        <option value="Todo">Ver Todo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="tblComprobantes" class="table  table-striped">
                                    <thead>
                                        <tr>
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
                                            <th scope="col" style="text-align: center;">Descripcion</th>
                                            <th scope="col" style="text-align: center;">Estado</th>
                                            <th scope="col" style="text-align: center;">Débito</th>
                                            <th scope="col" style="text-align: center;">Crédito</th>
                                            <th scope="col" style="text-align: center;">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblBodyComprobantes">

                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    <div id="paginador"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin tabla Comprobantes-->

                <!-- Comienzo tabla Cuenta Corriente-->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cuenta Corriente</h5>
                            <br>
                            <div class="table-responsive">
                                <table id="tblCtaCorriente" class="table  table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="display: none;">idCliente</th>
                                            <th scope="col" style="text-align: center;">Saldo Cta. Cte.</th>
                                            <th scope="col" style="text-align: center;">Ultimo Movimiento</th>
                                            <th scope="col" style="text-align: center;">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblBodyCtaCorriente">
                                        <tr>
                                            <th scope="row" style="display: none;">0</th>
                                            <td style="text-align: center;">$ 0.00</td>
                                            <td style="text-align: center;"> - </td>
                                            <td style="text-align: center;"> - </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin tabla Cuenta Corriente-->

                <!-- Ventana Modal Nuevo Credito -->
                <div class="modal fade" id="modalNuevoCredito" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Nuevo Crédito</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form id="frmNuevoCredito">
                                <div class="modal-body">
                                    <input type="hidden" name="idClienteCredito" value="<?php echo $idCliente ?>">
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción:
                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Agrega una breve descripcion."></i>
                                        </label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" style="height: 100px"></textarea>
                                    </div>

                                    <div>
                                        <label for="valor" class="form-label">Valor:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" id="valor" name="valor" step="0.01" min="0" class="form-control" required value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Aceptar</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Ventana Modal Nuevo Credito -->

                <!-- Ventana Modal Nuevo Debito -->
                <div class="modal fade" id="modalNuevoDebito" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Nuevo Débito</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form id="frmNuevoDebito" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="idClienteDebito" value="<?php echo $idCliente ?>">
                                    <div class="mb-3">
                                        <label for="descripcionDebito" class="form-label">Descripción:
                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Agrega una breve descripcion."></i>
                                        </label>
                                        <textarea class="form-control" id="descripcionDebito" name="descripcionDebito" style="height: 100px"></textarea>
                                    </div>

                                    <div>
                                        <label for="valorDebito" class="form-label">Valor:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" id="valorDebito" name="valorDebito" step="0.01" min="0" class="form-control" required value="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success ">Aceptar</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Ventana Modal Nuevo Debito -->
            </div>
        </section>

    </main>


    <?php
    require "../template/footer.php";
    ?>

    <script src="../template/js/functions-comprobantes.js"></script>

    <script>
        // Lógica para obtener el id (puede variar dependiendo de tu implementación)
        let id = "<?= $_GET['p'] ?>";
        let fechaDesdeInput = document.querySelector("#desde");
        let fechaHastaInput = document.querySelector("#hasta");
        // Función para ejecutar cuando se cambia la fecha
        function onChangeFecha() {
            const fechaDesde = fechaDesdeInput.value;
            const fechaHasta = fechaHastaInput.value;

            if (document.querySelector("#tblBodyCtaCorriente")) {
                getComprobantesFecha(id, fechaDesde, fechaHasta);
                getCuentaCorriente(id);
            }
        }

        // Verificar si existe tblBodyCtaCorriente al cargar la página
        if (document.querySelector("#tblBodyCtaCorriente")) {
            // Ejecutar funciones iniciales
            getComprobantes(id);
            getCuentaCorriente(id);

            // Agregar eventos de escucha para cambios en las fechas
            fechaDesdeInput.addEventListener('change', onChangeFecha);
            fechaHastaInput.addEventListener('change', onChangeFecha);
        }
    </script>