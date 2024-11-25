<?php
$titulo = "Lista de usuarios";
include_once("../../Estructura/cabeceraBT.php");

$abmUsuario = new AbmUsuario();
$usuarios = $abmUsuario->buscar(null);
$todosLosUs = "";
foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    $inputValue =  $usdeshabilitado ? "Habilitar" : "Deshabilitar";
    if($usdeshabilitado==null) {
        $usdeshabilitado = "Habilitado";
    }
        $todosLosUs .= "
    <tr>
        <td>".$unUsuario->get_idusuario()."</td>
        <td>".$unUsuario->get_usnombre()."</td>
        <td>".$unUsuario->get_usmail()."</td>
        <td class='estado'>".$usdeshabilitado."</td>
        <td><input class='btn btn-primary botonEstado' type='button' data-id='".$unUsuario->get_idusuario()."' value='".$inputValue."'></td>
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
        var accion = $(this).val();
        var idusuario = $(this).data('id');
        var datos = {
            accion: accion,
            idusuario: idusuario
        }
        //console.log("Datos:", datos);
        $.ajax({
            data: datos,
            type: 'POST',
            dataType: 'json',
            url: 'accion/estado_usuario.php',
            success: function(data) {
                //var newButtonValue = newState === "Habilitar" ? "Deshabilitar" : "Habilitar";
                //$('#'+usId).val(newButtonValue);
            },
        });
    });
</script>

<?php
include_once("../../Estructura/pie.php")
?>