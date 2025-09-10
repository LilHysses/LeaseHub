<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contraseña</title>
    <link rel="stylesheet" href="/public/css/newPass.css">
</head>
<body>
    <?php 
        session_start();

        $correo = $_SESSION['correo_verificacion'] ?? '';
    ?>
    <div class="password-container">
        <button class="close-btn" onclick="closeForm()">
            <span class="close-icon"></span>
        </button>
        
        <div class="password-header">
            <div class="password-icon">
                <span class="lock-icon"></span>
            </div>
            <h1 class="password-title">Actualizar contraseña</h1>
            <p class="password-subtitle">Nueva contraseña:</p>
            <p class="password-description">
                Crea una contraseña segura para proteger tu cuenta
            </p>
        </div>

        <div class="password-content">
            <div class="success-message" id="successMessage">
                ¡Contraseña actualizada correctamente! Redirigiendo al login...
            </div>

            <div class="error-message" id="errorMessage">
                Error al actualizar la contraseña. Inténtalo de nuevo.
            </div>

            <form id="passwordForm" method="post" action="/app/controllers/controlPassword.php">
                <input type="hidden" name="correo" value="<?php echo $correo ?>">
                <div class="form-group">
                    <label class="form-label" for="newPassword">Nueva contraseña</label>
                    <div class="password-input-container">
                        <input 
                            type="password" 
                            id="newPassword" 
                            name="newPassword" 
                            class="form-input" 
                            placeholder="Ingresa tu nueva contraseña"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword('newPassword')">
                            <span class="eye-icon" id="eyeIcon1"></span>
                        </button>
                    </div>
                    
                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Ingresa una contraseña</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirmPassword">Confirmar contraseña</label>
                    <div class="password-input-container">
                        <input 
                            type="password" 
                            id="confirmPassword" 
                            name="contraseña" 
                            class="form-input" 
                            placeholder="Confirma tu nueva contraseña"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')" >
                            <span class="eye-icon" id="eyeIcon2"></span>
                        </button>
                    </div>
                </div>

                <div class="password-requirements">
                    <div class="requirements-title">Requisitos de contraseña:</div>
                    <div class="requirement" id="req-length">
                        <div class="requirement-icon">✓</div>
                        Al menos 8 caracteres
                    </div>
                </div>

                <button type="submit" class="password-btn" id="passwordBtn" name="Verificar" disabled>
                    Actualizar Contraseña
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
        document.addEventListener('DOMContentLoaded', function() {
            const newPasswordInput = document.getElementById('newPassword');
            const confirmPasswordInput = document.getElementById('contraseña');
            const passwordBtn = document.getElementById('passwordBtn');

            newPasswordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                validateForm();
            });

            confirmPasswordInput.addEventListener('input', function() {
                checkPasswordMatch();
                validateForm();
            });
        });

        function checkPasswordStrength(password) {
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');
            
            const length = password.length;

            // Actualizar indicador de longitud si existe (opcional)
            const lengthReq = document.getElementById('req-length');
            if (lengthReq) {
                if (length >= 8) {
                    lengthReq.classList.add('met');
                } else {
                    lengthReq.classList.remove('met');
                }
            }

            // Determinar nivel de fortaleza
            let strength = 'weak';
            let strengthClass = 'strength-weak';
            let strengthTextClass = 'strength-weak-text';

            if (length >= 8) {
                strength = 'strong';
                strengthClass = 'strength-strong';
                strengthTextClass = 'strength-strong-text';
            } else if (length >= 6) {
                strength = 'good';
                strengthClass = 'strength-good';
                strengthTextClass = 'strength-good-text';
            } else if (length >= 4) {
                strength = 'fair';
                strengthClass = 'strength-fair';
                strengthTextClass = 'strength-fair-text';
            }

            // Actualizar barra de fortaleza visual
            strengthFill.className = `strength-fill ${strengthClass}`;
            strengthText.className = `strength-text ${strengthTextClass}`;

            const strengthTexts = {
                weak: 'Contraseña débil',
                fair: 'Contraseña regular',
                good: 'Contraseña buena',
                strong: 'Contraseña fuerte'
            };

            strengthText.textContent = strengthTexts[strength];

            return length >= 8; // mínima recomendada
        }


        function checkPasswordMatch() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const confirmInput = document.getElementById('confirmPassword');

            if (confirmPassword && newPassword !== confirmPassword) {
                confirmInput.classList.add('invalid');
                confirmInput.classList.remove('valid');
                return false;
            } else if (confirmPassword && newPassword === confirmPassword) {
                confirmInput.classList.add('valid');
                confirmInput.classList.remove('invalid');
                return true;
            } else {
                confirmInput.classList.remove('valid', 'invalid');
                return false;
            }
        }



        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId === 'newPassword' ? 'eyeIcon1' : 'eyeIcon2');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.className = 'eye-slash-icon';
            } else {
                input.type = 'password';
                eyeIcon.className = 'eye-icon';
            }
        }

        function showError(message) {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorMessage.classList.add('show');
            
            setTimeout(() => {
                errorMessage.classList.remove('show');
            }, 5000);
        }

        function closeForm() {
            if (confirm('¿Está seguro de que desea cancelar la actualización de contraseña?')) {
                window.location.href = "/app/views/index.php";
            }
        }

        function goBack() {
            if (confirm('¿Desea volver al paso anterior?')) {
                alert('Volviendo a la verificación del correo...');
                window.location.href="olvidar.php"
            }
        }

        function validarCoincidenciaContrasenas() {
        const password = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        const boton = document.getElementById('passwordBtn');

        if (password && confirm && password === confirm) {
            boton.disabled = false;
        } else {
            boton.disabled = true;
        }
    }
    document.getElementById('newPassword').addEventListener('input', validarCoincidenciaContrasenas);
    document.getElementById('confirmPassword').addEventListener('input', validarCoincidenciaContrasenas);

    </script>
</body>
</html>