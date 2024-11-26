<?php
include_once '../../../configuracion.php';

$datosJSON = file_get_contents('php://input'); 
$datosCompra = json_decode($datosJSON, true);

if($datosCompra){
    $compra=new AbmCompra();
    $respuesta=$compra->actualizarCompra($datosCompra); 
    echo json_encode(['mensaje'=>'Compra actualizada','respuesta'=>$respuesta]);
    
}


?>