<?php include("./partials/header.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Quejas</title>
     <link rel="stylesheet" href="../../public/css/quejas.css">
</head>
<body>
    <div class="page-container">
        <!-- Ejemplo de contenido de página -->
        <div class="page-content">
            <div class="header-section">
                <h1>Centro de Ayuda</h1>
                <p>Estamos aquí para ayudarte con cualquier problema</p>
            </div>

            <!-- Formulario de quejas -->
            <div class="complaint-form-container">
                <div class="complaint-form-card">
                    <div class="form-grid">
                        <!-- Sección izquierda - Información -->
                        <div class="info-section">
                            <div class="info-content">
                                <div class="text-content">
                                    <h2>¿Presenció un error o tiene alguna solicitud?</h2>
                                    <p>Por favor díganos en qué podemos<br>mejorar o ayudarle.</p>
                                </div>

                                <!-- Ilustración de queja/problema -->
                                <div class="icon-container">
                                    <div class="icon-wrapper">
                                        <div class="main-icon">
                                            <!-- Icono de AlertTriangle -->
                                            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/>
                                                <path d="M12 9v4"/>
                                                <path d="m12 17 .01 0"/>
                                            </svg>
                                        </div>
                                        <div class="small-icon">
                                            <!-- Icono de MessageCircle -->
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección derecha - Formulario -->
                        <div class="form-section">
                            <div class="form-content">
                                <h3>¿Cuál es tu opinión?</h3>

                                <form  class="complaint-form" id="formQuejas" method="post" action="../controllers/controlPagina.php">
                                    <div class="textarea-container">
                                        <textarea 
                                            id="q_descripcion"
                                            name="q_descripcion"
                                            placeholder="Escriba el error que presencio o la solicitud aquí..." 
                                            required
                                        ></textarea>
                                    </div>

                                    <button type="submit" name="queja" class="submit-button">
                                        <span class="button-content">
                                            <!-- Icono de Send -->
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m22 2-7 20-4-9-9-4Z"/>
                                                <path d="M22 2 11 13"/>
                                            </svg>
                                            <span class="button-text">ENVIAR</span>
                                        </span>
                                        <span class="loading-content" style="display: none;">
                                            <div class="spinner"></div>
                                            <span>ENVIANDO...</span>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 
        </div>
    </div>


</body>
</html>

<?php include("./partials/footer.php"); ?>