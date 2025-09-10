<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Código</title>
    <link rel="stylesheet" href="/public/css/code.css">
</head>
<body>
    <?php 
        session_start();
        $correo = $_SESSION['correo_verificacion'] ?? '';
    ?>
    <div class="verify-container">
        <button class="close-btn" onclick="closeForm()">
            <span class="close-icon"></span>
        </button>
        
        <div class="verify-header">
            <div class="verify-icon">
                <span class="shield-icon"></span>
            </div>
            <h1 class="verify-title">Verificar Código</h1>
            <p class="verify-subtitle">Código enviado a tu correo:</p>
            <div class="email-display" id="emailDisplay">
                <?php echo $correo  ?>
            </div>
            <p class="verify-description">
                Ingresa el código de 6 dígitos que enviamos a tu correo electrónico
            </p>
        </div>

        <div class="verify-content">
            <div class="success-message" id="successMessage">
                ¡Código verificado correctamente! Redirigiendo...
            </div>

            <div class="error-message" id="errorMessage">
                Código incorrecto. Por favor, inténtalo de nuevo.
            </div>

            <form id="verifyForm" action="/app/controllers/controlPassword.php" method="post">
                <div class="code-input-container">
                    <label class="form-label">Ingresa el código de verificación</label>
                    <div class="code-inputs" id="codeInputs">
                        <input type="text" class="code-input" maxlength="1" data-index="0">
                        <input type="text" class="code-input" maxlength="1" data-index="1">
                        <input type="text" class="code-input" maxlength="1" data-index="2">
                        <input type="text" class="code-input" maxlength="1" data-index="3">
                        <input type="text" class="code-input" maxlength="1" data-index="4">
                        <input type="text" class="code-input" maxlength="1" data-index="5">
                    </div>
                </div>
                <input type="hidden" name="codigo" id="codigo">
                <button type="submit" class="verify-btn" name="ValidarCodigo" onclick="handleVerification()">
                    Validar Código
                </button>
            </form>

            <div class="back-link">
                <a href="#" onclick="goBack()">
                    <span class="arrow-left"></span>
                    Volver al paso anterior
                </a>
            </div>
        </div>
    </div>

    <script>
        let countdownInterval;
        const correctCode = '123456'; // Código de ejemplo para demo

        // Inicializar
        document.addEventListener('DOMContentLoaded', function() {
            setupCodeInputs();
            startResendCountdown();
            
            // Simular email del usuario (normalmente vendría de la sesión)
            const email = localStorage.getItem('recoveryEmail') || 'usuario@ejemplo.com';
            document.getElementById('emailDisplay').textContent = email;
        });

        function setupCodeInputs() {
            const inputs = document.querySelectorAll('.code-input');
            
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value.replace(/[^0-9]/g, '');
                    e.target.value = value;
                    
                    if (value) {
                        e.target.classList.add('filled');
                        e.target.classList.remove('error');
                        
                        // Mover al siguiente input
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    } else {
                        e.target.classList.remove('filled');
                    }
                    
                    // Auto-submit cuando todos los campos estén llenos
                    checkAutoSubmit();
                });
                
                input.addEventListener('keydown', function(e) {
                    // Permitir backspace para ir al input anterior
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = '';
                        inputs[index - 1].classList.remove('filled');
                    }
                    
                    // Permitir solo números
                    if (!/[0-9]/.test(e.key) && !['Backspace', 'Delete', 'Tab', 'Enter'].includes(e.key)) {
                        e.preventDefault();
                    }
                });
                
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const numbers = paste.replace(/[^0-9]/g, '').slice(0, 6);
                    
                    numbers.split('').forEach((num, i) => {
                        if (inputs[i]) {
                            inputs[i].value = num;
                            inputs[i].classList.add('filled');
                        }
                    });
                    
                    checkAutoSubmit();
                });
            });
        }

        function checkAutoSubmit() {
            const inputs = document.querySelectorAll('.code-input');
            const code = Array.from(inputs).map(input => input.value).join('');
            
            if (code.length === 6) {
                setTimeout(() => {
                    handleVerification(null, code);
                }, 500);
            }
        }

        function handleVerification() {

            document.getElementById('verifyForm').addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('.code-input');
            let codigo = '';
            inputs.forEach(input => codigo += input.value);
            document.getElementById('codigo').value = codigo;
            });
        }

 
        function closeForm() {
        Swal.fire({
            title: '¿Está seguro de que desea cancelar la verificación?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
            window.location.href = "olvidar.php";
            }
        });
        
        }

        function goBack() {
        Swal.fire({
            title: '¿Desea volver al paso anterior?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
            Swal.fire({
                title: 'Volviendo al formulario de recuperación...',
                icon: 'info',
                timer: 1500,
                showConfirmButton: false,
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "olvidar.php";
            });
            }
        });

        }
            </script>

          <?php if (isset($_SESSION['alerta'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION['alerta']['tipo'] ?>',
            title: '<?= $_SESSION['alerta']['titulo'] ?>',
            text: '<?= $_SESSION['alerta']['mensaje'] ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>