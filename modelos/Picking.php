<?php

 require "../config/ConexionSQL.php";

Class Picking
 {
  public function _construct(){
  }


  //#############CONSOLIDADIOS-##############################

    public function consolidados($usuario){
        $sql="exec GA_WMS_PgetConsolidadoUsuario_app '$usuario'";
        return ejecutarConsultaSQL($sql);
    }

    public function obtenerProductosConsolidado($consolidado,$usuario){
        $msg="";
        $query=ejecutarProcedureSQL("exec GA_WMS_PGetRutaPicking '$consolidado','GPIAV','00','$usuario',?");
        $query->bindParam(1, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        return $query;
    }

    public function cantidadPicking($consolidado,$producto,$usuario,$origen){
        $sql="exec GA_WMS_PgetProdxConsolidado $consolidado,'$producto','8','$usuario','00','$origen'  ";
        return ejecutarConsultaSQL($sql);
    }

    public function cantidadPickingPendiente($consolidado,$producto,$usuario,$origen){
        $sql="exec GA_WMS_PgetProdxConsolidado $consolidado,'$producto','7','$usuario','00','$origen'  ";
        return ejecutarConsultaSQL($sql);
    }

    public function validarCoordenadaPicking($coordenada){
        $sql="exec [GA_WMS_PCoorPedvalida] '$coordenada', '', 'PICKDESTINO', '1'";
        return ejecutarConsultaSQL($sql);
    }

    public function validarCantidad($consolidado,$producto,$cantidad){
        $msg="";
        $query=ejecutarProcedureSQL("exec GA_WMS_PValidarPick 0,'$consolidado','$producto', '$cantidad' ,?");
        $query->bindParam(1, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        if (strlen($msg) > 0 ) {
            return $msg;
        }else {
            return false;
        }
    }

    public function guardarPicking($consolidado,$producto,$origen,$solicitada,$procesada,$pendiente,$destino,$usuario){
        $solicitada=number_format($solicitada, 2, '.', '');
        $procesada=number_format($procesada, 2, '.', '');
        $pendiente=number_format($pendiente, 2, '.', '');
       
        $msg="";
        $query=ejecutarProcedureSQL("exec [GA_WMS_PInspickingconsolidado] '$consolidado', '$producto', '$origen', '$solicitada', '$procesada', '$pendiente', '$destino', '$usuario','GPIAV','' ,? ");
        $query->bindParam(1, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        if (strlen($msg) > 0 ) {
            return $msg;
        }else {
            return false;
        }
    }

    public function product_consolidados($consolidado,$usuario){
        $sql="GA_WMS_PgetProdxConsolidado '$consolidado','','1','$usuario','' ";
        return ejecutarConsultaSQL($sql);
    }

    
 }
?>