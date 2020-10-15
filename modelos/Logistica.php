<?php
require "../config/ConexionSQL.php";
class Logistica{
    public function __construct(){

    }
    public function getPedido($pedido){
        $sql = "exec GA_WMS_PGetpedido '$pedido'";
        return ejecutarConsultaSQL($sql);
    }

    public function insLogistica($pedido, $usuario){
        $sql = "exec GA_WMS_PreciboLogistica '$pedido','$usuario','GPIAV'";
        return ejecutarConsultaSQL($sql);
    }

    public function cargaCamion($pedido, $camion, $transportista, $usuario){
        $sql = "exec GA_WMS_Pcargacamion '$pedido','$camion','$transportista','$usuario','GPIAV'";
        return ejecutarConsultaSQL($sql);
    }

    public function getTrans($pedido, $opcion){
        $sql = "exec GA_WMS_PGetTrans '$pedido','$opcion'";
        return ejecutarConsultaSQL($sql);
    }

    
}
?>