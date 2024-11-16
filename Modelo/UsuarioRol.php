<?php
class UsuarioRol extends BaseDatos {
    private $objusuario;
    private $objrol;
    private $mensaje_operacion;
    
    public function __construct(){
        parent::__construct();
        $this->objusuario=new Usuario();
        $this->objrol=new Rol();
    }   

    public function setear ($objusuario,$objrol){
        $this->set_objusuario($objusuario);
        $this->set_objrol($objrol);
    }

    public function get_objusuario(){
        return $this->objusuario;
    }
    public function set_objusuario($objusuario){
        $this->objusuario=$objusuario;
    }

    public function get_objrol(){
        return $this->objrol;
    }
    public function set_objrol($objrol){
        $this->objrol=$objrol;
    }

    public function get_mensajeoperacion(){
        return $this->mensaje_operacion;
    }
    public function set_mensajeoperacion($valor){
        $this->mensaje_operacion = $valor;
    }

    public function cargar(){
        $resp = false;
        $sql = "SELECT * FROM usuariorol WHERE idusuario = '" . $this->get_objusuario()->get_idusuario() . "' AND idrol = " . $this->get_objrol()->get_idrol();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();

                    $objU= new Usuario();
                    $objU->set_idusuario($row['idusuario']);
                    $objU->cargar();
                    $objR= new Rol();
                    $objR->set_idrol($row['idrol']);
                    $objR->cargar();
                    $this->setear($objU,$objR);
                    $resp=true;
                }
            }
        } else {
            $this->set_mensajeoperacion("usuariorol->listar: ".$this->getError());
        }
        return $resp;   
    }

    public function insertar(){
        $resp=false;
        $sql="INSERT INTO usuariorol (idusuario, idrol)
        VALUES ('".$this->get_objusuario()->get_idusuario()."', '".$this->get_objrol()->get_idrol()."')";
        if ($this->Iniciar()){
            if($elid = $this->Ejecutar($sql)){
                $resp=true;
            }else{
                $this->set_mensajeoperacion("usuariorol->insertar: ".$this->getError());
            }
        }else {
            $this->set_mensajeoperacion("usuariorol->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM usuariorol WHERE `idusuario` = '".$this->get_objusuario()->get_idusuario()."' AND idrol = ".$this->get_objrol()->get_idrol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("usuariorol->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("usuariorol->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $db=new BaseDatos();
        $sql="SELECT * FROM usuariorol";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $db->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $db->Registro()){
                    $obj= new UsuarioRol();
                    $obj->get_objusuario()->set_idusuario($row['idusuario']);
                    $obj->get_objrol()->set_idrol($row['idrol']);
                    $obj->cargar();
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("usuariorol->listar: ".$this->getError());
        }
        return $arreglo;
    }
    
    
}

?>