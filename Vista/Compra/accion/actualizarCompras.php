<?php
/*include_once '../../../configuracion.php';

$datosCompra=  data_submitted();

if(!empty($datosCompra)){

    $compra=new AbmCompra();
    $respuesta=$compra->actualizarCompra($datosCompra); 
    echo json_encode(['mensaje'=>'Compra actualizada','respuesta'=>$respuesta]);

}*/

include_once '../../../configuracion.php';

$datosCompra = data_submitted();

$respuesta = false;
if(!empty($datosCompra)) {
    $compra=new AbmCompra();
    $respuesta = $compra->actualizarCompra($datosCompra);
    if (!$respuesta) {
        $mensaje = "La acci&oacute;n no pudo concretarse";
    }
}

$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
?>