<?php
 require "../config/ConexionSQL.php";
 class  Conteo{
    public function _construct(){
    }


    public function getccParcial($op, $id, $producto, $origen){
        $msg="";
        $empresa="GPIAV";
        $documento="";
        $tipo="";
        $cantidad=0;
        $descripcion="";
        $observacion="";
        $usuario="";
        $usuarioa="";

        $query=ejecutarProcedureSQL("exec GA_WMS_PInsConteoCiclico ?,?,?,?,?,?,?,?,?,?,?,?,?");
        $query->bindParam(1, $op);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $documento);
        $query->bindParam(4, $cantidad);
        $query->bindParam(5, $producto);
        $query->bindParam(6, $descripcion);
        $query->bindParam(7, $observacion);
        $query->bindParam(8, $origen);
        $query->bindParam(9, $empresa);
        $query->bindParam(10, $id);
        $query->bindParam(11, $usuario);
        $query->bindParam(12, $usuarioa);
        $query->bindParam(13, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        return $msg;
        
    }

    public function getConteosCiclicos($documento,$tipo,$producto, $op){
        $sql = "exec GA_WMS_PgetConteosCiclico '$documento','$tipo','$producto','$op'";
        return ejecutarConsultaSQL($sql);
    }

    public function validarCoordenadaConteo($coordenada, $tipo){
        $sql="exec [GA_WMS_PCoorPedvalida] '$coordenada', '', '$tipo', '1'";
        return ejecutarConsultaSQL($sql);
    }

    public function activaSuma($op, $id, $producto, $origen, $activo){
        $msg="";
        $empresa="GPIAV";
        $documento="";
        $tipo="";
        $descripcion="";
        $observacion="";
        $usuario="";
        $usuarioa="";

        $query=ejecutarProcedureSQL("exec GA_WMS_PInsConteoCiclico ?,?,?,?,?,?,?,?,?,?,?,?,?");
        $query->bindParam(1, $op);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $documento);
        $query->bindParam(4, $activo);
        $query->bindParam(5, $producto);
        $query->bindParam(6, $descripcion);
        $query->bindParam(7, $observacion);
        $query->bindParam(8, $origen);
        $query->bindParam(9, $empresa);
        $query->bindParam(10, $id);
        $query->bindParam(11, $usuario);
        $query->bindParam(12, $usuarioa);
        $query->bindParam(13, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        return $msg;
        
    }

    public function insConteoCilico($bodega, $op,$tipo, $id, $producto, $origen, $cantidad, $usuario){
        $msg="";
        $empresa="GPIAV";
        $documento="";
        $descripcion="";
        $observacion="";
        $usuarioa="";
        if ($bodega == "MATRIZ") {
            $procedure = "GA_WMS_PInsConteoCiclico";
        }else{
            $procedure = "GA_WMS_PInsConteoCiclicoCuarentena";
        }

        $query=ejecutarProcedureSQL("exec '$procedure' ?,?,?,?,?,?,?,?,?,?,?,?,?");
        $query->bindParam(1, $op);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $documento);
        $query->bindParam(4, $cantidad);
        $query->bindParam(5, $producto);
        $query->bindParam(6, $descripcion);
        $query->bindParam(7, $observacion);
        $query->bindParam(8, $origen);
        $query->bindParam(9, $empresa);
        $query->bindParam(10, $id);
        $query->bindParam(11, $usuario);
        $query->bindParam(12, $usuarioa);
        $query->bindParam(13, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        return $msg;
        
    }

    

 }
?>