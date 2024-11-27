<?php
class Session{

    public function __construct(){  
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
      }
   
    /**
     * Actualiza las variables de sesión con los valores ingresados.
     */
    public function iniciar($usuario, $uspass) {
        $resp = false;
        $abmUsuario = new AbmUsuario();
        $param['usnombre'] = $usuario;
        $param['usdeshabilitado'] = null;
        
        $usuario = $abmUsuario->buscar($param);
        if (!empty($usuario) && $uspass==$usuario[0]->get_uspass()) {
            $usuario = $usuario[0];
            $_SESSION['idusuario'] = $usuario->get_idusuario();
            $resp = true;
        } else {
            $this->cerrar();
        }
        return $resp;
    }

    /**
     *Devuelve true o false si la sesión está activa o no.
     */
    public function activa() {
        $sesionActiva = session_status() === PHP_SESSION_ACTIVE ? true : false;
        return $sesionActiva;
    }
    
    /**
     * Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar() {
        $sesionValida = $this->activa() && isset($_SESSION['idusuario']) ? true : false;
        return $sesionValida;
    }
   
    /**
     * Devuelve el usuario logeado.
     */
    public function getUsuario() {
        $usuario = null;
        if ($this->validar()) {
            $usuarioAbm = new AbmUsuario();
            $resultado = $usuarioAbm->buscar(['idusuario' => $_SESSION['idusuario']]);
            if (!empty($resultado)) {
                $usuario = $resultado[0];
            }
        }
        return $usuario;
    }

     /**
     * Devuelve el rol del usuario logeado.
     */
    public function getRol() {
        $rol = null;
        $usuario = $this->getUsuario();
        if ($this->validar() && !empty($usuario)) {
            $rolUsuarioAbm = new AbmUsuarioRol();
            $rolData = $rolUsuarioAbm->buscar(['idusuario' => $usuario->get_idusuario()]);
            if (!empty($rolData)) {
                $usuarioRol = $rolData[0];
                $rolObj = $usuarioRol->get_objrol();
                if (!empty($rolObj)) {
                    $rol = $rolObj;
                }
            }
        }
        return $rol;
    }
    
    /**
     *Cierra la sesión actual.
     */
    public function cerrar(){
        $resp = true;
        session_destroy();
        return $resp;
    }

    public function iniciarSesion($datos){
        if (isset($datos['accion'])){

            if ($datos['accion']=="login"){
                    $li="";
                    $uspass=$datos['uspass'];
                    $resp = $this->iniciar($datos['usnombre'],$uspass);
                    $usuario = $this->getUsuario();
                        if($resp) {
                            if ($usuario->get_usdeshabilitado() == null) {
                                $usuariorol=$this->getRol();
                                if(!empty($usuariorol)){  
                                     //$idrol=$usuariorol->get_idrol();
                                    $li= ' <li class="nav-item">
                                    <a class="nav-link" href="../menu/menu_listar.php">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></g></svg>    
                                    Perfil
                                    </a>
                                    </li>';
                                    $li = urlencode($li);
                                    echo("<script>location.href = '../Home/index.php?li=$li';</script>");  
                                } else {
                                    $mensaje ="Error, vuelva a intentarlo";
                                    echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                                }
                                } else {
                                    $this->cerrar();
                                    $mensaje ="El usuario fue eliminado";
                                    echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                                }
                            } else {
                                $mensaje ="Error, vuelva a intentarlo";
                                echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                            }
                                
                    } else {
                        
                    }
            }
            
            if ($datos['accion']=="cerrar"){
            
                $resp = $this->cerrar();
                if($resp) {
                    $mensaje ="Sesión Cerrada";
                    echo("<script>location.href = './index.php?msg=".$mensaje."';</script>");
                }
            }
    }
}
?>