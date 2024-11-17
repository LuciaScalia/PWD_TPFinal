<?php
$Titulo = "Inicio";
include_once("../Estructura/cabeceraBTNoSegura.php");
?>

<<<<<<< HEAD
?>

<?php
include_once("../Estructura/pie.php");
?>
=======
<div id="contenedor">
    <div id="productos"></div>
</div>
<script>
$(document).ready(function() {  
    $.ajax({
        url: "accion.php",
        success: function(mensaje) {
            $('#productos').html(mensaje);
        },
    });
});
</script>
>>>>>>> 8ac8ca782a7f9c6149ddbf507be802d696575ccc
