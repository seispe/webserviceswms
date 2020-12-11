<?php
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
require_once "../modelos/Conteo.php";
$conteo=new Conteo();
switch ($_GET["op"]) {
    case 'getConteosCiclicos':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->op)) {
            $rspta=$conteo->getConteosCiclicos($obj->documento,$obj->tipo,$obj->producto,$obj->op);
                while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                    $resp[]=$reg;
                 }
                if(empty($resp)){
                    $reeturn=array("status"=>"error",
                                    "mensaje"=>'No hay conteos');
                        echo json_encode($reeturn);
                }else{
                    $reeturn=array("status"=>'Ok',
                                    "conteos"=>$resp,
                                    "mensaje"=>"Datos correctos");
                    echo json_encode($reeturn);
       
                }
        }
    break;

    case 'getccParcial':
			$obj = json_decode(file_get_contents('php://input'));
			if (!empty($obj->op)) {
				$rspta=$conteo->getccParcial($obj->op,$obj->id,$obj->producto);
                if($rspta>=0){
                    $rspta=array("status"=>"Ok",
                                    "mensaje"=>"Parcial valido",
                                    "parcial"=>$rspta);
                    echo json_encode($rspta);
                }else{
                    $rspta=array("status"=>"error",
                                    "mensaje"=>'Error del producto');
                    echo json_encode($rspta);
                }	
			}
			
		break;
    
    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>