<?php

class AbmMenuRol {
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjeto($param){
        $obj = null;
        $idmenu = $param[0];
        $idmenu = $idmenu->getIdmenu();
        $idrol = $param[1];
        $idrol = $idrol->get_idrol();
        if($idmenu!=null && $idrol!=null){
           $obj = new MenuRol();
           $obj->setear($param[0], $param[1]);
        }
        return $obj;
    }
    

    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return MenuRol
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        $idmenu = $param[0];
        $idmenu = $idmenu->getIdmenu();
        $idrol = $param[1];
        $idrol = $idrol->get_idrol();
        if($idmenu!=null && $idrol!=null) {
            $obj = new MenuRol();
            $menu= new Menu();
            $menu->setIdmenu($idmenu);
            $rol= new Rol();
            $rol->set_idrol($idrol);
            $obj->setear($menu,$rol);
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
        $idmenu = $param[0];
        $idmenu = $idmenu->getIdmenu();
        $idrol = $param[1];
        $idrol = $idrol->get_idrol();
        if ($idmenu!=null && $idrol!=null)
            $resp = true;
        return $resp;
    }

     /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $elObjtMenuRol = $this->cargarObjeto($param);
        if ($elObjtMenuRol!=null && $elObjtMenuRol->insertar()){
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
            $elObjtMenuRol = $this->cargarObjetoConClave($param);
            if ($elObjtMenuRol!=null && $elObjtMenuRol->eliminar()){
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
            $elObjtMenuRol = $this->cargarObjeto($param);
            if($elObjtMenuRol!=null && $elObjtMenuRol->modificar()){
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
            if  (isset($param['idmenu']))
                $where.=" and idmenu ='".$param['idmenu']."'";
            if  (isset($param['idrol']))
                 $where.=" and idrol ='".$param['idrol']."'";
        }
        $arreglo = MenuRol::listar($where);
        return $arreglo; 
    }
}