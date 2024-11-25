<?php
include_once '../../../configuracion.php';

$datosJSON=file_get_contents('php://input');
$datosCompra= json_decode($datosJSON, true);

if(isset($datosCompra['productos'])){
    $productos=$datosCompra['productos'];
    $obj=new AbmCompra();
    $mensaje=$obj->IniciarCompra($productos);
    echo json_encode($mensaje);
}



?>