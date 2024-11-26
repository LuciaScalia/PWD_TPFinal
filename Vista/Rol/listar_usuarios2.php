<?php
$titulo = "Lista de usuarios";
include_once("../../Estructura/cabeceraBT.php");

$abmUsuario = new AbmUsuario();
$usuarios = $abmUsuario->buscar(null);
$todosLosUs = "";
foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    $accionDisp =  $usdeshabilitado == null || $usdeshabilitado == "0000-00-00 00:00:00"? "Deshabilitar" : "Habilitar";
    $estado = $accionDisp == "Deshabilitar" ? "Habilitado" : $usdeshabilitado;
    $valorEstadoCambio = $estado == "Habilitado" ? date('Y-m-d H:i:s') : null;

    $todosLosUs .= "
    <tr data-id='".$unUsuario->get_idusuario()."' 
        data-usnombre='".$unUsuario->get_usnombre()."' 
        data-usmail='".$unUsuario->get_usmail()."' 
        data-uspass='".$unUsuario->get_uspass()."' 
        data-valorestadocambio='".$valorEstadoCambio."'>
        <td>".$unUsuario->get_idusuario()."</td>
        <td>".$unUsuario->get_usnombre()."</td>
        <td>".$unUsuario->get_usmail()."</td>
        <td>".$estado."</td>
        <td><input class='btn btn-primary botonEstado' type='button' value='".$accionDisp."'></td>
    </tr>";
}
?>

<div>
    <b>Usuarios</b>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Mail</th>
                <th>Estado</th>
                <!--<th>Rol</th>-->
                <th></th>
            </tr>
        </thead>
        <?php
            echo $todosLosUs;
        ?>
    </table>
</div>
<script>
    $(document).ready(function() {
    $('.botonEstado').click(function() {
    //tr más cercano al botón clickeado
    var $tr = $(this).closest('tr');
    
    //Todos los datos del tr
    var idusuario = $tr.data('id');
    var usnombre = $tr.data('usnombre');
    var usmail = $tr.data('usmail');
    var uspass = $tr.data('uspass');
    var usdeshabilitado = $tr.data('valorestadocambio');
    alert(usdeshabilitado);

    var datos = {
        idusuario: idusuario,
        usnombre: usnombre,
        usmail: usmail,
        uspass: uspass,
        usdeshabilitado: usdeshabilitado
    };
    $.ajax({
        data: datos,
        type: 'POST',
        dataType: 'json',
        url: '../Usuario/accion/estado_usuario.php',
        success: function(data) {
            if (data.respuesta) {
                alert('Usuario actualizado correctamente.');
                // Update the button value based on the new state
                //var newButtonValue = (accion === "Habilitar") ? "Deshabilitar" : "Habilitar";
                //$(this).val(newButtonValue); // Update the button value
            } else {
                alert('Error al actualizar el usuario.');
            }
        }
    });
});
});
</script>

<?php
include_once("../../Estructura/pie.php");
?>