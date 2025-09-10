<?php
session_start();
require_once("../models/modelQueja.php");

require_once __DIR__ . "/phpmailer/PHPMailer.php";
require_once __DIR__ . "/phpmailer/SMTP.php";
require_once __DIR__ . "/phpmailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conexion = new Conexion();
$quejaModel = new Quejas($conexion->getConexion());


if (isset($_POST['btnmodificar'])) {

    
    $idqueja = $_POST['id'];
    $descripcion = $_POST['descripcion'];
    $respuesta = $_POST['respuesta'];
    $correo = $_POST['correo']; // ← ya lo tienes en el formulario

    // Actualiza la queja
    $quejaModel->actualizarQueja($idqueja, $correo, $descripcion, $respuesta);

    // Si hay una respuesta, se envía el correo
    if (!empty(trim($respuesta))) {

        // Obtener nombre del usuario (si lo tienes en DB)
        $datos = $quejaModel->getCorreoUsuarioPorQueja($idqueja);
        $nombre = $datos ? $datos['u_nombre'] : 'Usuario';

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jesusrodriguezrocha10@gmail.com';
            $mail->Password   = 'lwum mqcm ntbg yjgu'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('jesusrodriguezrocha10@gmail.com', 'LeaseHub');
            $mail->addAddress($correo, $nombre);
            $mail->isHTML(true);
            $mail->Subject = 'Respuesta a tu PQR';
            $mail->Body = '
    <div style="font-family: Arial, sans-serif; color: #333;">
        <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px;">
            <div style="text-align: center;">
            <h2 style="color: #2a2a2a;">Soporte de LeaseHub</h2>
                <img src="https://i.imgur.com/D17bM51.png" alt="LeaseHub" style="width: 120px; margin-bottom: 20px;">
                <h2 style="color: #2a2a2a;">Respuesta a tu PQR</h2>
            </div>
            <p>Hola <strong>' . htmlspecialchars($nombre) . '</strong>,</p>
            <p>Hemos revisado tu solicitud y te compartimos nuestra respuesta:</p>
            <div style="background-color: #ffffff; padding: 15px; border-left: 5px solid #007bff; margin: 20px 0;">
                <em>' . nl2br(htmlspecialchars($respuesta)) . '</em>
            </div>
            <p>Gracias por contactarnos. Si tienes más dudas, no dudes en escribirnos.</p>
            <br>
            <p style="font-size: 14px; color: #777;">— Equipo LeaseHub</p>
        </div>
    </div>
';
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Repuesta enviada Correctamente.','mensaje'=>''];

        $mail->send();
        } catch (Exception $e) {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al enviar correo: ','mensaje'=>$mail->ErrorInfo];

        }
    }

    header('Location: ../views/viewCruds/vistaQueja.php');
}

if (isset($_GET['eliminar'])) {
    $idqueja = $_GET['id'];

    if (!empty($idqueja)) {
        $queja = $quejaModel->eliminarQueja($idqueja);

        if ($queja) {
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro eliminado correctamente','mensaje'=>''];
        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al eliminar el registro','mensaje'=>''];

        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'ID no válido','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaQueja.php');
    exit();
}

?>