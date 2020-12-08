<?php  
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
require_once "../modelos/Armado.php";
$armado=new Armado();
switch ($_GET["op"]) {
    case 'getImpresoras':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->usuario)) {
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
        }
                

        break;
    case 'getInfoArmado':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->bulto)) {
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
        }
          
        break;
    case 'colaImpresion':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->bulto)) {
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
        }
				
        break;
    case 'audImpresion':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->usuario)) {
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
        if (!empty($obj->coordenada)) {
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
        }
            
        break;
    case 'pedDetProceso':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->pedido)) {
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
        }
            
        break;
    case 'getBultos':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->usuario)) {
            $rspta=$armado->getBultos($obj->usuario,$obj->op);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $reeturn=array("status"=>"error",
                                "mensaje"=>'No existe bulto');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "bulto"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
   
            }
        }
            
        break;
    case 'insBultos':
            $obj = json_decode(file_get_contents('php://input'));
            
            if($obj->estado==2 || $obj->estado=="2"){
                $rspta=$armado->insBultos($obj->estado,$obj->usuario);
                if($rspta!=false){
                    $rspta=array("status"=>"Ok",
                                    "mensaje"=>"Bulto creado",
                                    "bulto"=>$rspta);
                    echo json_encode($rspta);
                }else{
                    $rspta=array("status"=>"error",
                                    "mensaje"=>'Error creación bulto');
                    echo json_encode($rspta);
                }
            }

			
        break;
    case 'validarVoid':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->codigo)) {
            $rspta=$armado->validarVoid($obj->codigo,$obj->op);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Producto válido",
								"void"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Error del producto');
				echo json_encode($rspta);
			}
        }
				
        break;
    case 'getDetArmado':
            $obj = json_decode(file_get_contents('php://input'));
        if ((!empty($obj->codigo))) {
            $rspta=$armado->getDetArmado($obj->codigo,$obj->pedido,$obj->area,$obj->op);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $reeturn=array("status"=>"error",
                                "mensaje"=>'Error recuperando datos');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "armado"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
   
            }
        }
            
        break;
    case 'validaBulto':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->idbulto)) {
            $rspta=$armado->validaBulto($obj->op,$obj->idbulto,$obj->pedido,$obj->usuario);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Bulto validado",
								"bulto"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Error validación bulto');
				echo json_encode($rspta);
			}
        }
				
        break;
    case 'insArmado':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->pedido)) {
            $observacion = isset($obj->observacion) ? $obj->observacion:"";
            $rspta=$armado->insArmado($obj->pedido,$obj->producto,$obj->coor_origen,$obj->coor_destino,$obj->can_armada,$obj->can_armar,$obj->can_pend_armar,$obj->codigo_void,$observacion,$obj->usuario,$obj->idbulto);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Correcto insertar armado",
								"armado"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Error insertar armado');
				echo json_encode($rspta);
			}	
        }
			
        break;
    case 'cierreArmado':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->pedido)) {
            $rspta=$armado->cierreArmado($obj->pedido,$obj->area);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Correcto cierre armado",
								"cierre"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Error cierre armado');
				echo json_encode($rspta);
			}	
        }
			
        break;
    case 'detProcPed':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->pedido)) {
            $rspta=$armado->detProcPed($obj->pedido,$obj->usuario,$obj->area);
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
        }
            
        break;

    case 'artDetArm':
            $obj = json_decode(file_get_contents('php://input'));
            if (!empty($obj->pedido)) {
                $rspta=$armado->artDetArm($obj->pedido,$obj->op,$obj->area);
                    while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                        $resp[]=$reg;
                     }
                    if(empty($resp)){
                        $reeturn=array("status"=>"error",
                                        "mensaje"=>'Verifique el pedido');
                            echo json_encode($reeturn);
                    }else{
                        $reeturn=array("status"=>'Ok',
                                        "articulos"=>$resp,
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