<?php

include_once '../../../configuracion.php';
$datos = data_submitted();
print_r($datos);
$respuesta = false;
if(isset($datos['idusuario'])) {
    $ambUsuario = new AbmUsuario();
    $respuesta = $ambUsuario->modificacion($datos);
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