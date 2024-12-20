<?php
class AbmProducto {

//Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
 * @param array $param
 * @return Producto
 */
private function cargarObjeto($param){
    $obj = null;
       
    if(array_key_exists('idproducto',$param) && array_key_exists('pronombre',$param) && array_key_exists('prodetalle',$param) && array_key_exists('procantstock',$param) && array_key_exists('proprecio',$param)){
        $obj = new Producto();
        $obj->setear($param['idproducto'], $param['pronombre'], $param['prodetalle'], $param['procantstock'], $param['proprecio']);
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
        
        if(isset($param['idproducto']) ){
            $obj = new Producto();
            $obj->setear($param['idproducto'], null, null, null,null);
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
        if (isset($param['idproducto']))
            $resp = true;
        return $resp;
    }

     /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idproducto'] = null;
        $elObjProducto = $this->cargarObjeto($param);
        if ($elObjProducto!=null and $elObjProducto->insertar()){
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
            $elObjProducto = $this->cargarObjetoConClave($param);
            if ($elObjProducto!=null and $elObjProducto->eliminar()){
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
            $elObjProducto = $this->cargarObjeto($param);
            if($elObjProducto!=null && $elObjProducto->modificar()){
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
            if  (isset($param['idproducto']))
                $where.=" and idproducto =".$param['idproducto'];
            if  (isset($param['pronombre']))
                 $where.=" and pronombre ='".$param['pronombre']."'";
             if  (isset($param['prodetalle']))
             $where.=" and prodetalle ='".$param['prodetalle']."'";
             if  (isset($param['procantstock']))
             $where.=" and procantstock ='".$param['procantstock']."'";
            if(isset($param['proprecio']))
            $where.=" and proprecio ='".$param['proprecio']."'";
        }
        $arreglo = Producto::listar($where);  
        return $arreglo; 
    }

    public function mostrarProductos(){
        $resp=false;
        $productos = $this->buscar(null);
      
        if (!empty($productos)) {
            foreach ($productos as $unProducto) {
                if($unProducto->get_procantstock()>0){
                 
                echo "
                            
                    <div class='producto' style='margin:20px;'>
                        <img src='../".$unProducto->get_prodetalle()."'alt='".$unProducto->get_pronombre()."'class='imagen-producto'>

                        <div class='detalles-producto'>
                            <span id='producto-".$unProducto->get_idproducto()."'>".$unProducto->get_pronombre()."</span><br>
                            <span>$ ".$unProducto->get_proprecio()."</span>
                            <input class='btn btn-primary btn-block agregar-producto ' data-id='".$unProducto->get_idproducto()."'data-nombre='".$unProducto->get_pronombre()."' data-imagen='../".$unProducto->get_prodetalle()."' data-precio='".$unProducto->get_proprecio()."' data-stock='".$unProducto->get_procantstock()."' type='button' value='Agregar'>  
                        </div>
                    </div>";   
                }
                
            }
            $resp=true;
        }
        return $resp;
    }

    
    public function mostrarProductosIndex(){
        $resp=false;
        $productos = $this->buscar(null);
        $sesion=new Session();
        $valido=$sesion->validar();
        if (!empty($productos)) {
            echo "
                        <div id='contenedor'>
                            <div id='productos'>";
            foreach ($productos as $unProducto) {
                if($unProducto->get_procantstock()>0){
                 
                
                        echo " 
                            <div class='producto'>
                                <img src='../".$unProducto->get_prodetalle()."'alt='".$unProducto->get_pronombre()."'class='imagen-producto'>

                                <div class='detalles-producto'>
                                    <span id='producto-".$unProducto->get_idproducto()."'>".$unProducto->get_pronombre()."</span><br>
                                    <span>$ ".$unProducto->get_proprecio()."</span>
                                    <input class='btn btn-primary btn-block agregar-producto ' data-id='".$unProducto->get_idproducto()."'data-nombre='".$unProducto->get_pronombre()."' data-imagen='../".$unProducto->get_prodetalle()."' data-precio='".$unProducto->get_proprecio()."' data-stock='".$unProducto->get_procantstock()."' type='button' value='Agregar' onclick='".($valido ? "" : "redireccionarALogin()")."'>  
                                </div>
                            </div>";   
                }
                
            }
            echo "</div>
            </div>";
            $resp=true;
        }
        return $resp;
    }
}

