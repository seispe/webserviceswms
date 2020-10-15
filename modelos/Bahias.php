<?php
     require "../config/ConexionSQL.php";
     class  Bahias{
        public function _construct(){
        }


        public function bahiasxbultos($bulto, $bahia, $usuario){
            $sql = "exec GA_WMS_Pbahiasxbultos '$bulto','$bahia','$usuario'";
            return ejecutarConsultaSQL($sql);

        }


     }
?>