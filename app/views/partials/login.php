<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/public/css/login.css">
    
</head>
<body>
    <div class="login-container">
        <button class="close-btn" onclick="closeForm()">
            <span class="close-icon"></span>
        </button>
        
        <div class="login-header">
            <div class="profile-icon">
                <span class="user-icon"></span>
            </div>
            <h1 class="login-title">Iniciar Sesión</h1>
            <p class="login-subtitle">Ingresa tus datos para acceder</p>
        </div>

        <div class="login-content">
            <div class="error-message" id="errorMessage">
                Credenciales incorrectas. Por favor, inténtalo de nuevo.
            </div>

            <form id="loginForm" action="/app/controllers/controlPagina.php" method="post">
                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="correo" 
                        class="form-input" 
                        placeholder="Correo"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <div class="password-container">
                        <input 
                            type="password" 
                            id="password" 
                            name="contraseña" 
                            class="form-input" 
                            placeholder="Contraseña"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <span class="eye-icon" id="eyeIcon"></span>
                        </button>
                    </div>
                </div>

                <button type="submit" class="login-btn" id="loginBtn" name="iniciar">
                    Iniciar Sesión
                </button>
            </form>

            <div class="forgot-password">
                <a href="#" onclick="forgotPassword()">¿Olvidaste tu contraseña?</a>
            </div>

            <div class="register-link">
                ¿No tienes cuenta?
                <a href="#" onclick="goToRegister()">Regístrate aquí</a>
            </div>
        </div>
    </div>

    <script>
  
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'eye-slash-icon';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'eye-icon';
            }
        }

        function closeForm() {
             window.location.href = "/app/views/index.php";
        }

        function goToRegister(){
             window.location.href = "register.php";
        }

        function forgotPassword(){
            window.location.href = "olvidar.php";
        }

        // Validación en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.style.borderColor = '#ef4444';
                    } else {
                        this.style.borderColor = '#e2e8f0';
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.style.borderColor === 'rgb(239, 68, 68)') {
                        this.style.borderColor = '#e2e8f0';
                    }
                    
                    // Ocultar mensaje de error al escribir
                    const errorMessage = document.getElementById('errorMessage');
                    if (errorMessage.classList.contains('show')) {
                        errorMessage.classList.remove('show');
                    }
                });
            });
        });
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






</body>
</html>