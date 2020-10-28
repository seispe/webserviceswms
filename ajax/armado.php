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
    case 'audImpresion':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$armado->audImpresion($obj->pedidos,$obj->usuario,$obj->modulo,$obj->op,$obj->obs);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Auditado. ",
								"msj"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Problemas de impresón');
				echo json_encode($rspta);
			}	
        break;
    case 'getPedidos':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$armado->getPedidos($obj->filtro,$obj->area,$obj->op);
			while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                $resp[]=$reg;
             }
            if(empty($resp)){
                $reeturn=array("status"=>"error",
                                "mensaje"=>'Verifique con sistemas');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "pedidos"=>$resp,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
   
            }	
        break;
    case 'validarCoordenadaArmado':
            $obj = json_decode(file_get_contents('php://input'));

            $rspta=$armado->validarCoordenadaArmado( $obj->coordenada,$obj->tipo);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $rspta=array("status"=>"error",
                                "mensaje"=>'Error verificar datos');
                    echo json_encode($rspta);
            }else{
                $reeturn=array("status"=>'Ok',
                                "existe"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
            }
        break;
    case 'pedDetProceso':
			$obj = json_decode(file_get_contents('php://input'));
            $rspta=$armado->pedDetProceso($obj->pedido,$obj->producto,$obj->op,$obj->usuario,$obj->area);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $reeturn=array("status"=>"error",
                                "mensaje"=>'Error verifique el artículo');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "existe"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
   
            }
        break;
    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>