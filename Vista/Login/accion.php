<?php
include_once("../../Estructura/cabeceraBTNoSegura.php");
$datos = data_submitted();
$resp = false;


$objSession= new Session();
$respuesta=$objSession->iniciarSesion($datos);

?>
