<?php
$titulo = "Lista de usuarios";
include_once("../../Estructura/cabeceraBT.php");

$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new AbmUsuarioRol();
$session = new Session();
$usrol = $session->getRol();
$usidrol = $usrol->get_idrol();

$pag = "listarusuarios";
$resp = $abmUsuarioRol->permisosPagina($usidrol, $pag);

if ($resp) {
    $usuarios = $abmUsuario->buscar(null);
    $todosLosUs = "";
    foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    $habilitado = $usdeshabilitado == null || $usdeshabilitado == "0000-00-00 00:00:00" ? true : false;
    $tdEstado = $habilitado ? "Habilitado" : $usdeshabilitado;
    $todosLosUs .= "
    <tr data-id='".$unUsuario->get_idusuario()."' 
        data-usnombre='".$unUsuario->get_usnombre()."' 
        data-usmail='".$unUsuario->get_usmail()."' 
        data-uspass='".$unUsuario->get_uspass()."' 
        data-usdeshabilitado='".$usdeshabilitado."'>
        <td>".$unUsuario->get_idusuario()."</td>
        <td>".$unUsuario->get_usnombre()."</td>
        <td>".$unUsuario->get_usmail()."</td>
        <td id='estado'>".$tdEstado."</td>
        <td><input class='btn btn-success botonEstado' type='button' value='Habilitar' " . ($habilitado ? "disabled" : "") . ">  
            <input class='btn btn-danger botonEstado' type='button' value='Deshabilitar' " . ($habilitado ? "" : "disabled") . "></td>
    </tr>";
}

echo '<div>
        <b>Usuarios</b>
        <table class="table table-striped table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Mail</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
                '.$todosLosUs.'
        </table>
    </div>';
} else {
    echo("<script>location.href = '../Home/index.php'</script>");
}
?>

<script>
    $('.botonEstado').click(function() {

    var $tr = $(this).closest('tr');
    var idusuario = $tr.data('id');
    var usnombre = $tr.data('usnombre');
    var usmail = $tr.data('usmail');
    var uspass = $tr.data('uspass');
    var usdeshabilitado = $(this).data('usdeshabilitado');
    
    var accion = $(this).val();

    var estado = $('#estado');
    if (accion == "Habilitar") {
        estado = "Habilitado";
        usdeshabilitado = null;
    } else {
        var fechaActual = new Date();
        var formatoFecha = fechaActual.toISOString().slice(0, 19).replace('T', ' ');
        estado = formatoFecha;
        usdeshabilitado = formatoFecha;
    }
    var datos = {
        idusuario: idusuario,
        usnombre: usnombre,
        usmail: usmail,
        uspass: uspass,
        usdeshabilitado: usdeshabilitado
    };

    //alert(JSON.stringify(datos));
    $.ajax({
        data: datos,
        type: 'POST',
        dataType: 'json',
        url: '../Usuario/accion/estado_usuario.php',
        success: function(data) {
            if (data.respuesta) {
                alert('Usuario actualizado correctamente.');
                $('#estado').html(estado);
            } else {
                alert('Error al actualizar el usuario.');
            }
        }
    });
});
</script>

<?php
include_once("../../Estructura/pie.php")
?>