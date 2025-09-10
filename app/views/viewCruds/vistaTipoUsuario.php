<?php
require_once("../../models/conexion.php");
require_once("../../models/modelUsuarios.php");
include("../partials/headerCrud.php");

// Conexión a la base de datos
$conexion = new Conexion();
$tabla = new TraerElementos($conexion->getConexion());

// Obtener el ID consultado desde la sesión (si existe)
$idConsultado = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Mensajes de sesión
if (isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}');</script>";
    unset($_SESSION['msg']);
}
?>
<div class="container-fluid row"  style="margin-bottom: 270px;">
<form class="col-4 p-3" method="post" action="../../controllers/controlUsuarios.php">
    <h3 class="text-center">Tipo de usuario</h3>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">ID</label>
    <input type="number" class="form-control" name="id">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombre">
  </div>
  <button type="submit" class="btn btn-primary" name="registrar" value="ok">Registrar</button>
</form>

<div class="col-8 p-4">
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nombre</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <?php $tabla->getTabla2($id=null); ?>
  </tbody>
</table><br><br>
</div>
</div>
<?php include("../partials/footerCrud.php"); ?>