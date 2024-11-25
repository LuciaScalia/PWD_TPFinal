<?php
$titulo = "Lista de usuarios";
include_once("../../Estructura/cabeceraBT.php");

$abmUsuario = new AbmUsuario();
$usuarios = $abmUsuario->buscar(null);
$todosLosUs = "";
foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    $estado =  $usdeshabilitado ? "Habilitar" : "Deshabilitar";
    $inputValue = date('Y-m-d H:i:s');
    if ($estado == "Habilitar") {
        $inputValue = null;
    } 
    $todosLosUs .= "
    <tr data-id='".$unUsuario->get_idusuario()."' 
        data-usnombre='".$unUsuario->get_usnombre()."' 
        data-usmail='".$unUsuario->get_usmail()."' 
        data-uspass='".$unUsuario->get_uspass()."' 
        data-usdeshabilitado='".$usdeshabilitado."'>
        <td>".$unUsuario->get_idusuario()."</td>
        <td>".$unUsuario->get_usnombre()."</td>
        <td>".$unUsuario->get_usmail()."</td>
        <td class='estado'>".$usdeshabilitado."</td>
        <td><input class='btn btn-primary botonEstado' type='button' data-usdeshabilitado='".$inputValue."' value='".$estado."'></td>
    </tr>";
}
?>

<div>
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
        <?php
            echo $todosLosUs;
        ?>
    </table>
</div>
<script>
    $('.botonEstado').click(function() {
    // Get the parent <tr> of the clicked button
    var $tr = $(this).closest('tr');
    
    // Retrieve all the data attributes from the <tr>
    var idusuario = $tr.data('id');
    var usnombre = $tr.data('usnombre');
    var usmail = $tr.data('usmail');
    var uspass = $tr.data('uspass');
    var usdeshabilitado = $(this).data('usdeshabilitado');
    
    // Determine the action based on the button value
    var accion = $(this).val();
    
    // Create a data object to send via AJAX
    var datos = {
        idusuario: idusuario,
        usnombre: usnombre,
        usmail: usmail,
        uspass: uspass,
        usdeshabilitado: usdeshabilitado
    };
    
    // Perform the AJAX request
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
</script>

<?php
include_once("../../Estructura/pie.php")
?>