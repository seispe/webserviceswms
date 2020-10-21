<?php
     require "../config/ConexionSQL.php";
     class  Impresoras{
        public function _construct(){
        }


        public function getImpresoras($usuario, $tipo){
            $sql = "exec GA_IMP_PgetImpresora 'GPIAV','$usuario','$tipo'";
            return ejecutarConsultaSQL($sql);

        }


     }
?>