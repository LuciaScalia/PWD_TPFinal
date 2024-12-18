<?php

class AbmUsuario {

    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Usuario
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if(array_key_exists('idusuario',$param) && array_key_exists('usnombre',$param) && array_key_exists('uspass',$param) && array_key_exists('usmail',$param) && array_key_exists('usdeshabilitado',$param)){
            $obj = new Usuario();
            $obj->setear($param['idusuario'], $param['usnombre'], $param['uspass'], $param['usmail'], $param['usdeshabilitado']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Usuario
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idusuario']) ){
            $obj = new Usuario();
            $obj->setear($param['idusuario'], null, null, null, null);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
     private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['idusuario']))
            $resp = true;
        return $resp;
    }/********************************************************** ACÁ*/
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idusuario'] = null;
        $param['usdeshabilitado'] = null;
        $elObjUsuario = $this->cargarObjeto($param);
        if ($elObjUsuario!=null and $elObjUsuario->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtUsuario = $this->cargarObjetoConClave($param);
            if ($elObjtUsuario!=null and $elObjtUsuario->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $elObjtUsuario = $this->cargarObjeto($param);
            //print_r($elObjtUsuario);
            if($elObjtUsuario!=null && $elObjtUsuario->modificar()){

                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        if ($param!=NULL){
            if  (isset($param['idusuario']))
                $where.=" and idusuario =".$param['idusuario'];
            if  (isset($param['usnombre']))
                 $where.=" and usnombre ='".$param['usnombre']."'";
            if (isset($param['uspass']))
               $where.=" and uspass ='".$param['uspass']."'";
            if  (isset($param['usmail']))
               $where.=" and usmail ='".$param['usmail']."'";
            if  (isset($param['usdeshabilitado']))
                $where.=" and usdeshabilitado ='".$param['usdeshabilitado']."'";
        }
        $arreglo = Usuario::listar($where);  
        return $arreglo; 
    }

    public function fechaActual(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaActual = date('Y-m-d H:i:s');
        return $fechaActual;
    }

    public function estadoUsuario($param) {
        $resp = false;
        $ambUsuarioRol = new AbmUsuarioRol();
        $abmRol = new AbmRol();
        if($param['usdeshabilitado'] == null || $param['usdeshabilitado'] == "0000-00-00 00:00:00") {
            $param['usdeshabilitado'] = $this->fechaActual();
        } else {
            $usuario = $this->buscar(['idusuario'=>$param['idusuario']]);
            if ($usuario[0]->get_usdeshabilitado() == null || $usuario[0]->get_usdeshabilitado() == "0000-00-00 00:00:00") {
                //borra la fila de usuariorol
                $usuarioRol = $ambUsuarioRol->buscar(['idusuario'=>$param['idusuario']]);
                $usuarioRol = $abmRol->buscar(['idrol'=>$usuarioRol[0]->get_objrol()->get_idrol()]);
                if(!empty($usuarioRol)) {
                    $usuario = $this->buscar(['idusuario'=>$param['idusuario']]);
                    $baja = [$usuario, $usuarioRol];
                    $resp = $ambUsuarioRol->baja($baja);
                }
            }
        }
        $resp = $this->modificacion($param);
        if ($resp) {
            $session = new Session();
            $resp = $session->cerrar();
        }
        return $resp;
    }

    public function estadoUsuarioAdmin($param) {
        $resp = false;
        $ambUsuarioRol = new AbmUsuarioRol();
        $abmRol = new AbmRol();
        if($param['usdeshabilitado'] == null || $param['usdeshabilitado'] == "0000-00-00 00:00:00") {
            $param['usdeshabilitado'] = $this->fechaActual();
        } else {
            $usuario = $this->buscar(['idusuario'=>$param['idusuario']]);
            if ($usuario[0]->get_usdeshabilitado() == null || $usuario[0]->get_usdeshabilitado() == "0000-00-00 00:00:00") {
                //borra la fila de usuariorol
                $usuarioRol = $ambUsuarioRol->buscar(['idusuario'=>$param['idusuario']]);
                $usuarioRol = $abmRol->buscar(['idrol'=>$usuarioRol[0]->get_objrol()->get_idrol()]);
                if(!empty($usuarioRol)) {
                    $usuario = $this->buscar(['idusuario'=>$param['idusuario']]);
                    $baja = [$usuario, $usuarioRol];
                    $resp = $ambUsuarioRol->baja($baja);
                }
            }
        }
        $resp = $this->modificacion($param);
        return $resp;
    }
}
?>
