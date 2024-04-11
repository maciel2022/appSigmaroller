<?php 
    require_once "../libraries/conexion.php";
    class LegajoModel {
        private $conexion;
        function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conect();
        }   

        public function getLegajos() {
            $arrLegajos = array();
            $rs = $this->conexion->query("CALL verClientes()");

            while($obj = $rs->fetch_object()){
                array_push($arrLegajos, $obj);
            }
          
            return $arrLegajos;
        }

        public function insertLegajo($cuit, $nombreCliente,  $razonSocial ,$email, $telefono,
                                     $domicilio, $domicilioEntrega,$localidad, $estadoActual, $usuario, $contraHash, $tipoUsuario,  $notasFacturacion){
            $verificarUsuario = "SELECT * FROM usuarios WHERE usuario = '{$usuario}'";
            $resultado = $this->conexion->query($verificarUsuario);
            if($resultado->num_rows > 0) {
                return 0;
            }else{                                
                // Verificar que el cliente no existe con nombre y cuit
                $verificarCliente = "SELECT * FROM cliente WHERE nombreCliente = '{$nombreCliente}'";
                $resultado = $this->conexion->query($verificarCliente);
                if ($resultado->num_rows > 0) {
                    return 2;
                } else {
                    $query = "INSERT INTO usuarios (usuario, contraseña, tipoUsuario) VALUES ('{$usuario}', '{$contraHash}','{$tipoUsuario}')";
                    $sql1 = $this->conexion->query($query);
                    if ($sql1) {
                        $idUsuario = $this->conexion->insert_id;

                        // $query2 =  "CALL nuevoCliente('{$cuit}', '{$nombreCliente}', '{$razonSocial}','{$email}', '{$cupoCtaCorriente}', '{$telefono}', '{$domicilio}', '{$domicilioEntrega}', '{$localidad}','{$estadoActual}',
                        // '{$notasFacturacion}', '{$idUsuario}')"; 
                        $query2 = "	INSERT INTO cliente(cuit, nombreCliente, razonSocial, email, telefono, domicilio, domicilioEntrega, localidad, estadoActual, notasFacturacion, idUsuarios)
                                        VALUES ('{$cuit}', '{$nombreCliente}', '{$razonSocial}','{$email}', '{$telefono}', '{$domicilio}', '{$domicilioEntrega}', '{$localidad}', '{$estadoActual}',
                                        '{$notasFacturacion}', '{$idUsuario}')";
                        if ($this->conexion->query($query2) === TRUE) {
                            return 1;
                        } else {
                            return 2;
                        }
                    } else {
                        return 0;
                    }
                }
            }   
       }

        public function getLegajo($idCliente){
            $sql = $this->conexion->query("CALL verCliente('{$idCliente}')");
            $sql = $sql->fetch_object();
            return $sql;
        }

        public function updateLegajo($idCli, $cui, $nomCli, $razSoc,  $ema, $nroTel, $domi, $domEnt, $locali,$estad, $notFact){
             // Verificar que el cuit no se repita con el de otro cliente
             $verificarCliente = "SELECT idCliente FROM cliente WHERE cuit = '{$cui}'";
             $resultado = $this->conexion->query($verificarCliente);
             if($resultado->num_rows > 0){
                $resultado = $resultado->fetch_assoc();
                $idCliente = intval($resultado['idCliente']);
             }else{
                $query = "UPDATE cliente SET cuit = '{$cui}', nombreCliente = '{$nomCli}', razonSocial = '{$razSoc}', email = '{$ema}', telefono = '{$nroTel}', domicilio ='{$domi}', domicilioEntrega = '{$domEnt}', localidad = '{$locali}', estadoActual = '{$estad}', notasFacturacion = '{$notFact}'
                          WHERE idCliente = '{$idCli}'";

                if ($this->conexion->query($query) === TRUE) {
                    return 1;
                }else{
                    return 0;
                }
             }
             
             if(intval($idCliente) == $idCli){
                $query = "UPDATE cliente SET nombreCliente = '{$nomCli}', razonSocial = '{$razSoc}', email = '{$ema}', telefono = '{$nroTel}', domicilio ='{$domi}', domicilioEntrega = '{$domEnt}', localidad = '{$locali}', estadoActual = '{$estad}', notasFacturacion = '{$notFact}'
                          WHERE idCliente = '{$idCli}'";

                if ($this->conexion->query($query) === TRUE) {
                    return 1;
                }else{
                    return 0;
                }
             }else{
                return 0;
             }
            // $sql = $this->conexion->query("CALL modificarCliente('{$idCli}', '{$cui}', '{$nomCli}', '{$razSoc}', '{$ema}','{$cupCtaCor}','{$nroTel}','{$domi}','{$domEnt}','{$locali}','{$estad}','{$notFact}')");
            // $sql = $sql->fetch_object();
            // return $sql;
        }

        public function delLegajo($id){
            $query = "UPDATE cliente SET estado = 1 WHERE idCliente = '{$id}'";
            if($this->conexion->query($query) === TRUE){
                return 1;
            }else{
                return 0;
            }
            
        }

        public function getAgrupamiento(string $nombreAgrupamiento){
            $query = "SELECT francoPredeterminado FROM agrupamientos WHERE nombreAgrupamiento = '{$nombreAgrupamiento}'";
            $sql = $this->conexion->query($query);
            $sql = $sql->fetch_object();
            return $sql;
        }

        public function getBusqueda($busqueda){
            $arrBusqueda = array();
            $query = "SELECT c.*, r.saldo FROM cliente c LEFT JOIN cuentaCorriente r ON c.idCliente = r.idCliente
                      WHERE c.nombreCliente LIKE CONCAT ('%', '{$busqueda}', '%') 
                      OR  c.idCliente LIKE CONCAT ('%', '{$busqueda}', '%')
                      OR c.razonSocial LIKE CONCAT ('%', '{$busqueda}', '%')";
            $rs = $this->conexion->query($query);

            while($obj = $rs->fetch_object()){
                array_push($arrBusqueda, $obj);
            }
          
            return $arrBusqueda;
        }
        
        public function updateContra($id, $newContra)
        {
            $query = "UPDATE usuarios SET contraseña = '{$newContra}' WHERE idUsuarios = '{$id}'";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }

        public function getUsuario($id)
        {
            $query = "SELECT usuario FROM usuarios WHERE idUsuarios = '{$id}'";
            $rs = $this->conexion->query($query);
            $resp = $rs->fetch_assoc();
            return $resp;
            
        }

        public function modcontra($usuario, $contraHash)
        {
            $query = "UPDATE usuarios SET contraseña = '{$contraHash}' WHERE usuario = '{$usuario}'";
            if ($this->conexion->query($query) === TRUE) {
                return 1;
            } else {
                return 0;
            }
        }
        
    }
