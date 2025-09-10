<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="/public/css/olvidar.css">
</head>
<body>
    <?php 
        session_start();
        
    ?>
    <div class="recovery-container">
             
        <div class="recovery-header">
            <div class="recovery-icon">
                <span class="lock-icon"></span>
            </div>
            <h1 class="recovery-title">Recuperar</h1>
            <p class="recovery-subtitle">Correo electrónico</p>
            <p class="recovery-description">
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña
            </p>
        </div>

        <div class="recovery-content">
            <div class="success-message" id="successMessage">
                ¡Correo enviado! Revisa tu bandeja de entrada y sigue las instrucciones.
            </div>

            <div class="error-message" id="errorMessage">
                No se pudo enviar el correo. Por favor, verifica tu dirección e inténtalo de nuevo.
            </div>

            <!-- Formulario inicial -->
            <div id="recoveryForm">
                <form action="/app/controllers/controlPassword.php" method="post">
                    <div class="form-group">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="correo"
                            class="form-input" 
                            placeholder="ej: user@example.com"
                            required
                            autocomplete="email"
                        >
                    </div>

                    <button type="submit" class="recovery-btn" id="recoveryBtn" name="Recuperar">
                        Recuperar
                    </button>
                </form>
            </div>

            <!-- Estado después de enviar el correo -->
            <div class="email-sent-state" id="emailSentState">
                <div class="email-sent-icon">
                    <span class="email-icon"></span>
                </div>
                <h3 style="color: #1e293b; margin-bottom: 12px; font-size: clamp(16px, 3vw, 18px);">
                    ¡Correo Enviado!
                </h3>
                <p style="color: #6b7280; font-size: clamp(12px, 2.4vw, 13px); line-height: 1.4; margin-bottom: 16px;">
                    Hemos enviado un enlace de recuperación a tu correo electrónico. 
                    Revisa tu bandeja de entrada y carpeta de spam.
                </p>
                <div class="resend-timer" id="resendTimer">
                    Podrás reenviar el correo en <span id="countdown">60</span> segundos
                </div>
                <button class="resend-btn" id="resendBtn" onclick="resendEmail()" disabled>
                    Reenviar correo
                </button>
            </div>

            <div class="back-to-login">
                <a href="#" onclick="backToLogin()">
                    <span class="arrow-left"></span>
                    Volver al inicio de sesión
                </a>
            </div>
        </div>
    </div>

    <script>
        let countdownInterval;

function backToLogin() {
    Swal.fire({
        title: '¿Desea volver al inicio de sesión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Redirigiendo al login...',
                icon: 'info',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "login.php";
            });
        }
    });
}

        // Validación en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.value) && this.value.trim() !== '') {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#e2e8f0';
                }
            });
            
            emailInput.addEventListener('input', function() {
                if (this.style.borderColor === 'rgb(239, 68, 68)') {
                    this.style.borderColor = '#e2e8f0';
                }
                
                // Ocultar mensajes de error al escribir
                const errorMessage = document.getElementById('errorMessage');
                if (errorMessage.classList.contains('show')) {
                    errorMessage.classList.remove('show');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>