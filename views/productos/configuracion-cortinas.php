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
                <h1> Configuración Cortinas-Globales</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Configuraciones</li>
                        <li class="breadcrumb-item active">Globales</li>
                    </ol>
                </nav>
                <div class="row">
                    <!-- Comienzo tabla  configuracioneds globales telas-->
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Telas</h5>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTela">
                                    Agregra Tela
                                </button>
                                <br>
                                <br>
                                <!-- Agrega un botón para minimizar/maximizar la tabla -->
                                <div class="d-flex justify-content-end mb-2">
                                    <button onclick="toggleTableTela()" class="btn btn-secondary btn-sm ">Mostrar/Esconder Tabla</button>
                                </div>
                                
                                <table id="tblTela" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="display: none;">idTela</th>
                                            <th scope="col" class="text-center">Nombre</th>
                                            <th scope="col" class="text-center">Precio</th>
                                            <th scope="col" class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <!-- id para setear cada elemento en la tabla que creamos desde js -->
                                    <tbody id="tblBodyTela">

                                    </tbody>
                                </table>
                                <!-- Comienzo Ventana Modal Agregar Tela-->
                                <div class="modal fade" id="modalTela" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Nueva Tela</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmNuevaTela">
                                                    <div class="row mb-3 px-4">
                                                        <label for="txtNombre" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="numPrecio" class="form-label">Precio</label>
                                                        <input type="num" class="form-control" id="numPrecio" name="numPrecio" placeholder="Precio" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="selEstado" class="form-label">Estado</label>
                                                        <div class="col-sm-14">
                                                            <select class="form-select" id="selEstado" name="selEstado" aria-label="Default select example" required>
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
                                <!-- Fin Ventana modal agregar tela-->

                                <!-- Comienzo Ventana Modal Modificar Telas-->
                                <div class="modal fade" id="modalModificarTelas" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modificar Telas</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmModificarTelas">
                                                    <div class="row mb-3">
                                                        <input type="hidden" class="form-control" id="intModalIdTelas" name="intModalIdTelas" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="txtModalModificarNombre" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" id="txtModalModificarNombre" name="txtModalModificarNombre" placeholder="Nombre" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="numModificarPrecio" class="form-label">Precio</label>
                                                        <input type="num" class="form-control" id="numModificarPrecio" name="numModificarPrecio" placeholder="Precio" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="selModificarEstado" class="form-label">Estado</label>
                                                        <div class="col-sm-14">
                                                            <select class="form-select" id="selModificarEstado" name="selModificarEstado" aria-label="Default select example" required>
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
                                <!-- Fin Ventana Modal modificar Telas-->
                            </div>
                        </div>
                    </div>
                    <!-- Fin tabla telas-->
                </div><!-- End Page Title -->
                <div class="row">
                    <!-- Comienzo tabla  configuracioneds globales colores-->
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Colores</h5>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalColor">
                                    Agregar Color
                                </button>
                                <br>
                                <br>
                                 <!-- Agrega un botón para minimizar/maximizar la tabla -->
                                 <div class="d-flex justify-content-end mb-2">
                                    <button onclick="toggleTableColor()" class="btn btn-secondary btn-sm ">Mostrar/Esconder Tabla</button>
                                </div>

                                <table id="tblColor" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="display: none;">idColor</th>
                                            <th scope="col" class="text-center">Nombre</th>
                                            <th scope="col" class="text-center">Tela</th>
                                            <th scope="col" class="text-center">Estado</th>
                                            <th class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <!-- id para setear cada elemento en la tabla que creamos desde js -->
                                    <tbody id="tblBodyColor">

                                    </tbody>
                                </table>
                                <!-- Comienzo Ventana Modal Agregar Color-->
                                <div class="modal fade" id="modalColor" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Nuevo Color</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmNuevoColor">
                                                    <div class="row mb-3 px-4">
                                                        <label for="txtNombreColor" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" id="txtNombreColor" name="txtNombreColor" placeholder="Nombre" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="selTelaColor" class="form-label">Tela</label>
                                                        <div class="col-sm-14">
                                                            <select class="form-select" id="selTelaColor" name="selTelaColor" aria-label="Default select example" required>
                                                                <option value="">Seleccione Tela</option>
                                                                <?php
                                                                // Consulta a la base de datos para asociar el nombre de tela
                                                                $sql = "SELECT * FROM tela";
                                                                $result = $mysql->query($sql);
                                                                // Iterar sobre los resultados y generar las opciones
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        $nombre = $row["nombre"];
                                                                        $idTela = $row["idTela"];
                                                                        echo "<option value='$idTela'>$nombre</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="selEstadoColor" class="form-label">Estado</label>
                                                        <div class="col-sm-14">
                                                            <select class="form-select" id="selEstadoColor" name="selEstadoColor" aria-label="Default select example" required>
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
                                <!-- Fin Ventana modal agregar Color-->

                                <!-- Comienzo Ventana Modal Modificar Colores-->
                                <div class="modal fade" id="modalModificarColor" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modificar Colores</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="frmModificarColor">
                                                    <div class="row mb-3">
                                                        <input type="hidden" class="form-control" id="intModalIdColor" name="intModalIdColor" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="txtModalModificarNombreColor" class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" id="txtModalModificarColorNombre" name="txtModalModificarNombreColor" placeholder="Nombre" required>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="selModTelaColor" class="form-label">Tela</label>
                                                        <div class="col-sm-14">
                                                            <select class="form-select" id="selModTelaColor" name="selModTelaColor" aria-label="Default select example" required>
                                                                <option value="">Seleccione Tela</option>
                                                                <?php
                                                                // Consulta a la base de datos para asociar el nombre de tela
                                                                $sql = "SELECT * FROM tela";
                                                                $result = $mysql->query($sql);
                                                                // Iterar sobre los resultados y generar las opciones
                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        $nombre = $row["nombre"];
                                                                        $idTela = $row["idTela"];
                                                                        echo "<option value='$idTela'>$nombre</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3 px-4">
                                                        <label for="selModificarColorEstado" class="form-label">Estado</label>
                                                        <div class="col-sm-14">
                                                            <select class="form-select" id="selModificarColorEstado" name="selModificarColorEstado" aria-label="Default select example" required>
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
                                <!-- Fin Ventana Modal modificar Colores-->
                            </div>
                        </div>
                    </div>
                    <!-- Fin tabla Colores-->
                </div>
        </section>

    </main>


    <?php
    require "../template/footer.php";
    ?>
    <script src="../template/js/functions-configuracion.js"></script>
 