<?php

class AbmCompraEstado {

    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if(array_key_exists('idcompraestado',$param) && array_key_exists('idcompra',$param) && array_key_exists('idcompraestadotipo',$param) && array_key_exists('cefechaini',$param) && array_key_exists('cefechafin',$param)){
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], $param['idcompra'], $param['idcompraestadotipo'], $param['cefechaini'], $param['cefechafin']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraEstado
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idcompraestado']) ){
            $obj = new CompraEstado();
            $obj->setear($param['idcompraestado'], null, null, null, null);
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
        if (isset($param['idcompraestado']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idcompraestado'] = null;
        $elObjCompraEstado = $this->cargarObjeto($param);
        if ($elObjCompraEstado!=null and $elObjCompraEstado->insertar()){
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
            $elObjtCompraEstado = $this->cargarObjetoConClave($param);
            if ($elObjtCompraEstado!=null and $elObjtCompraEstado->eliminar()){
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
            $elObjtCompraEstado = $this->cargarObjeto($param);
            if($elObjtCompraEstado!=null && $elObjtCompraEstado->modificar()){
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
            if  (isset($param['idcompraestado']))
                $where.=" and idcompraestado =".$param['idcompraestado'];
            if  (isset($param['idcompra']))
                 $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['idcompraestadotipo']))
            $where.=" and idcompraestadotipo ='".$param['idcompraestadotipo']."'";
            if  (isset($param['cefechaini']))
            $where.=" and cefechaini ='".$param['cefechaini']."'";
            if  (isset($param['cefechafin']))
            $where.=" and cefechafin ='".$param['cefechafin']."'";
        }
        $arreglo = CompraEstado::listar($where);  
        return $arreglo; 
    }
}
?>