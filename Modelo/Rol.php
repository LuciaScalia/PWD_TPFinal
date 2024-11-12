<?php

class Rol extends BaseDatos {
    private $idrol;
    private $rodescripcion;
    private $mensaje_operacion;

    public function __construct() {
        parent::__construct();
        $this->idrol = "";
        $this->rodescripcion = "";
    }

    public function setear($idrol, $rodescripcion) {
        $this->set_idrol($idrol);
        $this->set_rodescripcion($rodescripcion);
    }

    public function get_idrol() {
        return $this->idrol;
    }
    public function get_rodescripcion() {
        return $this->rodescripcion;
    }
    public function get_mensajeoperacion() {
        return $this->mensaje_operacion;
    }

    public function set_idrol($idrol) {
        $this->idrol = $idrol;
    }
    public function set_rodescripcion($rodescripcion) {
        $this->rodescripcion = $rodescripcion;
    }
    public function set_mensajeoperacion($mensaje_operacion) {
        $this->mensaje_operacion = $mensaje_operacion;
    }

    public function cargar(){
        $resp = false;
        $sql="SELECT * FROM rol WHERE idrol = '".$this->get_idrol()."'";
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if($res>-1){
                if($res>-1){
                    $row = $this->Registro();
                    $this->setear($row['idrol'], $row['rodescripcion']);
                    //$resp = true;
                }
            }
        } else {
            $this->set_mensajeoperacion("rol->listar: ".$this->getError());
        }
        return $resp;
    }

    public function insertar(){
        $resp = false;
        $sql="INSERT INTO rol(`idrol`, `rodescripcion`) 
              VALUES('".$this->get_idrol()."', '".$this->get_rodescripcion()."'";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("rol->insertar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("rol->insertar: ".$this->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $sql = "UPDATE rol SET `rodescripcion` = '".$this->get_usnombre()."' WHERE `idrol` = '".$this->get_idrol()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->set_mensajeoperacion("rol->modificar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("rol->modificar: ".$this->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $sql="DELETE FROM rol WHERE `idrol` = '".$this->get_idrol()."'";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                return true;
            } else {
                $this->set_mensajeoperacion("rol->eliminar: ".$this->getError());
            }
        } else {
            $this->set_mensajeoperacion("rol->eliminar: ".$this->getError());
        }
        return $resp;
    }

    public static function listar($parametro=""){
        $arreglo = array();
        $sql="SELECT * FROM rol";
        if ($parametro!="") {
           $sql.=' WHERE '.$parametro;
        }
        $res = $this->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                while ($row = $this->Registro()){
                    $obj= new Rol();
                    $obj->setear($row['idrol'], $row['rodescripcion']);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->set_mensajeoperacion("rol->listar: ".$this->getError());
        }
        return $arreglo;
    }
}