<?php
require_once("../../models/conexion.php");
require_once("../../models/modelUsuarios.php");

$conexion = new Conexion();
$usuarioModel = new Usuarios($conexion->getConexion());

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $tipousuario = $usuarioModel->consultarTipoUsuario($id);
} else {
    echo "ID de tipo de usuario no proporcionado.";
    exit();
}
include("../partials/headerEdit.php");
?>
<form class="col-4 p-3 m-auto" method="post" action="../../controllers/controlTipoUsuario.php">
<div class="sub">
    <h3>Modificar el Tipo de Usuario</h3>
    </div>
      <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">ID</label>
    <input type="number" class="form-control" name="id" value="<?=$tipousuario['tu_id']; ?>" readonly>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombre" value="<?=$tipousuario['tu_nombre']; ?>">
  </div>
  <button type="submit" class="btn btn-primary" name="modificar" value="ok">Modificar tipo de usuario</button>
</form>
<?php include("../partials/footerCrud.php"); ?>
