<?php
require_once("../../models/conexion.php");
require_once("../../models/modelTipoPago.php");
include("../partials/headerEdit.php");

$conexion = new Conexion();
$modelTipoPago = new tipoPago($conexion->getConexion());
 
if (isset($_GET['id'])) {
    $idtipopago = $_GET['id'];
    $datosTipoPago = $modelTipoPago->consultarTipoPago($idtipopago);
} else {
    echo "ID de tipo de pago no proporcionado.";
    exit();
}
?>

<form class="col-4 p-3 m-auto" action="../../controllers/controlTipoPago.php" method="post">
    <div class="sub">
        <h3>Modificar el Tipo de Pago</h3>
        </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">ID</label>
        <input type="number" class="form-control" name="id" value="<?=$datosTipoPago['tp_id'] ?>" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Tipo de pago</label>
        <input type="text" class="form-control" name="nombre" value="<?=$datosTipoPago['tp_pago'] ?>">
    </div> 
    <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar tipo de pago</button>
</form>

<?php include("../partials/footerCrud.php"); ?>
