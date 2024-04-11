<?php

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
            <h1>Productos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Productos</li>
                    <li class="breadcrumb-item active">Configuración</li>
                </ol>
            </nav>
        </div><!-- Fin Titulo -->

        <section class="section">
            <div class="row">
        
                <!-- Comienzo tabla Productos-->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAreas">
                                Nuevo Producto
                            </button>
                            <br>
                            <br>
                            <div class="table-responsive">
                                <table id="tblAreas" class="table table-striped table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">Codigo/Artículo</th>
                                            <th scope="col" class="text-center">Producto</th>
                                            <th scope="col" class="text-center">Precio</th>                                       
                                            <th scope="col" class="text-center">Observaciones</th>
                                            <th scope="col" class="text-center">Imagen</th>
                                            <th scope="col" class="text-center">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblBodyAreas">

                                    </tbody>
                                </table>
                            </div>
                            <!-- Comienzo Ventana Modal Productos-->
                            <div class="modal fade" id="modalAreas" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmNuevoArea">
												<div class="row mb-3 px-4">
                                                    <label for="numArticulo" class="form-label">Cod. Artículo</label>
                                                    <input type="num" class="form-control" id="numArticulo" name="numArticulo" placeholder="Articulo" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtNombreArea" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtNombreArea" name="txtNombreArea" placeholder="Nombre" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numPrecio" class="form-label">Precio</label>
                                                    <input type="num" class="form-control" id="numPrecio" name="numPrecio" placeholder="Precio" step="0.01" required>
                                                </div>
                                                
                                                <div class="row mb-3 px-4">
                                                    <label for="txtObservaciones" class="form-label">Obseravciones</label>
                                                    <input type="text" class="form-control" id="txtObservaciones" name="txtObservaciones" placeholder="Observaciones" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="imgProducto" class="form-label">Imagen</label>
                                                    <input type="img" class="form-control" id="imgProducto" name="imgProducto" placeholder="Producto" >
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
                            <!-- Fin Ventana Modal Productos-->
                             <!-- Comienzo Ventana Modal Modificar Productos-->
                             <div class="modal fade" id="modalModificarAreas" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modificar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmModificarAreas">
												<div class="row mb-3 px-4">
                                                    <label for="numModalModificarCodigo" class="form-label">Codigo</label>
                                                    <input type="number" class="form-control" id="numModalModificarCodigo" name="numModalModificarCodigo" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <input type="hidden" class="form-control" id="txtModalIdAreas" name="txtModalIdAreas" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalNombreAreas" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="txtModalNombreAreas" name="txtModalNombreAreas" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="numModalModificarPrecio" class="form-label">Precio</label>
                                                    <input type="number" class="form-control" id="numModalModificarPrecio" name="numModalModificarPrecio" step="0.01" required>
                                                </div>
                                                
                                                <div class="row mb-3 px-4">
                                                    <label for="txtModalModificarObservaciones" class="form-label">Observaciones</label>
                                                    <input type="text" class="form-control" id="txtModalModificarObservaciones" name="txtModalModificarObservaciones" required>
                                                </div>
                                                <div class="row mb-3 px-4">
                                                    <label for="imgModificarProducto" class="form-label">Imagen</label>
                                                    <input type="img" class="form-control" id="imgModifircarProducto" name="imgModificarProducto" placeholder="Producto" >
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
                            <!-- Fin Ventana Moda modificar Productos-->

        </section>

    </main>


    <?php
    require "../template/footer.php";
    ?>

    <script src="../template/js/functions-productos.js"></script>