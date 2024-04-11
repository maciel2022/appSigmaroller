<?php
require_once "../libraries/conexion.php";
class ConfiguracionGlobalModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }


    ///////////////////// FUNCIONES DE  TELAS /////////////////////
    public function getTelas()
    {
        $arrTelas = array();
        $query = "SELECT * FROM tela";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrTelas, $obj);
        }

        return $arrTelas;
    }



    public function insertTela(string $nombre, int $precio,  $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM tela WHERE nombre = '{$nombre}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO tela (nombre, precio, estado) VALUES('{$nombre}', '{$precio}','{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    public function getTela(int $idTela)
    {
        $query = "SELECT * FROM tela WHERE idTela = '{$idTela}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateTelas(int $idTela, string $nombre, int $precio, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE tela SET nombre = '{$nombre}', precio = '{$precio}' , estado = '{$estado}' WHERE idTela = '{$idTela}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
    // public function delTela(int $idTela){
    //     if($this->conexion->query("DELETE FROM tela WHERE idTela = '{$idTela}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }


    ///////////////////// FUNCIONES DE COLORES /////////////////////
    public function getColores(){
        $arrColores = array();
        $query = "SELECT color.idColor, color.nombreColor, color.idTela, color.activo, tela.nombre FROM color INNER JOIN tela ON color.idTela = tela.idTela";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrColores, $obj);
        }
        //print_r($arrColores);
        return $arrColores;
    }

    public function obtenerColores($idTela)
    {
        $arrCol = array();
        $query = "SELECT * FROM color WHERE idTela = '{$idTela}'";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            //var_dump($obj);
            //exit;
            array_push($arrCol, $obj);
        }
        //print_r($arrColores);
        return $arrCol;
    }




    public function insertColor(string $nombre, int $idTela,  $activo)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM color WHERE nombreColor = '{$nombre}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO color (nombreColor, idTela, activo) VALUES('{$nombre}', '{$idTela}','{$activo}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    public function getColor(int $idColor)
    {
        $query = "SELECT * FROM color WHERE idColor = '{$idColor}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateColores(int $idColor, string $nombre, int $idTela,  $activo)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE color SET nombreColor = '{$nombre}', idTela = '{$idTela}' , activo = '{$activo}' WHERE idColor = '{$idColor}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public function delColor(int $idCol){
        if($this->conexion->query("DELETE FROM color WHERE idColor = '{$idCol}'")===TRUE){
            return 1;
        }else{
            return 0;
        }
    }

    ///////////////////// FUNCIONES DE LIST MECANISMO BV/////////////////////
    public function getMecanismoBV()
    {
        $arrMecanismoBV = array();
        $query = "SELECT * FROM mecanismoBandaVertical";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrMecanismoBV, $obj);
        }

        return $arrMecanismoBV;
    }

    public function insertMecanismoBV(string $nombreMecanismoBV, string $estado, int $precioBV)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM mecanismoBandaVertical WHERE nomMecBanVer = '{$nombreMecanismoBV}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO mecanismoBandaVertical (nomMecBanVer,estado, precioBV) VALUES('{$nombreMecanismoBV}','{$estado}', '{$precioBV}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getMecanismosBV(int $idMecanismoBandaVertical)
    {
        $query = "SELECT * FROM mecanismoBandaVertical WHERE idMecanismoBandaVertical = '{$idMecanismoBandaVertical}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateMecanismoBV(int $idMecanismoBV, string $nombreMecanismoBV, string $estado, int $precioBV)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE mecanismoBandaVertical SET nomMecBanVer = '{$nombreMecanismoBV}',  estado = '{$estado}', precioBV = '{$precioBV}' WHERE idMecanismoBandaVertical = '{$idMecanismoBV}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    // public function delMBV(int $idMBV){
    //     if($this->conexion->query("DELETE FROM mecanismoBandaVertical WHERE idMecanismoBandaVertical = '{$idMBV}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }

    public function getApertura()
    {
        $arrApertura = array();
        $query = "SELECT * FROM apertura";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrApertura, $obj);
        }

        return $arrApertura;
    }

    public function insertApertura(string $nombreA, int $precioA, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM apertura WHERE tipoApertura = '{$nombreA}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO apertura (tipoApertura, precioA, estado) VALUES('{$nombreA}', '{$precioA}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getAper(int $idApertura)
    {
        $query = "SELECT * FROM apertura WHERE idApertura = '{$idApertura}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateApertura(int $idAper, string $nombreA, int $precioA, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE apertura SET tipoApertura = '{$nombreA}', precioA = '{$precioA}', estado = '{$estado}' WHERE idApertura = '{$idAper}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
    // public function delAper(int $idAper){
    //     if($this->conexion->query("DELETE FROM apertura WHERE idApertura = '{$idAper}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }

    /////////////////////FIN FUNCIONES DE LIST MECANISMO BV/////////////////////

    public function getMotorMBV()
    {
        $arrMotorBV = array();
        $query = "SELECT * FROM motorBandaVertical";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrMotorBV, $obj);
        }

        return $arrMotorBV;
    }
    public function insertMotorBV(string $nombreMotorBV, int $precioMBV, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM motorBandaVertical WHERE nombreMotorBV = '{$nombreMotorBV}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO motorBandaVertical (nombreMotorBV, precioMBV, estado) VALUES('{$nombreMotorBV}', '{$precioMBV}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }




    public function getMotorBV(int $idMotorBandaVertical)
    {
        $query = "SELECT * FROM motorBandaVertical WHERE idMotorBandaVertical = '{$idMotorBandaVertical}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateMotorBV(int $idMotorBV, string $nombreMotorBV, int $precioMotorBV, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE motorBandaVertical SET nombreMotorBV = '{$nombreMotorBV}', precioMBV = '{$precioMotorBV}', estado = '{$estado}' WHERE idMotorBandaVertical = '{$idMotorBV}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    // public function delMotBV(int $idMBV){
    //     if($this->conexion->query("DELETE FROM mecanismoBandaVertical WHERE idMecanismoBandaVertical = '{$idMBV}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }

    ///////////////////// FUNCIONES DE  MECANISMOS CORTINAS CONFECCION    /////////////////////
    public function getMecanismoCC()
    {
        $arrMCC = array();
        $query = "SELECT * FROM mecanismoConfeccion";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrMCC, $obj);
        }

        return $arrMCC;
    }

    public function insertMCC(string $nombreMCC, int $precioMCC, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM mecanismoConfeccion WHERE nombreMecanismoConfeccion = '{$nombreMCC}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO mecanismoConfeccion (nombreMecanismoConfeccion, precioMCC, estado) VALUES('{$nombreMCC}', '{$precioMCC}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getMCC(int $idMecanismoConfeccion)
    {
        $query = "SELECT * FROM mecanismoConfeccion WHERE idMecanismoConfeccion = '{$idMecanismoConfeccion}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateMCC(int $idMCC, string $nombreMCC, $precioMCC, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE mecanismoConfeccion SET nombreMecanismoConfeccion = '{$nombreMCC}', precioMCC= '{$precioMCC}', estado= '{$estado}' WHERE idMecanismoConfeccion = '{$idMCC}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
    // public function delMecCC(int $idMecCC){
    //     if($this->conexion->query("DELETE FROM mecanismoConfeccion WHERE idMecanismoConfeccion = '{$idMecCC}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }
    ///////////////////// FUNCIONES DE  MOTOR CORTINAS CONFECCION    /////////////////////
    public function getMotCC()
    {
        $arrMotCC = array();
        $query = "SELECT * FROM motorConfeccion";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrMotCC, $obj);
        }

        return $arrMotCC;
    }


    public function insertMotCC(string $nombreMotCC, int $precioMotCC, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM motorConfeccion WHERE nomMotCC = '{$nombreMotCC}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO motorConfeccion (nomMotCC, precioMotCC, estado) VALUES('{$nombreMotCC}', '{$precioMotCC}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getMotorCC($idMotorConfeccion)
    {
        $query = "SELECT * FROM motorConfeccion WHERE idMotorConfeccion = '{$idMotorConfeccion}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateMotCC($idMotCC,  $nombreMotCC, $precioMotCC, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE motorConfeccion SET nomMotCC = '{$nombreMotCC}', precioMotCC= '{$precioMotCC}', estado= '{$estado}' WHERE idMotorConfeccion = '{$idMotCC}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    // public function delMotCC(int $idMotorCC){
    //     if($this->conexion->query("DELETE FROM motorConfeccion WHERE idMotorConfeccion = '{$idMotorCC}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }


    

    ///////////////////// FUNCIONES DE  CORTINAS ROLLER   /////////////////////
    public function getMecR()
    {
        $arrMecR = array();
        $query = "SELECT * FROM mecanismoRoller";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrMecR, $obj);
        }

        return $arrMecR;
    }

    public function insertMecR( $nombreMecR, $largoMecR, $precioMecR, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM mecanismoRoller WHERE tipoMecanismoRollr = '{$nombreMecR}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO mecanismoRoller (tipoMecanismoRollr, largo, precioMR, estado) VALUES('{$nombreMecR}','{$largoMecR}', '{$precioMecR}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }


    public function getMecRol($idMecanismoRoller)
    {
        $query = "SELECT * FROM mecanismoRoller WHERE idMecanismoRoller = '{$idMecanismoRoller}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateMecR($idMecR,  $nombreMecR, $largoMecR, $precioMecR, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE mecanismoRoller SET tipoMecanismoRollr = '{$nombreMecR}', largo = '{$largoMecR}',  precioMR = '{$precioMecR}', estado = '{$estado}' WHERE idMecanismoRoller = '{$idMecR}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    // public function delMCR(int $idMCR){
    //     if($this->conexion->query("DELETE FROM mecanismoRoller WHERE idMecanismoRoller = '{$idMCR}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }



    ///////////////////// FUNCIONES DE  CORTINAS MOTOR ROLLER   /////////////////////
    public function getMotR()
    {
        $arrMotR = array();
        $query = "SELECT * FROM motorCR";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrMotR, $obj);
        }

        return $arrMotR;
    }
    public function insertMotR( $nombreMotR,  $precioMotR, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM motorCR WHERE tipoMotorCR = '{$nombreMotR}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO motorCR (tipoMotorCR, precioMCR, estado) VALUES('{$nombreMotR}', '{$precioMotR}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getMotCR($idMotR)
    {
        $query = "SELECT * FROM motorCR WHERE idMotorCR = '{$idMotR}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateMotR($idMotR,  $nombreMotR, $precioMotR, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE motorCR SET tipoMotorCR = '{$nombreMotR}', precioMCR= '{$precioMotR}', estado = '{$estado}' WHERE idMotorCR = '{$idMotR}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    // public function delMoCR(int $idMoCR){
    //     if($this->conexion->query("DELETE FROM motorCR WHERE idMotorCR = '{$idMoCR}'")===TRUE){
    //         return 1;
    //     }else{
    //         return 0;
    //     }
    // }


    ///////////////////// FUNCIONES DE  ZOCALO ROLLER   /////////////////////

    // public function getZ()
    // {
    //     $arrZ = array();
    //     $query = "SELECT * FROM zocaloCR";
    //     $rs = $this->conexion->query($query);

    //     while ($obj = $rs->fetch_object()) {
    //         array_push($arrZ, $obj);
    //     }

    //     return $arrZ;
    // }


    // public function insertZoc( $nombreZ, $precioZ)
    // {
    //     // Consulta para verificar si el nombre ya existe en la tabla
    //     $verificarNombre = "SELECT * FROM zocaloCR WHERE tipoZocalo = '{$nombreZ}'";
    //     $resultado = $this->conexion->query($verificarNombre);
    //     if ($resultado->num_rows > 0) {
    //         return 0;
    //     } else {
    //         $query = "INSERT INTO zocaloCR (tipoZocalo, precioZ) VALUES('{$nombreZ}', '{$precioZ}')";
    //         if ($this->conexion->query($query) === TRUE) {
    //             return 1;
    //         } else {
    //             return 0;
    //         }
    //     }
    // }
    // public function getZoc($idZoc)
    // {
    //     $query = "SELECT * FROM zocaloCR WHERE idZocalo = '{$idZoc}'";
    //     $sql = $this->conexion->query($query);
    //     $sql = $sql->fetch_object();
    //     return $sql;
    // }

    // public function updateZoc($idZoc,  $nombreZoc, $precioZoc)
    // {
    //     // Consulta para verificar si el nombre ya existe en la tabla

    //     $query = "UPDATE zocaloCR SET tipoZocalo = '{$nombreZoc}',  precioZ = '{$precioZoc}' WHERE idZocalo = '{$idZoc}'";
    //     if ($this->conexion->query($query) === TRUE) {
    //         return 1;
    //     } else {
    //         return 0;
    //     }
    // }
///////////////////// FUNCIONES DE  SOPORTE ROLLER   /////////////////////

public function getS()
{
    $arrS = array();
    $query = "SELECT * FROM soporteCR";
    $rs = $this->conexion->query($query);

    while ($obj = $rs->fetch_object()) {
        array_push($arrS, $obj);
    }

    return $arrS;
}
public function insertSop( $nombreS, $precioS, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla
        $verificarNombre = "SELECT * FROM soporteCR WHERE tipoSoporte = '{$nombreS}'";
        $resultado = $this->conexion->query($verificarNombre);
        if ($resultado->num_rows > 0) {
            return 0;
        } else {
            $query = "INSERT INTO soporteCR (tipoSoporte, precioSCR, estado) VALUES('{$nombreS}', '{$precioS}', '{$estado}')";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    
    public function getSop($idSop)
    {
        $query = "SELECT * FROM soporteCR WHERE idSoporte = '{$idSop}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updateSop($idSop,  $nombreSop, $precioSop, $estado)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE soporteCR SET tipoSoporte = '{$nombreSop}',  precioSCR = '{$precioSop}',  estado = '{$estado}' WHERE idSoporte = '{$idSop}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }


//      public function delSop(int $idSoporteCR){
//     if($this->conexion->query("DELETE FROM SoporteCR WHERE idSoporte = '{$idSoporteCR}'")===TRUE){
//         return 1;
//     }else{
//         return 0;
//     }
// }

    ///////////////////// FUNCIONES DE  CORTINAS ROLLER EXTRAS  /////////////////////
    public function getExtras()
    {
        $arrExtras = array();
        $query = "SELECT * FROM extras";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrExtras, $obj);
        }

        return $arrExtras;
    }

    public function getExtra($idExt)
    {
        $query = "SELECT * FROM extras WHERE idExtras = '{$idExt}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        return $sql;
    }

    public function updatePrecio($idExt, $precio)
    {
        // Consulta para verificar si el nombre ya existe en la tabla

        $query = "UPDATE extras SET precio = '{$precio}' WHERE idExtras = '{$idExt}'";
        if ($this->conexion->query($query) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }


}

 