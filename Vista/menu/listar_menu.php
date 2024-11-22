<?php
$titulo = "Inicio";
include_once("../Estructura/cabeceraBT.php");
$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new AbmUsuarioRol();
$usuario = $_SESSION['idusuario'];
$rol = $abmUsuarioRol->buscar(['idusuario'=>$_SESSION['idusuario']]);
/*$rol = $rol[0]->get_objrol();
$rolDescripcion = $rol->get_rodescripcion();*/
//print_r($rol->get_idrol());
?>

<input id="idusuario" name ="idusuario" value="<?php echo $usuario?>" type="hidden">
<table id="permisos">
    <th>Permisos de <?php /*echo $rolDescripcion;*/ ?></th>
    <tr>
        <td><input type="button" name="editar" id="editar" value="Editar"></td>
        <td><input type="button" name="borrar" id="borrar" value="Eliminar cuenta" onclick="borrarUsuario()"></td>
    </tr>
</table>
<form name="formEditar" id="formEditar" method="post" action="../Usuario/accion/editar_usuario.php" style="display:none;">
    <label class="form-label text-muted" for="usnombre">Usuario nuevo</label>
    <input type="text" name="usnombre" id="usnombre" class="form-control"><br>
    <!---->
    <label class="form-label text-muted" for="usmail">Mail nuevo</label>
    <input type="email" name="usmail" id="usmail" class="form-control"><br>
    <!---->
    <label class="form-label text-muted" for="uspass">Contraseña nueva</label>
    <input type="password" name="uspass" id="uspass" class="form-control"><br><br>
    <div class="d-flex justify-content-center">
    <input id="editar" type="submit" class="btn btn-primary btn-block" value="Editar">
    </div>
    <br>
</form>
<div id="respuesta"></div>
<script>
    $('#editar').click(function() {
        $('#formEditar').show();
    })
    function borrarUsuario() {
        var usuario = $('#idusuario').serialize();
        alert(usuario);
        $.ajax({
            data: usuario,
            type: 'POST',
            dataType: 'json',
            url: '../Usuario/accion/borrar_usuario.php',
            success: function(data) {
                    if (data.respuesta) {
                        $('#respuesta').html('<div><p>Usuario borrado correctamente</p></div>');
                    } else {
                        $('#respuesta').html('<div><p>' + data.errorMsg + '</p></div>');
                    }
                }
        });
    }
   /*$(document).ready(function() {
        $('#editar').click(function(evento) {
            evento.preventDefault();
            formSubmit();
            var datosForm = $('#formUsuario').serialize();

            $.ajax({
            data: datosForm,
            type: 'POST',
            dataType: 'json',
            url: '../Usuario/accion/editar_usuario.php',
            success: function(data) {
                    $('#formEditar').empty();
                    if (data.respuesta) {
                        $('#formEditar').html('<div><p>Usuario creado correctamente</p><a href="../Login/index.php"><input type="button" value="Ingresar"></a></div>');
                    } else {
                        $('#formEditar').html('<div><p>' + data.errorMsg + '</p></div>');
                    }
                }
            });
        });
   });*/
</script>
<?php
include_once("../Estructura/pie.php");
?>