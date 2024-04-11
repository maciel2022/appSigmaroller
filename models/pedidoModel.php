<?php
require_once "../libraries/conexion.php";
class PedidoModel
{
    private $conexion;
    function __construct()
    {
        $this->conexion = new Conexion();
        $this->conexion = $this->conexion->conect();
    }

    public function getPedidos()
    {
        $arrPedidos = array();
        $rs = $this->conexion->query("CALL verPedidos()");

        while ($obj = $rs->fetch_object()) {
            array_push($arrPedidos, $obj);
        }

        return $arrPedidos;
    }

    public function getPedidosFecha($desde, $hasta)
    {
        $arrPedidos = array();
        $rs = $this->conexion->query("SELECT pedido.idPedido, pedido.nroPedido, pedido.fecha, pedido.valorTotal, pedido.estadoPedido, cliente.nombreCliente
        FROM pedido 
        INNER JOIN cliente ON pedido.idClientes = cliente.idCliente
        AND DATE(pedido.fecha) BETWEEN '{$desde}' AND '{$hasta}'
        ORDER BY pedido.fecha DESC");

        while ($obj = $rs->fetch_object()) {
            array_push($arrPedidos, $obj);
        }

        return $arrPedidos;
    }

    public function insertPedido($intIdCliente, $dateFecha, $valorTotal, $strEstado)
    {

        $pedidoAnterior = "SELECT idPedido FROM pedido ORDER BY nroPedido DESC LIMIT 1";
        $rsPedidoAnterior = $this->conexion->query($pedidoAnterior);
        $rs = $rsPedidoAnterior->fetch_assoc();
        $nroPedido = $rs['idPedido'] + 1;

        $query = "INSERT INTO pedido (idClientes, nroPedido, fecha, valorTotal, estadoPedido) VALUES ('{$intIdCliente}', '{$nroPedido}','{$dateFecha}', '{$valorTotal}', '{$strEstado}')";
        if ($this->conexion->query($query) === TRUE) {
            $id = mysqli_insert_id($this->conexion);
            return $id;
        } else {
            return 0;
        }
    }

    public function delPedido($id)
    {
        if ($this->conexion->query("DELETE FROM pedido WHERE idPedido =  '{$id}'") === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getBusqueda($busqueda)
    {
        $arrBusqueda = array();
        $query = "SELECT p.idPedido, p.valorTotal, p.estadoPedido, p.nroPedido, p.fecha, c.nombreCliente, c.idCliente FROM pedido p
                INNER JOIN cliente c ON p.idClientes = c.idCliente
                WHERE p.nroPedido LIKE CONCAT ('%', '{$busqueda}', '%') 
                OR p.fecha LIKE CONCAT ('%', '{$busqueda}', '%')
                OR c.nombreCliente LIKE CONCAT ('%', '{$busqueda}', '%')
                ORDER BY p.fecha DESC, p.nropedido DESc";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrBusqueda, $obj);
        }

        return $arrBusqueda;
    }

    public function cambiarCreado($id)
    {
        $query = "UPDATE pedido SET estadoPedido = 'En Proceso' WHERE idPedido = '{$id}'";
        $sql = $this->conexion->query($query);
        return $sql;
    }

    public function cambiarEnProceso($id)
    {
        $query = "UPDATE pedido SET estadoPedido = 'Finalizado' WHERE idPedido = '{$id}'";
        $sql = $this->conexion->query($query);
        return $sql;
    }

    public function cambiarFinalizado($id)
    {
        $query = "UPDATE pedido SET estadoPedido = 'Entregado' WHERE idPedido = '{$id}'";
        $sql = $this->conexion->query($query);
        return $sql;
    }

    public function existeItem($idPedido){
        $arrValores = array();
        $valorTotal = 0;
        $query = "SELECT valorTotal FROM item WHERE idPedido = '{$idPedido}'";
        $sql = $this->conexion->query($query);
        if ($sql->num_rows > 0){
            while ($obj = $sql->fetch_object()) {
                array_push($arrValores, $obj);
            }
        }
        for ($i = 0; $i < count($arrValores); $i++) {
            $valorItem = $arrValores[$i]->valorTotal;
            $valorItem = floatval($valorItem);

            $valorTotal += $valorItem;
        }
        return $valorTotal;
        
    }

    public function getPedidosCliente($id)
    {
       //Primero bscamos el idCliente con el idUsuario
        $query = "SELECT idCliente FROM cliente WHERE idUsuarios = '{$id}' LIMIT 1";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        $arrCliente = array();
        array_push($arrCliente, $sql);
        $idCliente = $arrCliente[0]->idCliente;

        //Ahora tenemos que buscar los pedidos asociados a este idCliente
        $arrPedidos = array();
        $query = "SELECT pedido.idPedido, pedido.nroPedido, pedido.fecha, pedido.valorTotal, pedido.estadoPedido, cliente.nombreCliente
        FROM pedido 
        INNER JOIN cliente ON pedido.idClientes = cliente.idCliente
        WHERE pedido.idClientes = '{$idCliente}'
        ORDER BY pedido.fecha DESC,  pedido.nropedido DESc";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrPedidos, $obj);
        }
        // echo "<pre>";
        // var_dump($arrPedidos);
        // echo "</pre>";
        // exit;
        return $arrPedidos;
    }

    public function getPedidosClienteFecha($id, $desde, $hasta)
    {
       //Primero bscamos el idCliente con el idUsuario
        $query = "SELECT idCliente FROM cliente WHERE idUsuarios = '{$id}' LIMIT 1";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_object();
        $arrCliente = array();
        array_push($arrCliente, $sql);
        $idCliente = $arrCliente[0]->idCliente;

        //Ahora tenemos que buscar los pedidos asociados a este idCliente
        $arrPedidos = array();
        $query = "SELECT pedido.idPedido, pedido.nroPedido, pedido.fecha, pedido.valorTotal, pedido.estadoPedido, cliente.nombreCliente
        FROM pedido 
        INNER JOIN cliente ON pedido.idClientes = cliente.idCliente
        WHERE pedido.idClientes = '{$idCliente}'
        AND DATE(pedido.fecha) BETWEEN '{$desde}' AND '{$hasta}'
        ORDER BY pedido.fecha DESC,  pedido.nropedido DESc";
        $rs = $this->conexion->query($query);

        while ($obj = $rs->fetch_object()) {
            array_push($arrPedidos, $obj);
        }
        // echo "<pre>";
        // var_dump($arrPedidos);
        // echo "</pre>";
        // exit;
        return $arrPedidos;
    }


    public function cambiarEstadoCliente($id)
    {
        $query = "UPDATE pedido SET estadoPedido = 'Creado' WHERE idPedido = '{$id}'";
        $sql = $this->conexion->query($query);
        return $sql;
    }

    public function getPedidoDebito($id)
    {
        $query = "SELECT idClientes FROM pedido WHERE idPedido = '{$id}'";
        $sql = $this->conexion->query($query);
        $sql = $sql->fetch_assoc();
        return $sql;
    }

    public function eliminarBorrador()
    {
        $query = "DELETE FROM pedido WHERE estadoPedido = 'Borrador'";
        if($this->conexion->query($query) === TRUE){
            return 1;
        }else{
            return 0;
        }
    }  
 }

    
