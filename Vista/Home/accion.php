<?php

include_once '../../configuracion.php';

$abmProducto = new AbmProducto();
$productos = $abmProducto->buscar(null);

if (!empty($productos)) {
    foreach ($productos as $unProducto) {
        echo "<div class='producto'>".$unProducto->get_pronombre()."</div>";
    }
}

