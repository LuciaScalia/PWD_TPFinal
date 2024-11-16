<?php
$Titulo = "Inicio";
include_once("../Estructura/cabeceraBTNoSegura.php");
?>

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