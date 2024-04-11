<?php 
    require_once "../libraries/conexion.php";
    class ClasificacionModel {
        private $conexion;
        function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conect();
        }   
        ///////////////////// FUNCIONES DE AGRUPAMIENTOS /////////////////////
        public function getAgrupamientos() {
            $arrAgrupamientos = array();
            $query = "SELECT * FROM agrupamientos";
            $rs = $this->conexion->query($query);

            while($obj = $rs->fetch_object()){
                array_push($arrAgrupamientos, $obj);
            }
          
            return $arrAgrupamientos;
        }

        public function insertAgrupamiento(string $nombre, string $diaFranco){
            // Consulta para verificar si el nombre ya existe en la tabla
            $verificarNombre = "SELECT * FROM agrupamientos WHERE nombreAgrupamiento = '{$nombre}'";
            $resultado = $this->conexion->query($verificarNombre);
            if ($resultado->num_rows > 0){
                return 0;
            }else{            
                $query = "INSERT INTO agrupamientos(nombreAgrupamiento, francoPredeterminado) VALUES('{$nombre}', '{$diaFranco}')";
                if($this->conexion->query($query)===TRUE){
                    return 1;
                }else{
                    return 0;
                }
            }       
        }

        public function getAgrupamiento(int $idAgrupamientos){
            $query = "SELECT * FROM agrupamientos WHERE idAgrupamientos = '{$idAgrupamientos}'";
            $sql = $this->conexion->query($query);
            $sql = $sql->fetch_object();
            return $sql;
        }

        public function updateAgrupamiento(int $idAgrupamientos, string $nombreAgrupamiento, string $diaFranco){
            // Consulta para verificar si el nombre ya existe en la tabla
            $verificarNombre = "SELECT * FROM agrupamientos WHERE nombreAgrupamiento = '{$nombreAgrupamiento}' AND francoPredeterminado = '{$diaFranco}'";
            $resultado = $this->conexion->query($verificarNombre);
            if ($resultado->num_rows > 0){
                return 0;
            }else{            
                $query = "UPDATE agrupamientos SET nombreAgrupamiento = '{$nombreAgrupamiento}', francoPredeterminado = '{$diaFranco}' WHERE idAgrupamientos = '{$idAgrupamientos}'";
                if($this->conexion->query($query)===TRUE){
                    return 1;
                }else{
                    return 0;
                }
            } 
        }

        public function delAgrupamiento(int $idAgr){
            if($this->conexion->query("DELETE FROM agrupamientos WHERE idAgrupamientos = '{$idAgr}'")===TRUE){
                return 1;
            }else{
                return 0;
            }
        }



        ////// FUNCIONES DE AREAS ///////////////////
        public function getAreas() {
            $arrAreas = array();
            $query = "SELECT * FROM producto";
            $rs = $this->conexion->query($query);

            while($obj = $rs->fetch_object()){
                array_push($arrAreas, $obj);
            }
            
            return $arrAreas;
        }

        public function insertArea(string $nombre, $precio, int $codigo, string $observaciones){
            // Consulta para verificar si el nombre ya existe en la tabla
            $verificarNombre = "SELECT * FROM producto WHERE nombre = '{$nombre}'";
            $resultado = $this->conexion->query($verificarNombre);
            if ($resultado->num_rows > 0){
                return 0;
            }else{            
                $query = "INSERT INTO producto(nombre, precio, codArticulo, observaciones) VALUES('{$nombre}', '{$precio}', '{$codigo}', '{$observaciones}')";
                if($this->conexion->query($query)===TRUE){
                    return 1;
                }else{
                    return 0;
                }
            }       
        }

        public function getArea(int $idAreas){
            $query = "SELECT * FROM producto WHERE idProducto = '{$idAreas}'";
            $sql = $this->conexion->query($query);
            $sql = $sql->fetch_object();
            return $sql;
        }


        public function updateArea(int $idAreas, string $nombreArea, $precio, int $codigo, string $observaciones){
            // Consulta para verificar si el nombre ya existe en la tabla
                 
                $query = "UPDATE producto SET nombre = '{$nombreArea}', precio = '{$precio}', codArticulo = '{$codigo}', observaciones = '{$observaciones}' WHERE idProducto = '{$idAreas}'";
                if($this->conexion->query($query)===TRUE){
                    return 1;
                }else{
                    return 0;
                }
             
        }

        public function delArea(int $idAre){
            if($this->conexion->query("DELETE FROM producto WHERE idProducto = '{$idAre}'")===TRUE){
                return 1;
            }else{
                return 0;
            }
        }
    }
?> 