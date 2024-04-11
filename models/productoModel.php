<?php 
    require_once "../libraries/conexion.php";
    class ProductoModel {
        private $conexion;
        function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conect();
        }

        public function listProducto(){
            $arrProductos = array();
            $query = "SELECT * FROM producto";
            $rs = $this->conexion->query($query);

            while ($obj = $rs->fetch_object()) {
                array_push($arrProductos, $obj);
            }
            return $arrProductos;
        }
    

        public function guardarCR($nombre, $selTela, $selColor, $ancho, $alto, $selCadena, $selComando, $selCaida, $selMR, 
        $selSoporte, $selMotor, $termofusion, $mecCol, $contrapeso, $selDuplica, $cantidad, $observaciones, $valor, $zocalo, $idPedido, $idCR, $idCRItem){
            // echo "<pre>";
            // var_dump($ancho);
            // echo "</pre>";
            // exit;
            if ($idCR == 0) {
                $query = "INSERT INTO cortinaRoller (nombre, tela, color, comando, cadena, caida, ancho, alto, valor, zocalo, termofusion, mecanismoColor, 
                    contrapesoCadena, observaciones, idMecanismoRoller, idSoporte, idMotorCR, duplica, cantidad) 
                    VALUES ('{$nombre}', '{$selTela}', '{$selColor}', '{$selComando}', '{$selCadena}', '{$selCaida}', '{$ancho}', '{$alto}', '{$valor}', '{$zocalo}',
                    '{$termofusion}', '{$mecCol}', '{$contrapeso}', '{$observaciones}', '{$selMR}', '{$selSoporte}', 
                    '{$selMotor}', '{$selDuplica}', '{$cantidad}') ";
                if ($this->conexion->query($query) === TRUE) {
                    $idCR = mysqli_insert_id($this->conexion);
                    // ahora debe guardarse el item
                    $valorTotal = ($valor * $cantidad);
                    $query1 = "INSERT INTO item (cantidad, valorUnitario, valorTotal, idPedido, idCortinaRoller) VALUES ('{$cantidad}', '{$valor}', '{$valorTotal}', '{$idPedido}', '{$idCR}')";
                    if ($this->conexion->query($query1) === TRUE) {
                        return 1;
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
            }else{
                $query = "UPDATE cortinaRoller SET nombre = '{$nombre}', tela = '{$selTela}', color = '{$selColor}', comando = '{$selComando}', cadena ='{$selCadena}', caida = '{$selCaida}', ancho = '{$ancho}', alto = '{$alto}', valor = '{$valor}',
                 zocalo = '{$zocalo}' , termofusion = '{$termofusion}', mecanismoColor = '{$mecCol}', contrapesoCadena = '{$contrapeso}', observaciones = '{$observaciones}', idMecanismoRoller ='{$selMR}', idSoporte = '{$selSoporte}', 
                idMotorCR = '{$selMotor}', duplica = '{$selDuplica}', cantidad = '{$cantidad}'WHERE idCortinaRoller = '{$idCR}'";
                if($this->conexion->query($query)===TRUE){
                    $valorTotal = ($valor * $cantidad);
                    $query1 = "UPDATE item SET cantidad = '{$cantidad}', valorUnitario = '{$valor}', valorTotal = '{$valorTotal}' WHERE idItem = '{$idCRItem}'";
                    if ($this->conexion->query($query1) === TRUE) {
                        return 2;
                    } else {
                        return 0;
                    }
                }else{
                    return 0;
                }
            }
        } 
    

    public function guardarCBV($nombre, $selTela1, $selColor1, $anchoCBV, $altoCBV, $selComandoCBV, $selMecCBV, $selMenCBV, $selMotCBV, 
    $selAperCBV, $intValorCBV, $selDupCBV, $intCantCBV, $txtObsCBV, $idPedidoBV, $idCBV, $idCBVItem){
        // var_dump($intAltoCBV);
        // exit;
        if ($idCBV == 0) {
            $query = "INSERT INTO cortinaBandaVertical (nombre, tela, color, comando, ancho, alto, valor, 
                    observacion,  idMecanismoBandaVertical, mensulas, idMotorBandaVertical,idApertura, duplica, cantidad) 
                    VALUES ('{$nombre}', '{$selTela1}', '{$selColor1}', '{$selComandoCBV}', '{$anchoCBV}', '{$altoCBV}', '{$intValorCBV}',
                    '{$txtObsCBV}', '{$selMecCBV}', '{$selMenCBV}', '{$selMotCBV}', '{$selAperCBV}', '{$selDupCBV}', '{$intCantCBV}') ";
            if($this->conexion->query($query)===TRUE){
                $idBV = mysqli_insert_id($this->conexion);
                // ahora debe guardarse el item
                $valorTotal = ($intValorCBV * $intCantCBV);
                $query1 = "INSERT INTO item (cantidad, valorUnitario, valorTotal, idPedido, idCortinaBandaVertical) VALUES ('{$intCantCBV}', '{$intValorCBV}', '{$valorTotal}', '{$idPedidoBV}', '{$idBV}')";
                if($this->conexion->query($query1)===TRUE){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            $query = "UPDATE cortinaBandaVertical SET nombre = '{$nombre}', tela = '{$selTela1}', color = '{$selColor1}', comando = '{$selComandoCBV}', ancho = '{$anchoCBV}', alto = '{$altoCBV}', valor = '{$intValorCBV}', 
            observacion = '{$txtObsCBV}',  idMecanismoBandaVertical = '{$selMecCBV}', mensulas = '{$selMenCBV}', idMotorBandaVertical = '{$selMotCBV}', idApertura = '{$selAperCBV}', duplica = '{$selDupCBV}', cantidad = '{$intCantCBV}'
            WHERE idCortinaBandaVertical = '{$idCBV}'";
                if($this->conexion->query($query)===TRUE){
                    $valorTotal = ($intValorCBV * $intCantCBV);
                    $query1 = "UPDATE item SET cantidad = '{$intCantCBV}', valorUnitario = '{$intValorCBV}', valorTotal = '{$valorTotal}' WHERE idItem = '{$idCBVItem}'";
                    if ($this->conexion->query($query1) === TRUE) {
                        return 2;
                    } else {
                        return 0;
                    }
                }else{
                    return 0;
                }
        }
    }

  public function guardarCC($nombre, $selTela2, $selColor2, $intAnchoCC, $intAltoCC, $intValorCC, $txtObsCC, $idPedidoCC, $idCC, $idCCItem){
    if ($idCC == 0) {
        $query = "INSERT INTO CortinaConfeccion (nombre, tela, color, ancho, alto, valor, observacion) VALUES ('{$nombre}', '{$selTela2}', '{$selColor2}', '{$intAnchoCC}', '{$intAltoCC}', '{$intValorCC}', '{$txtObsCC}') ";
        if($this->conexion->query($query)===TRUE){
            $idCC = mysqli_insert_id($this->conexion);
                $query1 = "INSERT INTO item (valorUnitario, valorTotal, idPedido, idCortinaConfeccion) VALUES ('{$intValorCC}', '{$intValorCC}','{$idPedidoCC}', '{$idCC}')";
                if($this->conexion->query($query1)===TRUE){
                    return 1;
                }else{
                    return 0;
                }     
            }else{
                 return 0;
           }
    }else{
        $query = "UPDATE CortinaConfeccion SET nombre = '{$nombre}', tela = '{$selTela2}', color = '{$selColor2}', ancho = '{$intAnchoCC}', alto = '{$intAltoCC}', valor = '{$intValorCC}', observacion = '{$txtObsCC}' WHERE idCortinaConfeccion = '{$idCC}'";
            if($this->conexion->query($query)===TRUE){
                $query1 = "UPDATE item SET  valorUnitario = '{$intValorCC}', valorTotal = '{$intValorCC}' WHERE idItem = '{$idCCItem}'";
                if ($this->conexion->query($query1) === TRUE) {
                    return 2;
                } else {
                    return 0;
                }
            }else{
                return 0;
            }
        }

    }

    
    
    
    
    public function guardarItemPro($idPro, $idPed, $cantidad, $valorUni, $valorTotal){
        $query = "INSERT INTO item (valorUnitario, valorTotal, idPedido, idProducto, cantidadProducto) VALUES ('{$valorUni}', '{$valorTotal}', '{$idPed}', '{$idPro}', '{$cantidad}')";
        if($this->conexion->query($query)===TRUE){
            return 1;
        }else{
            return 0;
       }
    }



  ///////////////////// FUNCIONES DE LISTAR ITEMS/////////////////////
  public function traerItems($idPed)
  {
      $arrItems = array();
      $query = "SELECT * FROM item  WHERE idPedido = '{$idPed}'";
      $rs = $this->conexion->query($query);
      while ($obj = $rs->fetch_object()) {
        array_push($arrItems, $obj);
      }
        // echo "<pre>"; 
        // var_dump($arrItems);
        // echo "</pre>";
        // exit;
          
      
      return $arrItems;
  }

  public function getProducto($id){
    $query = "SELECT * FROM producto  WHERE idProducto = '{$id}'";
    $rs = $this->conexion->query($query);
    $obj = $rs->fetch_object();
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
    return $obj;
  }

  public function getItemCR($id){
    $query = "SELECT c.*, mr.tipoMecanismoRollr, mr.largo, sr.tipoSoporte, cr.tipoMotorCR FROM cortinaRoller c 
    INNER JOIN mecanismoRoller mr ON c.idMecanismoRoller = mr.idMecanismoRoller
    INNER JOIN soporteCR sr ON c.idSoporte = sr.idSoporte
    INNER JOIN motorCR cr ON c.idMotorCR = cr.idMotorCR
    WHERE idCortinaRoller = '{$id}'";
    $rs = $this->conexion->query($query);
    $obj = $rs->fetch_object();
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
    return $obj;
  }

//   public function getItemBV($id){
//     $query = "SELECT * FROM cortinaBandaVertical  WHERE idCortinaBandaVertical = '{$id}'";
//     $rs = $this->conexion->query($query);
//     $obj = $rs->fetch_object();
//     // echo "<pre>"; 
//     // var_dump($obj);
//     // echo "</pre>";
//     // exit;
//     return $obj;
//   }

    public function getItemBV($id){
    $query = "SELECT b.*, mb.nomMecBanVer, mob.nombreMotorBV, a.tipoApertura FROM cortinaBandaVertical b
    INNER JOIN mecanismoBandaVertical mb ON  b.idMecanismoBandaVertical = mb.idMecanismoBandaVertical
    INNER JOIN motorBandaVertical mob ON b.idMotorBandaVertical = mob.idMotorBandaVertical
    INNER JOIN apertura a ON b.idApertura = a.idApertura
     WHERE idCortinaBandaVertical = '{$id}'";
    $rs = $this->conexion->query($query);
    $obj = $rs->fetch_object();
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
    return $obj;
  }

  public function getItemCC($id){
    $query = "SELECT * FROM CortinaConfeccion WHERE idCortinaConfeccion = '{$id}'";
    $rs = $this->conexion->query($query);
    $obj = $rs->fetch_object();
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
    return $obj;
  }

  ///////////////////// FUNCIONES DE MODIFICAR  /////////////////////
    public function getCR($id){
        $query = "SELECT * FROM cortinaRoller WHERE idCortinaRoller = '{$id}'";
        $rs = $this->conexion->query($query);
        $obj = $rs->fetch_object(); 
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
        return $obj;

    }

    public function getCBV($id){
        $query = "SELECT * FROM cortinaBandaVertical WHERE idCortinaBandaVertical = '{$id}'";
        $rs = $this->conexion->query($query);
        $obj = $rs->fetch_object(); 
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
        return $obj;

    }

    public function getCC($id){
        $query = "SELECT * FROM CortinaConfeccion WHERE idCortinaConfeccion = '{$id}'";
        $rs = $this->conexion->query($query);
        $obj = $rs->fetch_object(); 
    // echo "<pre>"; 
    // var_dump($obj);
    // echo "</pre>";
    // exit;
        return $obj;

    }

    public function delItem($id){
        if($this->conexion->query("DELETE FROM item WHERE idItem = '{$id}'")===TRUE){
            return 1;
        }else{
            return 0;
        }
    }   

    public function getTela($id){
        $query = "SELECT nombre FROM tela WHERE idTela = '{$id}'";
        $rs = $this->conexion->query($query);
        $res = $rs->fetch_assoc(); 
        return $res;
    }

    public function getColor($id){
        $query = "SELECT nombreColor FROM color WHERE idColor = '{$id}'";
        $rs = $this->conexion->query($query);
        $res = $rs->fetch_assoc(); 
        return $res;
    }

    public function datosPedido($id){
        $query = "SELECT p.*, c.nombreCliente FROM pedido p
                INNER JOIN cliente c ON p.idClientes = c.idCliente
                WHERE idPedido = '{$id}'";
        $rs = $this->conexion->query($query);
        $res = $rs->fetch_assoc(); 
        return $res;
    }

}


?>