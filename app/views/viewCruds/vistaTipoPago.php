<?php

require_once("../../models/conexion.php");
require_once("../../models/modelTipoPago.php");
include("../partials/headerCrud.php");

$conexion = new Conexion();
$tabla = new ModelTipoPago($conexion->getConexion());

?>
<div class="container-fluid row" style="margin-bottom: 265px;">
<form class="col-4 p-3" action="../../controllers/controlTipoPago.php" method="post">
    <h3 class="text-center">Tipo de pago</h3>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">ID</label>
    <input type="number" class="form-control" name="id">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tipo de pago</label>
    <input type="text" class="form-control" name="nombre">
  </div>
  <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
</form>

<div class="col-8 p-4">
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Tipo de pago</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <?php
    $tabla->getTabla();
    ?>


  </tbody>
</table><br><br>
</div>
</div>
<?php 
include("../partials/footerCrud.php");
?>