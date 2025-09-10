<?php
require_once("../../models/conexion.php");
require_once("../../models/modelInmuebles.php");
include("../partials/headerCrud.php");

// Conexión a la base de datos
$conexion = new Conexion();
$tabla = new TraerElementos($conexion->getConexion());

// Obtener el ID consultado desde la sesión (si existe)

$idConsultado = isset($_SESSION['idinmueble']) ? $_SESSION['idinmueble'] : null;

// Mensajes de sesión
if (isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}');</script>";
    unset($_SESSION['msg']);
}

?>
<div class="container-fluid row">
    <form action="../../controllers/controlnmuebles.php" method="post" class="col-4 p-3">
        <h3 class="text-center">Consultar Inmueble</h3>
        <div class="mb-3">
            <label class="form-label">ID inmueble:</label>
            <input type="number" placeholder="Ingrese ID del inmueble" class="form-control" name="idinmueble">
        </div>
        <button type="submit" class="btn btn-primary" name="consultar">Consultar</button>
    </form>

    <div class="col-8 p-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha de publicación</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Título</th>
                    <th scope="col">Barrio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">ID Usuario</th>
                    <th scope="col">Tipo de Inmueble</th>
                    <th scope="col">Tipo de Pago</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tabla->getTabla($idConsultado);
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("../partials/footerCrud.php"); ?>