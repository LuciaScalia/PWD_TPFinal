<?php
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

<div id="contenedor" class="container d-flex justify-content-center">
    <div class="col-md-5">
        <br>
        <div class="d-flex justify-content-center">
            <h3>Nuevo usuario</h3>
        </div>
        <div>
            <form name="formUsuario" id="formUsuario" method="post" action="accion.php">
                <label class="form-label text-muted" for="usnombre">Usuario</label>
                <input type="text" name="usnombre" id="usnombre" class="form-control" required><br>
                <!---->
                <label class="form-label text-muted" for="usmail">Mail</label>
                <input type="email" name="usmail" id="usmail" class="form-control" required><br>
                <!---->
                <label class="form-label text-muted" for="uspass">Contraseña</label>
                <input type="password" name="uspass" id="uspass" class="form-control" required><br><br>

                <div class="d-flex justify-content-center">
                <input type="button" class="btn btn-primary btn-block" value="Aceptar" onclick="formSubmit('formUsuario','uspass')">
                </div>
                <br>
            </form>
        </div>
    </div>
</div>
<script src="../js/encriptar.js"></script>
<?php
include_once("../Estructura/pie.php");
?>