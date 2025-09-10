<?php
require_once("../../models/conexion.php");
require_once("../../models/modelInmuebles.php");

$conexion = new Conexion();
$inmuebleModel = new Inmuebles($conexion->getConexion());

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tipoinmueble = $inmuebleModel->consultarTipoInmueble($id);
} else {
    echo "ID de tipo de inmueble no proporcionado.";
    exit();
}
include("../partials/headerEdit.php");
?>
<form class="col-4 p-3 m-auto" action="../../controllers/controlnmuebles.php" method="post">
<div class="sub">
    <h3>Modificar el Tipo de Inmueble</h3>
    </div>
      <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">ID</label>
    <input type="number" class="form-control" name="id" value="<?=$tipoinmueble['tip_id'] ?>" readonly>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombre" value="<?=$tipoinmueble['tip_nombre'] ?>">
  </div>
  <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar inmueble</button>
</form>
<?php include("../partials/footerCrud.php"); ?>
