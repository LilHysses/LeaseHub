<?php
session_start();
require_once("../models/conexion.php");
require_once("../models/modelReseña.php");

$conexion = new Conexion();
$reseñaModel = new Reseña($conexion->getConexion());

if (isset($_POST['btnregistrar'])) {
    $id = $_POST["id"];
    $calificacion = $_POST["calificacion"];
    $fecha = $_POST["fecha"];
    $usuario = $_POST["usuario"];
    $inmueble = $_POST["inmueble"];

    if (!empty($id) && !empty($calificacion) && !empty($fecha) && !empty($usuario) && !empty($inmueble)) {
        // Validar si ya existe el ID
        $existe = $reseñaModel->consultarReseña($id);

        if ($existe) {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'No se puede registrar','mensaje'=>'El ID de reseña ya existe.'];

        } else {
            $resultado = $reseñaModel->registrarReseña($id, $calificacion, $fecha, $usuario, $inmueble);
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Reseña registrada correctamente','mensaje'=>''];

        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Todos los campos son obligatorios','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaReseña.php');
    exit();
}


if (isset($_POST['btnmodificar'])) {
    $idreseña = $_POST["id"];
    $calificacion = $_POST["calificacion"];
    $fecha = $_POST["fecha"];
    $usuario = $_POST["usuario"];
    $inmueble = $_POST["inmueble"];

    if (!empty($idreseña) && !empty($calificacion) && !empty($fecha) && !empty($usuario) && !empty($inmueble)) {
        $resultado = $reseñaModel->actualizarReseña($idreseña, $calificacion, $fecha, $usuario, $inmueble);

        if ($resultado) {
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Reseña actualizada correctamente','mensaje'=>''];

        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al actualizar la reseña','mensaje'=>''];

        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'info','titulo'=>'Por favor, complete todos los campos para actualizar la reseña.','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaReseña.php');
    exit();
}


if (isset($_GET['eliminar'])) {
    $idreseña = $_GET['id'];

    if (!empty($idreseña)) {
        $resultado = $reseñaModel->eliminarReseña($idreseña);

        if ($resultado) {
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Reseña eliminada correctamente','mensaje'=>''];

        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al eliminar la reseña','mensaje'=>''];
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'ID no válido','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaReseña.php');
    exit();
}
