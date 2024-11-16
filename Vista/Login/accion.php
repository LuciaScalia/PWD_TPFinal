<?php
include_once("../Estructura/cabeceraBTNoSegura.php");
$datos = data_submitted();
$resp = false;
$li="";
//print_r($datos);
if (isset($datos['accion'])){

    if ($datos['accion']=="login"){
        $usuarioAbm = new AbmUsuario();
        $usuario = $usuarioAbm->buscar(['usnombre' => $datos['usnombre']]);
        //var_dump($usuario);
        if (!empty($usuario)) {
            $uspass = $usuario[0]->get_uspass();
            if($uspass===$datos['uspass']){  
                
                $objTrans = new Session();
                $resp2 = $objTrans->iniciar($datos['usnombre'],$uspass);
                if($resp2) {
                    $objUsuarioRol= new AbmUsuarioRol();
                    $usuariorol=$objUsuarioRol->buscar(['idusuario'=>$usuario[0]->get_idusuario()]);
                  //  var_dump($usuariorol);
                    if(!empty($usuariorol)){
                        //print_r($usuariorol[0]->get_objusuario());
                        /*echo "accion ";
                        print_r($usuariorol[0]->get_objrol());*/
                        
                        
                        if($usuariorol[0]->get_objrol()->get_idrol()==2){
                           echo "hpla";
                            $li= ' <li class="nav-item">
                            <a class="nav-link active" href="../Home/index.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            ADMIN<span class="sr-only">(current)</span>
                            </a>
                            </li>';
                            $li = urlencode($li);
                            //include_once '../Estructura/cabeceraBT.php';
                           echo("<script>location.href = '../Home/index.php?li=$li';</script>");  
                        } 
                        
                    }
            
                   

                   
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
