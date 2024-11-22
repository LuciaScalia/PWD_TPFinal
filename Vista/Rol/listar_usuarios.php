<?php
$titulo = "Lista de usuarios";
include_once("../Estructura/cabeceraBT.php");

$abmUsuario = new AbmUsuario();
$usuarios = $abmUsuario->buscar(null);
$todosLosUs = "";
foreach ($usuarios as $unUsuario) {
    $usdeshabilitado = $unUsuario->get_usdeshabilitado();
    if($usdeshabilitado==null) {
        $usdeshabilitado = "Habilitado";
    }
        $todosLosUs .= "
    <tr>
        <td>".$unUsuario->get_idusuario()."</td>
        <td>".$unUsuario->get_usnombre()."</td>
        <td>".$unUsuario->get_usmail()."</td>
        <td>".$usdeshabilitado."</td>
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
                <th>Deshabilitado/habilitado</th>
            </tr>
        </thead>
        <?php
            echo $todosLosUs;
        ?>
    </table>
</div>

<?php
include_once("../Estructura/pie.php")
?>