<?php
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
require_once "../modelos/Conteo.php";
$conteo=new Conteo();
switch ($_GET["op"]) {
    case 'getccMatriz':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->op)) {
            $rspta=$conteo->getccMatriz($obj->op,$obj->documento);
                while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                    $resp[]=$reg;
                 }
                if(empty($resp)){
                    $reeturn=array("status"=>"error",
                                    "mensaje"=>'Verifique el usuario');
                        echo json_encode($reeturn);
                }else{
                    $reeturn=array("status"=>'Ok',
                                    "conteos"=>$resp,
                                    "mensaje"=>"Datos correctos");
                    echo json_encode($reeturn);
       
                }
        }
                

        break;
    
    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>