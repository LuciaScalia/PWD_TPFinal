<?php
include_once '../Estructura/cabeceraBTNoSegura.php';
?>
</head>
<div id="contenedor" class="container d-flex justify-content-center">
    <div class="col-md-5">
        <br>
        <div class="d-flex justify-content-center">
            <h3>Nuevo usuario</h3>
        </div>
        <div>
            <form name="formUsuario" id="formUsuario" method="post">
                <label class="form-label text-muted" for="usnombre">Usuario</label>
                <input type="text" name="usnombre" id="usnombre" class="form-control" required><br>
                <!---->
                <label class="form-label text-muted" for="usmail">Mail</label>
                <input type="email" name="usmail" id="usmail" class="form-control" required><br>
                <!---->
                <label class="form-label text-muted" for="uspass">Contraseña</label>
                <input type="password" name="uspass" id="uspass" class="form-control" required><br><br>

                <div class="d-flex justify-content-center">
                    <input type="button" id="aceptar" value="Aceptar">
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
        $('#aceptar').click(function() {
            var uspass = encriptar();
            var datosForm = $('#formUsuario').serialize();
        $.ajax({
            data: datosForm,
            url: "accion.php",
            type: "POST",
            success: function(mensaje) {
                $('#contenedor').html(mensaje);
            },
        });
    })
});
function encriptar()
{
    var password =  document.getElementById("uspass").value;
    //alert(password);
    var passhash = CryptoJS.MD5(password).toString();
    //alert(passhash);
    document.getElementById("uspass").value = passhash;
}
</script>