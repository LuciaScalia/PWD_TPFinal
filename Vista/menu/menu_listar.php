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
    $menuOperacion .= '<input type="button" name="'.$id.'" id="'.$id.'"value="'.$unmenu->getMenombre().'">';
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
<!--<div id="editar" style="display: none;">
    <input type="hidden" name="usnombre" id="usnombre" value="<?php //echo $us->get_usnombre() ?>">
</div>-->
<script>
    $('#Listarusuarios').click(function() {
        window.location.href = '../Rol/listar_usuarios.php';
    });
    ///////////////
    $('#Editarusuario').click(function() {
        window.location.href = '../Rol/listar_usuarios.php';
    });
    ///////////////
    $('#Gestionarroles').click(function() {
        window.location.href = '../Rol/gestionar_rolusuario.php';
    });
    ///////////////
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
            url: '../Usuario/accion/borrar_usuario.php',
            success: function(data) {
                $('#menu').empty();
                if (data.respuesta) {
                    $('#menu').html('<div><p>Usuario eliminado correctamente</p></div><input type="button" name="finalizar" id="finalizar" value="Aceptar">');
                    $('#finalizar').click(function() {
                        window.location.href = '../Home/index.php?message=Usuario eliminado correctamente';
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