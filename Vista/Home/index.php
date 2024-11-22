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
<div id="contenedor">
    <div id="productos"></div>
</div>
<div id="miModal" class="modal">
    <div class="modal-contenido">
        <span class="close">&times;</span>
        <h2>Mi Carrito</h2>
        <div id="contenidoCarrito"></div><br>
        <div id="totalPagar">Total: $<span id="total">0.00</span></div>
        <input type="button" class="btn btn-primary btn-block" value="Confirmar Compra"></input>
        <input type="button" class="btn btn-primary btn-block" id="vaciarCarrito" value="Vaciar carrito"></input>
    </div>
</div>
<script>
$(document).ready(function() {   
    var productos = []; 
    cargarCarrito();
    function cargarProductos(){
        $.ajax({
            url: "accion.php",
            success: function(mensaje) {
                $('#productos').html(mensaje);
      
        $('.agregar-producto').on('click',function() {
            var idProducto = $(this).data('id');
            var nombre = $(this).data('nombre');
            var imagenUrl = $(this).data('imagen');
            var precio = $(this).data('precio'); 
            var stock = $(this).data('stock');
           

              //verifica q el produc no este ya en el carrito
            if (!productos.some(p => p.id ===idProducto)) {
            productos.push({id: idProducto, nombre: nombre, imagenUrl: imagenUrl, cantidad:1 , stock: stock, precio: precio});
          // console.log(productos);

            //añade el producto al html del carrito
            $('#contenidoCarrito').append(
                `<div class="producto-carrito" data-id="${idProducto}">
                <img src="${imagenUrl}" alt="${nombre}" class="imagen-carrito">
                ${nombre}
                <input type="number" class="cantidad-carrito" style="width:10%; min="1" max="${stock}" value="1" data-precio="${precio}"> Cantidad 
                <span class="precio-producto">$${(1*precio).toFixed(2)}</span>
                <i class="fas fa-trash eliminar-producto" data-id="${idProducto}"></i>
                </div>`
            );
          
            $('cantProd').text(productos.length);
            guardarCarrito();
            actualizarTotal();
            $('#contenidoCarrito .cantidad-carrito').last().on('change', function() {
                var min = parseInt($(this).attr('min'), 10);;
                var value = parseInt($(this).val(), 10);
                if (value < min) {
                    $(this).val(min); // Establecer el valor mínimo si es menor
                }
                console.log(min,value)
                actualizarPrecioProducto($(this));
                actualizarTotal();
            });
            }
        }); 
    },  
    error: function(xhr, status, error) {
            console.error("Error al cargar productos:", error); 
    }   
});
}
    function guardarCarrito() {
        setCookie('carrito', JSON.stringify(productos), 7); // Guarda por 7 días
    }
    function cargarCarrito() {
        var carrito = getCookie('carrito');
        if (carrito) {
            productos = JSON.parse(carrito);
            if(!Array.isArray(productos)){
                productos=[];
            }
            productos.forEach(function(producto) {
                $('#contenidoCarrito').append(
                    `<div class="producto-carrito" data-id="${producto.id}"> 
                    <img src="${producto.imagenUrl}" alt="${producto.nombre}" class="imagen-carrito"> ${producto.nombre} 
                    <input type="number" class="cantidad-carrito" style="width: 10%;" min="1" max="${producto.stock}" value="${producto.cantidad}" data-precio="${producto.precio}"> Cantidad 
                    <span class="precio-producto">$${(producto.cantidad*producto.precio).toFixed(2)}</span>
                    <i class="fas fa-trash eliminar-producto" data-id="${producto.id}"></i> </div>`
                );
            });
           console.log(productos);
            $('#cantProd').text(productos.length);
            actualizarTotal();

            $('#contenidoCarrito .cantidad-carrito').last().on('change', function() {
                var min = parseInt($(this).attr('min'), 10);
                var value = parseInt($(this).val(), 10);
               
                if (value < min) {
                    $(this).val(min);
                }
               // console.log(min,value)
                actualizarPrecioProducto($(this));
                actualizarTotal();
            });
        }
    }
 
    function eliminarProducto(idProducto){
        productos=productos.filter(p => p.id !== idProducto);
        $(`.producto-carrito[data-id="${idProducto}"]`).remove();
        $('#cantProd').text(productos.length);
        guardarCarrito();
        actualizarTotal();
    }
    function vaciarCarrito(){
        productos=[];
        $('#contenidoCarrito').empty();
        $('#cantProd').text(productos.length);
        borrarCookie('carrito');
        actualizarTotal();
    }
    function actualizarPrecioProducto(input) {
        const cantidad = parseInt(input.val(), 10);
        const precio = parseFloat(input.attr('data-precio'));
        const precioTotal = cantidad * precio;
        input.siblings('.precio-producto').text(`$${precioTotal.toFixed(2)}`);
    }
    function actualizarTotal(){
        var total = 0;
        $('#contenidoCarrito .producto-carrito').each(function(){
            const cantidad =parseInt($(this).find('.cantidad-carrito').val(),10);
            const precio = parseFloat($(this).find('.cantidad-carrito').attr('data-precio'));
            if(!isNaN(cantidad) && !isNaN(precio)){
               total += cantidad*precio;   
            }
           
           //  console.log(total, cantidad, precio);
        });
      
        $('#total').text(total.toFixed(2));
    }

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

function borrarCookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


    cargarProductos(); /*
    $('#toggleCarrito').on('click',function(){
        $('#contenidoCarrito').toggle();
    });*/
    var modal=document.getElementById("miModal");
    var btn=document.getElementById("toggleCarrito");
    var span=document.getElementsByClassName("close")[0];

    btn.onclick=function(){
        modal.style.display="block";
    }

    span.onclick=function(){
        modal.style.display="none";
    }

    window.onclick=function(event){
        if(event.target===modal){
        modal.style.display="none";
        }
    }
    $('#vaciarCarrito').on('click',function(){
        vaciarCarrito();
    });
    
 
    $('#contenidoCarrito').on('click','.eliminar-producto',function(){
            var idProducto=$(this).data('id');
            eliminarProducto(idProducto);
    });
   
});






</script>



<?php
include_once("../../Estructura/pie.php");
?>