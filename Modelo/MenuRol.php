<?php
class MenuRol extends BaseDatos {
    private $objmenu;
    private $objrol;
    private $mensaje_operacion;
    
    public function __construct(){
        parent::__construct();
        $this->objmenu=new Menu();
        $this->objrol=new Rol();
        $this->usdeshabilitado = "";
    }   

    public function setear ($objmenu,$objrol){
        $this->set_objmenu($objmenu);
        $this->set_objrol($objrol);
    }

    public function get_objmenu(){
        return $this->objmenu;
    }
    public function set_objmenu($objmenu){
        $this->objmenu=$objmenu;
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

    /*public function get_usroldeshabilitado() {
        return $this->usdeshabilitado;
    }
    public function set_usroldeshabilitado($usdeshabilitado) {
        $this->usdeshabilitado = $usdeshabilitado;
    }*/

    public function cargar(){
        $resp = false;
        $sql = "SELECT * FROM menurol WHERE idmenu = '" . $this->get_objmenu()->getIdmenu() . "' AND idrol = " . $this->get_objrol()->get_idrol();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();

                    $objM= new Menu();
                    $objM->setIdmenu($row['idmenu']);
                    $objM->cargar();
                    $objR= new Rol();
                    $objR->set_idrol($row['idrol']);
                    $objR->cargar();
                    $this->setear($objM,$objR);
                    //$resp=true;
                }
            }
        } else {
            $this->set_mensajeoperacion("menurol->listar: ".$this->getError());
        }
        return $resp;   
    }

    public function insertar(){
        $resp=false;
        $sql="INSERT INTO menurol (idmenu, idrol) VALUES ('".$this->get_objmenu()->getIdmenu()."', '".$this->get_objrol()->get_idrol()."')";
        if ($this->Iniciar()){
            if($elid = $this->Ejecutar($sql)){
                $resp=true;
            }else{
                $this->set_mensajeoperacion("menurol->insertar: ".$this->getError());
            }
        }else {
            $this->set_mensajeoperacion("menurol->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql = "UPDATE menurol SET `idmenu` = '".$this->get_objmenu()->getIdmenu()."',`idrol` = '".$this->get_objrol()->get_idrol()."'
        WHERE `idmenu` = '".$this->get_objmenu()->getIdmenu()."' AND `idrol` = ".$this->get_objrol()->get_idrol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("menurol->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("menurol->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM menurol WHERE `idmenu` = '".$this->get_objmenu()->getIdmenu()."' AND `idrol` = ".$this->get_objrol()->get_idrol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("menurol->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("menurol->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $db=new BaseDatos();
        $sql="SELECT * FROM menurol";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $db->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $db->Registro()){

                    $obj= new MenuRol();
                    $obj->get_objmenu()->setIdmenu($row['idmenu']);
                    $obj->get_objrol()->set_idrol($row['idrol']);
                    $obj->cargar();
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("menurol->listar: ".$this->getError());
        }
        return $arreglo;
    }
}

?>