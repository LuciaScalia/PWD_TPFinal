<?php

require __DIR__ . '/../Util/vendor/autoload.php'; 
// Verificación de la clase PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
           
    public function EnviarCorreo($mensaje){
         //Crea una instancia de la clase para acceder a sus metodos
        $mail = new PHPMailer(true);

        try {
            //Configuracion del servidor SMTP de Gmail
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host      = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nadiacarrasco83.nc@gmail.com';      //nombre gmail del emisor
            $mail->Password   = 'rnxc pupb kxfh urow';              //contraseña de aplicacion de gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      //para el cifrado TLS
            $mail->Port       = 587; //puerto para SMTP con TLS                             

            //Recipients
            $mail->setFrom('nadiacarrasco83.nc@gmail.com', 'Tienda'); //emisor
            $mail->addAddress('nadia.carrasco@est.fi.uncoma.edu.ar');     //mail receptor

            //Contenido
            $mail->isHTML(true); //envia mail con formato HTML
            $mail->Subject = 'Asunto'; //el asunto del mail
            $mail->Body    = $mensaje; //el contenido del mail
            

            $mail->send();
           
        } catch (Exception $e) {
            echo "Error al enviar. Mailer Error: {$mail->ErrorInfo}"; //si no lo envía, le muestra al desarrollador el error
        }
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
                        $correo="¡Su compra fue ingresada!";     
                        $this->EnviarCorreo($correo);
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
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function actualizarCompra($datosCompra){
        $idcompra = (int)$datosCompra['idcompra']; 
        $cefechafin = $datosCompra['cefechafin']; 
        $idcompraestadotipo = $datosCompra['idcompraestadotipo']; 
        $idcompraestado= $datosCompra['idcompraestado'];
        $accion= $datosCompra['accion'];
        $mensaje=false;
        $compraestado=new AbmCompraEstado();
        $compra=$compraestado->buscar(['idcompra'=>$idcompra]);

        switch($accion){
            case 'confirmar':
               $param=['idcompraestado'=>$idcompraestado,
               'idcompra'=>$idcompra,
               'idcompraestadotipo'=>1,
               'cefechaini'=>$compra[0]->get_cefechaini(),
               'cefechafin'=>$this->fechaActual()];
               $mensaje=$compraestado->modificacion($param);
               if($mensaje){
                    $param=['idcompra'=>$idcompra,'idcompraestadotipo'=>2,'cefechaini'=>$this->fechaActual(),'cefechafin'=>null];
                    $mensaje=$compraestado->alta($param);
                    if($mensaje){
                        $correo="¡Su compra fue confirmada!";
                        $this->EnviarCorreo($correo);
                        $abmCompraItem=new AbmCompraItem();
                        $compraItem=$abmCompraItem->buscar(['idcompra'=>$idcompra]);
                       foreach($compraItem as $item){
                            $idproducto= $item->get_idproducto();
                            $cicantidad= $item->get_cicantidad();
                            $abmProducto=new AbmProducto();
                            $producto=$abmProducto->buscar(['idproducto'=>$idproducto]);
                            if(!empty($producto)){
                                $cant=$producto[0]->get_procantstock();
                                $param=['idproducto'=>$idproducto,
                                'pronombre'=>$producto[0]->get_pronombre(),
                                'prodetalle'=>$producto[0]->get_prodetalle(),
                                'procantstock'=>$cant-$cicantidad,
                                'proprecio'=>$producto[0]->get_proprecio()];
                                $mensaje=$abmProducto->modificacion($param);
                            }
                        }
                    }
                }
                break;
            case 'enviar':
                $compraestados = $compraestado->buscar(['idcompra'=>(int)$datosCompra['idcompra']]);
                $cantcompraestados = count($compraestados);
                $compraestados = $compraestados[$cantcompraestados - 1];
                $param=['idcompraestado'=>$compraestados->get_idcompraestado(), //esto hay q cambiar
               'idcompra'=>$idcompra,
               'idcompraestadotipo'=>2,
               'cefechaini'=>$compra[0]->get_cefechaini(),
               'cefechafin'=>$this->fechaActual()];
               $mensaje=$compraestado->modificacion($param);
               if($mensaje){
                    $param=['idcompra'=>$idcompra,'idcompraestadotipo'=>3,'cefechaini'=>$this->fechaActual(),'cefechafin'=>null];
                    $mensaje=$compraestado->alta($param);
                    if($mensaje){
                        $correo="¡Su compra fue enviada!";
                        $this->EnviarCorreo($correo);
                    }
                }
                break;
            case 'cancelar':
                //ver
                foreach($compra as $unaCompraEstado) {
                    $cefechafin = $unaCompraEstado->get_cefechafin() == null || $unaCompraEstado->get_cefechafin() == "0000-00-00 00:00:00" ? $this->fechaActual() : $unaCompraEstado->get_cefechafin();
                    $param=['idcompraestado'=>$idcompraestado,
                   'idcompra'=>$unaCompraEstado->get_idcompra(),
                   'idcompraestadotipo'=>$unaCompraEstado->get_idcompraestadotipo(),
                   'cefechaini'=>$compra[0]->get_cefechaini(),
                   'cefechafin'=>$cefechafin];
                   $mensaje=$compraestado->modificacion($param);
                }
                
                if($mensaje){
                    $param=['idcompra'=>$idcompra,'idcompraestadotipo'=>5,'cefechaini'=>$this->fechaActual(),'cefechafin'=>$this->fechaActual()];
                    $mensaje=$compraestado->alta($param);
                    if($mensaje){
                        $correo="¡Su compra fue cancelada!";
                        $this->EnviarCorreo($correo);
                        $abmCompraItem=new AbmCompraItem();
                        $compraItem=$abmCompraItem->buscar(['idcompra'=>$idcompra]);
                            foreach($compraItem as $item){
                                $idproducto= $item->get_idproducto();
                                $cicantidad= $item->get_cicantidad();
                                $abmProducto=new AbmProducto();
                                $producto=$abmProducto->buscar(['idproducto'=>$idproducto]);
                                if(!empty($producto)){
                                    $cant=$producto[0]->get_procantstock();
                                    $param=['idproducto'=>$idproducto,
                                    'pronombre'=>$producto[0]->get_pronombre(),
                                    'prodetalle'=>$producto[0]->get_prodetalle(),
                                    'procantstock'=>$cant+$cicantidad,
                                    'proprecio'=>$producto[0]->get_proprecio()];
                                    $mensaje=$abmProducto->modificacion($param);
                                }
                            }
                        }
                }
                 break;
            case 'recibida':
                $compraestados = $compraestado->buscar(['idcompra'=>(int)$datosCompra['idcompra']]);
                $cantcompraestados = count($compraestados);
                $compraestados = $compraestados[$cantcompraestados - 1];
                $param=['idcompraestado'=>$compraestados->get_idcompraestado(), //esto hay q cambiar
               'idcompra'=>$idcompra,
               'idcompraestadotipo'=>3,
               'cefechaini'=>$compra[0]->get_cefechaini(),
               'cefechafin'=>$this->fechaActual()];
               $mensaje=$compraestado->modificacion($param);
               if($mensaje){
                    $param=['idcompra'=>$idcompra,'idcompraestadotipo'=>4,'cefechaini'=>$this->fechaActual(),'cefechafin'=>$this->fechaActual() ];
                    $mensaje=$compraestado->alta($param);
                    if($mensaje){
                        $correo="¡Su compra llegó!";
                        $this->EnviarCorreo($correo);
                    }
                }
                break;
            }
        return [ 'mensaje'=> $mensaje ];
    }
}
?>