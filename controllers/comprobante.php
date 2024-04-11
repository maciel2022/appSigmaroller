<?php
require_once "../models/comprobanteModel.php";
require_once "../models/pedidoModel.php";


$option = $_REQUEST['op'];
$objComp = new ComprobanteModel();
$objItem = new PedidoModel();


if ($option == "guardarCredito") {
    if ($_POST) {
        
        $idCliente = intval($_POST['idClienteCredito']);
        $descripcion = ucwords(trim($_POST['descripcion']));
        $valorCredito = $_POST['valor'];
        $fecha = date('Y-m-d H:i:s');
        $tipo = 'Crédito';

        // var_dump($_POST);
        // exit;

        $resp = $objComp->guardarCredito($idCliente, $descripcion, $valorCredito, $fecha, $tipo);
    
        if ($resp > 0) {
            $arrRespuesta = array('status' => true, 'msg' => 'Se realizo correctamente el Crédito!');
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'No se pudo realizar el Crédito!');
        }
        echo json_encode($arrRespuesta);
    }
    die();   
}

if ($option == "guardarDebito") {
    if ($_POST) {      
       
        $idCliente = intval($_POST['idClienteDebito']);
        $descripcion = ucwords(trim($_POST['descripcionDebito']));
        $valorDebito = $_POST['valorDebito'];
        $fecha = date('Y-m-d H:i:s');
        $tipo = 'Débito';

        // var_dump($_POST);
        // exit;

        $resp = $objComp->guardarDebito($idCliente, $descripcion, $valorDebito, $fecha, $tipo);
    
        if ($resp > 0) {
            $arrRespuesta = array('status' => true, 'msg' => 'Se realizo correctamente el Débito!');
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'No se pudo realizar el Débito!');
        }
        echo json_encode($arrRespuesta);
    }
    die();   
}

if ($option == "listaComprobantes") {
    
    if($_POST){
        $idCliente = $_POST['id'];
    }

    $resp = $objComp->listaComprobantes($idCliente);
    // var_dump($resp);
    // exit;
    if(empty($resp)){
        $arrRespuesta = array('status' => false, 'datos' => "");
    }else{
        $arrRespuesta = array('status' => true, 'datos' => $resp);
    }   
    echo json_encode($arrRespuesta);   
    // echo "<pre>";
    // var_dump($resp);
    // echo "</pre>";
    // exit;
    die();
}

if ($option == "listaComproFecha") {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
    if($_POST){
        $idCliente = $_POST['id'];
        $desde = $_POST['fechaDesde'];
        $hasta = $_POST['fechaHasta'];
    }

    $resp = $objComp->listaComproFecha($idCliente, $desde, $hasta);
    // var_dump($resp);
    // exit;
    if(empty($resp)){
        $arrRespuesta = array('status' => false, 'datos' => "");
    }else{
        $arrRespuesta = array('status' => true, 'datos' => $resp);
    }   
    echo json_encode($arrRespuesta);   
    // echo "<pre>";
    // var_dump($resp);
    // echo "</pre>";
    // exit;
    die();
}

if ($option == "listaCuentaCorriente") {
    if($_POST){
        $idCliente = $_POST['id'];
    }

    $resp = $objComp->cuentaCorriente($idCliente);
    // echo "<pre>";
    // var_dump($resp);
    // echo "</pre>";
    // exit;

    if(empty($resp)){
        $arrRespuesta = array('status' => false, 'data' => "");
    }else{
        $arrRespuesta = array('status' => true, 'data' => $resp);
    }   
    echo json_encode($arrRespuesta);   
    
    die();
}

if ($option == "debitoPorId") {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
    if($_POST){
        $idPedido = intval($_POST['idPedido']);
    }

    $valorDebito = $objItem->existeItem($idPedido);
    $resultado = $objItem->getPedidoDebito($idPedido);
    $idCliente = $resultado['idClientes'];
    $descripcion = 'Pedido Nro: '. $idPedido;
    $fecha = date('Y-m-d H:i:s');
    $tipo = 'Débito';

    $resp = $objComp->guardarDebitoAuto($idCliente, $idPedido, $descripcion, $valorDebito, $fecha, $tipo);
    
    if ($resp > 0) {
        $arrRespuesta = array('status' => true, 'msg' => 'Se realizo correctamente el Débito!');
    } else {
        $arrRespuesta = array('status' => false, 'msg' => 'No se pudo realizar el Débito!');
    }
    echo json_encode($arrRespuesta); 
    
    die();
}
