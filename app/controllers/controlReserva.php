<?php 
session_start();
require_once("../models/modelReserva.php");

$conexion = new Conexion();
$reservaModel = new Reserva($conexion->getConexion());

$correo = $_SESSION['correo'];
$datosReserva = $reservaModel->datosReserva($correo);

if (isset($_POST['send'])) {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $idinmueble = $_POST['id_inmueble'];
    $estado = "Pendiente";
    $uid = $datosReserva['u_id'];

    $redirect = $_POST['redirect'] ?? '../views/compra.php';

    if (!empty($fecha) && !empty($hora)) {
        if ($reservaModel->PropietarioDelInmueble($uid, $idinmueble)) {
            $_SESSION['alerta'] = [
                'tipo' => 'error',
                'titulo' => 'No puedes agendar una cita a tu propio inmueble',
                'mensaje' => 'Intenta agendar en otro inmueble.'
            ];
            header("Location: ../views/inmuebles.php");
            exit;
        } elseif ($reservaModel->guardarReserva($fecha, $estado, $hora, $uid, $idinmueble)) {
            $_SESSION['alerta'] = [
                'tipo' => 'success',
                'titulo' => 'Cita Agendada Correctamente',
                'mensaje' => 'Te esperamos en la fecha indicada.'
            ];
            header("Location: $redirect");
            exit;
        } else {
            $_SESSION['alerta'] = [
                'tipo' => 'error',
                'titulo' => 'Error al agendar la cita',
                'mensaje' => 'Por favor, intenta nuevamente.'
            ];
            header("Location: $redirect");
            exit;
        }
    } else {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'titulo' => 'Fecha no válida',
            'mensaje' => 'Por favor, selecciona una fecha y hora para la cita.'
        ];
        header("Location: $redirect");
        exit;
    }
}


if (isset($_POST['consultar'])) {
    $idusuario = $_POST['idusuario'];

    if (!empty($idusuario)) {
       $usuario = $reservaModel->consultarReserva($idusuario);

        if ($usuario) {
            $_SESSION['idusuario'] = $idusuario; // Guardamos el ID consultado
            $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Consulta realizada correctamente','mensaje'=>''];
        } else {
            $_SESSION['alerta']=['tipo'=>'error','titulo'=>'No se encontró el usuario','mensaje'=>''];
            unset($_SESSION['idusuario']);
        }
    } else {
        $_SESSION['alerta']=['tipo'=>'info','titulo'=>'Por favor, ingresa un ID para consultar','mensaje'=>''];
        unset($_SESSION['idusuario']);
    }

    header('location: ../views/viewCruds/vistaReserva.php');
    exit();
}

if (isset($_POST['btnmodificar'])) {

    $idreserva=$_POST["id"];
    $fechainicio=$_POST["fecha1"];
    $estado=$_POST["estado"];
    $hora = $_POST["hora"];
    $usuario=$_POST["usuario"];
    $inmueble=$_POST["inmueble"];
    $motivo = isset($_POST['motivo_cancelacion']) ? $_POST['motivo_cancelacion'] : '';

    // Validación de campos no vacíos
    if (!empty($idreserva) && !empty($fechainicio) && !empty($hora) && !empty($estado) && !empty($usuario) &&
        !empty($inmueble)) {

        
            $reserva = $reservaModel->actualizarReserva($idreserva, $fechainicio, $estado, $hora, $usuario, $inmueble, $motivo);

            if ($reserva) {
                $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Registro actualizado correctamente','mensaje'=>''];

            } else {
                $_SESSION['alerta']=['tipo'=>'error','titulo'=>'Error al actualizar registro','mensaje'=>''];
            }
    } else {
        $_SESSION['alerta']=['tipo'=>'info','titulo'=>'Por favor, complete todos los campos para actualizar.','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaReserva.php');
}

if (isset($_GET['eliminar'])) {
    $idreserva = $_GET['id'];

    if (!empty($idreserva)) {
        $reserva = $reservaModel->eliminarReserva($idreserva);

        if ($reserva) {
        $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Registro eliminado correctamente','mensaje'=>''];
        } else {
        $_SESSION['alerta']=['tipo'=>'error','titulo'=>'Error al eliminar el registro','mensaje'=>''];
        }
    } else {
        $_SESSION['alerta']=['tipo'=>'warning','titulo'=>'ID no válido','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaReserva.php');
    exit();
}


?>
