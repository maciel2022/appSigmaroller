<?php 
    require_once "../libraries/conexion.php";
    class ComprobanteModel {
        private $conexion;
        function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conect();
        }   

        public function guardarDebito($idCliente, $descripcion, $valorDebito, $fecha, $tipo) {
            // Confirmar si existe la cuenta corriente, y sino existe crearla:
            $query = "SELECT * FROM cuentaCorriente WHERE idCliente = '{$idCliente}'";
            $sql = $this->conexion->query($query);
            if ($sql->num_rows > 0){
                $resp =$sql->fetch_assoc();
                $idCuentaCorriente = $resp['id'];
                $saldo = $resp['saldo'];
                $nuevoSaldo = $saldo + $valorDebito;

                // Ahora guardamos el comprobante
                $query1 = "INSERT INTO comprobante (idCuentaCorriente, fecha, descripcion, valor, tipoComprobante, saldoComprobante)
                           VALUES ('{$idCuentaCorriente}', '{$fecha}', '{$descripcion}', '{$valorDebito}', '{$tipo}', '{$nuevoSaldo}')";               
                if($this->conexion->query($query1) === TRUE){
                    //Actualizamos el saldo
                    $setSaldo = $this->conexion->query("UPDATE cuentaCorriente SET saldo = '{$nuevoSaldo}' WHERE idCliente = '{$idCliente}'");
                    return 1;
                }else{
                    return 0;
                }
            }else{
                //Vamos a crear una nueva Cuenta Corriente
                $nuevoSaldo = $valorDebito;
                $query2 = "INSERT INTO cuentaCorriente (idCliente, saldo) VALUES ('{$idCliente}', '{$nuevoSaldo}')";
                if ($this->conexion->query($query2) === TRUE) {
                    //Obtenemos el nuevo id de la cuenta corriente
                    $idCuentaCorriente = mysqli_insert_id($this->conexion);
                    // Ahora guardamos el comprobante
                    $query3 = "INSERT INTO comprobante (idCuentaCorriente, fecha, descripcion, valor, tipoComprobante, saldoComprobante)
                    VALUES ('{$idCuentaCorriente}', '{$fecha}', '{$descripcion}', '{$valorDebito}', '{$tipo}', '{$nuevoSaldo}')";               
                    if($this->conexion->query($query3) === TRUE){
                        return 1;
                    }else{
                        return 0;
                    }
                }

            }
        }

        public function guardarDebitoAuto($idCliente, $idPedido, $descripcion, $valorDebito, $fecha, $tipo) {
            // Confirmar si existe la cuenta corriente, y sino existe crearla:
            $query = "SELECT * FROM cuentaCorriente WHERE idCliente = '{$idCliente}'";
            $sql = $this->conexion->query($query);
            if ($sql->num_rows > 0){
                $resp =$sql->fetch_assoc();
                $idCuentaCorriente = $resp['id'];
                $saldo = $resp['saldo'];
                $nuevoSaldo = $saldo + $valorDebito;

                // Ahora guardamos el comprobante
                $query1 = "INSERT INTO comprobante (idCuentaCorriente, idPedido, fecha, descripcion, valor, tipoComprobante, saldoComprobante)
                           VALUES ('{$idCuentaCorriente}', '{$idPedido}', '{$fecha}', '{$descripcion}', '{$valorDebito}', '{$tipo}', '{$nuevoSaldo}')";               
                if($this->conexion->query($query1) === TRUE){
                    //Actualizamos el saldo
                    $setSaldo = $this->conexion->query("UPDATE cuentaCorriente SET saldo = '{$nuevoSaldo}' WHERE idCliente = '{$idCliente}'");
                    return 1;
                }else{
                    return 0;
                }
            }else{
                //Vamos a crear una nueva Cuenta Corriente
                $nuevoSaldo = $valorDebito;
                $query2 = "INSERT INTO cuentaCorriente (idCliente, saldo) VALUES ('{$idCliente}', '{$nuevoSaldo}')";
                if ($this->conexion->query($query2) === TRUE) {
                    //Obtenemos el nuevo id de la cuenta corriente
                    $idCuentaCorriente = mysqli_insert_id($this->conexion);
                    // Ahora guardamos el comprobante
                    $query3 = "INSERT INTO comprobante (idCuentaCorriente, idPedido, fecha, descripcion, valor, tipoComprobante, saldoComprobante)
                    VALUES ('{$idCuentaCorriente}', '{$idPedido}', '{$fecha}', '{$descripcion}', '{$valorDebito}', '{$tipo}', '{$nuevoSaldo}')";               
                    if($this->conexion->query($query3) === TRUE){
                        return 1;
                    }else{
                        return 0;
                    }
                }

            }
        }

        public function guardarCredito($idCliente, $descripcion, $valorCredito, $fecha, $tipo) {
            // Confirmar si existe la cuenta corriente, y sino existe crearla:
            $query = "SELECT * FROM cuentaCorriente WHERE idCliente = '{$idCliente}'";
            $sql = $this->conexion->query($query);
            if ($sql->num_rows > 0){
                $resp =$sql->fetch_assoc();
                $idCuentaCorriente = $resp['id'];
                $saldo = $resp['saldo'];
                $nuevoSaldo = $saldo - $valorCredito;

                // Ahora guardamos el comprobante
                $query1 = "INSERT INTO comprobante (idCuentaCorriente, fecha, descripcion, valor, tipoComprobante, saldoComprobante)
                           VALUES ('{$idCuentaCorriente}', '{$fecha}', '{$descripcion}', '{$valorCredito}', '{$tipo}', '{$nuevoSaldo}')";               
                if($this->conexion->query($query1) === TRUE){
                    //Actualizamos el saldo
                    $setSaldo = $this->conexion->query("UPDATE cuentaCorriente SET saldo = '{$nuevoSaldo}' WHERE idCliente = '{$idCliente}'");
                    return 1;
                }else{
                    return 0;
                }
            // var_dump($idCliente, $descripcion, $valorCredito, $fecha, $tipo);
            // exit;
            }else{
                //Vamos a crear una nueva Cuenta Corriente
                $nuevoSaldo = $valorCredito * (-1);
                $query2 = "INSERT INTO cuentaCorriente (idCliente, saldo) VALUES ('{$idCliente}', '{$nuevoSaldo}')";
                if ($this->conexion->query($query2) === TRUE) {
                    //Obtenemos el nuevo id de la cuenta corriente
                    $idCuentaCorriente = mysqli_insert_id($this->conexion);
                    // Ahora guardamos el comprobante
                    $query3 = "INSERT INTO comprobante (idCuentaCorriente, fecha, descripcion, valor, tipoComprobante, saldoComprobante)
                    VALUES ('{$idCuentaCorriente}', '{$fecha}', '{$descripcion}', '{$valorCredito}', '{$tipo}', '{$nuevoSaldo}')";               
                    if($this->conexion->query($query3) === TRUE){
                        return 1;
                    }else{
                        return 0;
                    }
                }

            }
        }

        public function listaComprobantes($idCliente){
            $query = "SELECT id FROM cuentaCorriente WHERE idCliente = '{$idCliente}'";
            $sql = $this->conexion->query($query);
            if ($sql->num_rows > 0){
                $resp =$sql->fetch_assoc();
                $idCuentaCorriente = $resp['id'];
            }
            $arrComprobantes = array();
            $query1 = "SELECT c.*, p.estadoPedido FROM comprobante c
                       LEFT JOIN pedido p ON p.idPedido = c.idPedido 
                       WHERE c.idCuentaCorriente = '{$idCuentaCorriente}'
                       ORDER BY c.fecha DESC";
            $sql1 = $this->conexion->query($query1);
            
            while($obj = $sql1->fetch_object()){
                array_push($arrComprobantes, $obj);
            }
            
            return $arrComprobantes;

        }

        public function listaComproFecha($idCliente, $desde, $hasta){
            $query = "SELECT id FROM cuentaCorriente WHERE idCliente = '{$idCliente}'";
            $sql = $this->conexion->query($query);
            if ($sql->num_rows > 0){
                $resp =$sql->fetch_assoc();
                $idCuentaCorriente = $resp['id'];
            }
            $arrComprobantes = array();
            $query1 = "SELECT c.*, p.estadoPedido FROM comprobante c
                       LEFT JOIN pedido p ON p.idPedido = c.idPedido 
                       WHERE c.idCuentaCorriente = '{$idCuentaCorriente}'
                       AND DATE(c.fecha) BETWEEN '{$desde}' AND '{$hasta}'
                       ORDER BY c.fecha DESC";
            $sql1 = $this->conexion->query($query1);
            
            while($obj = $sql1->fetch_object()){
                array_push($arrComprobantes, $obj);
            }
            
            return $arrComprobantes;

        }

        public function cuentaCorriente($idCliente){
            $query = "SELECT * FROM cuentaCorriente WHERE idCliente = '{$idCliente}'";
            $sql = $this->conexion->query($query);
            if ($sql->num_rows > 0){
                $resp =$sql->fetch_assoc();
                $idCuentaCorriente = $resp['id'];
                $saldo = $resp['saldo'];
            }
            
            $query1 = "SELECT * FROM comprobante WHERE idCuentaCorriente = '{$idCuentaCorriente}' ORDER BY fecha DESC LIMIT 1";
            $sql1 = $this->conexion->query($query1);
            $arrComprobantes = $sql1->fetch_object();
            $arrComprobantes->saldo = $saldo;
            $arrCuentaCorriente = (array)$arrComprobantes;
            return $arrCuentaCorriente;

        }


    }