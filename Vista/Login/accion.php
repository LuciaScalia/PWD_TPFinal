<?php
include_once("../../Estructura/cabeceraBTNoSegura.php");
$datos = data_submitted();
$resp = false;
$li="";
//print_r($datos);
if (isset($datos['accion'])){

    if ($datos['accion']=="login"){
            $objTrans = new Session();
            $uspass=$datos['uspass'];
            $resp2 = $objTrans->iniciar($datos['usnombre'],$uspass);
<<<<<<< HEAD
            if($resp2) {
                $usuariorol=$objTrans->getRol();
                if(!empty($usuariorol)){
                       
                    $idrol=$usuariorol->get_idrol();
                        
                    if($idrol==2){
                        $li= ' <li class="nav-item">
                        <a class="nav-link active" href="../menu/menu_list.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        ADMIN<span class="sr-only">(current)</span>
                        </a>
                        </li>';
                         $li = urlencode($li);
                        echo("<script>location.href = '../Home/indexx.php?li=$li';</script>");  
                    }elseif($idrol==1){
                        $li= ' <li class="nav-item">
                        <a class="nav-link" href="../usuario/editar.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></g></svg>    
                        Perfil
                        </a>
                        </li>';
                        $li = urlencode($li);
                        echo("<script>location.href = '../Home/indexx.php?li=$li';</script>");  
=======
            $usuario = $objTrans->getUsuario();
                if($resp2) {
                    if ($usuario->get_usdeshabilitado() == null) {
                        $usuariorol=$objTrans->getRol();
                        if(!empty($usuariorol)){  
                             //$idrol=$usuariorol->get_idrol();
                            $li= ' <li class="nav-item">
                            <a class="nav-link" href="../Menu/menu_listar.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></g></svg>    
                            Perfil
                            </a>
                            </li>';
                            $li = urlencode($li);
                            echo("<script>location.href = '../Home/indexx.php?li=$li';</script>");  
                        } else {
                            $mensaje ="Error, vuelva a intentarlo";
                            echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                        }
                        } else {
                            $objTrans->cerrar();
                            $mensaje ="El usuario fue eliminado";
                            echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                        }
                    } else {
                        $mensaje ="Error, vuelva a intentarlo";
                        echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
>>>>>>> 01ff08e2316d167063743f5a0c7fed57c16f0d4e
                    }
                        
            } else {
                
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
?>
