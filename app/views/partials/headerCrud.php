<?php 
session_start(); 
ob_start();

$correo = $_SESSION['correo'] ?? null;
$rol = $_SESSION['rol'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeaseHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/cruds.css">
    <script src="https://kit.fontawesome.com/3e3060d435.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="title">
        <h1 class="text-center">LEASEHUB</h1>
        <a href="/app/views/perfil.php" class="salir"><i class="fa-solid fa-person-walking-arrow-right fa-2xl"></i></a>
        <ul>
            <?php if ($rol === 'Administrador'): ?>
                <li><a href="/app/views/viewCruds/vistaUsuarios.php">Usuario</a></li>
                <li><a href="/app/views/viewCruds/vistaTipoUsuario.php">Tipo de Usuario</a></li>
                <li><a href="/app/views/viewCruds/vistaInmuebles.php">Inmueble</a></li>
                <li><a href="/app/views/viewCruds/vistaTipoInmueble.php">Tipo de Inmueble</a></li>
                <li><a href="/app/views/viewCruds/vistaTipoPago.php">Tipo de Pago</a></li>
                <li><a href="/app/views/viewCruds/vistaReserva.php">Citas</a></li>
                <li><a href="/app/views/viewCruds/vistaReseña.php">Reseña</a></li>
                <li><a href="/app/views/viewCruds/vistaQueja.php">Quejas</a></li>
            <?php elseif ($rol === 'Propietario'): ?>
                <li><a href="/app/views/viewCruds/vistaInmuebles.php">Inmueble</a></li>
                <li><a href="/app/views/viewCruds/vistaReseña.php">Reseña</a></li>
                <li><a href="/app/views/viewCruds/vistaReserva.php">Citas</a></li>
            <?php endif; ?>
        </ul>
    </div>
