<?php
$titulo = "Inicio";
include_once("../Estructura/cabeceraBTNoSegura.php");
?>

<<<<<<< HEAD
?>

<<<<<<< HEAD

=======
<?php
include_once("../Estructura/pie.php");
?>
>>>>>>> 01ff08e2316d167063743f5a0c7fed57c16f0d4e

<div id="contenedor">
    <div id="productos"></div>
    <div id="carrito"><input type="button" value="Carrito"><span id="cantProd"></span></div>
</div>
<script>
$(document).ready(function() {  
    $.ajax({
        url: "accion.php",
        success: function(mensaje) {
            $('#productos').html(mensaje);
        },
    });

    var productos = [];

    $('.agregar-producto').click(function() {
        var idProducto = $(this).data('id');
        if (!productos.includes(idProducto)) {
           productos.push(idProducto);
           var producto = div.find('span').text(); 
           $('#carrito').append('<div>ID: ' + idProducto + ' ' + producto + '<input type="number">Cantidad</div>');
        }      
    });    
});
</script>
<?php
include_once("../../Estructura/pie.php");
?>