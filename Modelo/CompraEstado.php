<?php

class CompraEstado extends BaseDatos{
    private $idcompraestado;
    private $idcompra;
    private $idcompraestadotipo;
    private $cefechaini;
    private $cefechafin;
    private $mensaje_operacion;

    public function __construct() {
        parent::__construct();
        $this->idcompraestado = "";
        $this->idcompra = "";
        $this->idcompraestadotipo = "";
        $this->cefechaini = "";
        $this->cefechafin = "";
    }

    public function setear($idcompraestado, $idcompra, $idcompraestadotipo, $cefechaini, $cefechafin) {
        $this->set_idcompraestado($idcompraestado);
        $this->set_idcompra($idcompra);
        $this->set_idcompraestadotipo($idcompraestadotipo);
        $this->set_cefechaini($cefechaini);
        $this->set_cefechafin($cefechafin);
    }

    public function get_idcompraestado() {
        return $this->idcompraestado;
    }
    public function get_idcompra() {
        return $this->idcompra;
    }
    public function get_idcompraestadotipo() {
        return $this->idcompraestadotipo;
    }
    public function get_cefechaini() {
        return $this->cefechaini;
    }
    public function get_cefechafin() {
        return $this->cefechafin;
    }
    public function get_mensajeoperacion() {
        return $this->mensaje_operacion;
    }

    public function set_idcompraestado($idcompraestado) {
        $this->idcompraestado = $idcompraestado;
    }
    public function set_idcompra($idcompra) {
        $this->idcompra= $idcompra;
    }
    public function set_idcompraestadotipo($idcompraestadotipo) {
        $this->idcompraestadotipo = $idcompraestadotipo;
    }
    public function set_cefechaini($cefechaini) {
        $this->cefechaini = $cefechaini;
    }
    public function set_cefechafin($cefechafin) {
        $this->cefechafin = $cefechafin;
    }
    public function set_mensajeoperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM compraestado WHERE idcompraestado = '".$this->get_idcompraestado()."'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();
                    $this->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);
                    //$resp = true;
                }
            }
        } else {
            $this->set_mensajeoperacion("compraestado->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO compraestado(`idcompra`, `idcompraestadotipo`, `cefechaini`, `cefechafin`) 
        VALUES('".$this->get_idcompra()."', '".$this->get_idcompraestadotipo()."', '".$this->get_cefechaini()."', '".$this->get_cefechafin()."');";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compraestado->insertar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraestado->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql = "UPDATE compraestado SET `idcompra` = '".$this->get_idcompra()."', `idcompraestadotipo` = '".$this->get_idcompraestadotipo()."', `cefechaini` = '".$this->get_cefechaini()."', `cefechafin` = '".$this->get_cefechafin()."'
        WHERE `idcompra` = '".$this->get_idcompra()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compraestado->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraestado->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM compraestado WHERE `idcompraestado` = '".$this->get_idcompraestado()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("compraestado->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraestado->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $sql="SELECT * FROM compraestado";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $this->Registro()){
                    $obj= new CompraEstado();
                    $this->setear($row['idcompraestado'], $row['idcompra'], $row['idcompraestadotipo'], $row['cefechaini'], $row['cefechafin']);      
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("compraestado->listar: ".$this->getError());
        }
        return $arreglo;
    }
}