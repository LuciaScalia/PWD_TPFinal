<?php

class CompraItem extends BaseDatos{
    private $idcompraitem;
    private $idproducto;
    private $idcompra;
    private $cicantidad;
    private $mensaje_operacion;

    public function __construct() {
        parent::__construct();
        $this->idcompraitem = "";
        $this->idproducto = "";
        $this->idcompra = "";
        $this->cicantidad = "";
    }

    public function setear($idcompraitem, $idproducto, $idcompra, $cicantidad) {
        $this->set_idcompraitem($idcompraitem);
        $this->set_idproducto($idproducto);
        $this->set_idcompra($idcompra);
        $this->set_cicantidad($cicantidad);
    }

    public function get_idcompraitem() {
        return $this->idcompraitem;
    }
    public function get_idproducto() {
        return $this->idproducto;
    }
    public function get_idcompra() {
        return $this->idcompra;
    }
    public function get_cicantidad() {
        return $this->cicantidad;
    }
    public function get_mensajeoperacion() {
        return $this->mensaje_operacion;
    }

    public function set_idcompraitem($idcompraitem) {
        $this->idcompraitem = $idcompraitem;
    }
    public function set_idproducto($idproducto) {
        $this->idproducto= $idproducto;
    }
    public function set_idcompra($idcompra) {
        $this->idcompra = $idcompra;
    }
    public function set_cicantidad($cicantidad) {
        $this->cicantidad = $cicantidad;
    }
    public function set_mensajeoperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM compraitem WHERE idcompraitem = '".$this->get_idcompraitem()."'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();
                    $this->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    //$resp = true;
                }
            }
        } else {
            $this->set_mensajeoperacion("compraitem->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO compraitem(`idproducto`, `idcompra`, `cicantidad`) 
        VALUES('".$this->get_idproducto()."', '".$this->get_idcompra()."', '".$this->get_cicantidad()."');";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compraitem->insertar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraitem->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql = "UPDATE compraitem SET `idproducto` = '".$this->get_idproducto()."', `idcompra` = '".$this->get_idcompra()."', `cicantidad` = '".$this->get_cicantidad()."'
        WHERE `idcompraitem` = '".$this->get_idcompraitem()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("compraitem->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraitem->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM compraitem WHERE `idcompraitem` = '".$this->get_idcompraitem()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("compraitem->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("compraitem->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $sql="SELECT * FROM compraitem";
        $db=new BaseDatos();
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $db->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $db->Registro()){
                    $obj= new CompraItem();
                    $obj->setear($row['idcompraitem'], $row['idproducto'], $row['idcompra'], $row['cicantidad']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("compraitem->listar: ".$this->getError());
        }
        return $arreglo;
    }
}