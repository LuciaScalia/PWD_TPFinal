<?php

include_once '../../configuracion.php';

$abmProducto = new AbmProducto();
$productos = $abmProducto->buscar(null);

if (!empty($productos)) {
    foreach ($productos as $unProducto) {
        echo "<div class='producto'>
                <span id=".$unProducto->get_idproducto().">".$unProducto->get_pronombre()."</span>
                <input class='agregar-producto' type='button' value='Agregar'>
             </div>";
    }
    echo $_SESSION['idusuario'];
} else {
    echo "No hay productos";
}