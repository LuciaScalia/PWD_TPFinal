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
    $cantFilas = count($idCompraEstado);
    $idCompraEstado = $cantFilas > 1 ? $idCompraEstado[$cantFilas - 1] : $idCompraEstado[0];    
   
     if ($idCompraEstado->get_cefechafin() == null || $idCompraEstado->get_cefechafin() == "0000-00-00 00:00:00") {
        $idCompraEstadoTipo = $idCompraEstado->get_idcompraestadotipo();
        $estadoTipo = $abmCompraEstadoTipo->buscar(['idcompraestadotipo'=>$idCompraEstadoTipo]);
        $estado=$estadoTipo[0]->get_idcompraestadotipo();
        $estadoTipo = $estadoTipo[0]->get_cetdescripcion();
        //$confirmada = $estadoTipo == "Confirmada" ? true : false;
        //$enviada = $estadoTipo == "Enviada" ? true : false;

        $mostrarCompras .= "
     <tr>
        <td>".$unaCompra->get_idcompra()."</td>
        <td>".$unaCompra->get_cofecha()."</td>
        <td>".$unaCompra->get_idusuario()."</td>
        <td data-estadotipo=".$estadoTipo.">".$estadoTipo."</td>";
        
        $botones = "";
        if($estado == 1) {
            $botones = " 
                <input type='button' value='Confirmar' class='btn btn-success confirmar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>
                <input type='button' value='Cancelar' class='btn btn-danger cancelar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>
            ";
        } elseif ($estado == 2) {
            $botones = "
                <input type='button' value='Enviar' class='btn btn-success enviar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>
                <input type='button' value='Cancelar' class='btn btn-danger cancelar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>
            ";
        } elseif ($estado == 3) {
            $botones = "
                <input type='button' value='Recibida' class='btn btn-success recibida-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>
                <input disabled type='button' value='Cancelar' class='btn btn-danger cancelar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>

            ";
        } elseif ($estado == 4) {
            $botones = "
                <input disabled type='button' value='Recibida' class='btn btn-success recibida-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>
                <input disabled type='button' value='Cancelar' class='btn btn-danger cancelar-btn' data-idcompra='".$unaCompra->get_idcompra()."' data-cefechafin='".$idCompraEstado->get_cefechafin()."' data-idcompraestadotipo='".$idCompraEstadoTipo."' data-idcompraestado='".$idCompraEstado->get_idcompraestado()."'>

            ";
        } 
        
        $mostrarCompras .= "<td>$botones</td>";
        $mostrarCompras .= "</tr>";
    }
}
?>
<div class='d-flex justify-content-center'><h2>Datos de las compras</h2></div>
<div id="mensaje"></div>
<div>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID compra</th>
                <th>Fecha inicio</th>
                <th>ID usuario</th>
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
    var botonClickeado = $(this);
    var $estadotipoTd = botonClickeado.closest('tr').find('td[data-estadotipo]'); // Correctly define $estadotipoTd
    console.log($estadotipoTd); // Log the element to the console for debugging
    var idcompra = botonClickeado.data('idcompra');
    var cefechafin = botonClickeado.data('cefechafin');
    var idcompraestadotipo = botonClickeado.data('idcompraestadotipo');
    var idcompraestado = botonClickeado.data('idcompraestado');
    var accion = botonClickeado.val().toLowerCase(); 

    //Botones de la fila
    var $confirmarBtn = $('.confirmar-btn[data-idcompra="' + idcompra + '"]');
    var $cancelarBtn = $('.cancelar-btn[data-idcompra="' + idcompra + '"]');
   
    $.ajax({ 
        data: {
            idcompra: idcompra,
            cefechafin: cefechafin,
            idcompraestadotipo: idcompraestadotipo,
            idcompraestado: idcompraestado,
            accion: accion
        },
        type: 'POST',
        dataType: 'json',  
        url: 'accion/actualizarCompras.php',
        success: function(respuesta) {  
            if (accion === "confirmar") {
                $confirmarBtn.val("Enviar"); // Cambia "Confirmar" a "Enviar"
                $estadotipoTd.html("Confirmada"); 
            } else if (accion === "enviar") { 
                $confirmarBtn.val("Recibida"); // Cambia "Enviar" a "Recibida"
                $cancelarBtn.prop('disabled', true);
                $estadotipoTd.html("Enviada a destino"); 
            } else if (accion === "cancelar") {
                $confirmarBtn.prop('disabled', true);
                $cancelarBtn.prop('disabled', true);
                $estadotipoTd.html("Cancelada");
            } else if (accion === "recibida") {
                $confirmarBtn.prop('disabled', true); 
                $cancelarBtn.prop('disabled', true);
                $estadotipoTd.html("Recibida"); 
            }

            $('#mensaje').html("La acci&oacute;n '" + accion + "' se ejecut&oacute; correctamente");
        },
        error: function(xhr) {
            // Handle errors here
            var errorMsg = xhr.responseJSON ? xhr.responseJSON.errorMsg : "Ocurrió un error desconocido";
            $('#mensaje').html(errorMsg);
        }
    });
});
</script>