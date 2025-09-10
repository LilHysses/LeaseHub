<?php
require_once("../../models/modelInmuebles.php");

$conexion = new Conexion();
$inmuebleModel = new Inmuebles($conexion->getConexion());

if (isset($_GET['id'])) {
    $idinmueble = $_GET['id'];
    $inmueble = $inmuebleModel->consultarInmueble($idinmueble);
} else {
    echo "ID de inmueble no proporcionado.";
    exit();
}
include("../partials/headerEdit.php");
?>

<form action="../../controllers/controlnmuebles.php" method="post" class="col-4 p-3 m-auto">
    <div class="sub">
        <h3>Modificar Inmuebles</h3>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">ID del inmueble</label>
        <input type="number" name="idinmueble" value="<?= $inmueble['in_id'] ?>" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label for=""class="form-label">Fecha de Publicación</label>
        <input type="date" name="fecha" value="<?= $inmueble['in_fecha_publicacion'] ?>" class="form-control" readonly>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Dirección</label>
        <input type="text" name="direccion" value="<?= $inmueble['in_direccion'] ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Precio</label>
        <input type="number" name="precio" value="<?= $inmueble['in_precio'] ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4"><?= $inmueble['in_descripcion'] ?></textarea>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Título</label>
        <input type="text" name="titulo" value="<?= $inmueble['in_titulo'] ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Barrio</label>
        <input type="text" name="barrio" value="<?= $inmueble['in_barrio'] ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Estado</label>
        <select name="estado" class="form-control">
            <option value="Disponible" <?= $inmueble['in_estado'] == 'Disponible' ? 'selected' : '' ?>>Disponible</option>
            <option value="No Disponible" <?= $inmueble['in_estado'] == 'No Disponible' ? 'selected' : '' ?>>No Disponible</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">ID usuario</label>
        <select name="idusuario" class="form-control" class="form-control">
            <option value="">Seleccione...</option>
            <?php
            $queryUsuarios = "SELECT u_id, u_nombre FROM usuario";
            $resultadoUsuarios = mysqli_query($conexion->getConexion(), $queryUsuarios);

            if ($resultadoUsuarios->num_rows > 0) {
                while ($filaUsuario = $resultadoUsuarios->fetch_assoc()) {

                    $selected = ($filaUsuario['u_id'] == $inmueble['u_id']) ? 'selected' : '';
                    echo '<option value="' . $filaUsuario['u_id'] . '" ' . $selected . '>' . $filaUsuario['u_nombre'] . '</option>';
                }
            } else {
                echo '<option value="">No hay usuarios disponibles</option>';
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Modificar el inmueble</label><br><br>
        <select name="tipoinmueble" class="form-control">
            <option value="101" <?= $inmueble['tip_id'] == '101' ? 'selected' : '' ?>>Apartamento</option>
            <option value="102" <?= $inmueble['tip_id'] == '102' ? 'selected' : '' ?>>Apartaestudio</option>
            <option value="103" <?= $inmueble['tip_id'] == '103' ? 'selected' : '' ?>>Casa</option>
            <option value="104" <?= $inmueble['tip_id'] == '104' ? 'selected' : '' ?>>Local</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">Tipo de Pago</label>
        <select name="tipopago" class="form-control">
            <option value="1" <?= $inmueble['tp_id'] == '1' ? 'selected' : '' ?>>Efectivo</option>
            <option value="2" <?= $inmueble['tp_id'] == '2' ? 'selected' : '' ?>>Crédito</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" name="actualizar">Modificar inmueble</button>
</form>
<?php include("../partials/footerCrud.php"); ?>