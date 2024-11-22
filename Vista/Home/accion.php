<?php

include_once '../../configuracion.php';

$abmProducto = new AbmProducto();
$productos = $abmProducto->buscar(null);

if (!empty($productos)) {
    foreach ($productos as $unProducto) {
        if($unProducto->get_procantstock()>0){
         echo "<div class='producto'>
                <img src='../".$unProducto->get_prodetalle()."'alt='".$unProducto->get_pronombre()."'class='imagen-producto'>

                <div class='detalles-producto'>
                    <span id='producto-".$unProducto->get_idproducto()."'>".$unProducto->get_pronombre()."</span><br>
                    <span>$ ".$unProducto->get_proprecio()."</span>
                    <input class='btn btn-primary btn-block agregar-producto ' data-id='".$unProducto->get_idproducto()."'data-nombre='".$unProducto->get_pronombre()."' data-imagen='../".$unProducto->get_prodetalle()."' data-precio='".$unProducto->get_proprecio()."' data-stock='".$unProducto->get_procantstock()."' type='button' value='Agregar'>
                    
                </div>
            </div>";   
        }
        
    }
   
} else {
    echo "No hay productos";
}

