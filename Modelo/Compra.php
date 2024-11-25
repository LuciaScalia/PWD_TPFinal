<?php

class Compra extends BaseDatos{
    private $idcompra;
    private $cofecha;
    private $idusuario;
    private $mensaje_operacion;

    public function __construct() {
        parent::__construct();
        $this->idcompra = "";
        $this->cofecha = "";
        $this->idusuario = "";
    }

    public function setear($idcompra, $cofecha, $idusuario) {
        $this->set_idcompra($idcompra);
        $this->set_cofecha($cofecha);
        $this->set_idusuario($idusuario);
    }

    public function get_idcompra() {
        return $this->idcompra;
    }
    public function get_cofecha() {
        return $this->cofecha;
    }
    public function get_idusuario() {
        return $this->idusuario;
    }
    public function get_mensajeoperacion(){
        return $this->mensaje_operacion;
    }

    public function set_idcompra($idcompra) {
        $this->idcompra = $idcompra;
    }
    public function set_cofecha($cofecha) {
        $this->cofecha= $cofecha;
    }
    public function set_idusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    public function set_mensajeoperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM compra WHERE idcompra = '".$this->get_idcompra()."'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();
                    $this->setear($row['idcompra'], $row['cofecha'], $row['idusuario']);
                    //$resp = true;
                }
            }
        } else {
            $this->set_mensajeoperacion("compra->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO compra(`cofecha`, `idusuario`) VALUES('".$this->get_cofecha()."', '".$this->get_idusuario()."');";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compra->insertar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compra->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $db=new BaseDatos();
        $resp = false;
        $sql = "UPDATE compra SET `cofecha` = '".$this->get_cofecha()."', `idusuario` = '".$this->get_idusuario()."'
        WHERE `idcompra` = '".$this->get_idcompra()."'";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compra->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compra->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $db=new BaseDatos();
        $resp = false;
        $sql="DELETE FROM compra WHERE `idcompra` = '".$this->get_idcompra()."'";
        if ($db->Iniciar()) {
            if ($db->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("compra->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compra->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $db=new BaseDatos();
        $arreglo = array();
        $sql="SELECT * FROM compra";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $db->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $db->Registro()){
                    $obj= new Compra();
                    $obj->setear($row['idcompra'], $row['cofecha'], $row['idusuario']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("compra->listar: ".$this->getError());
        }
        return $arreglo;
    }
}