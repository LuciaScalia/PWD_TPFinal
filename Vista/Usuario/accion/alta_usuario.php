<?php
include_once '../../../configuracion.php';

$datos = data_submitted();

$respuesta = false;
if(isset($datos['usnombre']) && isset($datos['usmail']) && isset($datos['uspass'])) {
    $ambUsuario = new AbmUsuario();
    $respuesta = $ambUsuario->alta($datos);
    if (!$respuesta) {
        $mensaje = "La acci&oacute;n no pudo concretarse";
        //echo("<script>location.href = '../Login/index.php?msg=".$mensaje."';</script>");
    }
}
$retorno['respuesta'] = $respuesta;
if ($mensaje = "La acci&oacute;n no pudo concretarse"){
    $retorno['errorMsg'] = $mensaje;
}
echo json_encode($retorno);
?>