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

        <section>
            <div class="pagetitle">
                <h1>Cortina Roller</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Configuraciones</li>
                        <li class="breadcrumb-item active">Cortina Roller</li>
                    </ol>
            </div>

            <div class="row">
                <!-- Comienzo tabla  mecanismo Roller-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Mecanismo Roller</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalMecR">
                                Nuevo Mecanismo
                            </button>
                            <br>
                            <br>
                            <table id="tblMecR" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">idMecanismoRoller</th>
                                        <th scope="col" class="text-center">Mecanismo Roller</th>
                                        <th scope="col" class="text-center">Ancho Maximo (en metros)</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <!-- id para setear cada elemento en la tabla que creamos desde js -->
                                <tbody id="tblBodyMecR">

                                </tbody>
                            </table>
                            <!-- Comienzo Ventana Modal nuevo Mecanisamo Roller-->
                            <div class="modal fade" id="modalMecR" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Nuevo Mecanismo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevoMecR">
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNombreMecR" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNombreMecR" name="txtNombreMecR" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numLarMecR" class="form-label">Ancho Maximo (en metros)</label>
                                                    <input type="number" class="form-control" id="numLarMecR" name="numLarMecR" step="0.01" min="0" placeholder="Ancho" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPreMecR" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numPreMecR" name="numPreMecR" placeholder="Precio" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMe" name="selEstadoMe" aria-label="Default select example" required>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Modal nuevo Mecanismo Roller-->

                            <!-- Comienzo Ventana Modificar Mecanismo Roller-->
                            <div class="modal fade" id="modalModificarMecR" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Mecanismo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModificarMecR">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="txtModalIdMecR" name="txtModalIdMecR" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombreMecR" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombreMecR" name="txtModalNombreMecR" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numModalLarMecR" class="form-label">Ancho Maximo (en metros)</label>
                                                    <input type="number" class="form-control" id="numModalLarMecR" step="0.01" min="0" name="numModalLarMecR" placeholder="Largo" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalPrecioMecR" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="txtModalPrecioMecR" name="txtModalPrecioMecR" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMeMo" name="selEstadoMeMo" aria-label="Default select example" required>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Modificar Modificar mecanismo Roller-->

                        </div>
                    </div>
                </div>
                <!-- Fin tabla mecanismo Cortinas Roller-->
            </div>

            <div class="row">
                <!-- Comienzo tabla Motor Cortina Roller-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Motor Cortina Roller</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalMotR">
                                Nuevo Motor
                            </button>
                            <br>
                            <br>
                            <table id="tblMotR" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">idMotorCR</th>
                                        <th scope="col" class="text-center">Motor</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tblBodyMotR">

                                </tbody>
                            </table>
                            <!-- Comienzo Ventana Modal MOTCC-->
                            <div class="modal fade" id="modalMotR" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Nuevo Motor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevoMotR">
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNomMotR" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNomMotR" name="txtNomMotR" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPreMotR" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numPreMotR" name="numPreMotR" placeholder="Precio" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMo" name="selEstadoMo" aria-label="Default select example" required>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Modal MOTOR ROLLER-->

                            <!-- Comienzo Ventana Modal Modificar MOT-->
                            <div class="modal fade" id="modalModMotR" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Motor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModMotR">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="txtModalIdMotR" name="txtModalIdMotR" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombMotR" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombMotR" name="txtModalNombMotR" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numModalMotR" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numModalMotR" name="numModalMotR" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMoMe" name="selEstadoMoMe" aria-label="Default select example" required>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Moda modificar Motor-->


                        </div>
                    </div>
                </div>
                <!-- Fin tabla Cortinas Roller-->
            </div>

            <div class="row">
                <!-- Comienzo tabla Soporte Cortina Roller-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Soporte Cortina Roller</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalS">
                                Nuevo Soporte
                            </button>
                            <br>
                            <br>
                            <table id="tblSoporte" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">idSoporte</th>
                                        <th scope="col" class="text-center">Soporte</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tblBodyS">

                                </tbody>
                            </table>
                            <!-- Comienzo Ventana Modal SOPORTE-->
                            <div class="modal fade" id="modalS" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Nuevo Soporte</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevoS">
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNomS" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNomS" name="txtNomS" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPreS" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numPreS" name="numPreS" placeholder="Precio" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoS" name="selEstadoS" aria-label="Default select example" required>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Modal MOTOR ROLLER-->

                            <!-- Comienzo Ventana Modal Modificar MOT-->
                            <div class="modal fade" id="modalModS" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Soporte</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModS">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="txtModalIdS" name="txtModalIdS" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombS" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombS" name="txtModalNombS" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numModalS" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numModalS" name="numModalS" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstadoMoS" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMoS" name="selEstadoMoS" aria-label="Default select example" required>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Moda modificar Motor-->


                        </div>
                    </div>
                </div>
                <!-- Fin tabla Cortinas Roller-->
            </div>

            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Extras</h5>

                            <table id="tblExtras" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">idExtras</th>
                                        <th class="text-center">Extra</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tblBodyExtras">

                                </tbody>
                            </table>

                            <!-- Comienzo Ventana Modal Modificar precio extra-->
                            <div class="modal fade" id="modalExtras" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Precio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmExtras">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="txtModIdE" name="txtModIdE" required>
                                                </div>

                                                <div class="row mb-3 px-4">
                                                    <label for="numModalExtra" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numModalExtra" name="numModalExtra" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <button type="submit" class="btn btn-success ">GUARDAR</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">CERRAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Ventana Moda modificar Motor-->


                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main>


    <?php
    require "../template/footer.php";
    ?>
    <script src="../template/js/functions-cortinas-roller.js"></script>