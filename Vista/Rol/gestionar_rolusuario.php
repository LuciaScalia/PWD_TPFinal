<?php
$titulo = "Gestionar rol de usuario";
include_once("../../Estructura/CabeceraBT.php");
$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new abmUsuarioRol();
$usuarios = $abmUsuario->buscar(null);
$usActivos = "";
foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    $usrol = $abmUsuarioRol->buscar(['idusuario'=>$unUsuario->get_idusuario()]);
    $rolnombre = "sin rol";
    if (!empty($usrol)) {
        $idrol = $usrol[0]->get_objrol()->get_idrol();
        $rolnombre = $usrol[0]->get_objrol()->get_rodescripcion();
    }
    if ($usdeshabilitado == null) {
        $usActivos .= '
        <tr id="' . $unUsuario->get_idusuario() . '">
            <td>' . $unUsuario->get_idusuario() . '</td>
            <td>' . $unUsuario->get_usnombre() . '</td>
            <td>' . $unUsuario->get_usmail() . '</td>
            <td  data-rolus="' . $unUsuario->get_idusuario() . '">' . $rolnombre . '</td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-' . $unUsuario->get_idusuario() . '">Cambiar</button>
                <div class="modal fade" id="modal-' . $unUsuario->get_idusuario() . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Asignar rol</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <select class="form-control role-select" data-usuario="' . $unUsuario->get_idusuario() . '">
                                    <option value="1" data-rol="1">Cliente</option>
                                    <option value="3" data-rol="3">Depósito</option>
                                    <option value="2" data-rol="2">Admin</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary aceptar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
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
                <th>Rol</th>
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
    $('.aceptar').click(function() {
        var modal = $(this).closest('.modal');
        var rolSelect = modal.find('.role-select');
    
        var idrol = rolSelect.val();
        var idusuario = rolSelect.data('usuario');
        var datos = { idrol: idrol, idusuario: idusuario };
        alert(idusuario);
        $.ajax({
            data: datos,
            type: 'POST',
            dataType: 'json',
            url: 'accion/gestionar_rolusuario.php',
            success: function(data) {
                if (data.respuesta) {
                    
                } else {
                    $('#mensaje').html('<p>' + data.errorMsg + '</p>');
                }
            },
        });
    });
});
</script>

<?php
include_once("../../Estructura/pie.php")
include_once("../../Estructura/pie.php")
?>
               