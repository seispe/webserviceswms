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
        if (strlen($msg)>0) {
            return $msg;
        }else{
            return false;
        }
        
    }

    public function insConteoCilico($bodega, $op,$tipo, $id, $producto, $origen, $cantidad, $usuario){
        $msg="";
        $empresa="GPIAV";
        $documento="";
        $descripcion="";
        $observacion="";
        $usuarioa="";
        if ($bodega == "MATRIZ") {
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
            if (strlen($msg)>0) {
                return $msg;
            }else{
                return false;
            }
        }else{
            $query=ejecutarProcedureSQL("exec GA_WMS_PInsConteoCiclicoCuarentena ?,?,?,?,?,?,?,?,?,?,?,?,?");
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
            if (strlen($msg)>0) {
                return $msg;
            }else{
                return false;
            }
        }
    }

    public function getcierreTConteo($id, $producto){
        $msg="";
        $empresa="GPIAV";
        $usuario = "";
        $coordenada = "";
        $reconteo = 0;
        $op = "2";

        $query=ejecutarProcedureSQL("exec GA_CC_PCierreConteoCiclico ?,?,?,?,?,?,?,?");
        $query->bindParam(1, $usuario);
        $query->bindParam(2, $coordenada);
        $query->bindParam(3, $id);
        $query->bindParam(4, $reconteo);
        $query->bindParam(5, $producto);
        $query->bindParam(6, $empresa);
        $query->bindParam(7, $op);
        $query->bindParam(8, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getcierreConteo($id){
        $msg="";
        $empresa="GPIAV";
        $usuario = "";
        $coordenada = "";
        $reconteo = 0;
        $op = "1";
        $producto = "";
        $query=ejecutarProcedureSQL("exec GA_CC_PCierreConteoCiclico ?,?,?,?,?,?,?,?");
        $query->bindParam(1, $usuario);
        $query->bindParam(2, $coordenada);
        $query->bindParam(3, $id);
        $query->bindParam(4, $reconteo);
        $query->bindParam(5, $producto);
        $query->bindParam(6, $empresa);
        $query->bindParam(7, $op);
        $query->bindParam(8, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        if (strlen($msg)>0) {
            return $msg;
        }else{
            return false;
        }
    }

    

 }
?>