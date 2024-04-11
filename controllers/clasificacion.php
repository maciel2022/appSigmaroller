<?php 
    require_once "../models/clasificacionModel.php"; 

    $option = $_REQUEST['op'];
    $objArea = new ClasificacionModel();
   
    
    
    ///// OPCIONES DE AREAS ///////
    if($option == "listaAreas"){
        $arrRespuesta = array('status' => false, 'data' => "");
        $arrArea = $objArea->getAreas(); 
        if(!empty($arrArea)){
            for($i=0; $i < count($arrArea); $i++){
                $idAreas = $arrArea[$i]->idProducto;
                $options = '<button class="btn ms-2 btn-outline-primary btn-sm" onclick="fntVerModificarArea('.$idAreas.')"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn ms-2 btn-outline-danger btn-sm" title="Eliminar registro" onclick="fntEliminarArea('.$idAreas.')" ><i class="bi bi-trash"></i></button>'; 
                $arrArea[$i]->options = $options;
            }
            $arrRespuesta['status'] = true;
            $arrRespuesta['data'] = $arrArea;
        }
        echo json_encode($arrRespuesta);
        die();
    }

    if($option == "guardarArea"){
        if($_POST){
        if((empty($_POST['txtNombreArea']))) {
            $arrRespuesta = array('status' => false, 'msg' => 'Error de datos'); 
        }else{
            $strNombre = ucwords(trim($_POST['txtNombreArea']));              
            $intPrecio = (trim($_POST['numPrecio']));              
            $intCodigo = (trim($_POST['numArticulo']));              
            $strObservaciones = ucwords(trim($_POST['txtObservaciones']));              
            $valorRetorno = $objArea->insertArea($strNombre, $intPrecio, $intCodigo, $strObservaciones );
                if($valorRetorno > 0){
                $arrRespuesta = array('status' => true, 'msg' => 'Datos guardados correctamente');
            }else{
                $arrRespuesta = array('status' => false, 'msg' => 'Error al guardar o el area ya existe'); 
            }
        }
        echo json_encode($arrRespuesta);
        }
        die();
    }

    if ($option == "verArea") {
        if ($_POST) {
            $idAreas = intval($_POST['idProducto']);
            $arrArea = $objArea->getArea($idAreas);
            if (empty($arrArea)) {
                $arrRespuesta = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrRespuesta = array('status' => true, 'msg' => 'Datos encontrados', 'data' => $arrArea);
            }
            echo json_encode($arrRespuesta);
        }
    
        die();
    }

    if($option == "modificarArea"){
        if ($_POST) {
            if (empty($_POST['txtModalIdAreas']) || empty($_POST['txtModalNombreAreas'])) {
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $intId = intval($_POST['txtModalIdAreas']);
                $strNombre = ucwords($_POST['txtModalNombreAreas']);
                $intPrecio = trim($_POST['numModalModificarPrecio']);
                $intCodigo = trim($_POST['numModalModificarCodigo']);
                $strObservaciones = ucwords(trim($_POST['txtModalModificarObservaciones']));
              
                $valorRetorno = $objArea->updateArea($intId, $strNombre, $intPrecio, $intCodigo, $strObservaciones);
                if ($valorRetorno > 0) {
                    $arrRespuesta = array('status' => true, 'msg' => 'Datos modificados correctamente');
                } else {
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al modificar o Area ya existe');
                }
            }
            echo json_encode($arrRespuesta);
        }
        die();
    }
    if($option == "eliminarArea"){
        
        if($_POST){
            if(empty($_POST['idProducto'])){
                $arrRespuesta = array('status' => false, 'msg' => 'Error de datos');
            }else{
                $idArea = intval($_POST['idProducto']);
                $valorRetorno = $objArea->delArea($idArea);
                
                if($valorRetorno = 1){
                    $arrRespuesta = array('status' => true, 'msg' => 'Producto eliminado');
                }else{
                    $arrRespuesta = array('status' => false, 'msg' => 'Error al eliminar');
                }
            }
            echo json_encode($arrRespuesta);
        }
    }
?>