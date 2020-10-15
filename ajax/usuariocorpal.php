<?php 

	header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
	header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
	header("Access-Control-Allow-Origin: *");
	require_once "../modelos/Usuarioscorpal.php";
	$usuarios=new Usuarios();
	
	switch ($_GET["op"]){

		case 'ping':
				$reeturn=array("status"=>'Ok',
								"mensaje"=>"EXISTE CONEXION");
				echo json_encode($reeturn);
	    break;
		
		
		case 'login':
			    $obj = json_decode(file_get_contents('php://input'));
				$rspta=$usuarios->login($obj->usuario,$obj->clave);
				if($rspta!=false){
					$reeturn=array("status"=>'Ok',
									"usuario"=>$rspta,
									"mensaje"=>"Ingreso exitoso");
					echo json_encode($reeturn);
				}else{
					$rspta=array("status"=>"error",
								"mensaje"=>'Verifique su usuario o clave');
					echo json_encode($rspta);
				}
		break;

		case 'validarCoordenada':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$usuarios->validarCoordenada($obj->coordenada);
			$regCoordenada = $rspta->fetch(PDO::FETCH_ASSOC);
			$rspta=array("status"=>"Ok",
								"mensaje"=>$regCoordenada['existe']);
					echo json_encode($rspta);
		break;

		case 'validarProducto':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$usuarios->validarProducto($obj->codigo);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Producto válido",
								"producto"=>$rspta);
				echo json_encode($rspta);
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Error del producto');
				echo json_encode($rspta);
			}	
		break;

		case 'inforArtiCoor':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$usuarios->inforArtiCoor($obj->codigo,$obj->coordenada);
			$regCoordenada = $rspta->fetch(PDO::FETCH_ASSOC);
			if(empty($regCoordenada)){
				$rspta=array("status"=>"error",
								"mensaje"=>'Error del producto');
				echo json_encode($rspta);

			}else{
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Producto válido",
								"info"=>$regCoordenada);
				echo json_encode($rspta);
			}
		break;

		case 'movimientos':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$usuarios->movimientos($obj->coorInicio,$obj->coorFin, $obj->cantidad,$obj->producto,$obj->usuario, $obj->tipo);
			if($rspta!=false){
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Movimiento realizado",
								"info"=>$rspta);
				echo json_encode($rspta);
			
			}else{
				$rspta=array("status"=>"error",
								"mensaje"=>'Error al realizar el movimiento');
				echo json_encode($rspta);
			}	
		break;

		case 'busquedaProd':
			$obj = json_decode(file_get_contents('php://input'));
			$rspta=$usuarios->busquedaProd($obj->producto);
			$regProducto = $rspta->fetch(PDO::FETCH_ASSOC);
			if(empty($regProducto)){
				$rspta=array("status"=>"error",
								"mensaje"=>'No existe el producto');
				echo json_encode($rspta);

			}else{
				$rspta=array("status"=>"Ok",
								"mensaje"=>"Producto válido",
								"info"=>$regProducto);
				echo json_encode($rspta);
			}
		break;

		

		default:
		echo 'ENVIAR LA VARIABLE OP POR METODO GET';
		break;
		

	}
?>