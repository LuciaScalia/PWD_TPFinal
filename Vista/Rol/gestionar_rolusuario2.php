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
    $gestionar = "Asignar";
    $usnombre = "sin rol";
    if (!empty($usrol)) {
        $idrol = $usrol[0]->get_objrol()->get_idrol();
        $usnombre = $usrol[0]->get_objrol()->get_rodescripcion();
    }
    if ($usdeshabilitado == null) {
        $usActivos .= '
        <tr id=' . $unUsuario->get_idusuario() . '>
            <td>' . $unUsuario->get_idusuario() . '</td>
            <td>' . $unUsuario->get_usnombre() . '</td>
            <td>' . $unUsuario->get_usmail() . '</td>
            <td class"rol">' . $usnombre . '</td>
            <td><button type="button" class="form-control" data-toggle="modal" data-target="#exampleModalCenter"><a href="#" data-rol="Cambiar" data-id='.$unUsuario->get_idusuario().'>Cambiar</a></button></td>
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

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Asignar rol</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label><input type="radio" name="role" value="1" data-rol="1"> Cliente</label>
        <label><input type="radio" name="role" value="3" data-rol="3"> Depósito</label>
        <label><input type="radio" name="role" value="2" data-rol="2"> Admin</label>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        var idusuario; // Variable to store the user ID

        // When the "Cambiar" link is clicked, store the user ID
        $(document).on('click', 'a[data-rol="Cambiar"]', function() {
            idusuario = $(this).data('id'); // Store the user ID
        });

        // When the "Aceptar" button in the modal is clicked
        $('.modal-footer .btn-primary').click(function() {
            var idrol = $('input[name="role"]:checked').val(); // Get the selected role
            var datos = {idusuario: idusuario, idrol: idrol}
            alert("idus: " + idusuario + " idrol: " + idrol);
            $.ajax({
                data: datos,
                type: 'POST',
                dataType: "json",
                url: 'accion/gestionar_rolusuario.php',
                success: function(response) {
                    
                        alert("Role updated successfully!");
                    
                    // Optionally, you can refresh the table or update the UI
                },
            });
        });
    });
</script>

<?php
include_once("../../Estructura/pie.php")
?>
               