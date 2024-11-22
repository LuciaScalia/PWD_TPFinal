<?php

class Usuario extends BaseDatos{
    private $idusuario;
    private $usnombre;
    private $uspass;
    private $usmail;
    private $usdeshabilitado;
    private $mensaje_operacion;

    public function __construct() {
        parent::__construct();
        $this->idusuario = "";
        $this->usnombre = "";
        $this->uspass = "";
        $this->usmail = "";
        $this->usdeshabilitado = "";
    }

    public function setear($idusuario, $usnombre, $uspass, $usmail, $usdeshabilitado) {
        $this->set_idusuario($idusuario);
        $this->set_usnombre($usnombre);
        $this->set_uspass($uspass);
        $this->set_usmail($usmail);
        if($usdeshabilitado == '0000-00-00 00:00:00')
             $usdeshabilitado = "null";
        $this->set_usdeshabilitado($usdeshabilitado);
    }

    public function get_idusuario() {
        return $this->idusuario;
    }
    public function get_usnombre() {
        return $this->usnombre;
    }
    public function get_uspass() {
        return $this->uspass;
    }
    public function get_usmail() {
        return $this->usmail;
    }
    public function get_usdeshabilitado() {
        return $this->usdeshabilitado;
    }
    public function get_mensajeoperacion(){
        return $this->mensaje_operacion;
    }

    public function set_idusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    public function set_usnombre($usnombre) {
        $this->usnombre= $usnombre;
    }
    public function set_uspass($uspass) {
        $this->uspass = $uspass;
    }
    public function set_usmail($usmail) {
        $this->usmail = $usmail;
    }
    public function set_usdeshabilitado($usdeshabilitado) {
        $this->usdeshabilitado = $usdeshabilitado;
    }
    public function set_mensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM usuario WHERE idusuario = '".$this->get_idusuario()."'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();
                    $this->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    //$resp = true;
                }
            }
        } else {
            $this->set_mensajeoperacion("usuario->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO usuario(`usnombre`, `uspass`, `usmail`) 
              VALUES('".$this->get_usnombre()."', '".$this->get_uspass()."', '".$this->get_usmail()."');";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("usuario->insertar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("usuario->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql = "UPDATE usuario SET `usnombre` = '".$this->get_usnombre()."', `uspass` = '".$this->get_uspass()."', 
        `usmail` = '".$this->get_usmail()."', `usdeshabilitado` = '".$this->get_usdeshabilitado()."'
        WHERE `idusuario` = '".$this->get_idusuario()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("usuario->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("usuario->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM usuario WHERE idusuario=".$this->get_idusuario();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("usuario->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("usuario->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $db = new BaseDatos();
        $sql="SELECT * FROM usuario";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $db->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $db->Registro()){
                    $obj= new Usuario();
                    $obj->setear($row['idusuario'], $row['usnombre'], $row['uspass'], $row['usmail'], $row['usdeshabilitado']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("usuario->listar: ".$db->getError());
        }
        return $arreglo;
    }
}