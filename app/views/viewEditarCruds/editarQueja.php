<?php
require_once("../../models/modelQueja.php");

$conexion = new Conexion();
$quejaModel = new Quejas($conexion->getConexion());

if (isset($_GET['id'])) {
    $idqueja = $_GET['id'];
    $queja = $quejaModel->consultarQueja($idqueja);
} else {
    echo "ID de reserva no proporcionado.";
    exit();
}
include("../partials/headerEdit.php");
?>
<form action="../../controllers/controlQueja.php" class="col-4 p-3 m-auto" method="post">
      <div class="sub">
    <h3>Enviar Repuesta</h3>
    </div>
      <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">ID</label>
    <input type="number" class="form-control" name="id" value="<?=$queja['q_id']; ?>" readonly>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Correo</label>
    <input type="text" class="form-control" name="correo" value="<?=$queja['u_correo']; ?>" readonly>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">"Descripción</label>
    <input type="text" class="form-control" name="descripcion" value="<?=$queja['q_descripcion']; ?>" readonly>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Respuesta</label>
    <textarea name="respuesta" class="form-control"><?=$queja['q_respuesta']; ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Enviar Repuesta</button>
</form>
<?php include("../partials/footerCrud.php"); ?>