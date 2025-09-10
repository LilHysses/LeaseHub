<?php
require_once("../../models/conexion.php");
require_once("../../models/modelReseña.php");
include("../partials/headerEdit.php");

$conexion = new Conexion();
$reseñaModel = new Reseña($conexion->getConexion());

if (isset($_GET['id'])) {
    $idreseña = $_GET['id'];
    $reseña = $reseñaModel->consultarReseña($idreseña);
} else {
    echo "ID de reserva no proporcionado.";
    exit();
}

?>
<form class="col-4 p-3 m-auto" method="post" action="../../controllers/controlReseña.php">
    <div class="sub">
        <h3>Modificar las reseñas</h3>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">ID</label>
        <input type="number" class="form-control" name="id" value="<?= $reseña['re_id'] ?>" readonly>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Calificación</label>
        <input type="number" class="form-control" name="calificacion" value="<?= $reseña['re_calificacion'] ?>">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" value="<?= $reseña['re_fecha'] ?>">
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Usuario</label>
        <select name="usuario" class="combito1">
            <option value="">Seleccione...</option>
            <?php $reseñaModel->UsuariosSelect($reseña['u_id']); ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Inmueble</label>
        <select name="inmueble" class="combito">
            <option value="">Seleccione...</option>
            <?php $reseñaModel->InmuebleSelect($reseña['in_id']); ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar reseña</button>
</form>
<?php include("../partials/footerCrud.php"); ?>