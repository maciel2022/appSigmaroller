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


if (isset($_GET['p'])) {
    $nroPedido = $_GET['p'];
}

// var_dump($precioZoc, $precioTer);
// exit;
?>

<body>

    <?php
    require "../template/header.php";
    // Consultar el cliente
    $sql = "SELECT c.nombreCliente, p.estadoPedido FROM pedido p INNER JOIN cliente c ON p.idClientes = c.idCliente WHERE idPedido = {$nroPedido}";
    $result = $mysql->query($sql);
    $result = $result->fetch_assoc();
    $cliente = $result['nombreCliente'];
    $estadoPedido = $result['estadoPedido'];

    //Consultar Extras
    $sql1 = "SELECT * FROM extras";
    $result1 = $mysql->query($sql1);
    $arrExtras = array();
    while ($obj = $result1->fetch_object()) {
        array_push($arrExtras, $obj);
    }
    for ($i = 0; $i < count($arrExtras); $i++) {
        $idExtras = $arrExtras[$i]->idExtras;
        $precio = $arrExtras[$i]->precio;
        if ($idExtras == 1) {
            $precioZoc = $precio;
        } elseif ($idExtras == 2) {
            $precioTer = $precio;
        } elseif ($idExtras == 3) {
            $precioMc = $precio;
        } elseif ($idExtras == 4) {
            $precioCc = $precio;
        } else {
            $precioCadena = $precio;
        }
    }
    ?>


    <!-- Main -->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Pedidos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $baseUrl; ?>/views/pedidos/pedido.php">Pedidos</a></li>
                    <li class="breadcrumb-item active">Nuevo Pedido</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <!-- Section Menu Principal -->
        <section id="seccion2" class="section dashboard">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Nuevo Pedido de: <?php echo $cliente; ?></h5>

                            <!-- Botones Agregar -->
                            <div class="d-flex justify-content-center mb-3">
                                <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger">Atras</a>
                            </div>
                            
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productos">
                                Agregar Producto
                            </button>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cortinaRoller">
                                Agregar Cortina Roller
                            </button>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#CortinaBV">
                                Agregar Cortina Banda Vertical
                            </button>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#CortinaConfeccion">
                                Agregar Cortina Confección
                            </button>
                            <!-- Fin Botones -->

                            <!-- Modal Productos-->
                            <div class="modal fade" id="productos" tabindex="-1">
                                <div class="modal-dialog  modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Agregar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" class="form-control" id="idPedidoPro" name="idPedidoPro" required>
                                            <div class="table-responsive">
                                                <table class="table table-hover"">
                                                    <thead>
                                                        <tr>
                                                            <th  style=" width: 120px; text-align: center;">Producto</th>
                                                            <th scope="row" style="display: none;">id </th>
                                                            <th style="text-align: center;">Nombre</th>
                                                            <th style="text-align: center;">Precio</th>
                                                            <th style="text-align: center;">Cantidad</th>
                                                            <th style="text-align: center;">Agregar Producto</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="agregarProducto">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Fin Modal productos-->

                            <!-- Modal Cortina Roller-->
                            <div class="modal" id="cortinaRoller" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cortina Roller</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetFrmCR()"></button>
                                        </div>
                                        <form id="frmCortinaRoller">
                                            <div class="modal-body">
                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="nombre" class="form-label">Nombre de la cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Escriba un nombre para poder identificar la cortina."></i>
                                                        </label>
                                                        <input type="text" id="nombre" name="nombre" placeholder="Nombre de la cortina" class="form-control" value="Cortina Roller">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex mb-3">
                                                    <input type="hidden" class="form-control" id="idPedidoCR" name="idPedidoCR" required>
                                                    <input type="hidden" class="form-control" id="idCR" name="idCR" required>
                                                    <input type="hidden" class="form-control" id="idCRItem" name="idCRItem" required>
                                                    <div class="col-6 me-2">
                                                        <label for="selTela" class="form-label">Tela:</label>
                                                        <select class="form-select bg-light" id="selTela" name="selTela" aria-label="Default select example" onchange="obtenerTela()">
                                                            <option value="" disabled selected>--Seleccionar tela--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las telas
                                                            $sql = "SELECT * FROM tela WHERE nombre LIKE '%[Roller]%'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idTela"];
                                                                    $nombre = $row["nombre"];
                                                                    $activo = $row["estado"];
                                                                    $precioTelaCR = $row['precio'];

                                                                    if ($activo === 'Activo') {
                                                                        echo "<option value='$id' data-precio='$precioTelaCR'>$nombre</option>";
                                                                    } else {
                                                                        continue;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="selColor" class="form-label">Color:</label>
                                                        <select class="form-select bg-light" id="selColor" name="selColor" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar color--</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="ancho" class="form-label">Ancho:</label>
                                                        <div class="input-group">
                                                            <input type="number" id="ancho" name="ancho" step="0.01" min="0" class="form-control" required value="0.00">
                                                            <span class="input-group-text">mts.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="alto" class="form-label">Alto:</label>
                                                        <div class="input-group">
                                                            <input type="number" id="alto" name="alto" step="0.01" min="0" class="form-control" required value="0.00">
                                                            <span class="input-group-text">mts.</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selCadena" class="form-label">Cadena:</label>
                                                        <select class="form-select bg-light" id="selCadena" name="selCadena" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar cadena--</option>
                                                            <option value="1" data-precioCad="<?php echo $precioCadena; ?>">Metal</option>
                                                            <option value="2" selected data-precioCad="0">Plastico</option>
                                                            <option value="3" data-precioCad="0">Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="selSoporte" class="form-label">Soporte:</label>
                                                        <select class="form-select bg-light" id="selSoporte" name="selSoporte" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar soporte--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener los soportes
                                                            $sql = "SELECT * FROM soporteCR WHERE estado = 'Activo'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                $flag = 0;
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idSoporte"];
                                                                    $nombre = $row["tipoSoporte"];
                                                                    $precioSopCR = $row["precioSCR"];
                                                                    if ($flag == 0) {
                                                                        $flag++;
                                                                        echo "<option value='$id' selected data-precioSop='$precioSopCR'>$nombre</option>";
                                                                    } else {
                                                                        echo "<option value='$id' data-precioSop='$precioSopCR'>$nombre</option>";
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selComando" class="form-label">Comando:</label>
                                                        <select class="form-select bg-light" id="selComando" name="selComando" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar comando--</option>
                                                            <option value="1">Derecho</option>
                                                            <option value="2">Izquierdo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="selCaida" class="form-label">Caida:</label>
                                                        <select class="form-select bg-light" id="selCaida" name="selCaida" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar caida--</option>
                                                            <option value="1">Normal</option>
                                                            <option value="2">Invertida</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selMR" class="form-label">Mecanismo Roller:</label>
                                                        <select class="form-select bg-light" id="selMR" name="selMR" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar mecanismo--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las mecanismo roller
                                                            $sql = "SELECT * FROM mecanismoRoller WHERE estado = 'Activo'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idMecanismoRoller"];
                                                                    $nombre = $row["tipoMecanismoRollr"];
                                                                    $ancho = $row["largo"];
                                                                    $precioMRCR = $row["precioMR"];
                                                                    echo "<option value='$id' data-precioMR='$precioMRCR' data-ancho='$ancho'>$nombre</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="selMotor" class="form-label">Motor:</label>
                                                        <select class="form-select bg-light" id="selMotor" name="selMotor" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleccionar motor--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener los motores
                                                            $sql = "SELECT * FROM motorCR WHERE estado = 'Activo'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                $flag = 0;
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idMotorCR"];
                                                                    $nombre = $row["tipoMotorCR"];
                                                                    $precioMCR = $row["precioMCR"];
                                                                    if ($flag == 0) {
                                                                        $flag++;
                                                                        echo "<option value='$id' selected data-precioMCR='$precioMCR'>$nombre</option>";
                                                                    } else {
                                                                        echo "<option value='$id' data-precioMCR='$precioMCR'>$nombre</option>";
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 ms-2 mt-2 me-2">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" id="zocalo" name="zocalo" data-precio="<?php echo $precioZoc; ?>">
                                                            <label class="form-check-label" for="zocalo">
                                                                Zocalo Enfundado ...
                                                                <i class="bi bi-currency-dollar" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Tiene un precio extra de: $<?php echo $precioZoc; ?>"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" id="termofusion" name="termofusion" data-precio="<?php echo $precioTer; ?>">
                                                            <label class="form-check-label" for="termofusion">
                                                                Termofusion ...
                                                                <i class="bi bi-currency-dollar" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Tiene un precio extra de: $<?php echo $precioTer; ?>"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 ms-2 mt-2 me-2">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" id="mecCol" name="mecCol" data-precio="<?php echo $precioMc; ?>">
                                                            <label class="form-check-label" for="mecCol">
                                                                Mecanismo Color ...
                                                                <i class="bi bi-currency-dollar" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Tiene un precio extra de: $<?php echo $precioMc; ?>"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="contrapeso" name="contrapeso" data-precio="<?php echo $precioCc; ?>">
                                                            <label class="form-check-label" for="contrapeso">
                                                                Contrapeso cadena ...
                                                                <i class="bi bi-currency-dollar" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Tiene un precio extra de: $<?php echo $precioCc; ?>"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selDuplica" class="form-label">Duplica cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Genera otra cortina con comando invertido."></i>
                                                        </label>
                                                        <select class="form-select bg-light" id="selDuplica" name="selDuplica" aria-label="Default select example" required>
                                                            <option value="No" selected>No</option>
                                                            <option value="Si">Si</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="cantidad" class="form-label">Cantidad:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Si selecciona duplicar en item anterior, tambien se va a duplicar la cantidad que solicite."></i>
                                                        </label>
                                                        <input type="number" id="cantidad" name="cantidad" min="1" class="form-control" value="1" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="observaciones" class="form-label">Observaciones:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Agrega un comentario para hacernos saber algo sobre esta cortina."></i>
                                                        </label>
                                                        <textarea class="form-control" id="observaciones" name="observaciones" style="height: 100px"></textarea>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="valor" class="form-label">Valor Cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Selecciona todas las configuraciones de la cortina, para obtener un valor aproximado. El valor total esta sujeto a cambios sin previo aviso."></i>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="number" id="valor" name="valor" step="0.01" min="0" class="form-control" required value="0.00" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Lista de Productos dentro de Cortina -->
                                                <!-- <h5 class=" mt-5">Productos de Cortina Roller:</h5>
                                                <div class="d-flex justify-content-center mt-2">
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#productosCR">Agregar Producto</button>
                                                </div>

                                                <div class="table-responsive">
                                                    <table id="tblItemsCR" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="row" style="display: none;">id</th>
                                                                <td id="prodIt" style="text-align: center">Producto</td>
                                                                <td id="cantIt" style="text-align: center">Cantidad</td>
                                                                <td id="precioIt" style="text-align: center">Valor Unitario</td>
                                                                <td id="valorIt" style="text-align: center">Sub-Total</td>
                                                                <td style="text-align: center" scope="col">Eliminar</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tblBodyProductoCR">

                                                        </tbody>
                                                    </table>
                                                </div> -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="resetFrmCR()">Cerrar</button>
                                                <button type="submit" id="btnFinCR" class="btn btn-success">Terminar Cortina</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- Fin Modal Roller-->

                            <!-- Modal Cortina Banda Vertical-->
                            <div class="modal fade" id="CortinaBV" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cortina Banda Vertical</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetFrmCBV()"></button>
                                        </div>
                                        <form id="frmCortinaBV">
                                            <div class="modal-body">
                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="nombreCBV" class="form-label">Nombre de la cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Escriba un nombre para poder identificar la cortina."></i>
                                                        </label>
                                                        <input type="text" id="nombreCBV" name="nombreCBV" placeholder="Nombre de la cortina" class="form-control" value="Cortina Banda Vertical">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex mb-3">
                                                    <input type="hidden" class="form-control" id="idPedidoBV" name="idPedidoBV" required>
                                                    <input type="hidden" class="form-control" id="idCBV" name="idCBV" required>
                                                    <input type="hidden" class="form-control" id="idCBVItem" name="idCBVItem" required>
                                                    <div class="col-6 me-2">
                                                        <label for="selTela1" class="form-label">Tela:</label>
                                                        <select class="form-select bg-light" id="selTela1" name="selTela1" aria-label="Default select example" onchange="obtenerTela1()">
                                                            <option value="" disabled selected>--Selecionar tela--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las telas
                                                            $sql = "SELECT * FROM tela WHERE nombre LIKE '%[Banda]%'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idTela"];
                                                                    $nombre = $row["nombre"];
                                                                    $activo = $row["estado"];
                                                                    $precioTela = $row['precio'];
                                                                    if ($activo === 'Activo') {
                                                                        echo "<option value='$id' data-precio='$precioTela'>$nombre</option>";
                                                                    } else {
                                                                        continue;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="selColor1" class="form-label">Color:</label>
                                                        <select class="form-select bg-light" id="selColor1" name="selColor1" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Selecionar color--</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="numAnchoCBV" class="form-label">Ancho:</label>
                                                        <div class="input-group">
                                                            <input id="numAnchoCBV" type="number" name="numAnchoCBV" step="0.01" min="0" class="form-control" name="numAnchoCBV" required value="0.00">
                                                            <span class="input-group-text">mts.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="numAltoCBV" class="form-label">Alto:</label>
                                                        <div class="input-group">
                                                            <input id="numAltoCBV" name="numAltoCBV" type="number" step="0.01" min="0" class="form-control" required value="0.00">
                                                            <span class="input-group-text">mts.</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selComandoCBV" class="form-label">Comando:</label>
                                                        <select id="selComandoCBV" name="selComandoCBV" class="form-select bg-light" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleciona comando--</option>
                                                            <option value="1">Derecho</option>
                                                            <option value="2">Izquierdo</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 me-2">
                                                        <label for="selMecCBV" class="form-label">Mecanismo Banda Vertical:</label>
                                                        <select id="selMecCBV" name="selMecCBV" class="form-select bg-light" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Seleciona mecanismo--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las mecanismo BV
                                                            $sql = "SELECT * FROM mecanismoBandaVertical WHERE estado = 'Activo'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idMecanismoBandaVertical"];
                                                                    $nombre = $row["nomMecBanVer"];
                                                                    $precioBV = $row["precioBV"];
                                                                    echo "<option value='$id' data-precio='$precioBV'>$nombre</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <!-- lo dejamos como hidden y que queden en 0 -->
                                                    <div class="col-6" style="display: none;"> 
                                                        <label for="selMenCBV" class="form-label">Cantidad de Mensulas:</label>
                                                        <select id="selMenCBV" name="selMenCBV" class="form-select bg-light" aria-label="Default select example" required> 
                                                            <option value="0" selected>0</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 ms-2">
                                                        <label for="selMotCBV" class="form-label">Motor:</label>
                                                        <select id="selMotCBV" name="selMotCBV" class="form-select bg-light" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Selecionar motor--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las mecanismo BV
                                                            $sql = "SELECT * FROM motorBandaVertical WHERE estado = 'Activo'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idMotorBandaVertical"];
                                                                    $nombre = $row["nombreMotorBV"];
                                                                    $precioMotBV = $row["precioMBV"];
                                                                    echo "<option value='$id' data-precio='$precioMotBV'>$nombre</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selAperCBV" class="form-label">Apertura:</label>
                                                        <select id="selAperCBV" name="selAperCBV" class="form-select bg-light" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Selecionar Tipo Apertura--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las mecanismo BV
                                                            $sql = "SELECT * FROM apertura WHERE estado = 'Activo'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idApertura"];
                                                                    $nombre = $row["tipoApertura"];
                                                                    $precioAp = $row["precioA"];
                                                                    echo "<option value='$id' data-precio='$precioAp'>$nombre</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6 me-2">
                                                        <label for="numValorCBV" class="form-label">Valor Cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Selecciona todas las configuraciones de la cortina, para obtener un valor aproximado. El valor total esta sujeto a cambios sin previo aviso."></i>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input id="numValorCBV" name="numValorCBV" type="number" step="0.01" min="0" class="form-control" required value="0.00" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="selDupCBV" class="form-label">Duplica cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Genera otra cortina con comando invertido."></i>
                                                        </label>
                                                        <select id="selDupCBV" name="selDupCBV" class="form-select bg-light" aria-label="Default select example" required>
                                                            <option value="No" selected>No</option>
                                                            <option value="Si">Si</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="numCantCBV" class="form-label">Cantidad:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Si selecciona duplicar cortina, tambien se va a duplicar la cantidad que solicite."></i>
                                                        </label>
                                                        <input id="numCantCBV" name="numCantCBV" type="number" min="1" class="form-control" value="1" required>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-12 me-2">
                                                        <label for="txtObsCBV" class="form-label">Observaciones:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Agrega un comentario para hacernos saber algo sobre esta cortina."></i>
                                                        </label>
                                                        <textarea id="txtObsCBV" name="txtObsCBV" class="form-control" style="height: 100px"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="resetFrmCBV()">Cerrar</button>
                                                <button type="submit" id="btnFinCBV" class="btn btn-success">Terminar Cortina</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- Fin Modal cortina Banda Vertical-->

                            <!-- Modal Cortina Confección-->
                            <div class="modal fade" id="CortinaConfeccion" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cortina Confección</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetFrmCC()"></button>
                                        </div>
                                        <form id="frmCortinaConfec">
                                            <div class="modal-body">
                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="nombreCC" class="form-label">Nombre de la cortina:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Escriba un nombre para poder identificar la cortina."></i>
                                                        </label>
                                                        <input type="text" id="nombreCC" name="nombreCC" placeholder="Nombre de la cortina" class="form-control" value="Cortina Confeccion">
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex mb-3">
                                                    <input type="hidden" class="form-control" id="idPedidoCC" name="idPedidoCC" required>
                                                    <input type="hidden" class="form-control" id="idCC" name="idCC" required>
                                                    <input type="hidden" class="form-control" id="idCCItem" name="idCCItem" required>
                                                    <div class="col-6 me-2">
                                                        <label for="selTela2" class="form-label">Tela:</label>
                                                        <select class="form-select bg-light" id="selTela2" name="selTela2" aria-label="Default select example" onchange="obtenerTela2()">
                                                            <option value="" disabled selected>--Selecionar tela--</option>
                                                            <?php
                                                            // Consulta a la base de datos para obtener las telas
                                                            $sql = "SELECT * FROM tela WHERE nombre LIKE '%[Conf]%'";
                                                            $result = $mysql->query($sql);
                                                            // Iterar sobre los resultados y generar las opciones
                                                            if ($result->num_rows > 0) {
                                                                while ($row = $result->fetch_assoc()) {
                                                                    $id = $row["idTela"];
                                                                    $nombre = $row["nombre"];
                                                                    $activo = $row["estado"];
                                                                    $precioTela = $row['precio'];
                                                                    if ($activo === 'Activo') {
                                                                        echo "<option value='$id' data-precio='$precioTela'>$nombre</option>";
                                                                    } else {
                                                                        continue;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="selColor2" class="form-label">Color:</label>
                                                        <select class="form-select bg-light" id="selColor2" name="selColor2" aria-label="Default select example" required>
                                                            <option value="" disabled selected>--Selecionar color--</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 me-2">
                                                        <label for="numAnchoCC" class="form-label">Ancho:</label>
                                                        <div class="input-group">
                                                            <input id="numAnchoCC" name="numAnchoCC" type="number" step="0.01" min="0" class="form-control" required value="0.00">
                                                            <span class="input-group-text">mts.</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="numAltoCC" class="form-label">Alto:</label>
                                                        <div class="input-group">
                                                            <input type="number" id="numAltoCC" name="numAltoCC" step="0.01" min="0" class="form-control" required value="0.00">
                                                            <span class="input-group-text">mts.</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-12 me-2">
                                                        <label for="txtObsCC" class="form-label">Observaciones:
                                                            <i class="bi bi-question-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Describe todas las caracteristicas que deseas realizar en este tipo de cortina."></i>
                                                        </label>
                                                        <textarea id="txtObsCC" name="txtObsCC" class="form-control" style="height: 100px"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex mb-3">
                                                    <div class="col-6 ms-2">
                                                        <label for="numValorCC" class="form-label">Valor:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input id="numValorCC" name="numValorCC" type="number" step="0.01" min="0" class="form-control" required value="0.00">
                                                        </div>
                                                    </div>
                                                    <div class="col-6 ms-3">
                                                        <p class="pt-4">INFO: El valor es provisorio, se calculara en base a toda la descripcion (observaciones) que se proporcione.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="resetFrmCC()">Cerrar</button>
                                                <button type="submit"  id="btnFinCC" class="btn btn-success">Terminar Cortina</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- Fin Modal cortina Confección-->

                        </div>
                    </div>

                    <!-- Lista de Items -->
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" id="obtenerId" value="<?php echo $nroPedido; ?>">
                            <h5 class="card-title">Items del Pedido Nro: <?php echo $nroPedido; ?></h5>
                            <div class="table-responsive">
                                <table id="tblItems" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="row" style="display: none;">id</th>
                                            <td id="prodIt" style="text-align: center">Producto</td>
                                            <td id="cantIt" style="text-align: center">Cantidad</td>
                                            <td id="precioIt" style="text-align: center">Valor Unitario</td>
                                            <td id="valorIt" style="text-align: center">Sub-Total</td>
                                            <td style="text-align: center" scope="col">Opciones</td>
                                        </tr>
                                    </thead>
                                    <tbody id="tblBodyItems">

                                    </tbody>
                                </table>
                            </div>

                            <div id="contenedor" class="col-12 d-flex justify-content-center">
                                <div class="col-4"></div>
                                <div class="input-group">
                                    <span class="input-group-text">Valor Total: $</span>
                                    <input id="valorTotal" name="valorTotal" type="text" class="form-control">
                                </div>
                                <div class="col-4"></div>
                            </div>
                            
                            <div class="d-flex justify-content-center mt-3">
                                <?php if ($tipoUsuario == 'Cliente') {
                                    if ($estadoPedido == 'Borrador') {; ?>
                                        <button class="btn btn-success me-3" onclick="cambioACreado(<?php echo $nroPedido; ?>)"> Confirmar Pedido</button>
                                        <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-secondary me-3">Pedido en Borrador</a>
                                        <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger">Atras</a>
                                <?php  }
                                }else { ?>
                                <a href="<?= $baseUrl; ?>/views/pedidos/pedido.php" class="btn btn-danger">Atras</a>
                                <?php }; ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

    </main><!-- Fin main -->
    <?php
    require "../template/footer.php";
    ?>
    <script src="../template/js/functions-nuevo-pedido.js"></script>
    <script src="../template/js/functions-agregar-producto.js"></script>
    <script src="../template/js/functions-items.js"></script>
    <!-- script para obtener el id del pedido -->
    <script>
        let id = "<?= $_GET['p'] ?>";
        let inputIdPedidoCR = document.getElementById("idPedidoCR");
        inputIdPedidoCR.value = id;
        let inputIdPedidoBV = document.getElementById("idPedidoBV");
        inputIdPedidoBV.value = id;
        let inputIdPedidoCC = document.getElementById("idPedidoCC");
        inputIdPedidoCC.value = id;
        let inputIdPedidoPro = document.getElementById("idPedidoPro");
        inputIdPedidoPro.value = id;
    </script>