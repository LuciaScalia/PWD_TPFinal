<?php
include_once '../../../configuracion.php';

$datos = data_submitted();

$respuesta = false;
if(isset($datos['idusuario'])) {
    $ambUsuario = new AbmUsuario();
    $session = new Session();
    $rolSession = $session->getRol();
    if ($rolSession->get_idrol() != 2) {
        $respuesta = $ambUsuario->estadoUsuario($datos);
    } else {
        $respuesta = $ambUsuario->estadoUsuarioAdmin($datos);
    }
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