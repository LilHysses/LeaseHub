<?php
require_once("../../models/conexion.php");
require_once("../../models/modelReserva.php");
include("../partials/headerCrud.php");

$conexion = new Conexion();
$tabla = new TraerElementos($conexion->getConexion());

// Obtener el ID consultado desde la sesión (si existe)
$idConsultado = isset($_SESSION['idusuario']) ? $_SESSION['idusuario'] : null;

// Mensajes de sesión
if (isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}');</script>";
    unset($_SESSION['msg']);
}
?>
<div class="container-fluid row">
    <form action="../../controllers/controlReserva.php" method="post" class="col-4 p-3">
        <h3 class="text-center">Consultar la Cita</h3>
        <div class="mb-3">
            <label class="form-label">ID del Usuario:</label>
            <input type="number" placeholder="Ingrese ID del usuario" class="form-control" name="idusuario">
        </div>
        <button type="submit" class="btn btn-primary" name="consultar">Consultar</button>
    </form>
    <div class="col-8 p-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Inmueble</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
               <?php
                $tabla->getTabla($idConsultado);
               ?>
            </tbody>
        </table><br><br>
    </div>
</div>
<?php include("../partials/footerCrud.php"); ?>