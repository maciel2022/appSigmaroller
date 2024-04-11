<?php
require_once "../models/legajoModel.php";

$option = $_REQUEST['op'];
$objLegajo = new LegajoModel();
$objResp = new LegajoModel();

if ($option == "listregistros") {
    $arrRespuesta = array('status' => false, 'data' => "");
    $arrLegajo = $objLegajo->getLegajos();
    if (!empty($arrLegajo)) {
        
        for ($i = 0; $i < count($arrLegajo); $i++) {

            $idLegajos = $arrLegajo[$i]->idCliente;
            $estadoActual = $arrLegajo[$i]->estadoActual;
              
            //Determino el color del boton segun estado
            if($estadoActual == 'Al Dia'){
                $estadoActual = '<button class="btn btn-success btn-sm" title="Estado" onclick="fntCambioEstado()"><i class="bi bi-check-circle"></i> Al Día</button>';
            }else if($estadoActual == 'Suspendido'){
                $estadoActual = '<button class="btn btn-danger btn-sm" title="Estado" onclick="fntCambioEstado()"><i class="bi bi-x-circle"></i> Suspendido</button>';
            }else{
                $estadoActual = '<button class="btn btn-warning btn-sm" title="Estado" onclick="fntCambioEstado()"><i class="bi bi-x-circle"></i> Moroso</button>';
            };

            $options = '<a href="' . $baseUrl . '/views/legajos/modificar.php?p=' . $idLegajos . '"  class="btn me-1 btn-outline-primary btn-sm" title="Modificar Cliente"><i class="bi bi-pencil-square"></i></a>
                        <a href="' . $baseUrl . '/views/legajos/ver-legajo.php?p=' . $idLegajos . '"  class="btn me-1 btn-outline-warning btn-sm" title="Ver Cliente"><i class="bi bi-eye"></i></a>
                        <button class="btn  btn-outline-danger btn-sm " title="Eliminar Cliente" onclick="fntEliminarCliente('.$idLegajos.')" ><i class="bi bi-trash"></i></button>';
    
            $arrLegajo[$i]->estadoActual = $estadoActual;
            $arrLegajo[$i]->options = $options;
        }
        $arrRespuesta['status'] = true;
        $arrRespuesta['data'] = $arrLegajo;
    }
    echo json_encode($arrRespuesta);
    die();
}

if ($option == "guardar") {

    if ($_POST) {
        if (empty ($_POST)) {
                
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');

        } else {
            $intNumCuit = trim($_POST['numCuil']);
            $strNombreCliente = ucwords(trim($_POST['txtNombre']));
            $strRazonSocial = ucwords(trim($_POST['txtApellido']));
            $strEmail = ucwords($_POST['emailEmail']);
            $intNroTel = trim($_POST['numTelefono']);
            $strDomicilio = ucwords($_POST['txtDomicilio']);
            $strDomEntrega = ucwords($_POST['txtLocalidad']);
            $strLocalidadEntrega = ucwords($_POST['txtLocalidadEntrega']);
            $strEstado = ucwords($_POST['selEstado']);
            $strUsuario = ucwords($_POST['txtUsuario']);
            $strContraseña = ($_POST['contraseña']);
            $contraHash = password_hash($strContraseña, PASSWORD_BCRYPT);

            $strTipoUsuario = 'cliente';
            $strNotFact = ucwords($_POST['txtAreaObservaciones']);

            $arrLegajo = $objLegajo->insertLegajo($intNumCuit, $strNombreCliente, $strRazonSocial, $strEmail, $intNroTel, $strDomicilio,
             $strDomEntrega, $strLocalidadEntrega, $strEstado, $strUsuario, $contraHash, $strTipoUsuario, $strNotFact);
            
            if ($arrLegajo == 1) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            } else if ($arrLegajo == 2){
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o un Cliente ya se registro con ese CUIT');
            }else{
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o el Usuario ya existe');
            }
        }

        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "verlegajo") {
    if ($_POST) {
        $idCliente = intval($_POST['idCliente']);
        $arrLegajo = $objLegajo->getLegajo($idCliente);
        $idUsuario = $arrLegajo->idUsuarios;
        $resp = $objResp->getUsuario($idUsuario);
        $nombreUsuario = $resp['usuario'];
        // var_dump($resp);
        // exit;

        if (empty($arrLegajo)) {
            $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrLegajo->usuario = $nombreUsuario;
            $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrLegajo);
        }
        echo json_encode($arrRespuesta);
    }

    die();
}

