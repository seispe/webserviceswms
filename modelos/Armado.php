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
            
            die($query);


            $result = $query->fetch(PDO::FETCH_OBJ);
            $result->mensaje=$msg;
            print_r($result);
            die();

        }


     }
?>