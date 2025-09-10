<?php
ob_start(); // evitar salida antes del header

$idinmueble = $_GET['id_inmueble'] ?? null;

if (!$idinmueble) {
    echo "ID del inmueble no encontrado.";
    exit();
}

include('./partials/header.php');
include("../models/modelReserva.php");

$conexion = new Conexion();
$reserva = new Reserva($conexion->getConexion());

if (isset($_SESSION['correo'])) {
    $correo = $_SESSION['correo'];
    $datosReserva = $reserva->datosReserva($correo);
} else {
    $_SESSION['alerta'] = ['tipo'=>'error', 'titulo'=>'Inicie sesión','mensaje'=>'Para agendar una cita'];
    header("location: inmuebles.php");
    exit;
}

// Guardar URL anterior para enviar a controlador
$regresar = $_SERVER['HTTP_REFERER'] ?? '../views/compra.php';
?>
  <link rel="stylesheet" href="../../public/css/visit.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="formp">
    <form action="../controllers/controlReserva.php" method="post">
        <input type="hidden" name="id_inmueble" value="<?= $idinmueble ?>">
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($regresar) ?>">

        <label for="user">Nombre</label>
        <input type="text" name="user" id="user" value="<?= $datosReserva['u_nombre'] . " " . $datosReserva['u_apellido'] ?>" readonly>

        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
        <input type="date" name="fecha" id="fecha">

        <label for="hora" class="form-label">Hora</label>
        <input type="time" name="hora" id="hora">
        
        <div class="btn-reserva">
            <!-- Se eliminó la clase "pvisit" del botón de enviar -->
            <button name="send" type="submit">Enviar</button>
            <a href="<?= htmlspecialchars($regresar) ?>" class="pvisit">Regresar</a>
        </div>
    </form>
</div>

<?php include('./partials/footer.php'); ?>
