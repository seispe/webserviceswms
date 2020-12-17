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
				$rspta=$conteo->getccParcial($obj->op,$obj->id,$obj->producto,$obj->origen);
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
    case 'validarCoordenadaConteo':
            $obj = json_decode(file_get_contents('php://input'));
            if (!empty($obj->coordenada)) {
                $rspta=$conteo->validarCoordenadaConteo( $obj->coordenada,$obj->tipo);
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
    
    case 'activaSuma':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->op)) {
            $rspta=$conteo->activaSuma($obj->op,$obj->id,$obj->producto,$obj->origen,$obj->activo);
            if($rspta!=false){
                $rspta=array("status"=>"Ok",
                                "mensaje"=>"Correcto valores a sumar",
                                "suma"=>$rspta);
                echo json_encode($rspta);
            }else{
                $rspta=array("status"=>"error",
                                "mensaje"=>'Error valores a sumar');
                echo json_encode($rspta);
            }	
        }
			
        break;

        case 'insConteoCiclico':
            $obj = json_decode(file_get_contents('php://input'));
            if (!empty($obj->op)) {
                $rspta=$conteo->insConteoCilico($obj->bodega,$obj->op,$obj->tipo,$obj->id,$obj->producto,$obj->origen,$obj->cantidad,$obj->usuario);
                if($rspta!=false){
                    $rspta=array("status"=>"Ok",
                                    "mensaje"=>"Correcto insert conteo",
                                    "inserta"=>$rspta);
                    echo json_encode($rspta);
                }else{
                    $rspta=array("status"=>"error",
                                    "mensaje"=>'Error insert conteo');
                    echo json_encode($rspta);
                }	
            }
                
            break;
        case 'getcierreTConteo':
            $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->id)) {
            $rspta=$conteo->getcierreTConteo($obj->id,$obj->producto);
            if(empty($rspta)){
                $reeturn=array("status"=>"error",
                                "mensaje"=>'Error recuperando cierreconteocc');
                    echo json_encode($reeturn);
            }else{
                $reeturn=array("status"=>'Ok',
                                "valores"=>$rspta,
                                "mensaje"=>"Datos correctos");
                echo json_encode($reeturn);
    
            }
        }
            
        break;

    case 'getcierreConteo':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->id)) {
            $rspta=$conteo->getcierreConteo($obj->id);
            if($rspta!=false){
                $rspta=array("status"=>"Ok",
                                "mensaje"=>"Correcto cierre conteo",
                                "cierre"=>$rspta);
                echo json_encode($rspta);
            }else{
                $rspta=array("status"=>"error",
                                "mensaje"=>'Error cierre conteo');
                echo json_encode($rspta);
            }	
        }
            
        break;

    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>