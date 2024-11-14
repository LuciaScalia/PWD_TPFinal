<?php 

class Producto extends BaseDatos{
    private $idproducto;
    private $pronombre;
    private $prodetalle;
    private $procantstock;
    private $mensaje_operacion;

    public function __construct(){
        parent::__construct(); 
        $this->idproducto="";
        $this->pronombre="";
        $this->prodetalle="";
        $this->procantstock="";
        $this->mensaje_operacion="";
    }

    public function setear($idproducto,$pronombre,$prodetalle,$procantstock){
        $this->set_idproducto($idproducto);
        $this->set_pronombre($pronombre);
        $this->set_prodetalle($prodetalle);
        $this->set_procantstock($procantstock);
    }

    public function get_idproducto($idproducto){
        return $this->idproducto;
    }
    public function set_idproducto($idproducto){
        $this->idproducto=$idproducto;
    } 
    public function get_pronombre(){
        return $this->pronombre;
    }
    public function set_pronombre($pronombre){
        $this->pronombre=$pronombre;
    } 
    public function get_prodetalle(){
        return $this->prodetalle;
    }
    public function set_prodetalle($prodetalle){
        $this->prodetalle=$prodetalle;
    } 
    public function get_procantstock(){
        return $this->procantstock;
    }
    public function set_procantstock($procantstock){
        $this->procantstock=$procantstock;
    } 
    public function get_mensajeoperacion(){
        return $this->mensaje_operacion;
    }
    public function set_mensajeoperacion($mensaje_operacion){
        $this->mensaje_operacion=$mensaje_operacion;
    } 

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM producto WHERE idproducto = ".$this->get_idproducto();
        if($this->Iniciar()){
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $this->Registro();
                    $this->setear($row['idproducto'],$row['pronombre'],$row['prodetalle'],$row['procantstock']);
                }
            }
        } else{
            $this->set_mensajeoperacion("producto->listar:".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO producto(idproducto,pronombre,prodetalle,procantstock) VALUES('".$this->get_idproducto()."','".$this->get_pronombre()."','".$this->get_prodetalle()."','".$this->get_procantstock()."');";
        if($this->Iniciar()){
            if($elid = $this->Ejecutar($sql)){
                $this->set_idproducto($elid);
                $resp=true;
            }else{
                $this->set_mensajeoperacion("producto->insertar: ".$this->getError());
            }
        }else{
            $this->set_mensajeoperacion("producto->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql="UPDATE producto SET `pronombre`='".$this->get_pronombre()."',`prodetalle`='".$this->get_prodetalle()."',`procantstock`='".$this->get_procantstock()."' 
        WHERE `idproducto`='".$this->get_idproducto()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("producto->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("producto->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM usuario WHERE `idproducto` ='".$this->get_idproducto()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("producto->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("producto->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $sql="SELECT * FROM producto";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $this->Registro()){
                    $obj= new Producto();
                    $obj->setear($row['idproducto'], $row['pronombre'], $row['prodetalle'], $row['procantstock']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("producto->listar: ".$this->getError());
        }
        return $arreglo;
    }

}

?>