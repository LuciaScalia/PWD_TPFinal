<?php
include_once("../../configuracion.php");

$obj= new AbmUsuario();
$us=$obj->buscar(null);
$usA=[];
foreach($us as $u){
    $usd=$u->get_usdeshabilitado();
    var_dump($usd); 

}
//var_dump($usA);