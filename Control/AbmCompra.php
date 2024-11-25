<?php

class AbmCompra {

    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Compra
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if(array_key_exists('idcompra',$param) && array_key_exists('cofecha',$param) && array_key_exists('idusuario',$param)){
            $obj = new Compra();
            $obj->setear($param['idcompra'], $param['cofecha'], $param['idusuario']);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Compra
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if(isset($param['idcompra']) ){
            $obj = new Compra();
            $obj->setear($param['idcompra'], null, null, null, null);
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
        if (isset($param['idcompra']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        $param['idcompra'] = null;
        $elObjCompra = $this->cargarObjeto($param);
        if ($elObjCompra!=null and $elObjCompra->insertar()){
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
            $elObjtCompra = $this->cargarObjetoConClave($param);
            if ($elObjtCompra!=null and $elObjtCompra->eliminar()){
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
            $elObjtCompra = $this->cargarObjeto($param);
            if($elObjtCompra!=null && $elObjtCompra->modificar()){
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
            if  (isset($param['idcompra']))
                $where.=" and idcompra =".$param['idcompra'];
            if  (isset($param['cofecha']))
                 $where.=" and cofecha ='".$param['cofecha']."'";
             if  (isset($param['idusuario']))
             $where.=" and idusuario ='".$param['idusuario']."'";
        }
        $arreglo = Compra::listar($where);  
        return $arreglo; 
    }

    public function fechaActual(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fechaActual = date('Y-m-d H:i:s');
        return $fechaActual;
    }

    public function ultimoIdCompra(){
        $compras=$this->buscar("");

    }
    
    public function IniciarCompra($productos){
        $sesion=new Session();
        $mensaje="No se pudo iniciar la compra!";
        if($sesion->validar()){
           $usuario=$sesion->getUsuario();
           $idusuario=$usuario->get_idusuario();
            $fechaActual = $this->fechaActual();
            $param=['idusuario'=>$idusuario,'cofecha'=> $fechaActual];
            $compra=$this->alta($param);
            if($compra){
                $compraitem=new AbmCompraItem();
                $compras=$this->buscar("");
                $ultimaCompra=end($compras);
                $idCompra=$ultimaCompra->get_idcompra();
                $objProducto=new AbmProducto();
                foreach($productos as $producto){
                    $idProducto= (int)$producto['id'];
                    $cantidadProduc=(int)$producto['cantidad'];
                    $param2=['idproducto'=>$idProducto,'idcompra'=> $idCompra, 'cicantidad'=> $cantidadProduc];
                    $registroproduc=$compraitem->alta($param2);
                    /*
                    $producEncontrado=$objProducto->buscar(['idproducto'=>$idProducto]);
                    $cantstock=$producEncontrado[0]->get_procantstock();
                    $setCantStock=$producEncontrado[0]->set_procantstock($cantstock-$cantidadProduc);
                    */
                     if (!$registroproduc) { $registroproducExitoso = false; error_log("Error al registrar el producto ID: $idProducto en la compra ID: $idCompra cantidad: $cantidadProduc"); break;}
                }

                if($registroproduc){

                    $compraestado=new AbmCompraEstado();
                    $param3=['idcompra'=>$idCompra,'idcompraestadotipo'=>1,'cefechaini'=>$fechaActual,'cefechafin'=>null];
                    $ingresada=$compraestado->alta($param3);
                    if($ingresada){
                        $mensaje="Compra confirmada!";
                    }else{
                        $mensaje="No se pudo confirmar compra";
                    }
                }else{
                    $mensaje="No se pudo registrar los productos";
                }
            }else{
                $mensaje="No se pudo iniciar la compra";
            }
        }
        return [ 'mensaje'=> $mensaje ];
    }
  /*
    public function AceptarCompra($idusuario,$idCompraEstado){
        $sesion=new Session();
        $mensaje="No se pudo aceptar la compra";
        if($sesion->validar()){
            $compraestado=new AbmCompraEstado();
            $compra=$compraestado->buscar(['idcompraestado'=>$idCompraEstado]);
            if(!empty($compra)){
                $fechaActual=$this->fechaActual();
                $idCompra=$compra->set_cefechafin($fechaActual);
                $compra->set_idcompraestadotipo(2);
            }
        }
        return $mensaje;
    }*/
}
?>