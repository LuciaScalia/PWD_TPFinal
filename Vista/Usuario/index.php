<?php
include_once '../Estructura/cabeceraBTNoSegura.php';
$datos = data_submitted();
?>

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
                <input type="email" name="usmasil" id="usmail" class="form-control" required><br>
                <!---->
                <label class="form-label text-muted" for="uspass">Contraseña</label>
                <input type="password" name="uspass" id="uspass" class="form-control" required><br><br>

                <div class="d-flex justify-content-center">
                <input id="aceptar" type="button" class="btn btn-primary btn-block" value="Aceptar" onclick="formSubmit('formUsuario','uspass')">
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
        evento.preventDefault(); // Prevent default form submission
        var datosForm = $('#formUsuario').serialize();
        
        $.ajax({
            data: datosForm,
            type: 'POST',
            dataType: 'json',
            url: 'accion/alta_usuario.php',
            success: function(data) {
                $('#contenedor').empty();
                if (data.respuesta) {
                    $('#contenedor').html('<div><p>Usuario creado correctamente</p><a href="../Login/index.php"><input type="button" value="Ingresar"></a></div>');
                } else {
                    $('#contenedor').html('<div><p>' + data.errorMsg + '</p></div>');
                }
            }
            error: function(jqXHR, textStatus, errorThrown) {
                $('#contenedor').html('<div><p>Error en la solicitud: ' + textStatus + '</p></div>');
            }
        });
    });
});
</script>
<?php
include_once '../Estructura/footer.php';
?>