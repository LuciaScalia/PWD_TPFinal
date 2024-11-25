<?php
$titulo = "Gestionar rol de usuario";
include_once("../../Estructura/CabeceraBT.php");

$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new abmUsuarioRol();
$usuarios = $abmUsuario->buscar(null);

$usActivos = "";
foreach ($usuarios as $unUsuario) {
    $estado = $unUsuario->get_usdeshabilitado();
    if ($estado == null) {
        $idRol = "sinrol";
        $usRol = $abmUsuarioRol->buscar(['idusuario'=>$unUsuario->get_idusuario()]);
        $rolesBoton = "
        <input type='button' class='btn btn-primary cliente' data-rol='1' value='Cliente'>
        <input type='button' class='btn btn-primary deposito' data-rol='3' value='Dep&oacute;sito'>
        <input type='button' class='btn btn-primary administrador' data-rol='2' value='Admin'>";

        if (!empty($usRol)) {
            $idRol = $usRol[0]->get_objrol()->get_idrol();
            $rolNombre = $usRol[0]->get_objrol()->get_rodescripcion();
            $cliente = ($rolNombre == "cliente") ? true : false;
            $deposito = ($rolNombre == "deposito") ? true : false;
            $admin = ($rolNombre == "administrador") ? true : false;

            $rolesBoton = "
            <input type='button' class='btn btn-primary cliente' data-rol='1' value='Cliente' " . ($cliente ? "disabled" : "") . ">
            <input type='button' class='btn btn-primary deposito' data-rol='3' value='Dep&oacute;sito' " . ($deposito ? "disabled" : "") . ">
            <input type='button' class='btn btn-primary administrador' data-rol='2' value='Admin' " . ($admin ? "disabled" : "") . ">";
        }
        $usActivos .=
        "<tr 
        data-id=".$unUsuario->get_idusuario()."
        data-idrol=".$idRol.">
            <td>".$unUsuario->get_idusuario()."</td>
            <td>".$unUsuario->get_usnombre()."</td>
            <td>".$unUsuario->get_usmail()."</td>
            <td colspan='3'>".$rolesBoton."</td>
        </tr>";
    }
}
?>

<div id="mensaje"></div>
<div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Mail</th>
                <th></th>
            </tr>
        </thead>
        <?php
            echo $usActivos;
        ?>
    </table>
</div>

<script>
    $(document).ready(function() {
    // Event listener para cuando clickeo un botón
    $('.btn-primary').on('click', function() {
        var dataRol = $(this).data('rol'); //data-rol del botón clickeado
        var $tr = $(this).closest('tr');
        var idUsuario = $tr.data('id');
        var idRol = $tr.data('idrol');

        /*console.log('Data Rol:', dataRol);
        console.log('ID Usuario:', idUsuario);
        console.log('ID Rol:', idRol);*/

        $.ajax({
            data: {
                idusuario: idUsuario,
                idrol: idRol,
                datarol: dataRol
            },
            type: 'POST',
            dataType: 'json',
            url: 'accion/gestionar_rolusuario.php',
            success: function(response) {
                // Handle the response from the server
                $('#mensaje').html(response);
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error:', status, error);
            }
        });
    });
});
</script>