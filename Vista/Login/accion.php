<?php
include_once("../Estructura/cabeceraBTNoSegura.php");
$datos = data_submitted();
$resp = false;

print_r($datos);
if (isset($datos['accion'])){

    if ($datos['accion']=="login"){
        $usuarioAbm = new AbmUsuario();
        $usuario = $usuarioAbm->buscar(['usnombre' => $datos['usnombre']]);
        var_dump($usuario);
        if (!empty($usuario)) {
            $uspass = $usuario[0]->get_uspass();
            if($uspass===$datos['uspass']){  

                $objTrans = new Session();
                $resp2 = $objTrans->iniciar($datos['usnombre'],$uspass);
                if($resp2) {
                    echo("<script>location.href = '../Home/index.php';</script>");
                }else {
                    $mensaje ="Error, vuelva a intentarlo";
                    echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                }
            }else {
                $mensaje ="Error, vuelva a intentarlo";
                echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
            }
        }else {
            $mensaje ="Error, vuelva a intentarlo";
            echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
        }
    }

    
    if ($datos['accion']=="cerrar"){
        $objTrans = new Session();
        $resp = $objTrans->cerrar();
        if($resp) {
            $mensaje ="Sesión Cerrada";
            echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
        }
    }
}
    

?>
