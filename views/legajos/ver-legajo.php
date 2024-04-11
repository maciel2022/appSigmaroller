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
            <h1>Clientes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo $baseUrl; ?>/views/legajos/legajo.php">Clientes</a></li>
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
                            <h5 class="card-title">Ver Cliente</h5>
                            <table class="table ">
                                <tbody id="tblBodyVerLegajo">
                                    <tr>
                                        <th scope="row">Cuil:</th>
                                        <td id="numVerCuil"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nombre Cliente:</th>
                                        <td id="txtVerNombre"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Razon Social:</th>
                                        <td id="txtVerApellido"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email:</th>
                                        <td id="txtVerEmail"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Numero Telefono:</th>
                                        <td id="numVerNumTelefono"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Domicilio:</th>
                                        <td id="txtVerDomicilio"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Domicilio de Entrega:</th>
                                        <td id="txtVerLocalidad"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Localidad:</th>
                                        <td id="txtVerLocalidadEntrega"></td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Estado Actual:</th>
                                        <td id="txtVerEstado"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Notas Facturación:</th>
                                        <td id="txtVerObservaciones"></td>
                                    </tr>
                                </tbody>

                            </table>
                            <div class="text-center">
                                <button type="reset" class="btn btn-danger style" onclick="fntCancelarNuevoLeg()">ATRAS</button>
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
    <script>
        let id = "<?= $_GET['p'] ?>";
        fntVerLegajo(id);
    </script>