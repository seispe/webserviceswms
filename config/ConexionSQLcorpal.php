<?php

$driver_secundaria = "sqlServer";
$host_secundaria = "192.168.0.219";
$user_secundaria = "sa";
$pass_secundaria = "Alvarado2018*";
$database_secundaria = "WMScal";
$charset_secundaria = "utf8";
$port_secundaria = "3306";


// $host_secundaria = "13.59.81.157";
// $user_secundaria = "sa";
// $pass_secundaria = "Sistemas@2019*";
// $database_secundaria = "GPALL";


$con;
try {
    $conexionSQL = new PDO(
        "sqlsrv:Server=$host_secundaria;Database=$database_secundaria;", "$user_secundaria", "$pass_secundaria",
        array(
            //PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
}
catch(PDOException $e) {
    die("Error connecting to SQL Server: " . $e->getMessage());
}

if (!function_exists('ejecutarConsultaSQL'))
{
	  function ejecutarConsultaSQL($sql){
        global $conexionSQL;
          $query=$conexionSQL->query($sql);
          return $query;
    }
     function ejecutarProcedureSQL($sql){
        global $conexionSQL;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        return $conexionSQL->prepare($sql);
       
  }  
  function pruebaSQL($sql){
         global $conexionSQL;
          $query=$conexionSQL->mssql_connect($sql);
          return $query;
  }  
}
?>
