<?php
     require "../config/ConexionSQL.php";
     class  Armado{
        public function _construct(){
        }


        public function getImpresoras($usuario, $tipo){
            $sql = "exec GA_IMP_PgetImpresora 'GPIAV','$usuario','$tipo'";
            return ejecutarConsultaSQL($sql);

        }

        public function getInfoArmado($bulto){
            $msg="";
            $empresa="GPIAV";
            $query=ejecutarProcedureSQL("exec GA_IMP_PgetInfoArmado ?,?,?");
            $query->bindParam(1, $empresa);
            $query->bindParam(2, $bulto);
            $query->bindParam(3, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function colaImpresion($op, $bulto, $usuario, $tipo, $numero, $impresora, $estado, $activo, $modulo){
            $msg="";
            $empresa="GPIAV";
            $query=ejecutarProcedureSQL("exec GA_WMS_PCOLAIMPRESION ?,?,?,?,?,?,?,?,?,?,?");
            $query->bindParam(1, $op);
            $query->bindParam(2, $bulto);
            $query->bindParam(3, $usuario);
            $query->bindParam(4, $empresa);
            $query->bindParam(5, $tipo);
            $query->bindParam(6, $numero);
            $query->bindParam(7, $impresora);
            $query->bindParam(8, $estado);
            $query->bindParam(9, $activo);
            $query->bindParam(10, $modulo);
            $query->bindParam(11, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($msg) > 0 ) {
                return $msg;
            }else {
                return false;
            }
        }

        public function audImpresion($pedidos, $usuario, $modulo, $op, $obs){
            $msg="";
            $empresa="GPIAV";
            $query=ejecutarProcedureSQL("exec GA_WMS_PInsimpNE ?,?,?,?,?,?,?");
            $query->bindParam(1, $pedidos);
            $query->bindParam(2, $usuario);
            $query->bindParam(3, $modulo);
            $query->bindParam(4, $op);
            $query->bindParam(5, $empresa);
            $query->bindParam(6, $obs);
            $query->bindParam(7, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($msg) > 0 ) {
                return $msg;
            }else {
                return false;
            }
        }

        public function getPedidos($filtro, $area, $op){
            $sql = "exec GA_WMS_PPedEncProceso '$filtro','$area','$op'";
            return ejecutarConsultaSQL($sql);

        }

        public function validarCoordenadaArmado($coordenada,$tipo){
            $sql="exec [GA_WMS_PCoorPedvalida] '$coordenada', '', '$tipo', '1'";
            return ejecutarConsultaSQL($sql);
        }

        public function pedDetProceso($pedido,$producto,$op,$usuario,$area){
            $sql="exec GA_WMS_PPedDetProceso '$pedido', '$producto', '$op','$usuario', '$area'";
            return ejecutarConsultaSQL($sql);
        }

        public function getBultos($usuario,$op){
            $sql="exec GA_WMS_PGetBultos '$usuario', '', '','$op'";
            return ejecutarConsultaSQL($sql);
        }

        public function insBultos($estado,$usuario){

            $bulto="";
            $codbulto="";
            $query=ejecutarProcedureSQL("exec  GA_WMS_PInsbultoV2 ?,?,?,?");
            $query->bindParam(1, $estado);
            $query->bindParam(2, $usuario);
            $query->bindParam(3, $bulto, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->bindParam(4, $codbulto, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($bulto) > 0 && strlen($codbulto) > 0) {
                $result = array("bulto"=>$bulto,"codigo"=>$codbulto);
                return $result;
            }else {
                return false;
            }
        }

        public function validarVoid($codigo,$op){

            $msg="";
            $und="";
            $query=ejecutarProcedureSQL("exec  GA_WMS_PGetCodigoAlterno ?,'GPIAV',?,?,?");
            $query->bindParam(1, $codigo);
            $query->bindParam(2, $op);
            $query->bindParam(3, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->bindParam(4, $und, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($msg) > 0 ){
                return $msg;
            }else {
                return false;
            }
        }
    
        public function getDetArmado($codigo,$pedido,$area,$op){
            $sql="exec GA_WMS_PGetArmadoxProducto '$codigo', '$pedido', '$area','$op'";
            return ejecutarConsultaSQL($sql);
        }

        public function validaBulto($op,$idbulto,$pedido,$usuario){

            $msg="";
            $query=ejecutarProcedureSQL("exec  ga_wms_PValidaBulto ?,?,?,'GPIAV',?,?");
            $query->bindParam(1, $op);
            $query->bindParam(2, $idbulto);
            $query->bindParam(3, $pedido);
            $query->bindParam(4, $usuario);
            $query->bindParam(5, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($msg) > 0 ){
                return $msg;
            }else {
                return false;
            }
        }

        public function insArmado($pedido, $producto, $coor_origen, $coor_destino, $can_armada, $can_armar, $can_pend_armar, $codigo_void, $observacion, $usuario, $idbulto){

            $msg="";
            $query=ejecutarProcedureSQL("exec  GA_WMS_PInsarmado ?,?,?,?,?,?,?,?,?,?,'GPIAV',?,?");
            $query->bindParam(1, $pedido);
            $query->bindParam(2, $producto);
            $query->bindParam(3, $coor_origen);
            $query->bindParam(4, $coor_destino);
            $query->bindParam(5, $can_armada);
            $query->bindParam(6, $can_armar);
            $query->bindParam(7, $can_pend_armar);
            $query->bindParam(8, $codigo_void);
            $query->bindParam(9, $observacion);
            $query->bindParam(10, $usuario);
            $query->bindParam(11, $idbulto);
            $query->bindParam(12, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($msg) > 0 ){
                return $msg;
            }else {
                return false;
            }
        }

        public function cierreArmado($pedido, $area){
            $msg="";
            $query=ejecutarProcedureSQL("exec GA_WMS_PCierreArmado ?,?,?");
            $query->bindParam(1, $pedido);
            $query->bindParam(2, $area);
            $query->bindParam(3, $msg, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 50);
            $query->execute();
            if (strlen($msg) > 0 ) {
                return $msg;
            }else {
                return false;
            }
        }

        public function detProcPed($pedido,$usuario,$area){
            $sql="exec GA_WMS_PDetProcPedido '$pedido', '$usuario', '$area'";
            return ejecutarConsultaSQL($sql);
        }

        public function artDetArm($pedido,$op,$area){
            $sql="exec GA_WMS_PPedDetProceso '$pedido', '', '$op','', '$area'";
            return ejecutarConsultaSQL($sql);
        }


     }
?>