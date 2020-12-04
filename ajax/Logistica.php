<?php
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
require_once "../modelos/Logistica.php";
$logistica=new Logistica();
switch ($_GET["op"]) {
        case 'getPedido':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->pedido)) {
            $rspta=$logistica->getPedido($obj->pedido)->fetch(PDO::FETCH_ASSOC);
            if(empty($rspta)){
                 $reeturn=array("status"=>"error",
                                 "mensaje"=>'Verifique el pedido');
                     echo json_encode($reeturn);
             }else{
                 $reeturn=array("status"=>'Ok',
                                 "pedidos"=>$rspta,
                                 "mensaje"=>"Datos correctos");
                 echo json_encode($reeturn);
    
             }
        }
        
        break;
        case 'insLogistica':
            $obj = json_decode(file_get_contents('php://input'));
            if (!empty($obj->pedido)) {
                $rspta=$logistica->insLogistica($obj->pedido,$obj->usuario)->fetch(PDO::FETCH_ASSOC);
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
            }
            
            break;
        case 'cargaCamion':
                $obj = json_decode(file_get_contents('php://input'));
                if (!empty($obj->pedido)) {
                    $rspta=$logistica->cargaCamion($obj->pedido,$obj->camion,$obj->transportista,$obj->usuario)->fetch(PDO::FETCH_ASSOC);
                if(empty($rspta)){
                     $reeturn=array("status"=>"error",
                                     "mensaje"=>'Verifique el pedido');
                         echo json_encode($reeturn);
                 }else{
                     $reeturn=array("status"=>'Ok',
                                     "camion"=>$rspta,
                                     "mensaje"=>"Datos correctos");
                     echo json_encode($reeturn);
        
                 }
                }
                
                break;
        case 'getTrans':
                    $obj = json_decode(file_get_contents('php://input'));
                    if (!empty($obj->pedido)) {
                        $rspta=$logistica->getTrans($obj->pedido,$obj->opcion);
                    while($reg=$rspta->fetch(PDO::FETCH_ASSOC)){
                        $resp[]=$reg;
                     }
                    if(empty($resp)){
                         $reeturn=array("status"=>"error",
                                         "mensaje"=>'Verifique el pedido');
                             echo json_encode($reeturn);
                     }else{
                         $reeturn=array("status"=>'Ok',
                                         "transporte"=>$resp,
                                         "mensaje"=>"Datos correctos");
                         echo json_encode($reeturn);
            
                     }
                    }
                    
                    break;
    default:
        echo "ENVIAR LA VARIABLE OP POR METODO GET";
        break;
}
?>