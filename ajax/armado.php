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
                                "mensaje"=>'Verifique el bulto');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "armado"=>$rspta,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
   
            }
        break;
    case 'colaImpresion':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$armado->colaImpresion($obj->op,$obj->bulto,$obj->usuario,$obj->tipo,$obj->numero,$obj->impresora,$obj->estado,$obj->activo,$obj->modulo);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Se envió a imprimir. ",
								"msj"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Problemas de impresón');
				echo json_encode($rspta);
			}	
		break;
    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>