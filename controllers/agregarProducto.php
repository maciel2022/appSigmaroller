<?php
require_once "../models/configuracionGlobalModel.php";
require_once "../models/productoModel.php";

$option = $_REQUEST['op'];
$objColor = new ConfiguracionGlobalModel();
$objProducto = new ProductoModel();
$objCBV = new ProductoModel();
$objCR = new ProductoModel();
$objCC = new ProductoModel();
$objItemP = new ProductoModel();


///// OPCIONES DE OBTENER COLOR ///////
    //var_dump($_POST);
    //exit;
  

if ($option == "obtenerColor") {
    if ($_POST) {
        $idTela = intval($_POST['idTela']);
        $arrCol = $objColor->obtenerColores($idTela);
        //var_dump($arrCol);
        //exit;
        if (empty($arrCol)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrCol);
        }
        echo json_encode($arrRespuesta);
    }

    die();

   
}

if ($option == "agregarProducto") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrProd = $objProducto->listProducto();
   
    if (!empty($arrProd)) {
        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrProd;
    }
    echo json_encode($arrRespuesta);
    die();
}

if($option == "guardarCR"){
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
    if($_POST){
    if(empty($_POST)) {
        $arrRespuesta = array('status' => false, 'msg' => 'Error de datos'); 
    }else{
        $nombre = (trim($_POST['nombre'])); 
        $selTela = (trim($_POST['selTela']));              
        $selColor = (trim($_POST['selColor']));              
        $ancho = (trim($_POST['ancho']));              
        $alto = (trim($_POST['alto']));              
        $selCadena = (trim($_POST['selCadena']));                            
        $selComando = (trim($_POST['selComando']));              
        $selCaida = (trim($_POST['selCaida']));              
        $selMR = (trim($_POST['selMR']));              
        $selSoporte = (trim($_POST['selSoporte']));              
        $selMotor = (trim($_POST['selMotor']));
        // CheckBox        
        if(!empty($_POST['zocalo'])){
            $zocalo = 1;
        }else{
            $zocalo = 0;
        }         
        if(!empty($_POST['termofusion'])){
            $termofusion = 1;
        }else{
            $termofusion = 0;
        }             
        if(!empty($_POST['mecCol'])){
            $mecCol = 1;
        }else{
            $mecCol = 0;
        }             
        if(!empty($_POST['contrapeso'])){
            $contrapeso = 1;
        }else{
            $contrapeso = 0;
        } 

        $selDuplica = (trim($_POST['selDuplica']));
        $cantidad = (trim($_POST['cantidad']));
        $observaciones = (trim($_POST['observaciones']));
        $valor = (trim($_POST['valor']));
        $idPedido = intval($_POST['idPedidoCR']);
        $idCR = intval($_POST['idCR']);
        $idCRItem = intval($_POST['idCRItem']);
       
        $valorRetorno = $objCR->guardarCR($nombre, $selTela, $selColor, $ancho, $alto, $selCadena, $selComando, $selCaida, $selMR, 
                                          $selSoporte, $selMotor, $termofusion, $mecCol, $contrapeso, $selDuplica, $cantidad, $observaciones, $valor, $zocalo, $idPedido, $idCR, $idCRItem);
            if($valorRetorno == 1){
            $arrRespuesta = array('status' => true, 'msg' => 'Cortina creada correctamente! Item agregado.');
        }elseif($valorRetorno == 2){
            $arrRespuesta = array('status' => true, 'msg' => 'Item Modificado.');
        }else{
            $arrRespuesta = array('status' => false, 'msg' => 'Error al crear.'); 
        }
    }
    echo json_encode($arrRespuesta);
    }
    die();
}

//// FUNCION NUEVA CORTINA BANDA VERTICAL ////
    if ($option == "guardarCBV") {
    //     echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
        if ($_POST) {
            if ((empty($_POST))) {
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $nombre = (trim($_POST['nombreCBV']));
                $selTela1 = (trim($_POST['selTela1']));
                $selColor1 = (trim($_POST['selColor1']));
                $intAnchoCBV = (trim($_POST['numAnchoCBV']));
                $intAltoCBV = (trim($_POST['numAltoCBV']));
                $selComandoCBV = (trim($_POST['selComandoCBV']));
                $selMecCBV = (trim($_POST['selMecCBV']));
                $selMenCBV = (trim($_POST['selMenCBV']));
                $selMotCBV = (trim($_POST['selMotCBV']));
                $selAperCBV = (trim($_POST['selAperCBV']));
                $intValorCBV= (trim($_POST['numValorCBV']));
                $selDupCBV = (trim($_POST['selDupCBV']));
                $intCantCBV = (trim($_POST['numCantCBV']));
                $txtObsCBV = ucwords(trim($_POST['txtObsCBV']));
                $idPedidoBV = intval($_POST['idPedidoBV']);
                $idCBV = intval($_POST['idCBV']);
                $idCBVItem = intval($_POST['idCBVItem']);

                $valorRetorno = $objCBV->guardarCBV($nombre, $selTela1, $selColor1, $intAnchoCBV, $intAltoCBV, $selComandoCBV, $selMecCBV, $selMenCBV, $selMotCBV, $selAperCBV, $intValorCBV, $selDupCBV, $intCantCBV, $txtObsCBV, $idPedidoBV, $idCBV, $idCBVItem);
                if ($valorRetorno == 1) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Cortina creada correctamente! Item agregado.');
                }elseif($valorRetorno == 2){
                    $arrRespuesta = array('status' => true, 'msg' => 'Item Modificado.');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();
    }

    ///FUNCION NUEVA CORTINA BANDA CONFECCION //

    if ($option == "guardarCC") {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // exit;
        if ($_POST) {
            if ((empty($_POST))) {
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $nombre = (trim($_POST['nombreCC']));
                $selTela2 = (trim($_POST['selTela2']));
                $selColor2 = (trim($_POST['selColor2']));
                $intAnchoCC = (trim($_POST['numAnchoCC']));
                $intAltoCC = (trim($_POST['numAltoCC']));
                $intValorCC= intval($_POST['numValorCC']);
                $txtObsCC = ucwords(trim($_POST['txtObsCC']));
                $idPedidoCC = intval($_POST['idPedidoCC']);
                $idCC = intval($_POST['idCC']);
                $idCCItem = intval($_POST['idCCItem']);

                $valorRetorno = $objCC->guardarCC($nombre, $selTela2, $selColor2, $intAnchoCC, $intAltoCC, 
                $intValorCC, $txtObsCC, $idPedidoCC, $idCC, $idCCItem);
                if ($valorRetorno == 1) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Cortina creada correctamente! Item agregado.');
                } elseif($valorRetorno == 2){
                    $arrRespuesta = array('status' => true, 'msg' => 'Item Modificado.');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();
    }

    if ($option == "guardarItemProd") {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        // exit;
        if ($_POST) {
            if ((empty($_POST))) {
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $idPro = (trim($_POST['idPro']));
                $idPed = (trim($_POST['idPed']));
                $cantidad = $_POST['cantidad'];
                $valorUni = $_POST['valorUni'];
                $entero = substr($valorUni, 0, -2);
                $decimal = substr($valorUni, -2);
                $numeroFormat = $entero . '.' . $decimal;
                $valorUni = floatval($numeroFormat);

                $valorTotal = $valorUni * $cantidad;


                $valorRetorno = $objItemP->guardarItemPro($idPro, $idPed, $cantidad, $valorUni, $valorTotal);
                if ($valorRetorno > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Item agregado.');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();

 }
    

   
    

