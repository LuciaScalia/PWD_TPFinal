<?php
$titulo = "Listar compras";
include_once("../../Estructura/CabeceraBT.php");   

$session = new Session();
$abmCompra = new AbmCompra();
$abmCompraEstado = new AbmCompraEstado();
$abmCompraEstadoTipo = new AbmCompraEstadoTipo();

$usSession = $session->getUsuario();
$compras = $abmCompra->buscar(null);
//<td>".$estadoTipo[0]->get_cetdescripcion()."</td>
$mostrarCompras = "";
foreach ($compras as $unaCompra) {
    $idCompraEstado = $abmCompraEstado->buscar(['idcompra'=>$unaCompra->get_idcompra()]);
    $idCompraEstadoTipo = $idCompraEstado[0]->get_idcompraestadotipo();
    $estadoTipo = $abmCompraEstadoTipo->buscar(['idcompraestadotipo'=>$idCompraEstadoTipo]);
    print_r($estadoTipo);

    $mostrarCompras .= "
    <tr>
        <td>".$unaCompra->get_idcompra()."</td>
        <td>".$unaCompra->get_cofecha()."</td>
        <td>".$unaCompra->get_idusuario()."</td>
        
        <td></td>
    </tr>";
}
?>

<div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th></th>
            </tr>
        </thead>
        <?php
            echo $mostrarCompras;
        ?>
    </table>
</div>