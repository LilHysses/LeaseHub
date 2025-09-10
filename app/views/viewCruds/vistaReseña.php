<?php
require_once("../../models/conexion.php");
require_once("../../models/modelReseña.php");
include("../partials/headerCrud.php");

$conexion = new Conexion();
$tabla = new TraerElementos($conexion->getConexion());
$modelReseña=new Reseña($conexion->getConexion());

// Obtener el ID consultado desde la sesión (si existe)
$idConsultado = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Mensajes de sesión
if (isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}');</script>";
    unset($_SESSION['msg']);
}
?>
<div class="container-fluid row">
    <form action="../../controllers/controlReseña.php" class="col-4 p-3" method="post">
        <h3 class="text-center">Reseñas</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ID</label>
            <input type="number" class="form-control" name="id">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Calificación</label>
            <input type="number" class="form-control" name="calificacion">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Usuario</label>
            <select name="usuario" class="combito1">
                <option value="">Seleccione...</option>
                <?php
                    $modelReseña->UsuariosSelect($usuario);
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Inmuebles</label>
            <select name="inmueble" class="combito">
                <option value="">Seleccione...</option>
                <?php
                    $modelReseña->InmuebleSelect($inmueble);
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
    </form>
    <div class="col-8 p-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Calificación</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Inmueble</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tabla->getTabla($id=null);
                ?>
            </tbody>
        </table><br><br>
    </div>
</div>
<?php include("../partials/footerCrud.php"); ?>