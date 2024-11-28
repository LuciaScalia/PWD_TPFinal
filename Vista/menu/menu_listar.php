<?php
$titulo = "Inicio";
include_once("../../Estructura/cabeceraBT.php");

$session = new Session();
$ambMenuRol = new AbmMenuRol();
$abmMenu = new AbmMenu();
$us = $session->getUsuario();
$usrol = $session->getRol();
$usrolnombre = $usrol->get_rodescripcion();
$menurol = $ambMenuRol->buscar(['idrol'=>$usrol->get_idrol()]);

$menuOperacion = "<tr>";
foreach($menurol as $unmenu) {
    $unmenu = $unmenu->get_objmenu();
    $id = str_replace(' ', '', $unmenu->getMenombre());
    $menuOperacion .= '<td><input class="btn btn-primary" type="button" name="'.$id.'" id="'.$id.'"value="'.$unmenu->getMenombre().'"></td>';
}
$menuOperacion .= "</tr>";
?>
<!--<a href='".$unmenu->getMedescripcion().-->
<table class="table col-md-7">
  <th>Usuario</th>
  <th>Mail</th>
  <tr>
    <td name="usnombre" id="usnombre"><?php echo $us->get_usnombre() ?></td>
    <td name="usmail" id="usmail"><?php echo $us->get_usmail() ?></td>
    <td style="display: none;" name="idusuario" id="idusuario"><?php echo $us->get_idusuario() ?></td>
    <td style="display: none;" name="uspass" id="uspass"><?php echo $us->get_uspass() ?></td>
    <td style="display: none;" name="usdeshabilitado" id="usdeshabilitado"><?php echo $us->get_usdeshabilitado() ?></td>
  </tr>
<table>
<div id="menu">
    <b>Permisos de <?php echo $usrolnombre; ?></b><br>
    <table class="table col-md-7" >
        <?php echo $menuOperacion; ?>
    </table>
    <div name="formEditarUs" id="formEditarUs" class="col-md-7" style="display: none;">
      <br>
      <div name="mensaje" id="mensaje"></div>
      <div>
          
          <h3>Editar usuario</h3><br>
      </div>
      <div>
          <form name="formUsuario" id="formUsuario" method="post">
              <label class="form-label text-muted" for="usnombrenuevo">Usuario</label>
              <input type="text" name="usnombrenuevo" id="usnombrenuevo" class="form-control" data-usnombre="<?php echo $us->get_usnombre() ?>" placeholder="Nuevo nombre" required><br>
              <!---->
              <label class="form-label text-muted" for="usmailnuevo">Mail</label>
              <input type="email" name="usmailnuevo" id="usmailnuevo" class="form-control" data-usmail="<?php echo $us->get_usmail() ?>" placeholder="Nuevo mail" required><br>
              <!---->
              <label class="form-label text-muted" for="uspassnueva">Contraseña</label>
              <input type="password" name="uspassnueva" id="uspassnueva" class="form-control" data-uspass="<?php echo $us->get_uspass() ?>" placeholder="Nueva contraseña" required><br><br>
              <div class="d-flex justify-content-center">
              <input id="aceptar" type="button" class="btn btn-primary btn-block" value="Aceptar">
              </div>
              <br>
          </form>
    </div>
</div>
</div>

<script>
    $('#Editarusuario').click(function() {
        $('#formEditarUs').toggle(); // muestra y esconde el div
        $('#mensaje').html("");
        $('#aceptar').click(function(evento) {
            evento.preventDefault();
            var idusuario = $('#idusuario').html();
            var usdeshabilitado = null;

            var usnombreactual = $('#usnombrenuevo').data('usnombre');
            var usmailactual = $('#usmailnuevo').data('usmail');
            var uspassactual = $('#uspassnueva').data('uspass');

            var usnombrenuevo = $('#usnombrenuevo').val();
            var usmailnuevo = $('#usmailnuevo').val();
            var uspassnueva = $('#uspassnueva').val();

            var usnombre = usnombrenuevo != "" ? usnombrenuevo : usnombreactual;
            var usmail = usmailnuevo != "" ? usmailnuevo : usmailactual;
            var uspass;
            if (uspassnueva != "") {
                uspass = uspassnueva;
                uspass = CryptoJS.MD5(uspass).toString();
                document.getElementById("uspassnueva").value = uspass;
            } else {
                uspass = uspassactual;
            }

            var datos = {
                idusuario: idusuario,
                usnombre: usnombre,
                usmail: usmail,
                uspass: uspass,
                usdeshabilitado: usdeshabilitado
            };

            if (usnombrenuevo != "" || usmailnuevo != "" || uspassnueva != "") {
                $.ajax({
                    data: datos,
                    type: 'POST',
                    dataType: 'json',
                    url: '../Usuario/accion/editar_usuario.php',
                    success: function(data) {
                        $('#usnombre').html(usnombre);
                        $('#usmail').html(usmail);
                        $('#mensaje').html("El usuario se editó correctamente");

                        // Limpia los inputs
                        $('#usnombrenuevo').val('');
                        $('#usmailnuevo').val('');
                        $('#uspassnueva').val('');
                    },
                });
            } else {
                $('#mensaje').html("No se ingresaron datos para editar");
            }
        });
    });

    $('#Listarcompras').click(function() {
        window.location.href = '../Compra/listar_compras.php';
    });

    $('#Listarusuarios').click(function() {
        window.location.href = '../Rol/listar_usuarios.php';
    });
    
    $('#Gestionarroles').click(function() {
        window.location.href = '../Rol/rolusuario_gestionar.php';
    });
    
    $('#Eliminarcuenta').click(function() {
        var fechaActual = new Date();
        var formatoFecha = fechaActual.toISOString().slice(0, 19).replace('T', ' ');
        var datos = {
        idusuario: $('#idusuario').html(),
        usnombre: $('#usnombre').html(),
        usmail: $('#usmail').html(),
        uspass: $('#uspass').html(),
        usdeshabilitado : formatoFecha
        };
        //alert(JSON.stringify(datos));
        $.ajax({
            data: datos,
            type: 'POST',
            dataType: 'json',
            url: '../Usuario/accion/estado_usuario.php',
            success: function(data) {
                if (data.respuesta) {
                  $('#menu').empty();
                  alert("La cuenta se eliminó con éxito");
                  window.location.href = '../Home/index.php';
                } else {
                    $('#menu').html('<div><p>' + data.errorMsg + '</p></div>');
                }
            },
        });
    });
</script>
<?php
include_once("../../Estructura/pie.php")
?>