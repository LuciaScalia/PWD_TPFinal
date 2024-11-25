<?php
include_once '../../../configuracion.php';

$datos = data_submitted();
//var_dump($datos);
$respuesta = false;
if(isset($datos['idrol']) && isset($datos['idusuario'])) {
    $abmUsuarioRol = new AbmUsuarioRol();
    $respuesta = $abmUsuarioRol->gestionarRol($datos);
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