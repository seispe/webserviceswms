<?php
 require "../config/ConexionSQL.php";
 class  Conteo{
    public function _construct(){
    }


    public function getccParcial($op, $id, $producto){
        $msg="";
        $empresa="GPIAV";
        $documento="";
        $tipo="";
        $cantidad=0;
        $descripcion="";
        $observacion="";
        $origen="";
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

 }
?>