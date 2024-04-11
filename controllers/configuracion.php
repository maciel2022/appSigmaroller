<?php
require_once "../models/configuracionGlobalModel.php";

$option = $_REQUEST['op'];
$objTelas = new ConfiguracionGlobalModel();
$objColor = new ConfiguracionGlobalModel();
$objMecanismoBV = new ConfiguracionGlobalModel();
$objMotorBV = new ConfiguracionGlobalModel();
$objMCC = new ConfiguracionGlobalModel();
$objMotCC = new ConfiguracionGlobalModel();
$objMecR = new ConfiguracionGlobalModel();
$objMotR = new ConfiguracionGlobalModel();
$objZoc = new ConfiguracionGlobalModel();
$objSop = new ConfiguracionGlobalModel();
$objAper = new ConfiguracionGlobalModel();
$objExtras = new ConfiguracionGlobalModel();

///// OPCIONES DE TELAS ///////
if ($option == "listTelas") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrTelas = $objTelas->getTelas();

    if (!empty($arrTelas)) {
        for ($i = 0; $i < count($arrTelas); $i++) {
            $idTela = $arrTelas[$i]->idTela;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarTela(' . $idTela . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrTelas[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrTelas;
    }
    echo json_encode($arrRespuesta);
    die();
}
if ($option == "guardarTela") {
    // print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtNombre']) || empty($_POST['numPrecio']) || empty($_POST['selEstado'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreTela = ucwords(trim($_POST['txtNombre']));
            $intNumPrecio = trim($_POST['numPrecio']);
            $strEstado = ucwords($_POST['selEstado']);
            $arrTelas = $objTelas->insertTela($strNombreTela, $intNumPrecio, $strEstado);
            if ($arrTelas > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o usuario de cliente ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}
if ($option == "verTela") {
    if ($_POST) {
        $idTela = intval($_POST['idTela']);
        $arrTela = $objTelas->getTela($idTela);
        if (empty($arrTela)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrTela);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarTelas") {
    if ($_POST) {
        if (empty($_POST['txtModalModificarNombre']) || empty($_POST['numModificarPrecio']) || empty($_POST['selModificarEstado'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdTela = trim($_POST['intModalIdTelas']);
            $strNombreTela = ucwords(trim($_POST['txtModalModificarNombre']));
            $intNumPrecio = trim($_POST['numModificarPrecio']);
            $strEstado = ucwords($_POST['selModificarEstado']);

            $arrTela = $objTelas->updateTelas($intIdTela, $strNombreTela, $intNumPrecio, $strEstado);
            if ($arrTela > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o tela ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delTela"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idTela'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idTela = intval($_POST['idTela']);
//             $valorRetorno = $objTelas->delTela($idTela);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Tela eliminada');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }



///// OPCIONES DE COLORES ///////
if ($option == "listColores") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrColores = $objColor->getColores();

    if (!empty($arrColores)) {
        for ($i = 0; $i < count($arrColores); $i++) {
            $idColor = $arrColores[$i]->idColor;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarColor(' . $idColor . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrColores[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrColores;
    }
    echo json_encode($arrRespuesta);
    die();
}
if ($option == "guardarColor") {
    // print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtNombreColor']) || empty($_POST['selTelaColor']) || empty($_POST['selEstadoColor'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreColor = ucwords(trim($_POST['txtNombreColor']));
            $intIdTela = trim($_POST['selTelaColor']);
            $strEstado = ucwords($_POST['selEstadoColor']);
            $arrColores = $objColor->insertColor($strNombreColor, $intIdTela, $strEstado);
            if ($arrColores > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o usuario de color ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}
if ($option == "verColor") {
    if ($_POST) {
        $idColor = intval($_POST['idColor']);
        $arrColor = $objColor->getColor($idColor);
        if (empty($arrColor)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrColor);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarColor") {
    if ($_POST) {
        if (empty($_POST['txtModalModificarNombreColor']) || empty($_POST['selModTelaColor']) || empty($_POST['selModificarColorEstado'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdColor = trim($_POST['intModalIdColor']);
            $strNombreColor = ucwords(trim($_POST['txtModalModificarNombreColor']));
            $intIdTela = trim($_POST['selModTelaColor']);
            $strEstado = ucwords($_POST['selModificarColorEstado']);

            $arrColores = $objColor->updateColores($intIdColor, $strNombreColor, $intIdTela, $strEstado);
            if ($arrColores > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o color ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delColor"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idColor'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idColor = intval($_POST['idColor']);
//             $valorRetorno = $objColor->delColor($idColor);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Color eliminada');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }

///// OPCIONES DE MECANISMO BANDA VERTICAL ///////


if ($option == "listMecanismoBV") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrMecanismoBV = $objMecanismoBV->getMecanismoBV();

    if (!empty($arrMecanismoBV)) {
        for ($i = 0; $i < count($arrMecanismoBV); $i++) {
            $idMecanismoBandaVertical = $arrMecanismoBV[$i]->idMecanismoBandaVertical;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarMecanismoBV(' . $idMecanismoBandaVertical . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrMecanismoBV[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrMecanismoBV;
    }
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "guardarMecanismoBV") {
    // print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtNombreMBV']) || empty($_POST['numPrecioMBV'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreMecanismoBV = ucwords(trim($_POST['txtNombreMBV']));
            $intNumPrecioMecanismoBV = trim($_POST['numPrecioMBV']);
            $strEstado = trim($_POST['selEstadoMe']);
            $intNumPrecioMecanismoBV = trim($_POST['numPrecioMBV']);
            $arrMecanismoBV = $objMecanismoBV->insertMecanismoBV($strNombreMecanismoBV, $strEstado,$intNumPrecioMecanismoBV);
            if ($arrMecanismoBV > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o usuario de cliente ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "verMecanismoBV") {
    if ($_POST) {
        $idMecanismoBandaVertical = intval($_POST['idMecanismoBandaVertical']);
        $arrMecanismoBV = $objMecanismoBV->getMecanismosBV($idMecanismoBandaVertical);
     
        if (empty($arrMecanismoBV)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrMecanismoBV);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarMecanismoBV") {
    if ($_POST) {
        if (empty($_POST['txtModalNombreMecanismoBV']) || empty($_POST['selEstadoMoMe'])|| empty($_POST['modalNumPrecioMBV'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdMecanismoBV = trim($_POST['modalIdMecanismoBandaVertical']);
            $strNombreNuevoMecanismo = ucwords(trim($_POST['txtModalNombreMecanismoBV']));
            $strEstado= ucwords(trim($_POST['selEstadoMoMe']));
            $intNumNuevoPrecioBV = trim($_POST['modalNumPrecioMBV']);

            $arrMecanismoBV = $objMecanismoBV->updateMecanismoBV($intIdMecanismoBV, $strNombreNuevoMecanismo, $strEstado, $intNumNuevoPrecioBV);
            if ($arrMecanismoBV > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o tela ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delMecBV"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idMecanismoBandaVertical'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idMecanismoBandaVertical = intval($_POST['idMecanismoBandaVertical']);
//             $valorRetorno = $objMecanismoBV->delMBV($idMecanismoBandaVertical);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Mecanismo eliminado');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }

///// OPCIONES DE MOTOR BANDA VERTICAL ///////

if ($option == "listMotorMBV") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrMotorBV = $objMotorBV->getMotorMBV();

    if (!empty($arrMotorBV)) {
        for ($i = 0; $i < count($arrMotorBV); $i++) {
            $idMotorBandaVertical = $arrMotorBV[$i]->idMotorBandaVertical;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarMotorBV(' . $idMotorBandaVertical . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrMotorBV[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrMotorBV;
    }
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "guardarMotorBV") {
    // print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtNombreMotorBV']) || empty($_POST['numPrecioMotorBV'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreMotorBV = ucwords(trim($_POST['txtNombreMotorBV']));
            $intNumPrecioMotorBV = trim($_POST['numPrecioMotorBV']);
            $strEstado = ucwords($_POST['selEstadoMo']);
            $arrMotorBV = $objMotorBV->insertMotorBV($strNombreMotorBV, $intNumPrecioMotorBV, $strEstado);
            if ($arrMotorBV > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o motor ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}


if ($option == "verMotorBV") {
    if ($_POST) {
        $idMotorBandaVertical = intval($_POST['idMotorBandaVertical']);
        $arrMotorBV = $objMotorBV->getMotorBV($idMotorBandaVertical);
        if (empty($arrMotorBV)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrMotorBV);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarMotorBV") {
    if ($_POST) {
        if (empty($_POST['txtModalNombreMotorBV']) || empty($_POST['numModalPrecioMotorBV'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdMotorBV = trim($_POST['modalIdMotorBandaVertical']);
            $strNombreNuevoMotorBV = ucwords(trim($_POST['txtModalNombreMotorBV']));
            $intNumNuevoPrecioBV = trim($_POST['numModalPrecioMotorBV']);
            $strEstado = ucwords($_POST['selEstadoMoMo']);

            $arrMotorBV = $objMotorBV->updateMotorBV($intIdMotorBV, $strNombreNuevoMotorBV, $intNumNuevoPrecioBV, $strEstado);
            if ($arrMotorBV > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o tela ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delMotBV"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idMotorBandaVertical'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idMotorBandaVertical = intval($_POST['idMotorBandaVertical']);
//             $valorRetorno = $objMotorBV->delMotBV($idMotorBandaVertical);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Motor eliminado');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }

//////// fin//////////////

if ($option == "listApertura") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrApertura = $objAper->getApertura();

    if (!empty($arrApertura)) {
        for ($i = 0; $i < count($arrApertura); $i++) {
            $idApertura = $arrApertura[$i]->idApertura;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarApertura(' . $idApertura . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrApertura[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrApertura;
    }
    echo json_encode($arrRespuesta);
    die();
}
if ($option == "guardarApertura") {
    //     var_dump($_POST);
    //    exit;

    if ($_POST) {
        if (empty($_POST['txtNombreA']) || empty($_POST['numPreA'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreA = ucwords(trim($_POST['txtNombreA']));
            $intNumA = trim($_POST['numPreA']);
            $strEstado = ucwords($_POST['selEstadoAp']);
            $arrApertura = $objAper->insertApertura($strNombreA, $intNumA, $strEstado);
            if ($arrApertura > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o Apertura ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "verApertura") {
    if ($_POST) {
        $idApertura = intval($_POST['idApertura']);
        $arrApertura = $objAper->getAper($idApertura);
        if (empty($arrApertura)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrApertura);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarApertura") {
    if ($_POST) {
        if (empty($_POST['txtModalNombreA']) || empty($_POST['txtModalPrecioA']) || empty($_POST['selEstadoMoAp'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdA = trim($_POST['txtModalIdA']);
            $strNombreA = ucwords(trim($_POST['txtModalNombreA']));
            $intNumPreA = trim($_POST['txtModalPrecioA']);
            $strEstado = trim($_POST['selEstadoMoAp']);

            $arrApertura = $objAper->updateApertura($intIdA, $strNombreA, $intNumPreA, $strEstado);
            if ($arrApertura > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o apertura ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delApertura"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idApertura'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idApertura = intval($_POST['idApertura']);
//             $valorRetorno = $objAper->delAper($idApertura);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Motor eliminado');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }
///// OPCIONES DE MECANISMO CONFECCION CORTINAS CONFECION ///////
if ($option == "listMecanismoCC") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrMCC = $objMCC->getMecanismoCC();

    if (!empty($arrMCC)) {
        for ($i = 0; $i < count($arrMCC); $i++) {
            $idMecanismoConfeccion = $arrMCC[$i]->idMecanismoConfeccion;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarMCC(' . $idMecanismoConfeccion . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrMCC[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrMCC;
    }
    echo json_encode($arrRespuesta);
    die();
}


if ($option == "guardarMCC") {
    // print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtNombreMCC']) || empty($_POST['numPreMCC'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreMCC = ucwords(trim($_POST['txtNombreMCC']));
            $intNumPrecioMCC = trim($_POST['numPreMCC']);
            $strEstado = ucwords($_POST['selEstadoMe']);
            $arrMCC = $objMCC->insertMCC($strNombreMCC, $intNumPrecioMCC, $strEstado);
            if ($arrMCC > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o motor ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "verMCC") {
    //var_dump($_POST);
    if ($_POST) {
        $idMecanismoConfeccion = intval($_POST['idMecanismoConfeccion']);
        $arrMCC = $objMCC->getMCC($idMecanismoConfeccion);
        //var_dump($arrMCC);
        if (empty($arrMCC)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrMCC);
        }

        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarMCC") {
    if ($_POST) {
        if (empty($_POST['txtModalNombreMCC']) || empty($_POST['txtModalPrecioMCC'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdMCC = trim($_POST['txtModalIdMecanismoConfeccion']);
            $strNombreNuevoMCC = ucwords(trim($_POST['txtModalNombreMCC']));
            $intNumNuevoPrecioMCC = trim($_POST['txtModalPrecioMCC']);
            $strEstado = ucwords($_POST['selEstadoMeMo']);

            $arrMCC = $objMCC->updateMCC($intIdMCC, $strNombreNuevoMCC, $intNumNuevoPrecioMCC, $strEstado);

            if ($arrMCC > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o Mecanismo ya existe');
            }
        }
        //var_dump($arrRespuesta);
        echo json_encode($arrRespuesta);
    }
    die();
}
// if($option == "delMecanismoCC"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idMecanismoConfeccion'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idMecanismoConfeccion = intval($_POST['idMecanismoConfeccion']);
//             $valorRetorno = $objMCC->delMecCC($idMecanismoConfeccion);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Mecanismo eliminado');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }


///// OPCIONES DE MOTOR CORTINA CONFECCION ///////

if ($option == "listMotCC") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrMotCC = $objMotCC->getMotCC();
    //var_dump($arrMotCC);

    if (!empty($arrMotCC)) {
        for ($i = 0; $i < count($arrMotCC); $i++) {
            $idMotorConfeccion = $arrMotCC[$i]->idMotorConfeccion;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarMotCC(' . $idMotorConfeccion . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrMotCC[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrMotCC;
    }
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "guardarMotCC") {
    // print_r($_POST);

    if ($_POST) {
        if (empty($_POST['txtNomMotCC']) || empty($_POST['numPreMotCC'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreMotCC = ucwords(trim($_POST['txtNomMotCC']));
            $intNumPrecioMotCC = trim($_POST['numPreMotCC']);
            $strEstado = ucwords($_POST['selEstadoMo']);
            $arrMotCC = $objMotCC->insertMotCC($strNombreMotCC, $intNumPrecioMotCC, $strEstado);
            if ($arrMotCC > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o motor ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "verMotCC") {
    if ($_POST) {
        $idMotorConfeccion = intval($_POST['idMotorConfeccion']);
        $arrMotCC = $objMotCC->getMotorCC($idMotorConfeccion);
        if (empty($arrMotCC)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrMotCC);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarMotCC") {
    if ($_POST) {
        if (empty($_POST['txtModalNombMotCC']) || empty($_POST['numModalMotCC'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdMotCC = trim($_POST['txtModalIdMotCC']);
            $strNombreNuevoMotCC = ucwords(trim($_POST['txtModalNombMotCC']));
            $intNumNuevoPrecioMotCC = trim($_POST['numModalMotCC']);
            $strEstado = ucwords($_POST['selEstadoMoMo']);

            $arrMotCC = $objMotCC->updateMotCC($intIdMotCC, $strNombreNuevoMotCC, $intNumNuevoPrecioMotCC, $strEstado);
            if ($arrMotCC > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o Motor ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delMotorCC"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idMotorConfeccion'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idMotorConfeccion = intval($_POST['idMotorConfeccion']);
//             $valorRetorno = $objMotCC->delMotCC($idMotorConfeccion);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Motor eliminado');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }
///// OPCIONES DE MOTOR CORTINA CONFECCION  FIN ///////

///// OPCIONES DE MOTOR CORTINA ROLLER ///////

if ($option == "listMecR") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrMecR = $objMecR->getMecR();

    if (!empty($arrMecR)) {
        for ($i = 0; $i < count($arrMecR); $i++) {
            $idMecanismoRoller = $arrMecR[$i]->idMecanismoRoller;
            $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarMecR(' . $idMecanismoRoller . ')"><i class="bi bi-pencil-square"></i></button>';
            $arrMecR[$i]->options = $options;
        }

        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrMecR;
    }
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "guardarMecR") {
    //    var_dump($_POST);
    //    exit;

    if ($_POST) {
        if (empty($_POST['txtNombreMecR']) || empty($_POST['numLarMecR']) || empty($_POST['numPreMecR']) || empty($_POST['selEstadoMe'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $strNombreMecR = ucwords(trim($_POST['txtNombreMecR']));
            $intNumLargoMecR = trim($_POST['numLarMecR']);
            $intNumPrecioMecR = trim($_POST['numPreMecR']);
            $strEstado = ucwords($_POST['selEstadoMe']);
            $arrMecR = $objMecR->insertMecR($strNombreMecR, $intNumLargoMecR, $intNumPrecioMecR, $strEstado);
            if ($arrMecR > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o mecanismo ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "verMecR") {
    if ($_POST) {
        $idMecanismoRoller = intval($_POST['idMecanismoRoller']);
        $arrMecR = $objMecR->getMecRol($idMecanismoRoller);
        if (empty($arrMecR)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrMecR);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificarMecR") {
    //var_dump($_POST);
    //exit;

    if ($_POST) {
        if (empty($_POST['txtModalNombreMecR']) || empty($_POST['numModalLarMecR']) || empty($_POST['txtModalPrecioMecR']) || empty($_POST['selEstadoMeMo'])) {

            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdMecR = trim($_POST['txtModalIdMecR']);
            $strNombreNuevoMecR = ucwords(trim($_POST['txtModalNombreMecR']));
            $intNumNuevoLargoMecR = trim($_POST['numModalLarMecR']);
            $intNumNuevoPrecioMecR = trim($_POST['txtModalPrecioMecR']);
            $strEstado = trim($_POST['selEstadoMeMo']);

            $arrMecR = $objMecR->updateMecR($intIdMecR, $strNombreNuevoMecR, $intNumNuevoLargoMecR, $intNumNuevoPrecioMecR, $strEstado);
            if ($arrMecR > 0) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o Motor ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

// if($option == "delMecCR"){
        
//     if($_POST){
//         // echo ('<pre>');
//         // var_dump($_POST);
//         // echo ('</pre>');
//         // exit;
//         if(empty($_POST['idMecanismoRoller'])){
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         }else{
//             $idMecanismoRoller = intval($_POST['idMecanismoRoller']);
//             $valorRetorno = $objAper->delMCR($idMecanismoRoller);
            
//             if($valorRetorno = 1){
//                 $arrRespuesta = array('status' => true, 'msg' => 'Mecanismo eliminado');
//             }else{
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }
    ///// OPCIONES DE MECANISMO ROLLER FIN ///////
    
    
    ///// OPCIONES DE MOTOR ROLLER  ///////

    if ($option == "listMotR") {
        $arrRespuesta = array('status' => false, 'data' => "");
        $arrMotR = $objMotR->getMotR();
    
        if (!empty($arrMotR)) {
            for ($i = 0; $i < count($arrMotR); $i++) {
                $idMotorCR = $arrMotR[$i]->idMotorCR;
                $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarMotR(' . $idMotorCR . ')"><i class="bi bi-pencil-square"></i></button>';
                $arrMotR[$i]->options = $options;
            }
    
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrMotR;
        }
        echo json_encode($arrRespuesta);
        die();
    }

    if ($option == "guardarMotR") {
        // print_r($_POST);
    
        if ($_POST) {
            if (empty($_POST['txtNomMotR']) || empty($_POST['numPreMotR'])) {
    
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strNombreMotR = ucwords(trim($_POST['txtNomMotR']));
                $intNumPrecioMotR = trim($_POST['numPreMotR']);
                $strEstado = ucwords($_POST['selEstadoMo']);
                $arrMotR = $objMotR->insertMotR($strNombreMotR, $intNumPrecioMotR, $strEstado);
                if ($arrMotR > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o motor ya existe');
                }
            }
    
            echo json_encode($arrRespuesta);
        }
        die();
    }
    
    if ($option == "verMotR") {
        if ($_POST) {
            $idMotCR = intval($_POST['idMotorCR']);
            $arrMotR = $objMotR->getMotCR($idMotCR);
            if (empty($arrMotR)) {
                $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrMotR);
            }
            echo json_encode($arrRespuesta);
        }
    
        die();
    }
    
    if ($option == "modificarMotR") {
        if ($_POST) {
            if (empty($_POST['txtModalNombMotR']) || empty($_POST['numModalMotR']) || empty($_POST['selEstadoMoMe'])) {
    
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $intIdMotR = trim($_POST['txtModalIdMotR']);
                $strNombreNuevoMotR = ucwords(trim($_POST['txtModalNombMotR']));
                $intNumNuevoPrecioR= trim($_POST['numModalMotR']);
                $strEstado= trim($_POST['selEstadoMoMe']);
    
                $arrMotR = $objMotR->updateMotR($intIdMotR, $strNombreNuevoMotR, $intNumNuevoPrecioR, $strEstado);
                if ($arrMotR > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o motor ya existe');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();
    }

    // if($option == "delMotCR"){
        
    //     if($_POST){
    //         // echo ('<pre>');
    //         // var_dump($_POST);
    //         // echo ('</pre>');
    //         // exit;
    //         if(empty($_POST['idMotorCR'])){
    //             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
    //         }else{
    //             $idMotorCR = intval($_POST['idMotorCR']);
    //             $valorRetorno = $objMotR->delMoCR($idMotorCR);
                
    //             if($valorRetorno = 1){
    //                 $arrRespuesta = array('status' => true, 'msg' => 'Motor eliminado');
    //             }else{
    //                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
    //             }
    //         }
    //         echo json_encode($arrRespuesta);
    //     }
    // }

    // ///// OPCIONES DE ZOCALO ROLLER ///////

    // if ($option == "listZ") {
    //     $arrRespuesta = array('status' => false, 'data' => "");
    //     $arrZ = $objZoc->getZ();
    
    //     if (!empty($arrZ)) {
    //         for ($i = 0; $i < count($arrZ); $i++) {
    //             $idZocalo = $arrZ[$i]->idZocalo;
    //             $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarZ(' . $idZocalo . ')"><i class="bi bi-pencil-square"></i></button>
    //             <button class="btn  btn-outline-danger btn-sm " title="Eliminar Agrupamiento" onclick="fntDelZocalo('.$idZocalo.')" ><i class="bi bi-trash"></i></button>';
    //             $arrZ[$i]->options = $options;
    //         }
    
    //         $arrRespuesta['status'] = true;
    //         $arrRespuesta['data'] = $arrZ;
    //     }
    //     echo json_encode($arrRespuesta);
    //     die();
    // }


    // if ($option == "guardarZ") {
    //     // print_r($_POST);
    
    //     if ($_POST) {
    //         if (empty($_POST['txtNombreZ']) || empty($_POST['numPreZ'])) {
    
    //             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
    //         } else {
    //             $strNombreZ = ucwords(trim($_POST['txtNombreZ']));
    //             $intNumPrecioZ = trim($_POST['numPreZ']);
    //             $arrZ = $objZoc->insertZoc($strNombreZ, $intNumPrecioZ);
    //             if ($arrZ > 0) {
    //                 $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
    //             } else {
    //                 $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o motor ya existe');
    //             }
    //         }
    
    //         echo json_encode($arrRespuesta);
    //     }
    //     die();
    // }

    // if ($option == "verZ") {
    //     if ($_POST) {
    //         $idZocalo = intval($_POST['idZocalo']);
    //         $arrZ = $objZoc->getZoc($idZocalo);
    //         if (empty($arrZ)) {
    //             $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
    //         } else {
    //             $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrZ);
    //         }
    //         echo json_encode($arrRespuesta);
    //     }
    
    //     die();
    // }
    
    // if ($option == "modificarZ") {
    //     if ($_POST) {
    //         if (empty($_POST['txtModalNombreZ']) || empty($_POST['txtModalPrecioZ'])) {
    
    //             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
    //         } else {
    //             $intIdZ = trim($_POST['txtModalIdZ']);
    //             $strNombreNuevoZ = ucwords(trim($_POST['txtModalNombreZ']));
    //             $intNumNuevoPreZ= trim($_POST['txtModalPrecioZ']);
    
    //             $arrZ = $objZoc->updateZoc($intIdZ, $strNombreNuevoZ, $intNumNuevoPreZ);
    //             if ($arrZ > 0) {
    //                 $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
    //             } else {
    //                 $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o zocalo ya existe');
    //             }
    //         }
    //         echo json_encode($arrRespuesta);
    //     }
    //     die();
    // }

    //// OPCIONES DE SOPORTE ROLLER ///////

    if ($option == "listS") {
        $arrRespuesta = array('status' => false, 'data' => "");
        $arrS = $objSop->getS();
    
        if (!empty($arrS)) {
            for ($i = 0; $i < count($arrS); $i++) {
                $idSoporte = $arrS[$i]->idSoporte;
                $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarS(' . $idSoporte . ')"><i class="bi bi-pencil-square"></i></button>';
                $arrS[$i]->options = $options;
            }
    
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrS;
        }
        echo json_encode($arrRespuesta);
        die();
    }

    if ($option == "guardarS") {
        // print_r($_POST);
    
        if ($_POST) {
            if (empty($_POST['txtNomS']) || empty($_POST['numPreS']) || empty($_POST['selEstadoS'])) {
    
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strNombreS = ucwords(trim($_POST['txtNomS']));
                $intNumPrecioS = trim($_POST['numPreS']);
                $strEstado = ucwords($_POST['selEstadoS']);
                $arrS = $objSop->insertSop($strNombreS, $intNumPrecioS, $strEstado);
                if ($arrS > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o soporte ya existe');
                }
            }
    
            echo json_encode($arrRespuesta);
        }
        die();
    }

    if ($option == "verS") {
        if ($_POST) {
            $idSoporte = intval($_POST['idSoporte']);
            $arrS = $objSop->getSop($idSoporte);
            if (empty($arrS)) {
                $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrS);
            }
            echo json_encode($arrRespuesta);
        }
    
        die();
    }
    
    if ($option == "modificarS") {
        if ($_POST) {
            if (empty($_POST['txtModalNombS']) || empty($_POST['numModalS']) || empty($_POST['selEstadoMoS'])) {
    
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $intIdS = trim($_POST['txtModalIdS']);
                $strNombreNuevoS = ucwords(trim($_POST['txtModalNombS']));
                $intNumNuevoPreS= trim($_POST['numModalS']);
                $strEstado= ucwords($_POST['selEstadoMoS']);
    
                $arrS = $objZoc->updateSop($intIdS, $strNombreNuevoS, $intNumNuevoPreS, $strEstado);
                if ($arrS > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o zocalo ya existe');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();
    }

    // if($option == "delSoporte"){
        
    //     if($_POST){
    //         // echo ('<pre>');
    //         // var_dump($_POST);
    //         // echo ('</pre>');
    //         // exit;
    //         if(empty($_POST['idSoporte'])){
    //             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
    //         }else{
    //             $idSoporte = intval($_POST['idSoporte']);
    //             $valorRetorno = $objSop->delSop($idSoporte);
                
    //             if($valorRetorno = 1){
    //                 $arrRespuesta = array('status' => true, 'msg' => 'Soporte eliminado');
    //             }else{
    //                 $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
    //             }
    //         }
    //         echo json_encode($arrRespuesta);
    //     }
    // }
    if ($option == "listExtras") {
        $arrRespuesta = array('status' => false, 'data' => "");
        $arrExtras = $objExtras->getExtras();
    
        if (!empty($arrExtras)) {
            for ($i = 0; $i < count($arrExtras); $i++) {
                $idExtras = $arrExtras[$i]->idExtras;
                $options = '<button type="button" class="btn  btn-outline-primary btn-sm" onclick="fntVerModificarExtra(' . $idExtras . ')"><i class="bi bi-pencil-square"></i></button>';
                $arrExtras[$i]->options = $options;
            }
    
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrExtras;
        }
        echo json_encode($arrRespuesta);
        die();
    }

    if ($option == "verExtra") {
        if ($_POST) {
            $idExtras = intval($_POST['idExtras']);
            $arrExtras = $objExtras->getExtra($idExtras);
            if (empty($arrExtras)) {
                $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrExtras);
            }
            echo json_encode($arrRespuesta);
        }
    
        die();
    }
    
    if ($option == "modPrecio") {
        if ($_POST) {
            if (empty($_POST['numModalExtra'])) {
    
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $intIdExt= trim($_POST['txtModIdE']);
                $intPrecio= trim($_POST['numModalExtra']);
    
                $arrExtras = $objExtras->updatePrecio($intIdExt, $intPrecio);
                if ($arrExtras > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar precio');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();
    }
