<?php
 require "../config/ConexionSQL.php";
 class  Conteo{
    public function _construct(){
    }


    public function getccMatriz($op, $documento){
        $msg="";
        $empresa="GPIAV";
        $tipo="";
        $cantidad=0;
        $codigo="";
        $descripcion="";
        $observacion="";
        $origen="";
        $id=0;
        $usuario="";
        $usuarioa="";

        $query=ejecutarProcedureSQL("exec GA_WMS_PInsConteoCiclico ?,?,?,?,?,?,?,?,?,?,?,?,?");
        $query->bindParam(1, $op);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $documento);
        $query->bindParam(4, $cantidad);
        $query->bindParam(5, $codigo);
        $query->bindParam(6, $descripcion);
        $query->bindParam(7, $observacion);
        $query->bindParam(8, $origen);
        $query->bindParam(9, $empresa);
        $query->bindParam(10, $id);
        $query->bindParam(11, $usuario);
        $query->bindParam(12, $usuarioa);
        $query->bindParam(13, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        //$result = $query->fetch(PDO::FETCH_ASSOC);
        return $query;
    }

 }
?>