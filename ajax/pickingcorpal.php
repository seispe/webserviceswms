<?php 

	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
	header("Access-Control-Allow-Origin: *");
	require_once "../modelos/Pickingcorpal.php";
	$picking=new Picking();
	
	switch ($_GET["op"]){

	
		
		case 'consolidados':
			    $obj = json_decode(file_get_contents('php://input'));
                $rspta=$picking->consolidados($obj->usuario);

                while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                   $resp[]=$reg;
                }

                if(empty($resp)){
                    $rspta=array("status"=>"error",
                    				"mensaje"=>'Verifique su usuario');
                    	echo json_encode($rspta);
                }else{
                    $reeturn=array("status"=>'Ok',
									"consolidados"=>$resp,
									"mensaje"=>"Datos correctos");
                    echo json_encode($reeturn);

                }

        break;
        
        case 'obtenerProductosConsolidado':
            $obj = json_decode(file_get_contents('php://input'));
            $rspta=$picking->obtenerProductosConsolidado($obj->consolidado,$obj->usuario);
            while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
               $resp[]=$reg;
            }
            if(empty($resp)){
                $rspta=array("status"=>"error",
                                "mensaje"=>'Verifique su usuario');
                    echo json_encode($rspta);
            }else{
                $reeturn=array("status"=>'Ok',
                                "productos"=>$resp,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
            }
        break;

        case 'cantidadPicking':
            $obj = json_decode(file_get_contents('php://input'));
            $rspta=$picking->cantidadPicking( $obj->consolidado, $obj->producto, $obj->usuario, $obj->origen);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $rspta=array("status"=>"error",
                                "mensaje"=>'Verifique su usuario');
                    echo json_encode($rspta);
            }else{
                $reeturn=array("status"=>'Ok',
                                "cantidades"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
            }
        break;

        case 'cantidadPickingPendiente':
            $obj = json_decode(file_get_contents('php://input'));
            $rspta=$picking->cantidadPickingPendiente( $obj->consolidado, $obj->producto, $obj->usuario, $obj->origen);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $rspta=array("status"=>"error",
                                "mensaje"=>'Error veridicar datos');
                    echo json_encode($rspta);
            }else{
                $reeturn=array("status"=>'Ok',
                                "cantidades"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
            }
        break;

        case 'validarCoordenadaPicking':
            $obj = json_decode(file_get_contents('php://input'));

            $rspta=$picking->validarCoordenadaPicking( $obj->coordenada);
            $reg=$rspta->fetch(PDO::FETCH_ASSOC);
            if(empty($reg)){
                $rspta=array("status"=>"error",
                                "mensaje"=>'Error veridicar datos');
                    echo json_encode($rspta);
            }else{
                $reeturn=array("status"=>'Ok',
                                "existe"=>$reg,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
            }
        break;

        case 'validarCantidad':
			$obj = json_decode(file_get_contents('php://input'));

			$rspta=$picking->validarCantidad( $obj->consolidado,$obj->producto,$obj->cantidad);
			if($rspta==false){
				$reeturn=array("status"=>"error",
								"mensaje"=>'Error de procedimiento');
				echo json_encode($reeturn);
			}else{
				$reeturn=array("status"=>"Ok",
								"mensaje"=>"Correcto",
								"info"=>$rspta);
				echo json_encode($reeturn);
			}
        break;

        case 'guardarPicking':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$picking->guardarPicking($obj->consolidado,$obj->producto,$obj->origen,$obj->solicitada,$obj->procesada,$obj->pendiente,$obj->destino,$obj->usuario);
         
            if($rspta==false){
				$reeturn=array("status"=>"error",
								"mensaje"=>'Error de procedimiento');
				echo json_encode($reeturn);
			}else{
				$reeturn=array("status"=>"Ok",
								"mensaje"=>"Correcto",
								"info"=>$rspta);
				echo json_encode($reeturn);
			}
        break;

        case 'product_consolidados':
            $obj = json_decode(file_get_contents('php://input'));
            $rspta=$picking->product_consolidados( $obj->consolidado,$obj->usuario);
            while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                $resp[]=$reg;
             }
            if(empty($resp)){
                $rspta=array("status"=>"error",
                                "mensaje"=>'No hay datos');
                    echo json_encode($rspta);
            }else{
                $reeturn=array("status"=>'Ok',
                                "productos"=>$resp,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
            }
        break;
        
		default:
		echo 'ENVIAR LA VARIABLE OP POR METODO GET';
		break;
		

	}
?>