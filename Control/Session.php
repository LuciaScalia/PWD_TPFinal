<?php
class Session{

    public function __construct(){  
        session_start();
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
        if (!empty($usuario) && $uspass) {
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
}
?>