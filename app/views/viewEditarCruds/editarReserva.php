<?php
session_start();
ob_start();

if (!isset($_SESSION['correo'])) {
    echo "<script>alert('No se ha iniciado sesión.'); window.location='../index.php';</script>";
    exit();
}

$correo = $_SESSION['correo'];
require_once("../../models/modelReserva.php");

$conexion = new Conexion();
$reservaModel = new Reserva($conexion->getConexion());

$row = $reservaModel->datosReserva($correo);

if ($row) {
    // Almacenar los datos del usuario en variables para usarlas en el HTML
    $iduser = $row['u_id'];
    $nombre = $row['u_nombre'];
    $apellido = $row['u_apellido'];
    $direccion = $row['u_direccion'];
    $desc = $row['u_descripcion'];
    $rol = $row['tu_id'];
    if ($rol == 101) {
        $rol = 'Administrador';
    } elseif ($rol == 102) {
        $rol = 'Usuario';
    } else {
        $rol = 'Propietario';
    }
    $_SESSION['rol'] = $rol;
} else {
    // Si no se encuentra el usuario (error de consulta o usuario no encontrado)
    echo "Error al cargar los datos del usuario.";
    exit();
}

if (isset($_GET['id'])) {
    $idreserva = $_GET['id'];
    $reserva = $reservaModel->consultarReserva2($idreserva);
} else {
    echo "ID de reserva no proporcionado.";
    exit();
}
include("../partials/headerEdit.php");
?>

<form class="col-4 p-3 m-auto" action="../../controllers/controlReserva.php" method="post">
    <div class="sub">
        <h3>Modificar Citas</h3>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">ID</label>
        <input type="number" class="form-control" name="id" value="<?= $reserva['r_id'] ?>" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha1" value="<?= $reserva['r_fecha_inicio'] ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Hora</label>
        <input type="time" class="form-control" name="hora" value="<?= $reserva['r_hora'] ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-control">
            <option value="Pendiente" <?= $reserva['r_estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            <option value="Cancelado" <?= $reserva['r_estado'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
            <option value="Aceptado" <?= $reserva['r_estado'] == 'Aceptado' ? 'selected' : '' ?>>Aceptado</option>
        </select>
        <div id="motivoCancelacionContainer" style="display: none; margin-top: 10px;">
            <label for="motivo_cancelacion">Motivo de la cancelación:</label>
            <textarea name="motivo_cancelacion" id="motivo_cancelacion" class="form-control" rows="4" placeholder="Escribe el motivo..."><?= $reserva['r_motivo'] ?? '' ?></textarea>
        </div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Usuario</label>
        <select name="usuario" class="form-control" class="form-control">
            <option value="">Seleccione...</option>
            <?php
            $queryUsuarios = "SELECT u_id, u_nombre FROM usuario";
            $resultadoUsuarios = mysqli_query($conexion->getConexion(), $queryUsuarios);

            if ($resultadoUsuarios->num_rows > 0) {
                while ($filaUsuario = $resultadoUsuarios->fetch_assoc()) {

                    $selected = ($filaUsuario['u_id'] == $reserva['u_id']) ? 'selected' : '';
                    echo '<option value="' . $filaUsuario['u_id'] . '" ' . $selected . '>' . $filaUsuario['u_nombre'] . '</option>';
                }
            } else {
                echo '<option value="">No hay usuarios disponibles</option>';
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Inmueble</label>
        <select name="inmueble" class="form-control">
            <option value="">Seleccione un inmueble...</option>
            <?php
            // Consulta para obtener todos los inmuebles
            $queryInmuebles = "SELECT in_id, in_titulo FROM inmueble";
            $resultadoInmuebles = mysqli_query($conexion->getConexion(), $queryInmuebles);

            if ($resultadoInmuebles->num_rows > 0) {
                while ($filaInmueble = $resultadoInmuebles->fetch_assoc()) {
                    // Comparar el inmueble actual del registro con el listado
                    $selected = ($filaInmueble['in_id'] == $reserva['in_id']) ? 'selected' : '';
                    echo '<option value="' . $filaInmueble['in_id'] . '" ' . $selected . '>' . $filaInmueble['in_titulo'] . '</option>';
                }
            } else {
                echo '<option value="">No hay inmuebles disponibles</option>';
            }
            ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar cita</button>
</form>
<script>
  const estadoSelect = document.getElementById("estado");
  const motivoContainer = document.getElementById("motivoCancelacionContainer");

  function verificarEstado() {
    if (estadoSelect.value === "Cancelado") {
      motivoContainer.style.display = "block";
    } else {
      motivoContainer.style.display = "none";
    }
  }

  estadoSelect.addEventListener("change", verificarEstado);
  verificarEstado(); // Ejecutar en la carga inicial por si ya está seleccionado
</script>

<?php include("../partials/footerCrud.php"); ?>