<?php
$titulo = "Gestionar roles";
include_once("../../Estructura/CabeceraBT.php");

$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new AbmUsuarioRol();
$abmRol = new AbmRol(); // no mostrar administradores
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
            <input type='button' class='btn btn-primary cliente' data-rol='1' value='Cliente' " . ($cliente ? "disabled" : "") . " " . ($admin ? "disabled" : "") . ">
            <input type='button' class='btn btn-primary deposito' data-rol='3' value='Dep&oacute;sito' " . ($deposito ? "disabled" : "") . " " . ($admin ? "disabled" : "") . ">
            <input type='button' class='btn btn-primary administrador' data-rol='2' value='Admin' " . ($admin ? "disabled" : "") . ">";
        }
        $usActivos .=
        "<tr data-id=".$unUsuario->get_idusuario()." data-idrol=".$idRol.">
            <td>".$unUsuario->get_idusuario()."</td>
            <td>".$unUsuario->get_usnombre()."</td>
            <td>".$unUsuario->get_usmail()."</td>
            <td>".$rolesBoton."</td>
        </tr>";
    }
}
?> 

<div>
    <b>Usuarios habilitados</b>
    <div id="mensaje"></div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Mail</th>
                <th>Gestionar</th>
            </tr>
        </thead>
        <?php
            echo $usActivos;
        ?>
    </table>
</div>

<script>
    $(document).ready(function() {
    $('.btn-primary').on('click', function() {
        var $botonClickeado = $(this);
        var $tr = $botonClickeado.closest('tr');
        var $botonDeshabilitado = $tr.find('.btn-primary:disabled'); //Guarda el botón deshabilitado de la fila

        var dataRol = $(this).data('rol'); //data-rol del botón clickeado
        var $tr = $(this).closest('tr');
        var idUsuario = $tr.data('id');
        var idRol = $tr.data('idrol');
        //Deshabilita el botón clickeada
        $botonClickeado.prop('disabled', true);

        $.ajax({
            data: {
                idusuario: idUsuario,
                idrol: idRol,
                datarol: dataRol
            },
            type: 'POST',
            dataType: 'json',
            url: 'accion/gestionar_rolusuario.php',
            success: function(respuesta) {
                    if(respuesta.respuesta) {
                        //Habilita el botón
                    if ($botonDeshabilitado.length) {
                        $botonDeshabilitado.prop('disabled', false);
                    }
                    $('#mensaje').html("La acción se ejecutó correctamente");
                } else {
                    $('#mensaje').html("La acción no pudo concretarse");
                }
            },
        });
    });
});
</script>

<?php
include_once("../../Estructura/pie.php");
?>