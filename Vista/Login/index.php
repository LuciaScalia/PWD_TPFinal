<?php
$link = "";
$titulo = "Login";
include_once '../Estructura/cabeceraBTNoSegura.php';
$datos = data_submitted();
?>
<div class="row float-left">
    <div class="col-md-12 float-left">
      <?php 
      if(isset($datos) && isset($datos['msg']) && $datos['msg']!=null) {
        echo $datos['msg'];
      }
        
     ?>
    </div>
</div>


<form name="login" id="login" method="post" enctype="multipart/form-data" action="accion.php">
  <input id="accion" name ="accion" value="login" type="hidden">
  <div class="form-group"><br><br>
    <label for="usnombre">Usuario</label>
    <input type="text" class="form-control" name="usnombre" id="usnombre" placeholder="Usuario" required>
  </div>
  <div class="form-group">
    <label for="uspass">Contraseña</label>
    <input type="password" class="form-control" name="uspass" id="uspass" placeholder="Contraseña" required>
  </div>
  <br>
  <input type="button" class="btn btn-primary btn-block" value="Validar" onclick="formSubmit()">
</form>

<script>

function formSubmit()
{
    var password =  document.getElementById("uspass").value;
    //alert(password);
    var passhash = CryptoJS.MD5(password).toString();
    //alert(passhash);
    document.getElementById("uspass").value = passhash;

    setTimeout(function(){ 
        document.getElementById("login").submit();

	}, 500);
}
</script>

<?php
// footer
?>

