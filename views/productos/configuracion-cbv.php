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
                <h1> Configuración Cortina Banda Vertical</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Configuraciones</li>
                        <li class="breadcrumb-item active">Banda Vertical</li>
                    </ol>
            </div>


            <div class="row">
                <!-- Comienzo tabla mecanismo-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Mecanismo Banda Vertical</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalMecanismoBV">
                                Nuevo Mecanismo
                            </button>
                            <br>
                            <br>
                            <table id="tblMecanismoBV" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">idMecanismoBandaVertical</th>
                                        <th scope="col" class="text-center">Nombre mecanismo</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <!-- id para setear cada elemento en la tabla que creamos desde js -->
                                <tbody id="tblBodyMecanismoBV">

                                </tbody>
                            </table>
                            <!-- Comienzo Ventana Modal Nuevo Mecanismo-->
                            <div class="modal fade" id="modalMecanismoBV" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Nuevo MecanismoBV</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevoMecanismoBV">
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNombreMBV" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNombreMBV" name="txtNombreMBV" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPrecioMBV" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numPrecioMBV" name="numPrecioMBV" placeholder="Precio" required>
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
                            <!-- Fin Ventana Modal Nuevo mecanismo BV-->

                            <!-- Comienzo Ventana Modificar Modal mecnismo BV-->
                            <div class="modal fade" id="modalModificarMecanismoBV" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Mecanismo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModificarMecanismoBV">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="modalIdMecanismoBandaVertical" name="modalIdMecanismoBandaVertical" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombreMecanismoBV" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombreMecanismoBV" name="txtModalNombreMecanismoBV" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="modalNumPrecioMBV" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="modalNumPrecioMBV" name="modalNumPrecioMBV" placeholder="Precio" required>
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
                            <!-- Fin Ventana Modificar Modal mecanismo BV-->

                        </div>
                    </div>
                </div>
                <!-- Fin tabla Mecanismo Banda Vertical -->
            </div>
            <div class="row">
                <!-- Comienzo tabla Motor BV-->
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Motor Banda Vertical</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalMotorBV">
                                Nuevo Motor
                            </button>
                            <br>
                            <br>
                            <table id="tblMotorBV" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Nombre Motor</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tblBodyMotorBV">

                                </tbody>
                            </table>
                            <!-- Comienzo Ventana Modal Nuevo Motor-->
                            <div class="modal fade" id="modalMotorBV" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Nuevo Motor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevoMotorBV">
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNombreMotorBV" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNombreMotorBV" name="txtNombreMotorBV" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPrecioMotorBV" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numPrecioMotorBV" name="numPrecioMotorBV" placeholder="Precio" required>
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
                            <!-- Fin Ventana Modal Motor BV-->

                            <!-- Comienzo Ventana Modal Modificar Motor BV-->
                            <div class="modal fade" id="modalModificarMotorBV" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Motor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModificarMotorBV">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="modalIdMotorBandaVertical" name="modalIdMotorBandaVertical" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombreMotorBV" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombreMotorBV" name="txtModalNombreMotorBV" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numModalPrecioMotorBV" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numModalPrecioMotorBV" name="numModalPrecioMotorBV" placeholder="Precio" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMoMo" name="selEstadoMoMo" aria-label="Default select example" required>
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
                <!-- Fin tabla Motor-->
            </div>


            <!-- Comienzo tabla  Apertura BV-->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Apertura</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalA">
                                Nueva Apertura
                            </button>
                            <br>
                            <br>
                            <table id="tblApertura" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" style="display: none;">idApertura</th>
                                        <th scope="col" class="text-center">Apertura</th>
                                        <th scope="col" class="text-center">Precio</th>
                                        <th scope="col" class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <!-- id para setear cada elemento en la tabla que creamos desde js -->
                                <tbody id="tblBodyA">

                                </tbody>
                            </table>
                            <!-- Comienzo Ventana Modal Apertura BV-->
                            <div class="modal fade" id="modalA" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Nueva Apertura</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevaA">
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNombreA" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNombreA" name="txtNombreA" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPreA" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numPreA" name="numPreA" placeholder="Precio" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoAp" name="selEstadoAp" aria-label="Default select example" required>
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
                            <!-- Fin Ventana Modal nuevo Apertura BV-->

                            <!-- Comienzo Ventana Modificar Apertura BV-->
                            <div class="modal fade" id="modalModificarA" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Apertura</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModificarA">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" id="txtModalIdA" name="txtModalIdA" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombreA" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombreA" name="txtModalNombreA" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalPrecioA" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="txtModalPrecioA" name="txtModalPrecioA" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="selEstado" class="form-label">Estado</label>
                                                    <div class="col-sm-14">
                                                        <select class="form-select" id="selEstadoMoAp" name="selEstadoMoAp" aria-label="Default select example" required>
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
                            <!-- Fin Ventana Modificar Modificar Apertura BV-->
                        </div>
                    </div>
                </div>

                <!-- Fin tabla Apertura BV-->

            </div>

        </section>

    </main>


    <?php
    require "../template/footer.php";
    ?>
    <script src="../template/js/functions-banda-vertical.js"></script>