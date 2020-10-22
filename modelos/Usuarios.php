<?php

 require "../config/ConexionSQL.php";

Class Usuarios
 {
  public function _construct(){
  }

  public function login($usuario,$clave){

    $login ="SELECT * FROM GA_WMS_TUsuario WHERE usuario='$usuario' AND clave='$clave' AND id_empresa=1";
    $resp= ejecutarConsultaSQL($login);
    $regLogin = $resp->fetch(PDO::FETCH_ASSOC);
    
   
    if(!empty($regLogin)){
        

        return $regLogin;
        // $sql="SELECT * from GA_WMS_TUsuariosConectados with(nolock) WHERE usuario='$usuario' AND empresa=1";
        // $resp= ejecutarConsultaSQL($sql);
        // $regUusarioConec = $resp->fetch(PDO::FETCH_ASSOC);
       
        // if(!empty($regUusarioConec)){
        //     $sqlInsert="INSERT INTO GA_WMS_TUsuariosConectados (usuario,empresa,fconexion) VALUES ('$usuario',1,GETDATE())";
        //     return ejecutarConsultaSQL($sqlInsert)? $regLogin : false;
        // }else{
        //     $sqlUpdate="UPDATE GA_WMS_TUsuariosConectados SET fconexion=GETDATE() WHERE usuario='$usuario'";
        //     return ejecutarConsultaSQL($sqlUpdate)? $regLogin : false;
        // }
    }else{
       
        return false;
    }

  }

  //#############VALIDAR-COORDENADA--##############################

    public function validarCoordenada($coordenada){
        $sql="exec [GA_WMS_PCoorPedvalida] '$coordenada', '', '0', '0'";
        return ejecutarConsultaSQL($sql);
    }

    //###############--VALIDAR PRODUCTOS---###########################

    public function validarProducto($codigo){

        $msg="";
        $und="";
        $query=ejecutarProcedureSQL("exec  GA_WMS_PGetCodigoAlterno ?,'GPIAV',0,?,?");
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->bindParam(3, $und, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        if (strlen($msg) > 0 && strlen($und) > 0) {
            $result = array("producto"=>$msg,"unidad"=>$und);
            return $result;
        }else {
            return false;
        }
    }

    public function inforArtiCoor($codigo,$coordenada){
        $sql="exec  GA_WMS_PGetAsignadoUbicacion '$coordenada','$codigo','GPIAV'";
        return ejecutarConsultaSQL($sql);
    }

    public function movimientos($coorInicio,$coorFin,$cantidad,$producto,$usuario,$tipo){
        $msg="";
        $query=ejecutarProcedureSQL("exec GA_WMS_PInsmovimiento ?,?,?,?,?,'GPIAV',?,'',?");
        $query->bindParam(1, $coorInicio);
        $query->bindParam(2, $coorFin);
        $query->bindParam(3, $cantidad);
        $query->bindParam(4, $producto);
        $query->bindParam(5, $usuario);
        $query->bindParam(6, $tipo);
        $query->bindParam(7, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
        $query->execute();
        if (strlen($msg) > 0 ) {
            $result = array("producto"=>$msg);
            return $result;
        }else {
            return false;
        }

    }

    public function busquedaProd($producto){
        $sql="EXEC [GA_WMS_PDatoproducto] '$producto' ";
        return ejecutarConsultaSQL($sql);
    }

    //###############--CLAVE DEL SISTEMA---###########################

    public function getClaveEmpresa(){
        $clave ="SELECT clave_sistema FROM GA_WMS_TEmpresa WHERE empresa='IAV'";
        return ejecutarConsultaSQL($clave);
    }
 }
?>