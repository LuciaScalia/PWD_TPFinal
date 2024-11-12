<?php

class CompraEstadoTipo extends BaseDatos{
    private $idcompraestadotipo;
    private $cetdescripcion;
    private $cetdetalle;
    private $mensaje_operacion;

    public function __construct() {
        parent::__construct();
        $this->idcompraestadotipo = "";
        $this->cetdescripcion = "";
        $this->cetdetalle = "";
    }

    public function setear($idcompraestadotipo, $cetdescripcion, $cetdetalle) {
        $this->set_idcompraestadotipo($idcompraestadotipo);
        $this->set_cetdescripcion($cetdescripcion);
        $this->set_cetdetalle($cetdetalle);
    }

    public function get_idcompraestadotipo() {
        return $this->idcompraestadotipo;
    }
    public function get_cetdescripcion() {
        return $this->cetdescripcion;
    }
    public function get_cetdetalle() {
        return $this->cetdetalle;
    }
    public function get_mensajeoperacion() {
        return $this->mensaje_operacion;
    }

    public function set_idcompraestadotipo($idcompraestadotipo) {
        $this->idcompraestadotipo = $idcompraestadotipo;
    }
    public function set_cetdescripcion($cetdescripcion) {
        $this->cetdescripcion = $cetdescripcion;
    }
    public function set_cetdetalle($cetdetalle) {
        $this->cetdetalle = $cetdetalle;
    }
    public function set_mensajeoperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM compraestadotipo WHERE idcompraestadotipo = '".$this->get_idcompraestadotipo()."'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    //$resp = true;
                }
            }
        } else {
            $this->set_mensajeoperacion("compraestadotipo->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO compraestadotipo(`cetdescripcion`, `cetdetalle`) 
        VALUES('".$this->get_cetdescripcion()."', '".$this->get_cetdetalle()."');";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compraestadotipo->insertar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraestadotipo->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql = "UPDATE compraestadotipo SET `cetdescripcion` = '".$this->get_cetdescripcion()."', `cetdetalle` = '".$this->get_cetdetalle()."'
        WHERE `idcompraestadotipo` = '".$this->get_idcompraestadotipo()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compraestadotipo->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraestadotipo->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM compraestadotipo WHERE `idcompraestadotipo` = '".$this->get_idcompraestadotipo()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("compraestadotipo->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraestadotipo->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $sql="SELECT * FROM compraestadotipo";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $this->Registro()){
                    $obj= new CompraEstado();
                    $this->setear($row['idcompraestadotipo'], $row['cetdescripcion'], $row['cetdetalle']);
                    array_push($arreglo, $obj);       
                }
            }
        } else {
            $this->set_mensajeoperacion("compraestadotipo->listar: ".$this->getError());
        }
        return $arreglo;
    }
}