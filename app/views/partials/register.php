 <?php session_start()  ?>
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="/public/css/registrar.css">
</head>
<body>
    <?php
    include("../../models/modelPagina.php");
    $conexion = new Conexion();
    $metodosPagina = new MetodosVista($conexion->getConexion());
    ?>
    <div class="form-container">
        <div class="form-header">
            <button class="close-btn" onclick="closeForm()">
                <span class="close-icon"></span>
            </button>
            <h1 class="form-title">Registro de Usuario</h1>
            <p class="form-subtitle">Complete todos los campos para crear su cuenta</p>
            
            <div class="profile-section">
                <div class="avatar-container">
                    <div class="avatar">
                        <span class="user-icon"></span>
                    </div>
                    <button class="camera-btn" onclick="changeImage()">
                        <span class="camera-icon"></span>
                    </button>
                </div>
                <button class="change-image-btn" onclick="changeImage()">Cambiar Imagen</button>
            </div>
        </div>

        <div class="form-content">
            <form id="registrationForm" method="post" enctype="multipart/form-data" action="/app/controllers/controlPagina.php">
                <input type="file" name="imagenperfil" id="imageInput" accept="image/*" style="display: none;">
                <div class="form-grid">
                    <!-- Fila 1: Identificación y Correo -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="identificacion">Identificación</label>
                            <input 
                                type="text" 
                                id="identificacion" 
                                name="identificacion"
                                class="form-input" 
                                placeholder="Ingrese su identificación"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="correo">Correo Electrónico</label>
                            <input 
                                type="email" 
                                id="correo" 
                                name="correo" 
                                class="form-input" 
                                placeholder="ejemplo@correo.com"
                                required
                            >
                        </div>
                    </div>

                    <!-- Fila 2: Nombres y Dirección -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="nombres">Nombres</label>
                            <input 
                                type="text" 
                                id="nombres" 
                                name="nombres" 
                                class="form-input" 
                                placeholder="Ingrese sus nombres"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="direccion">Dirección</label>
                            <input 
                                type="text" 
                                id="direccion" 
                                name="direccion" 
                                class="form-input" 
                                placeholder="Ingrese su dirección"
                                required
                            >
                        </div>
                    </div>

                    <!-- Fila 3: Apellidos y Teléfono -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="apellidos">Apellidos</label>
                            <input 
                                type="text" 
                                id="apellidos" 
                                name="apellidos" 
                                class="form-input" 
                                placeholder="Ingrese sus apellidos"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="telefono">Teléfono</label>
                            <input 
                                type="tel" 
                                id="telefono" 
                                name="telefono" 
                                class="form-input" 
                                placeholder="Ingrese su teléfono"
                                required
                            >
                        </div>
                    </div>

                    <!-- Fila 4: Tipo de Usuario y Contraseña -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="tipoUsuario">Tipo de Usuario</label>
                            <select id="tipoUsuario" name="tipousuario" class="form-select" required>
                                <option value="">Seleccione</option>
                                <?php

                                $metodosPagina->UsuariosSelect($tipousuario);

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="contrasena">Contraseña</label>
                            <input 
                                type="password" 
                                id="contrasena" 
                                name="contraseña"
                                class="form-input" 
                                placeholder="Ingrese su contraseña"
                                required
                            >
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div class="form-group full-width">
                        <label class="form-label" for="descripcion">Descripción</label>
                        <textarea 
                            id="descripcion" 
                            name="descripcion" 
                            class="form-textarea" 
                            placeholder="Escriba aquí una breve descripción..."
                        ></textarea>
                    </div>

                    <!-- Botón de envío -->
                    <button type="submit" class="submit-btn" name="registrarme">
                        Registrarme
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function handleSubmit(event) {
            event.preventDefault();
            
            // Recopilar datos del formulario
            const formData = new FormData(event.target);
            const data = Object.fromEntries(formData.entries());
            
            console.log('Datos del formulario:', data);
            
            // Aquí puedes agregar la lógica para enviar los datos
            alert('¡Formulario enviado correctamente! Revisa la consola para ver los datos.');
        }

        function closeForm() {
            window.location.href = "login.php";
        }

        function changeImage() {
            // Crear input file oculto
            const input = document.getElementById('imageInput');
            
            input.onchange = function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const avatar = document.querySelector('.avatar');
                        avatar.innerHTML = `<img src="${e.target.result}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                    };
                    reader.readAsDataURL(file);
                }
            };
            
            input.click();
        }

        // Validación en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');
            
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