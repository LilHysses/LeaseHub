<?php
require_once("../../models/conexion.php");
require_once("../../models/modelUsuarios.php");

$conexion = new Conexion();
$usuarioModel = new Usuarios($conexion->getConexion());

if (isset($_GET['id'])) {
  $idusuario = $_GET['id'];
  $usuarios = $usuarioModel->ConsultarUsuarios($idusuario);
} else {
  echo "ID de usuario no proporcionado.";
  exit();
}
include("../partials/headerEdit.php");
?>
<form class="col-4 p-3 m-auto" action="../../controllers/controlUsuarios.php" method="post">
  <div class="sub">
    <h3>Modificar el Usuario</h3>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">ID</label>
    <input type="text" class="form-control" name="id" value="<?= $usuarios['u_id'] ?>" readonly>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Nombre</label>
    <input type="text" class="form-control" name="nombre" value="<?= $usuarios['u_nombre'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Apellido</label>
    <input type="text" class="form-control" name="apellido" value="<?= $usuarios['u_apellido'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Correo</label>
    <input type="email" class="form-control" name="correo" value="<?= $usuarios['u_correo'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Contraseña</label>
    <input type="number" class="form-control" name="contraseña" value="<?= $usuarios['u_contraseña'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Dirección</label>
    <input type="text" class="form-control" name="direccion" value="<?= $usuarios['u_direccion'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Teléfono</label>
    <input type="number" class="form-control" name="telefono" value="<?= $usuarios['u_telefono'] ?>">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Tipo usuario</label>
    <select name="tipousuario" class="form-control">
      <?php $usuarioModel->UsuariosSelect($usuarios['tu_id']);  ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Descripción</label>
    <input type="text" class="form-control" name="descripcion" value="<?= $usuarios['u_descripcion'] ?>">
  </div>

  <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar usuario</button>
</form>
<?php include("../partials/footerCrud.php"); ?>