<?php
require_once("../../models/modelQueja.php");
include("../partials/headerCrud.php");

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

<div class="container-fluid row" style="width: 100%;">
  <div class="col-8 p-4" style="margin: auto;">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Correo</th>
          <th scope="col">Descripción</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php $tabla->getTabla($id=null); ?>
      </tbody>
    </table><br><br>
  </div>
</div>
<?php include("../partials/footerCrud.php"); ?>