<?php
require_once "../models/productoModel.php";

$option = $_REQUEST['op'];
$objItem = new ProductoModel();
$objCR = new ProductoModel();
$objCBV = new ProductoModel();
$objCC = new ProductoModel();
$objTela = new ProductoModel();
$objColor = new ProductoModel();
$objPedido = new ProductoModel();


///// MOSTRAR POR TABLA ITEMS POR PEDIDO ///////
if ($option == "listItems") {
    // var_dump($_POST);
    // exit;
    if($_POST){
        $idPedido = intval($_POST['id']);
    }

    $arrRespuesta = array('status' => false, 'data' => "");
    $arrItems = $objItem->traerItems($idPedido);
    // echo "<pre>"; 
    // var_dump($arrItems);
    // echo "</pre>";
    // exit;
    if (!empty($arrItems)) {
        $valorTotal = 0;
        for ($i = 0; $i < count($arrItems); $i++) {
            $valorItem = $arrItems[$i]->valorTotal;
            $valorItem = floatval($valorItem);

            $valorTotal += $valorItem;
            
            $idItem = $arrItems[$i]->idItem;
            $idProd = $arrItems[$i]->idProducto;
            $idCR = $arrItems[$i]->idCortinaRoller;
            $idBV = $arrItems[$i]->idCortinaBandaVertical;
            $idCC = $arrItems[$i]->idCortinaConfeccion;
            $itemSelec = "";
            $tipo = "";
            
             if (!empty($idProd)) {
                $nombre = $objItem->getProducto($idProd);
                $itemSelec = $nombre->nombre;
                $tipo = 'producto';
                $options = '<button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarItem(' . $idItem . ')"><i class="bi bi-trash"></i></button>';
            } elseif (!empty($idCR )) {
                $nombre = $objItem->getItemCR($idCR);
                $itemSelec = 'CR: '. $nombre->nombre;
                $tipo = 'CR';
                $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntModCR(' . $idCR . ', ' . $idItem . ')"><i class="bi bi-pencil-square"></i></button>
                           <button type="button" class="btn  btn-outline-warning btn-sm ms-2" onclick="fntVerCR(' . $idCR . ', ' . $idItem . ')"><i class="bi bi-eye"></i></button>
                           <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarItem(' . $idItem . ')"><i class="bi bi-trash"></i></button>';
            } elseif (!empty($idBV)) {
                $nombre = $objItem->getItemBV($idBV);
                $itemSelec = 'CBV: '. $nombre->nombre;
                $tipo = 'CBV';
                $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntModCBV(' . $idBV . ', ' . $idItem . ')"><i class="bi bi-pencil-square"></i></button>
                           <button type="button" class="btn  btn-outline-warning btn-sm ms-2" onclick="fntVerCBV(' . $idBV . ', ' . $idItem . ')"><i class="bi bi-eye"></i></button>
                           <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarItem(' . $idItem . ')"><i class="bi bi-trash"></i></button>';
            } elseif (!empty($idCC)) {
                $nombre = $objItem->getItemCC($idCC);
                $itemSelec = 'CC: '. $nombre->nombre;
                $tipo = 'CC';
                $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntModCC(' . $idCC . ', ' . $idItem . ')"><i class="bi bi-pencil-square"></i></button>
                <button type="button" class="btn  btn-outline-warning btn-sm ms-2" onclick="fntVerCC(' . $idCC . ', ' . $idItem . ')"><i class="bi bi-eye"></i></button>
                           <button type="button" class="btn  btn-outline-danger btn-sm ms-2" onclick="fntEliminarItem(' . $idItem . ')"><i class="bi bi-trash"></i></button>';
            }

            $arrItems[$i]->options = $options;
            $arrItems[$i]->itemSelec = $itemSelec;
            $arrItems[$i]->tipo = $tipo;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrItems;
        $arrRespuesta['valorTotal'] = $valorTotal;
    }
    echo json_encode($arrRespuesta);
    die();
}

if($option == "modItemCR"){
    
    if ($_POST) {
        $id = intval($_POST['idCR']);
        $arrCR = $objCR->getCR($id);
        // echo "<pre>";
        // var_dump($arrCR);
        // echo "</pre>";
        // exit;
        if (empty($arrCR)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrCR);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if($option == "modItemCBV"){
    //  echo "<pre>";
    //     var_dump($_POST);
    //     echo "</pre>";
    //     exit;
    if ($_POST) {
        $id = intval($_POST['idCBV']);
        $arrCBV = $objCBV->getCBV($id);
        if (empty($arrCBV)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrCBV);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if($option == "modItemCC"){
    //  echo "<pre>";
    //     var_dump($_POST);
    //     echo "</pre>";
    //     exit;
    if ($_POST) {
        $id = intval($_POST['idCC']);
        $arrCC = $objCC->getCC($id);
        if (empty($arrCC)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrCC);
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
            $arrInfo = $objItem->delItem($id);
            if ($arrInfo > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Item eliminado');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
            }
        }
        echo json_encode($arrRespuesta);
    }

}

if($option == "verItems"){
    if(empty($_POST)){
        $arrRespuesta = array('status' => false, 'data' => "");
    }
    $idPedido = $_POST['id'];
    $arrItems = $objItem->traerItems($idPedido);
    $datosPedido = $objPedido->datosPedido($idPedido);
    // echo "<pre>"; 
    // var_dump($datosPedido);
    // echo "</pre>";
    // exit;
    if (!empty($arrItems)) {
        for ($i = 0; $i < count($arrItems); $i++) {

            $idItem = $arrItems[$i]->idItem;
            $idProd = $arrItems[$i]->idProducto;
            $idCR = $arrItems[$i]->idCortinaRoller;
            $idBV = $arrItems[$i]->idCortinaBandaVertical;
            $idCC = $arrItems[$i]->idCortinaConfeccion;
            $itemSelec = "";
            
             if (!empty($idProd)) {
                $producto = $objItem->getProducto($idProd);
                $producto->tipo = 'producto';
                $itemSelec = $producto;
 
            } elseif (!empty($idCR )) {
                $cortinaR = $objItem->getItemCR($idCR);
                // var_dump($cortinaR);
                // exit;
                $idTela = $cortinaR->tela;
                $idColor = $cortinaR->color;
                
                $nombreTela = $objTela->getTela($idTela);
                $nombreTela = $nombreTela['nombre'];

                $nombreColor = $objColor->getColor($idColor);
                $nombreColor = $nombreColor['nombreColor'];

                

                $cortinaR->tela = $nombreTela;
                $cortinaR->color = $nombreColor;
                $cortinaR->tipo = 'cortinaR';
                $itemSelec = $cortinaR;
             
            }elseif (!empty($idBV)) {
                $cortinaBV = $objItem->getItemBV($idBV);
                //  var_dump($cortinaBV);
                // exit;
                $cortinaBV->tipo = 'cortinaBV';
                $idTela = $cortinaBV->tela;
                $idColor = $cortinaBV->color;
                
                $nombreTela = $objTela->getTela($idTela);
                $nombreTela = $nombreTela['nombre'];

                $nombreColor = $objColor->getColor($idColor);
                $nombreColor = $nombreColor['nombreColor'];

                

                $cortinaBV->tela = $nombreTela;
                $cortinaBV->color = $nombreColor;
                $cortinaBV->tipo = 'cortinaBV';
                $itemSelec = $cortinaBV;

            }elseif (!empty($idCC)) {
                $cortinaC = $objItem->getItemCC($idCC);
                $cortinaC->tipo = 'cortinaC';
                $idTela = $cortinaC->tela;
                $idColor = $cortinaC->color;
                
                $nombreTela = $objTela->getTela($idTela);
                $nombreTela = $nombreTela['nombre'];

                $nombreColor = $objColor->getColor($idColor);
                $nombreColor = $nombreColor['nombreColor'];

                

                $cortinaC->tela = $nombreTela;
                $cortinaC->color = $nombreColor;
                $cortinaC->tipo = 'cortinaC';
                $itemSelec = $cortinaC;   
               
            }

            $arrItems[$i]->itemSelec = $itemSelec;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrItems;
        $arrRespuesta['datos'] = $datosPedido;
    }
    echo json_encode($arrRespuesta);
    die();
}

?>