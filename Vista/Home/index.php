<?php
include_once("../../configuracion.php");
$titulo = "Inicio";
$sesion=new Session();
if($sesion->validar()){
    include_once("../../Estructura/cabeceraBT.php");
}else{
    include_once("../../Estructura/cabeceraBTNoSegura.php");
}
?>
<link rel="stylesheet" href="../css/productosycarrito.css" >

<div  class="justify-content-center text-center"><h2>Nuestros productos</h2>
<?php 
 $rol=new AbmUsuarioRol();
 $resp=$rol->permisoRol();
 if($resp){
    echo  '
            <div id="contenedor">
                <div id="productos"></div>
            </div>
    
        <div id="miModal" class="modal">
            <div class="modal-contenido">
                <span class="close">&times;</span>
                <h2>Mi Carrito</h2>
                <div id="contenidoCarrito"></div><br>
                <div id="totalPagar">Total: $<span id="total">0.00</span></div>
                <input type="button" class="btn btn-primary btn-block" id="confirmarCompra" value="Confirmar Compra"></input>
                <input type="button" class="btn btn-primary btn-block" id="vaciarCarrito" value="Vaciar carrito"></input>
            </div>
        </div>
        
        
        <div id="modalPago" class="modal">
            <div class="modal-contenido">
                <span class="close">&times;</span>
                <h2 class="text-center">Proceso de pago</h2>
                <form id="formPago"  class="d-flex flex-column align-items-center">
                    <label for="nombre">Nombre titular: </label>
                    <input type="text" id="nombre" name="tarjeta" required>
                    <label for="tarjeta">Número de tarjeta: </label>
                    <input type="text" id="tarjeta" name="tarjeta" required>
                    <label for="expiracion">Fecha expiración: </label>
                    <input type="text" id="expiracion" name="expiracion" required>
                    <label for="cvv">CVV: </label>
                    <input type="text" id="cvv" name="cvv" required>
                    <div> <strong>Total a Pagar:</strong> 
                    <span id="totalPago">$0.00</span></div>
                    <input type="submit" class="btn btn-primary btn-block value="Pagar">
                </form>
            </div>
        </div>';
        echo '<script src="../js/carrito.js"></script>';
 }else{
    $ambProducto=new AbmProducto();
    $ambProducto->mostrarProductosIndex();
 }
?>

</div>

<?php
include_once("../../Estructura/pie.php");
?>