if ($option == "modificar") {
    // var_dump($_POST);
    // exit;
    if ($_POST) {
        if (empty($_POST)){
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intId = intval($_POST['txtId']);
            $intNumCuit = trim($_POST['numCuil']);
            $strNombreCliente = ucwords(trim($_POST['txtNombre']));
            $strRazonSocial = ucwords(trim($_POST['txtApellido']));
            $strEmail = ucwords($_POST['emailEmail']);
            $intNroTel = intval($_POST['numTelefono']);
            $strDomicilio = ucwords($_POST['txtDomicilio']);
            $strDomEntrega = ucwords($_POST['txtLocalidad']);
            $strLocalidadEntrega = ucwords($_POST['txtLocalidadEntrega']);
            $strEstado = ucwords($_POST['selEstado']);
            $strNotFact = ucwords($_POST['txtAreaObservaciones']);
            if(($_POST['contraseña'])!= ''){
                $contraseña = $_POST['contraseña'];
                $usuario = ucwords($_POST['txtUsuario']);           
                $contraHash = password_hash($contraseña, PASSWORD_BCRYPT);
                $resp = $objResp->modContra($usuario, $contraHash);
            }

            $arrLegajo = $objLegajo->updateLegajo($intId, $intNumCuit, $strNombreCliente, $strRazonSocial, $strEmail, $intNroTel,$strDomicilio, $strDomEntrega , $strLocalidadEntrega, $strEstado, $strNotFact);

            if ($arrLegajo > 0 ) {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
            } else {
                $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o CUIT ya existe');
            }
        }
        echo json_encode($arrRespuesta);
    }
    die();
}

if ($option == "eliminar") {
    // var_dump($_POST);
    // exit;
    if (empty($_POST)) {
        $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
    } else {
        $idCliente = intval($_POST['idCliente']);
        
        $resp = $objLegajo->delLegajo($idCliente);
        
        if ($resp > 0) {
            $arrRespuesta = array('status' => true, 'msg' => 'Cliente eliminado.');
        } else {
            $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar el Cliente.');
        }
        echo json_encode($arrRespuesta);
    }
}

// if ($option == "obtenerFranco") {

//     if ($_POST) {
//         if (empty($_POST['nombreAgrupamiento'])) {
//             $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
//         } else {
//             $strAgrupamiento =  trim($_POST['nombreAgrupamiento']);
//             $arrAgrupamiento = $objLegajo->getAgrupamiento($strAgrupamiento);
//             if (empty($arrAgrupamiento)) {
//                 $arrRespuesta = array('status' => false, 'msg' => 'Error');
//             } else {
//                 $arrRespuesta = array('status' => true, 'msg' => 'Dia de Franco Predeterminado', 'data' => $arrAgrupamiento);
//             }
//         }
//         echo json_encode($arrRespuesta);
//     }
// }
    if ($option == "buscador") {
        if ($_POST) {
            // var_dump($_POST);
            // exit;
            
            if (empty($_POST['txtBuscador'])) {
                $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $strBuscar = trim($_POST['txtBuscador']);
                $arrRespuesta = array('status' => false, 'found' => 0, 'data' => '');

                $arrInfo = $objLegajo->getBusqueda($strBuscar);
                
                if(!empty($arrInfo)){
                    $arrRespuesta = array('status' => true, 'found' => count($arrInfo), 'data' => $arrInfo);
                }  
            }
            echo json_encode($arrRespuesta);
        }

        die();
    }

    if ($option == "modContra") {
        if ($_POST) {
            if (empty($_POST['idUsuario']) || empty($_POST['txtNuevaContra'])) {
                $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $intId = intval($_POST['idUsuario']);
                $strNewContra = ($_POST['txtNuevaContra']);
                $contraNewHash = password_hash($strNewContra, PASSWORD_BCRYPT);
    
                $respuesta = $objLegajo->updateContra($intId, $contraNewHash);
                // var_dump($respuesta);
                // exit;
    
                if ($respuesta > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Contraseña modificada correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar la contraseña');
                }
            }
            echo json_encode($arrRespuesta);
        }
    
        die();
    }

die();