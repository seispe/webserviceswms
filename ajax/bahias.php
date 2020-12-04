<?php  
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");
require_once "../modelos/Bahias.php";
$bahias=new Bahias();
switch ($_GET["op"]) {
    case 'bahiasxbultos':
        $obj = json_decode(file_get_contents('php://input'));
        if (!empty($obj->bulto)) {
            $rspta=$bahias->bahiasxbultos($obj->bulto,$obj->bahia,$obj->usuario)->fetch(PDO::FETCH_ASSOC);

            if(empty($rspta)){
                $return=array("status"=>"error",
                                "mensaje"=>'Verificar datos');
                    echo json_encode($return);
            }else{
                $return=array("status"=>'Ok',
                                "salida"=>$rspta,
                                "mensaje"=>"Datos correctos");
                echo json_encode($return);

            }
        }
               

        break;
    
    default:
    echo 'ENVIAR LA VARIABLE OP POR METODO GET';
        break;
}
?>