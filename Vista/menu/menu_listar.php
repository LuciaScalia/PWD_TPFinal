<?php
$titulo = "Inicio";
include_once("../../Estructura/cabeceraBT.php");


$session = new Session();
$ambMenuRol = new AbmMenuRol();
$abmMenu = new AbmMenu();
$us = $session->getUsuario();
$usrol = $session->getRol();
$usrolnombre = $usrol->get_rodescripcion();
$menurol = $ambMenuRol->buscar(['idrol'=>$usrol->get_idrol()]);

$menuOperacion = "<tr>";
foreach($menurol as $unmenu) {
    $unmenu = $unmenu->get_objmenu();
    $id = str_replace(' ', '', $unmenu->getMenombre());
    $menuOperacion .= '<input class="btn btn-primary" type="button" name="'.$id.'" id="'.$id.'"value="'.$unmenu->getMenombre().'">';
}
?>
<!--<a href='".$unmenu->getMedescripcion().-->
<form name="us" id="us" style="display: none;">
    <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $us->get_idusuario() ?>">
    <input type="hidden" name="usnombre" id="usnombre" value="<?php echo $us->get_usnombre() ?>">
    <input type="hidden" name="usmail" id="usmail" value="<?php echo $us->get_usmail() ?>">
    <input type="hidden" name="uspass" id="uspass" value="<?php echo $us->get_uspass() ?>">
    <input type="hidden" name="usdeshabilitado" id="usdeshabilitado" value="<?php echo $us->get_usdeshabilitado() ?>">
</form>
<div id="menu">
    <b>Permisos de <?php echo $usrolnombre; ?></b><br>
    <table>
        <form>
            <?php echo $menuOperacion; ?>
            </tr>
        </form>
    </table>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Editar
</button>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label class="form-label text-muted" for="usnombremodal">Usuario</label>
        <input type="text" name="usnombremodal" id="usnombremodal" class="form-control" required>
        <!---->
        <label class="form-label text-muted" for="usmailmodal">Mail</label>
        <input type="email" name="usmailmodal" id="usmailmodal" class="form-control" required>
        <!---->
        <label class="form-label text-muted" for="uspassmodal">Contraseña</label>
        <input type="password" name="uspassmodal" id="uspassmodal" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script>
    $('#Listarusuarios').click(function() {
        window.location.href = '../Rol/listar_usuarios.php';
    });

    $('#Editarusuario').click(function() {
        var usnombre = $('#usnombre').val();
        $('#usnombremodal').val(usnombre);
    });
    
    $('#Gestionarroles').click(function() {
        window.location.href = '../Rol/rolusuario_gestionar.php';
    });
    
    $('#Eliminarcuenta').click(function() {
        var fechaActual = new Date();
        var formatoFecha = fechaActual.toISOString().slice(0, 19).replace('T', ' ');
        var datos = {
        idusuario: $('#idusuario').val(),
        usnombre: $('#usnombre').val(),
        usmail: $('#usmail').val(),
        uspass: $('#uspass').val(),
        usdeshabilitado: formatoFecha
        };
        $.ajax({
            data: datos,
            type: 'POST',
            dataType: 'json',
            url: '../Usuario/accion/eliminar_usuario.php',
            success: function(data) {
                $('#menu').empty();
                if (data.respuesta) {
                   $('#menu').html('<div><p>Usuario eliminado correctamente</p></div><input type="button" name="finalizar" id="finalizar" value="Aceptar">');
                    $('#finalizar').click(function() {
                        window.location.href = '../Login/index.php';
                    });
                } else {
                    $('#menu').html('<div><p>' + data.errorMsg + '</p></div>');
                }
            },
        });
    });
</script>
<?php
include_once("../../Estructura/pie.php")
?>