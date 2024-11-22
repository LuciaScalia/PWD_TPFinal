<?php
$titulo = "Gestionar rol de usuario";
include_once("../Estructura/cabeceraBT.php");
$abmUsuario = new AbmUsuario();
$abmUsuarioRol = new abmUsuarioRol();
$usuarios = $abmUsuario->buscar(null);
$usActivos = "";
foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    $usrol = $abmUsuarioRol->buscar(['idusuario'=>$unUsuario->get_idusuario()]);
    if (!empty($usrol)) {
        $usrol = $usrol[0]->get_objrol()->get_idrol();
    }
    if ($usdeshabilitado == null && $usrol != 2) {
        $usActivos .= '
        <tr id="' . $unUsuario->get_idusuario() . '">
            <td>' . $unUsuario->get_idusuario() . '</td>
            <td>' . $unUsuario->get_usnombre() . '</td>
            <td>' . $unUsuario->get_usmail() . '</td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-' . $unUsuario->get_idusuario() . '">Asignar</button>
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
        // Find the closest modal and then find the select within it
        var modal = $(this).closest('.modal');
        var roleSelect = modal.find('.role-select');
        
        // Get the selected role and user ID
        var idrol = roleSelect.val(); // Get the selected value from the dropdown
        var idusuario = roleSelect.data('usuario'); // Get the usuario from data attribute
        
        // Prepare data for AJAX request
        var datos = { idrol: idrol, idusuario: idusuario };
        alert(datos);
        $.ajax({
            data: datos,
            type: 'POST',
            dataType: 'json',
            url: 'accion/gestionar_rolusuario.php',
            success: function(data) {
                if (data.respuesta) {
                    $('#mensaje').html('<p>La acción fue ejecutada correctamente</p>');
                } else {
                    $('#mensaje').html('<p>' + data.errorMsg + '</p>');
                }
                modal.modal('hide');
            },
        });
    });
});
</script>

<?php
include_once("../Estructura/pie.php")
?>
               