<?php
include_once '../../Estructura/cabeceraBTNoSegura.php';
//$datos = data_submitted();
?>

<div id="contenedor">
    <div class="col-md-10">
        <br>
        <div>
            <h3>Registrarse</h3><br>
        </div>
        <div>
            <form name="formUsuario" id="formUsuario" method="post">
                <label class="form-label text-muted" for="usnombre">Usuario</label>
                <input type="text" name="usnombre" id="usnombre" class="form-control" placeholder="Usuario" required><br>
                <!---->
                <label class="form-label text-muted" for="usmail">Mail</label>
                <input type="email" name="usmail" id="usmail" class="form-control" placeholder="Mail" required><br>
                <!---->
                <label class="form-label text-muted" for="uspass">Contraseña</label>
                <input type="password" name="uspass" id="uspass" class="form-control" placeholder="Contraseña" required><br><br>

                <div class="d-flex justify-content-center">
                <input id="aceptar" type="button" class="btn btn-primary btn-block" value="Aceptar">
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
<script src="../js/encriptar.js"></script>
<script>
    $(document).ready(function() {
    $('#aceptar').click(function(evento) {
        evento.preventDefault();
        formSubmit();
        var datosForm = $('#formUsuario').serialize();
        $.ajax({
            data: datosForm,
            type: 'POST',
            dataType: 'json',
            url: 'accion/alta_usuario.php',
            success: function(data) {
                $('#contenedor').empty();
                if (data.respuesta) {
                    $('#contenedor').html('<div><p>Usuario creado correctamente</p></div>');
                } else {
                    $('#contenedor').html('<div><p>' + data.errorMsg + '</p></div>');
                }
            }
        });
    });
});
</script>
<?php
include_once("../../Estructura/pie.php");
?>