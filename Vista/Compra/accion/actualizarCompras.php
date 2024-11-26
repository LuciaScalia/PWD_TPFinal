<?php
include_once '../../../configuracion.php';

$datosCompra=  data_submitted();

if(!empty($datosCompra)){

    $compra=new AbmCompra();
    $respuesta=$compra->actualizarCompra($datosCompra); 
    echo json_encode(['mensaje'=>'Compra actualizada','respuesta'=>$respuesta]);

}


?>