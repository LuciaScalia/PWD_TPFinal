<?php
include_once '../../../configuracion.php';
echo "Editar usuario";
/*$datos = data_submitted();
$ambUsuario = new AbmUsuario();
$usuario = $ambUsuario->buscar(['idusuario'=>$datos['idusuario']]);
//$usuario = $usuario[0];

$param['idusuario'] = $datos['idusuario'];
$respuesta = false;
if($datos['usnombre']!=null) {
    $param['usnombre'] = $datos['usnombre'];
}
if($datos['usmail']!=null) {
    $param['usmail'] = $datos['usmail'];
}
if($datos['uspass']!=null) {
    $param['uspass'] = $datos['uspass'];
}
if(count($param)>1) {
    $respuesta = $ambUsuario->modificacion($param);
}
$respuesta = $usuario->modificacion($usuario);



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
?>*/