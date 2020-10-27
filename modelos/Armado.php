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
            $query=ejecutarProcedureSQL("exec GA_WMS_PCOLAIMPRESION_prb ?,?,?,?,?,?,?,?,?,?,?");
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


     }
?>