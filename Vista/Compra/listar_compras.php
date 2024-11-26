<?php
$titulo = "Listar compras";
include_once("../../Estructura/CabeceraBT.php");   

$session = new Session();
$abmCompra = new AbmCompra();
$abmCompraEstado = new AbmCompraEstado();
$abmCompraEstadoTipo = new AbmCompraEstadoTipo();

$usSession = $session->getUsuario();
$compras = $abmCompra->buscar(null);

$mostrarCompras = "";

foreach ($compras as $unaCompra) {
    $idCompraEstado = $abmCompraEstado->buscar(['idcompra'=>$unaCompra->get_idcompra()]);
    $idCompraEstadoTipo = $idCompraEstado[0]->get_idcompraestadotipo();
    $estadoTipo = $abmCompraEstadoTipo->buscar(['idcompraestadotipo'=>$idCompraEstadoTipo]);
    $estado=$estadoTipo[0]->get_idcompraestadotipo();
    $mostrarCompras .= "
     <tr>
        <td>".$unaCompra->get_idcompra()."</td>
        <td>".$unaCompra->get_cofecha()."</td>
        <td>".$unaCompra->get_idusuario()."</td>
        <td>".$estadoTipo[0]->get_cetdescripcion()."</td>";
        
        $buttons = "";
        if($estado == 1) {
            $buttons = " 
                <input type='button' value='Confirmar' class='btn btn-success confirmar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado[0]->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstado[0]->get_idcompraestadotipo()."'>
                <input type='button' value='Cancelar' class='btn btn-danger cancelar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado[0]->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstado[0]->get_idcompraestadotipo()."'>
            ";
        } elseif ($estado == 2) {
            $buttons = "
                <input type='button' value='Enviar' class='btn btn-success enviar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado[0]->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstado[0]->get_idcompraestadotipo()."'>
                <input type='button' value='Cancelar' class='btn btn-danger cancelar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado[0]->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstado[0]->get_idcompraestadotipo()."'>
            ";
        }
        
        $mostrarCompras .= "<td>$buttons</td>";
        $mostrarCompras .= "</tr>";
}
?>
<div class='d-flex justify-content-center'><h2>Datos de las compras</h2></div>
<div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th></th>
            
            </tr>
        </thead>
        <?php
            echo $mostrarCompras;
        ?>
    </table>
</div>

<script>
$(document).on('click', '.confirmar-btn, .cancelar-btn, .enviar-btn', function() {
    var idcompra = $(this).data('idcompra');
    var cefechafin = $(this).data('cefechafin');
    var idcompraestadotipo = $(this).data('idcompraestadotipo');
    var accion = $(this).val().toLowerCase(); 


    $.ajax({ 
        data: {
            idcompra: idcompra,
            cefechafin: cefechafin,
            idcompraestadotipo: idcompraestadotipo,
            accion: accion
        },
        type: 'POST',
        dataType: 'json',  
        url: 'accion/actualizarCompras.php',
        success: function(response){
            if(respuesta.respuesta) {
                    
                    $('#mensaje').html("La acción se ejecutó correctamente");
                } else {
                    $('#mensaje').html("La acción no pudo concretarse");
                }
        }
    });
});
</script>