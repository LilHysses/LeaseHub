<?php
session_start(); // IMPORTANTE: iniciar sesión siempre

require_once('../models/modelCompra.php');
require_once('../models/conexion.php');

$conexion = new Conexion();
$compraModel = new modelCompra($conexion->getConexion());

// Solo se usa para obtener datos (no se requiere incluir vista aquí)
if (isset($_GET['id'])) {
    $idinmueble = $_GET['id'];

    $inmueble = $compraModel->obtenerPorId($idinmueble);
    $comentarios = $compraModel->obtenerComentarios($idinmueble);
    $promedio = $compraModel->obtenerPromedioCalificacion($idinmueble);

    if (!$inmueble) {
        $_SESSION['alerta']=['tipo'=>'error', 'titulo'=>'No hay resultados','mensaje'=>''];
        header("location: ../views/inmuebles.php");
        exit;
    }
}

// Procesar acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['u_id'] ?? null;
    $inmuebleId = $_POST['in_id'] ?? null;

    if (!$userId || !$inmuebleId) {
        $_SESSION['alerta']=['tipo'=>'error', 'titulo'=>'Usuario o inmueble no válido','mensaje'=>''];
        header("location: ../views/compra.php?id=$inmuebleId");
        exit;
    }

    // Manejo de calificación
    if (isset($_POST['re_calificacion'])) {
        $calificacion = (int) $_POST['re_calificacion'];
        $compraModel->manejarCalificacion($userId, $inmuebleId, $calificacion);

        header("Location: ../views/compra.php?id=$inmuebleId");
        exit;
    }

    // Nuevo comentario
    if (isset($_POST['send'])) {
        $comentario = trim($_POST['coment'] ?? '');
        if (!empty($comentario)) {
            $compraModel->insertarComentario($comentario, $userId, $inmuebleId);
            header("Location: ../views/compra.php?id=$inmuebleId");
            exit;
        } else {
        $_SESSION['alerta']=['tipo'=>'error', 'titulo'=>'El comentario no puede estar vacío','mensaje'=>''];
        header("location: ../views/compra.php?id=$inmuebleId");
        exit;
        }
    }

    // Eliminar comentario
    if (isset($_POST['delete']) && isset($_POST['comentario_id'])) {
        $comentarioId = (int)$_POST['comentario_id'];
        $compraModel->eliminarComentario($comentarioId, $userId);

        header("Location: ../views/compra.php?id=$inmuebleId");
        exit;
    }

    // Favoritos (añadir o quitar)
    if (isset($_POST['fav'])) {
        $compraModel->manejarFavorito($userId, $inmuebleId);
        header("Location: ../views/compra.php?id=$inmuebleId");
        exit;
    }
}
?>
