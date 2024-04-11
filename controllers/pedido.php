<?php
require_once "../models/pedidoModel.php";

if(!isset($_SESSION)){
    session_start();
  }

$option = $_REQUEST['op'];
$objPedido = new PedidoModel();
$objItem = new PedidoModel();
$objPedidosCliente = new PedidoModel();

if ($option == "listpedidos") {
    if($_SESSION['tipoUsuario'] == 'administrador'){
        $arrRespuesta = array('status' => false, 'data' => "");
        $arrPedidos = $objPedido->getPedidos();
        
        if (!empty($arrPedidos)) {

            for ($i = 0; $i < count($arrPedidos); $i++) {
                $idPedido = $arrPedidos[$i]->idPedido;
                $estadoPedido = $arrPedidos[$i]->estadoPedido;
                // Funcion para calcular el valor Total del Pedido, segun si existe un item relacionado
                $valorTotalItems = $objItem->existeItem($idPedido);

                if (!empty($valorTotalItems)) {
                    $arrPedidos[$i]->valorTotal = $valorTotalItems;
                }

                // Determino el estado para el filtro
                $arrPedidos[$i]->estadoFiltro = $estadoPedido;
                
                //Determino el color del boton segun estado
                if ($estadoPedido == 'Borrador'){
                    continue;
                } else {
                    if ($estadoPedido == 'Creado') {
                        $estadoPedido = '<button class="btn btn-success btn-sm" title="Estado" onclick="fntCambiarCreado(' . $idPedido . ')"><i class="bi bi-check-circle"></i> Creado</button>';
    
                        $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                                <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>';
                    } else if ($estadoPedido == 'En Proceso') {
                        $estadoPedido = '<button class="btn btn-info btn-sm" title="Estado" onclick="fntCambiarEnProceso(' . $idPedido . ')"><i class="bi bi-play-circle"></i> En Proceso</button>';
    
                        $options = '
                                <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>
                                <a href="' . $baseUrl . '/views/pedidos/print-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>';
                    } else if ($estadoPedido == 'Finalizado') {
                        $estadoPedido = '<button class="btn btn-warning btn-sm" title="Estado" onclick="fntCambiarFinalizado(' . $idPedido . ')"><i class="bi bi-x-circle"></i> Finalizado</button>';
    
                        $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                ';
                    } else {
                        $estadoPedido = '<button class="btn btn-danger btn-sm" title="Estado"><i class="bi bi-truck"></i> Entregado</button>';
    
                        $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>';
                    };
    
                    // $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                    //             <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                    //             <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>
                    //             <a href="' . $baseUrl . '/views/pedidos/print-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>';
    
                    $arrPedidos[$i]->estadoPedido = $estadoPedido;
                    $arrPedidos[$i]->options = $options;
                    
                }
            }

            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrPedidos;
            $arrRespuesta['user'] = $_SESSION['tipoUsuario'];
        }
    }
    ///// Lado del Cliente //////
       else{
        $idUs = $_SESSION['idUsuario'];
        $arrPedidos = $objPedidosCliente->getPedidosCliente($idUs);

        if (!empty($arrPedidos)) {

            for ($i = 0; $i < count($arrPedidos); $i++) {
                $idPedido = $arrPedidos[$i]->idPedido;
                $estadoPedido = $arrPedidos[$i]->estadoPedido;
                // Funcion para calcular el valor Total del Pedido, segun si existe un item relacionado
                $valorTotalItems = $objItem->existeItem($idPedido);

                if (!empty($valorTotalItems)) {
                    $arrPedidos[$i]->valorTotal = $valorTotalItems;
                }

                // Determino el estado para el filtro
                $arrPedidos[$i]->estadoFiltro = $estadoPedido;

                //Determino el color del boton segun estado
                if ($estadoPedido == 'Borrador') {
                    $estadoPedido = '<button class="btn btn-secondary btn-sm" title="Estado"><i class="bi bi-pencil"></i> Borrador</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                            <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>';
                } else if ($estadoPedido == 'Creado') {
                    $estadoPedido = '<button class="btn btn-success btn-sm" title="Estado"><i class="bi bi-check-circle"></i> Creado</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';
                    
                } else if ($estadoPedido == 'En Proceso') {
                    $estadoPedido = '<button class="btn btn-info btn-sm" title="Estado"><i class="bi bi-play-circle"></i> En Proceso</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';

                } else if ($estadoPedido == 'Finalizado') {
                    $estadoPedido = '<button class="btn btn-warning btn-sm" title="Estado"><i class="bi bi-x-circle"></i> Finalizado</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';
                } else {
                    $estadoPedido = '<button class="btn btn-danger btn-sm" title="Estado"><i class="bi bi-truck"></i> Entregado</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';
                };

                // $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                //             <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                //             <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>
                //             <a href="' . $baseUrl . '/views/pedidos/print-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>';

                $arrPedidos[$i]->estadoPedido = $estadoPedido;
                $arrPedidos[$i]->options = $options;
 
            }
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrPedidos;
            $arrRespuesta['user'] = $_SESSION['tipoUsuario'];
        }
        // echo "<pre>";
        // var_dump($arrRespuesta);
        // echo "</pre>";
        // exit;
    }
    
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "listpedidosFecha") {
    $desde = $_POST['fechaDesde'];
    $hasta = $_POST['fechaHasta'];

    if($_SESSION['tipoUsuario'] == 'administrador'){
        $arrRespuesta = array('status' => false, 'data' => "");
        $arrPedidos = $objPedido->getPedidosFecha($desde, $hasta);
        
        if (!empty($arrPedidos)) {

            for ($i = 0; $i < count($arrPedidos); $i++) {
                $idPedido = $arrPedidos[$i]->idPedido;
                $estadoPedido = $arrPedidos[$i]->estadoPedido;
                // Funcion para calcular el valor Total del Pedido, segun si existe un item relacionado
                $valorTotalItems = $objItem->existeItem($idPedido);

                if (!empty($valorTotalItems)) {
                    $arrPedidos[$i]->valorTotal = $valorTotalItems;
                }

                // Determino el estado para el filtro
                $arrPedidos[$i]->estadoFiltro = $estadoPedido;
                
                //Determino el color del boton segun estado
                if ($estadoPedido == 'Borrador'){
                    continue;
                } else {
                    if ($estadoPedido == 'Creado') {
                        $estadoPedido = '<button class="btn btn-success btn-sm" title="Estado" onclick="fntCambiarCreado(' . $idPedido . ')"><i class="bi bi-check-circle"></i> Creado</button>';
    
                        $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                                <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>';
                    } else if ($estadoPedido == 'En Proceso') {
                        $estadoPedido = '<button class="btn btn-info btn-sm" title="Estado" onclick="fntCambiarEnProceso(' . $idPedido . ')"><i class="bi bi-play-circle"></i> En Proceso</button>';
    
                        $options = '
                                <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>
                                <a href="' . $baseUrl . '/views/pedidos/print-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>';
                    } else if ($estadoPedido == 'Finalizado') {
                        $estadoPedido = '<button class="btn btn-warning btn-sm" title="Estado" onclick="fntCambiarFinalizado(' . $idPedido . ')"><i class="bi bi-x-circle"></i> Finalizado</button>';
    
                        $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                ';
                    } else {
                        $estadoPedido = '<button class="btn btn-danger btn-sm" title="Estado"><i class="bi bi-truck"></i> Entregado</button>';
    
                        $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                                <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>';
                    };
    
                    // $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                    //             <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                    //             <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>
                    //             <a href="' . $baseUrl . '/views/pedidos/print-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>';
    
                    $arrPedidos[$i]->estadoPedido = $estadoPedido;
                    $arrPedidos[$i]->options = $options;
                    
                }
            }
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrPedidos;
            $arrRespuesta['user'] = $_SESSION['tipoUsuario'];
        }
    }
    ///// Lado del Cliente //////
       else{
        $idUs = $_SESSION['idUsuario'];
        $arrPedidos = $objPedidosCliente->getPedidosClienteFecha($idUs, $desde, $hasta);

        if (!empty($arrPedidos)) {

            for ($i = 0; $i < count($arrPedidos); $i++) {
                $idPedido = $arrPedidos[$i]->idPedido;
                $estadoPedido = $arrPedidos[$i]->estadoPedido;
                // Funcion para calcular el valor Total del Pedido, segun si existe un item relacionado
                $valorTotalItems = $objItem->existeItem($idPedido);

                if (!empty($valorTotalItems)) {
                    $arrPedidos[$i]->valorTotal = $valorTotalItems;
                }

                // Determino el estado para el filtro
                $arrPedidos[$i]->estadoFiltro = $estadoPedido;

                //Determino el color del boton segun estado
                if ($estadoPedido == 'Borrador') {
                    $estadoPedido = '<button class="btn btn-secondary btn-sm" title="Estado"><i class="bi bi-pencil"></i> Borrador</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                            <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                            <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>';
                } else if ($estadoPedido == 'Creado') {
                    $estadoPedido = '<button class="btn btn-success btn-sm" title="Estado"><i class="bi bi-check-circle"></i> Creado</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';
                    
                } else if ($estadoPedido == 'En Proceso') {
                    $estadoPedido = '<button class="btn btn-info btn-sm" title="Estado"><i class="bi bi-play-circle"></i> En Proceso</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';

                } else if ($estadoPedido == 'Finalizado') {
                    $estadoPedido = '<button class="btn btn-warning btn-sm" title="Estado"><i class="bi bi-x-circle"></i> Finalizado</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';
                } else {
                    $estadoPedido = '<button class="btn btn-danger btn-sm" title="Estado"><i class="bi bi-truck"></i> Entregado</button>';

                    $options = '<a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>';
                };

                // $options = '<a href="' . $baseUrl . '/views/pedidos/nuevo-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-primary btn-sm" title="Modificar pedido"><i class="bi bi-pencil-square"></i></a>
                //             <a href="' . $baseUrl . '/views/pedidos/ver-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-warning btn-sm" title="Ver pedido"><i class="bi bi-eye"></i></a>
                //             <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarPedido(' . $idPedido . ')"><i class="bi bi-trash"></i></button>
                //             <a href="' . $baseUrl . '/views/pedidos/print-pedido.php?p=' . $idPedido . '"  class="btn ms-2 btn-outline-info btn-sm" title="Imprimir pedido"><i class="bi bi-printer"></i></a>';

                $arrPedidos[$i]->estadoPedido = $estadoPedido;
                $arrPedidos[$i]->options = $options;
 
            }
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrPedidos;
            $arrRespuesta['user'] = $_SESSION['tipoUsuario'];
        }
        // echo "<pre>";
        // var_dump($arrRespuesta);
        // echo "</pre>";
        // exit;
    }
    
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "guardar") {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
    //  //print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtIdCliente'])) {
                
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');

        } else {
            $intIdCliente = trim($_POST['txtIdCliente']);
            $dateFecha = date('Y/m/d');          
            $valorTotal = 0;
            if($_SESSION['tipoUsuario'] == 'administrador'){
                $strEstado = "Creado";
            } else {
                $strEstado = "Borrador";
            }

            
         

            $arrPedido = $objPedido->insertPedido($intIdCliente, $dateFecha, $valorTotal, $strEstado);
            if ($arrPedido > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente', 'data'=> $arrPedido);
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "eliminar") {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
    if ($_POST) {
        if (empty($_POST['id'])) {
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $id = intval($_POST['id']);
            $arrInfo = $objPedido->delPedido($id);
            if ($arrInfo > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Pedido eliminado');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
            }
        }
        echo json_encode($arrRespuesta);
    }

}

if ($option == "buscador") {
    if ($_POST) {
        // var_dump($_POST);
        // exit;
        
        if (empty($_POST['searchPedido'])) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $strBuscar = trim($_POST['searchPedido']);
            $arrRespuesta = array('status' => false, 'found' => 0, 'data' => '');

            $arrInfo = $objPedido->getBusqueda($strBuscar);
            
            if(!empty($arrInfo)){
                for ($i = 0; $i < count($arrInfo); $i++) {
                    $idPedido = $arrInfo[$i]->idPedido;
                    
                    // Funcion para calcular el valor Total del Pedido, segun si existe un item relacionado
                    $valorTotalItems = $objItem->existeItem($idPedido);
    
                    if (!empty($valorTotalItems)) {
                        $arrInfo[$i]->valorTotal = $valorTotalItems;
                    }
                }
                
                $arrRespuesta = array('status' => true, 'found' => count($arrInfo), 'data' => $arrInfo);
            }  
        }
        $arrRespuesta['user'] = $_SESSION['tipoUsuario'];
        if($_SESSION['tipoUsuario'] == 'cliente'){
            $arrRespuesta['nombreCliente'] = $_SESSION['nombreCliente'];
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "cambiarCreado") {
    if($_POST){
        if (empty($_POST['id'])) {
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $id = intval($_POST['id']);
            $arrInfo = $objPedido->cambiarCreado($id);
            if ($arrInfo > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Estado Modificado, se genero una nota de Débito del pedido.');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "cambiarEnProceso") {
    if($_POST){
        if (empty($_POST['id'])) {
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $id = intval($_POST['id']);
            $arrInfo = $objPedido->cambiarEnProceso($id);
            if ($arrInfo > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Estado Modificado');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "cambiarFinalizado") {
    if($_POST){
        if (empty($_POST['id'])) {
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $id = intval($_POST['id']);
            $arrInfo = $objPedido->cambiarFinalizado($id);
            if ($arrInfo > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Estado Modificado');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "cambiarEstadoCliente") {

    if($_POST){
        if (empty($_POST)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $id = intval($_POST['idPedido']);
            $arrInfo = $objPedido->cambiarEstadoCliente($id);
            if ($arrInfo > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Estado Modificado');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "eliminarBorrador") {

    $respuesta = $objPedido->eliminarBorrador();
    if ($respuesta > 0) {
        $arrRespuesta = array('status' => true, 'msg' => 'Se eliminaron los pedidos Borradores con éxito');
    } else {
        $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
    }

    echo json_encode($arrRespuesta);

    die();
}


?>