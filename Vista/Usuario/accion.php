<?php
include_once '../../configuracion.php';

$datos = data_submitted();

$mensaje = "La acci&oacute;n no pudo concretarse";
if(isset($datos['usnombre']) && isset($datos['usmail']) && isset($datos['uspass'])) {
    $ambUsuario = new AbmUsuario();
    $respuesta = $ambUsuario->alta($datos);
    if ($respuesta) {
        $mensaje = "Usuario creado exitosamente";
    }
}
/*$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg'] = $mensaje;
}*/
echo $mensaje;
?>