<?php

class AbmUsuarioRol {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return UsuarioRol
     */
    private function cargarObjeto($param){
        $obj = null;
        if( array_key_exists('idusuario',$param) && array_key_exists('idrol',$param)){
            $obj = new UsuarioRol();
           $usuario= new Usuario();
           $usuario->set_idusuario($param['idusuario']);
           $rol= new Rol();
           $rol->set_idrol($usuario,$rol);
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
        if(isset($param['idusuario']) && isset($param['idrol']) ){
            $obj = new UsuarioRol();
            $usuario= new Usuario();
            $usuario->set_idusuario($param['idusuario']);
            $rol= new Rol();
            $rol->set_idrol($param['idrol']);
            $obj->setear($usuario,$rol);
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
        if (isset($param['idusuario']) && isset($param['idrol']))
            $resp = true;
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
        //echo "Estoy en modificacion";
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
}