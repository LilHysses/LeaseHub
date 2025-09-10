<?php
include("../models/conexion.php");
include("../models/modelPagina.php");

// Carga manual de PHPMailer
require_once __DIR__ . "/phpmailer/PHPMailer.php";
require_once __DIR__ . "/phpmailer/SMTP.php";
require_once __DIR__ . "/phpmailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start(); // Necesario para manejar el código de verificación

$conexion = new Conexion();
$metodosPagina = new MetodosVista($conexion->getConexion());

if (isset($_POST['Recuperar'])) {
    $email = trim($_POST['correo']); // Eliminar espacios en blanco

    // Verificar que el correo no esté vacío
    if (empty($email)) {
        $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'El correo electrónico es obligatorio.','mensaje'=>''];
        exit;
    }

    $fila = $metodosPagina->RecuperarPassword($email);

    if ($fila > 0) {
        // Generar y guardar el código
        $codigo = rand(100000, 999999);
        $_SESSION['codigo_verificacion'] = $codigo;
        $_SESSION['correo_verificacion'] = $email;

        enviarCodigoVerificacion($email, $codigo); // Enviar código por correo

        header("Location: ../views/partials/codigo.php");
    } else {
        $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'El correo no está registrado.','mensaje'=>''];
        header("location: ../views/index.php");
        exit;

    }
}

if (isset($_POST['ValidarCodigo'])) {
    $codigoIngresado = trim($_POST['codigo']);

    if ($codigoIngresado == $_SESSION['codigo_verificacion']) {
        
        header("Location: ../views/partials/newPassword.php");
    } else {
        $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'El código ingresado es incorrecto.','mensaje'=>'Favor, digitelo nuevamente'];
        header("location: ../views/partials/codigo.php");
        exit;
    }
}

if (isset($_POST['Verificar'])) {
    $email = trim($_POST['correo']);
    $newpassword=trim($_POST['newPassword']);
    $password = trim($_POST['contraseña']);

    if (empty($password) || empty($newpassword)) {
        echo "La contraseña es obligatoria.";
        exit;
    }

    $result = $metodosPagina->VerificarPassword($email, $password);

    if ($result) {
        enviarCodigoVerificacion($email); // Confirmación final
        $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Contraseña actualizada correctamente.','mensaje'=>''];
        header("location: ../views/index.php");
    } else {
        $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al actualizar contraseña.','mensaje'=>''];
        header("location: ../views/index.php");
    }
}

// ✅ función PHPMailer modificada para aceptar también código de verificación si se desea
function enviarCodigoVerificacion($email, $codigo = null)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'milkchocoprueba@gmail.com';
        $mail->Password   = 'sqamlxqxcdbqvpmj'; // ⚠️ Reemplaza por clave de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('milkchocoprueba@gmail.com', 'LEASEHUB');
        $mail->addAddress($email);

        $mail->isHTML(true);
        if ($codigo) {
            $mail->Subject = 'Codigo de Verificacion';
            $mail->Body = '
    <div style="font-family: Arial, sans-serif; color: #333;">
        <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
            <div style="text-align: center;">
                <img src="https://i.imgur.com/D17bM51.png" alt="LeaseHub" style="width: 120px; margin-bottom: 20px;">
                <h2 style="color: #2a2a2a;">Código de Verificación</h2>
            </div>
            <p style="font-size: 16px;">Tu código de verificación es:</p>
            <div style="font-size: 24px; font-weight: bold; color: #007bff; margin: 20px 0; text-align: center;">
                ' . htmlspecialchars($codigo) . '
            </div>
            <p>Ingresa este código en la plataforma para continuar con el proceso.</p>
            <p style="font-size: 14px; color: #777;">— Equipo LeaseHub</p>
        </div>
    </div>
';
        } else {
            $mail->Subject = 'Cambio de Contraseña';
            $mail->Body = '
    <div style="font-family: Arial, sans-serif; color: #333;">
        <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
            <div style="text-align: center;">
                <img src="https://i.imgur.com/D17bM51.png" alt="LeaseHub" style="width: 120px; margin-bottom: 20px;">
                <h2 style="color: #2a2a2a;">Contraseña Actualizada</h2>
            </div>
            <p style="font-size: 16px;">Tu contraseña ha sido actualizada correctamente.</p>
            <p>Si no realizaste este cambio, por favor contáctanos inmediatamente.</p>
            <p style="font-size: 14px; color: #777;">— Equipo LeaseHub</p>
        </div>
    </div>
';
        }

        $mail->send();
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="/public/css/password.css">
</head>
<body>
    
</body>
</html>