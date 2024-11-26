<?php

class AbmUsuarioRol {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjeto($param){
        $obj = null;
        $usuarioParam = $param[0];
        $idusuario = $usuarioParam[0]->get_idusuario();
        $rolParam = $param[1];
        $idrol = $rolParam[0]->get_idrol();
        if($idusuario!=null && $idrol!=null){
           $obj = new UsuarioRol();
           $obj->setear($usuarioParam[0], $rolParam[0]);
        }
        return $obj;
    }

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        $usuarioParam = $param[0];
        $idusuario = $usuarioParam[0]->get_idusuario();
        $rolParam = $param[1];
        $idrol = $rolParam[0]->get_idrol();
        if($idusuario!=null && $idrol!=null){
            $obj = new UsuarioRol();
            $obj->setear($usuarioParam[0], $rolParam[0]);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
     private function seteadosCamposClaves($param){
        $usuarioParam = $param[0];
        $idusuario = $usuarioParam[0]->get_idusuario();
        $rolParam = $param[1];
        $idrol = $rolParam[0]->get_idrol();
        if($idusuario!=null && $idrol!=null) {
            $resp = true;
        }
        return $resp;
    }

     /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $elObjtRol = $this->cargarObjeto($param);
        if ($elObjtRol!=null && $elObjtRol->insertar()){
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
            $elObjtRol = $this->cargarObjetoConClave($param);
            if ($elObjtRol!=null && $elObjtRol->eliminar()){
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
            $elObjtRol = $this->cargarObjeto($param);
            if($elObjtRol!=null && $elObjtRol->modificar()){
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
                $where.=" and idusuario ='".$param['idusuario']."'";
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }
        $arreglo = UsuarioRol::listar($where);
        return $arreglo; 
    }

    /*public function gestionarRol($datos) {
        //$datos = idusuario e idrol a cambiar
        $ambUsuarioRol = new abmUsuarioRol();
        $ambUsuario = new AbmUsuario();
        $ambRol = new AbmRol();
        $respuesta = false;
        //print_r($datos);
        $us = $ambUsuario->buscar(['idusuario'=>$datos['idusuario']]);
        $usrol = $ambUsuarioRol->buscar(['idusuario'=>$datos['idusuario']]);
        //print_r($usrol);
        $nuevorol = $ambRol->buscar(['idrol'=>$datos['idrol']]); //rol que llega en $datos
        $param = [$us, $nuevorol];//sirve para alta
        if (empty($usrol)) {
            $respuesta = $ambUsuarioRol->alta($param);
        } else {
            $usrol = [$us, $nuevorol];
            $respuesta = $ambUsuarioRol->baja($usrol);
            print_r($usrol);
            $respuesta = $ambUsuarioRol->alta($param);
        }
        return $respuesta;
    }*/

    public function gestionarRol($datos) {
        $ambUsuarioRol = new abmUsuarioRol();
        $ambUsuario = new AbmUsuario();
        $ambRol = new AbmRol();
        $respuesta = false;
        //print_r($datos);
        $us = $ambUsuario->buscar(['idusuario'=>$datos['idusuario']]);
        $usrol = $ambUsuarioRol->buscar(['idusuario'=>$datos['idusuario']]);
        //print_r($usrol);
        $nuevorol = $ambRol->buscar(['idrol'=>$datos['datarol']]); //rol que llega en $datos
        $param = [$us, $nuevorol];//sirve para alta cuando no tiene rol
        if ($datos['idrol'] == "sinrol") {
            $respuesta = $ambUsuarioRol->alta($param);
        } else {
            $borrarRol = $ambRol->buscar(['idrol'=>$datos['idrol']]);
            $usrol = [$us, $borrarRol];
            $respuesta = $ambUsuarioRol->baja($usrol);
            $respuesta = $ambUsuarioRol->alta($param);
        }
        return $respuesta;
    }

    public function permisoRol(){
        $sesion= new Session();
        $resp=false;  
        if($sesion->validar()){
            $rol=$sesion->getRol();
            $id=$rol->get_idrol();
            if($id==1){
                $resp=true;
            }
        }
        return $resp;
    }
}