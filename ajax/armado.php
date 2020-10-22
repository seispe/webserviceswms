<?php  
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
require_once "../modelos/Armado.php";
$armado=new Armado();
switch ($_GET["op"]) {
    case 'getImpresoras':
        $obj = json_decode(file_get_contents('php://input'));
                $rspta=$armado->getImpresoras($obj->usuario,$obj->tipo);
                while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                    $resp[]=$reg;
                 }
                if(empty($resp)){
                    $reeturn=array("status"=>"error",
                                    "mensaje"=>'Verifique el usuario');
                        echo json_encode($reeturn);
                }else{
                    $reeturn=array("status"=>'Ok',
                                    "impresoras"=>$resp,
                                    "mensaje"=>"Datos correctos");
                    echo json_encode($reeturn);
       
                }

        break;
    case 'getInfoArmado':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$armado->getInfoArmado($obj->bulto);
			if(empty($rspta)){
                $reeturn=array("status"=>"error",
                                "mensaje"=>'Verifique el pedido');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "logistica"=>$rspta,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
   
            }
		break;
    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>