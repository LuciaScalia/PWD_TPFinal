<?php

class AbmCompraItem {

    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if(array_key_exists('idcompraitem',$param) && array_key_exists('idproducto',$param) && array_key_exists('idcompra',$param) && array_key_exists('cicantidad',$param)){
            $obj = new CompraItem();
            $obj->setear($param['idcompraitem'], $param['idproducto'], $param['idcompra'], $param['cicantidad']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return CompraItem
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idcompraitem']) ){
            $obj = new CompraEstado();
            $obj->setear($param['idcompraitem'], null, null, null, null);
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
        if (isset($param['idcompraitem']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idcompraitem'] = null;
        $elObjCompraItem = $this->cargarObjeto($param);
        if ($elObjCompraItem!=null and $elObjCompraItem->insertar()){
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
            $elObjCompraItem = $this->cargarObjetoConClave($param);
            if ($elObjCompraItem!=null and $elObjCompraItem->eliminar()){
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
            $elObjCompraItem = $this->cargarObjeto($param);
            if($elObjCompraItem!=null && $elObjCompraItem->modificar()){
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
            if  (isset($param['idcompraitem']))
                $where.=" and idcompraitem =".$param['idcompraitem'];
            if  (isset($param['idproducto']))
                 $where.=" and idproducto ='".$param['idproducto']."'";
            if  (isset($param['idcompra']))
            $where.=" and idcompra ='".$param['idcompra']."'";
            if  (isset($param['cicantidad']))
            $where.=" and cicantidad ='".$param['cicantidad']."'";

        }
        $arreglo = CompraItem::listar($where);  
        return $arreglo; 
    }
}
?>