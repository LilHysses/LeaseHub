<?php

include('./partials/header.php');
require_once('../models/conexion.php');
require_once('../models/modelCompra.php');
require_once('../models/modelPerfil.php');

$conexion = new Conexion();
$compraModel = new modelCompra($conexion->getConexion());


$idUsuario = $_SESSION['u_id'] ?? null;
$datos = [];

if (isset($_GET['id'])) {
    $idinmueble = $_GET['id'];
    $datos = $compraModel->obtenerPorId($idinmueble);
    $propietario = $compraModel->obtenerDatosPropietario($datos['u_id']);
if (!$datos) { 
  $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Inmueble no encontrado','mensaje'=>'']; header("location: ../views/inmuebles.php"); 
  exit; 
}
    $calificacionUsuario = 0;
    if ($idUsuario !== null) {
    $calificacionUsuario = $compraModel->obtenerCalificacionUsuario($idinmueble, $idUsuario);
    }
    
    $promedio = $compraModel->obtenerPromedioCalificacion($idinmueble);
    $inmuebles = $compraModel->obtenerPublicacionesPropietario($propietario['u_id']);

    $comentarios = $compraModel->obtenerComentarios($idinmueble);
}
?>
  <title>Detalle del Inmueble</title>
  <link rel="stylesheet" href="../../public/css/compra.css">
  <script src="../../public/js/compra.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<body>
<section class="main-content">
    <div class="pcontenedor">
        <!-- Galería de Imágenes con Calificación Integrada -->
        <div class="pgallery-container">
            <div class="gallery-header">
                <h1 class="property-title"><?= $datos['in_titulo'] ?></h1>
            </div>
            
            <div class="ppmain-image">
                <img id="largeImage" src="<?= $datos['in_imagen'] ?>" alt="Imagen grande">
                <div class="image-overlay">
                    <div class="image-counter">
                        <i class="bi bi-camera"></i>
                        <span>1 / 4</span>
                    </div>
                </div>
                <div class="pnav-arrows">
                    <span class="parrow left-arrow"><i class="bi bi-chevron-left"></i></span>
                    <span class="parrow right-arrow"><i class="bi bi-chevron-right"></i></span>
                </div>
            </div>
            
            <div class="pthumbnail-container">
                <img class="pthumbnail active" src="<?= $datos['in_imagen'] ?>" alt="" data-index="0">
                <img class="pthumbnail" src="<?= $datos['in_imagen2'] ?>" alt="" data-index="1">
                <img class="pthumbnail" src="<?= $datos['in_imagen3'] ?>" alt="" data-index="2">
                <img class="pthumbnail" src="<?= $datos['in_imagen4'] ?>" alt="" data-index="3">
            </div>

            <!-- Calificación General - JUSTO DEBAJO DEL CARRUSEL -->
            <div class="rating-below-carousel">
                <h3>Tu Calificación</h3>
                
                <?php if ($idUsuario): ?>
                    <!-- Estrellas interactivas para usuario logueado -->
                    <form method="post" action="../controllers/controlCompra.php" id="rating-form">
                        <input type="hidden" name="in_id" value="<?= $idinmueble ?>">
                        <input type="hidden" name="re_calificacion" id="selected-rating" value="0">
                        
                        <div class="pstar-container">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="<?= ($i <= $calificacionUsuario) ? 'fas fa-star text-warning' : 'far fa-star' ?> star" data-value="<?= $i ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </form>
                <?php endif; ?>
                <h3>Calificación General</h3>
                <!-- Calificación promedio -->
                <div class="rating-display">
                    <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?= ($i <= round($promedio)) ? 'fas fa-star text-warning' : 'far fa-star' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-number"><?= round($promedio, 1) ?></span>
                </div>
            </div>

            <!-- Sección de Favoritos -->
            <?php if ($idUsuario): ?>
            <div class="pfav-inline">
                <form action="../controllers/controlCompra.php" method="post">
                    <input type="hidden" name="in_id" value="<?= $idinmueble ?>">
                    <button name="fav" type="submit" class="favorite-btn">
                        <i class="bi bi-heart"></i>
                        Añadir a favoritos
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>

        <!-- Panel de Información Mejorado -->
        <div class="pcontenedor-2">
            <div class="pinformation">
                <!-- Perfil del Propietario Mejorado -->
                <div class="owner-card">
                    <div class="perfilpropietario">
                        <div class="owner-avatar">
                            <img id="profileImage" src="<?= $propietario['u_imagen'] ?>" alt="Imagen de perfil">
                            <div class="online-indicator"></div>
                        </div>
                        <div class="owner-info">
                            <h4><?= $propietario['u_nombre']." ".$propietario['u_apellido'] ?></h4>
                            <p class="owner-role">Propietario Verificado</p>
                            <div class="owner-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>5.0</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="owner-actions">
                        <button type="button" class="btn-ver-perfil" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-person-circle"></i> Ver Perfil Completo
                        </button>
                    </div>
                </div>

                <!-- Modal del Propietario -->
                <?php
                $telefonoLimpio = preg_replace('/[^0-9]/', '', $propietario['u_telefono']);
                $mensajeWhatsapp = urlencode("Hola, estoy interesado en tu inmueble publicado en LeaseHub.");
                $asuntoCorreo = urlencode("Interesado en tu inmueble");
                $cuerpoCorreo = urlencode("Hola, me gustaría recibir más información sobre el inmueble que tienes publicado.");
                ?>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content act-1">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                    <i class="bi bi-person-badge"></i> Perfil del Propietario
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body act-perfil">
                                <form>
                                    <div class="owner-profile-header">
                                        <img src="<?= $propietario['u_imagen'] ?>" alt="Imagen de perfil">
                                        <div class="owner-profile-info">
                                            <h2><?= $propietario['u_nombre'] . " " . $propietario['u_apellido'] ?></h2>
                                            <p class="owner-verified"><i class="bi bi-patch-check-fill"></i> Propietario Verificado</p>
                                        </div>
                                    </div>
                                    <div class="owner-description">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-card-text"></i> Descripción del propietario:
                                        </label>
                                        <p><?= $propietario['u_descripcion'] ?></p>
                                    </div>
                                    <div class="contact-buttons">
                                        <a href="mailto:<?= $propietario['u_correo'] ?>?subject=<?= $asuntoCorreo ?>&body=<?= $cuerpoCorreo ?>" 
                                           class="btn btn-outline-primary">
                                            <i class="bi bi-envelope-fill"></i> Correo
                                        </a>
                                        <a href="https://wa.me/<?= $telefonoLimpio ?>?text=<?= $mensajeWhatsapp ?>" 
                                           class="btn btn-outline-success" target="_blank">
                                            <i class="bi bi-whatsapp"></i> WhatsApp
                                        </a>
                                    </div>
                                    <div class="owner-properties">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-buildings"></i> Inmuebles del propietario:
                                        </label>
                                        <?php if (count($inmuebles) > 0): ?>
                                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                                                <?php foreach ($inmuebles as $row): ?>
                                                    <div class="col">
                                                        <div class='card-publi'>
                                                            <a href="compra.php?id=<?= $row['in_id'] ?>">
                                                                <img src="../../public/img/inmuebles/<?= basename($row['in_imagen']) ?>"> 
                                                            </a>
                                                            <div class='card-content2'>
                                                                <h2 class='card-title'><?= htmlspecialchars($row['in_titulo']) ?></h2>
                                                                <p class='card-description'><?= htmlspecialchars($row['in_direccion']) ?></p>
                                                            </div>
                                                            <p class='card-price'>$<?= number_format($row['in_precio'], 0, ',', '.') ?><p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-warning text-center">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                Este propietario aún no ha publicado inmuebles.
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle"></i> Cerrar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información del Inmueble Mejorada -->
                <div class="property-details">
                    <div class="property-info-header">
                        <h5><i class="bi bi-info-circle"></i> Información del Inmueble</h5>
                    </div>
                    
                    <div class="property-specs">
                        <div class="spec-item">
                            <i class="bi bi-geo-alt"></i>
                            <div>
                                <strong>Ubicación</strong>
                                <p><?= $datos['in_direccion'] ?></p>
                            </div>
                        </div>
                        <div class="spec-item">
                            <i class="bi bi-map"></i>
                            <div>
                                <strong>Barrio</strong>
                                <p><?= $datos['in_barrio'] ?></p>
                            </div>
                        </div>
                        <div class="spec-item">
                            <i class="bi bi-check-circle"></i>
                            <div>
                                <strong>Estado</strong>
                                <p><?= $datos['in_estado'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="property-description">
                        <h6><i class="bi bi-card-text"></i> Descripción</h6>
                        <p><?= $datos['in_descripcion'] ?></p>
                    </div>
                    <div class="price-section">
                        <span class="precio-verde">$<?= number_format($datos['in_precio'], 2) ?></span>
                        <small class="price-note">Precio final</small>
                    </div>
                    <form action="../views/visit.php" method="get" class="action-form">
                        <input type="hidden" name="id_inmueble" value="<?= $idinmueble ?>">
                        <div class="pbotones-links">
                            <button type="submit" class="pvisit">
                                <i class="bi bi-calendar-check"></i>
                                Agendar Cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Comentarios y Mapa lado a lado -->
    <div class="comments-map-container">
        <!-- Columna de Comentarios (Izquierda) -->
        <div class="comments-column">
            <?php if ($idUsuario): ?>
                <div class="comentario">
                    <div class="comment-header">
                        <h4><i class="bi bi-chat-dots"></i> Deja tu Comentario</h4>
                    </div>
                    <form method="post" class="form-comentario" action="../controllers/controlCompra.php">
                        <div class="comment-input-group">
                            <textarea name="coment" placeholder="Comparte tu experiencia con este inmueble..." required></textarea>
                            <input type="hidden" name="in_id" value="<?= $idinmueble ?>">
                            <button type="submit" name="send">
                                <i class="bi bi-send"></i> Enviar Comentario
                            </button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="comentario2">
                    <div class="login-prompt">
                        <i class="bi bi-person-plus"></i>
                        <h4>¿Quieres dejar un comentario?</h4>
                        <p>Inicia sesión para compartir tu experiencia y valorar este inmueble.</p>
                        <a href="/app/views/partials/login.php" class="btn btn-primary">Iniciar Sesión</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="comments-list">
                <div class="comments-header">
                    <h4><i class="bi bi-chat-square-text"></i> Comentarios (<?= count($comentarios) ?>)</h4>
                </div>
                
                <?php foreach ($comentarios as $comentario): ?>
                    <div class="comentarios" id="comentario-<?= $comentario['c_id'] ?>">
                        <div class="comment-avatar">
                            <img src="<?= $comentario['u_imagen'] ?>" alt="Imagen de usuario" />
                        </div>
                        <div class="contenido-comentario">
                            <div class="comment-meta">
                                <strong><?= $comentario['u_nombre'] . ' ' . $comentario['u_apellido'] ?></strong>
                                <span class="comment-date">Hace 2 días</span>
                            </div>
                            <form method="post" class="comentario-form" action="../controllers/controlCompra.php" style="display: flex;">
                                <div class="comment-content">
                                    <p><?= $comentario['c_com'] ?></p>
                                </div>
                                <input type="hidden" name="comentario_id" value="<?= $comentario['c_id'] ?>">
                                <input type="hidden" name="in_id" value="<?= $idinmueble ?>">
                                <?php if ($idUsuario == $comentario['u_id']): ?>
                                    <button type="submit" name="delete" class="eliminar-btn">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Columna del Mapa (Derecha) -->
        <div class="map-column">
            <?php if (!empty($datos['in_latitud']) && !empty($datos['in_longitud'])): ?>
            <div class="map-section">
                <div class="map-header">
                    <h4><i class="bi bi-geo-alt"></i> Ubicación del Inmueble</h4>
                    <p>Explora la zona y servicios cercanos</p>
                </div>
                <div id="mapa-detalle"></div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Script de calificación
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.pstar-container .star');
        const ratingInput = document.getElementById('selected-rating');
        const form = document.getElementById('rating-form');

        if (stars.length > 0 && ratingInput && form) {
            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = rating;
                    stars.forEach(s => {
                        const val = parseInt(s.getAttribute('data-value'));
                        s.className = (val <= rating) ? 'fas fa-star text-warning star' : 'far fa-star star';
                    });
                    setTimeout(() => form.submit(), 100);
                });
            });
        }

        // Galería de imágenes mejorada
        const thumbnails = document.querySelectorAll('.pthumbnail');
        const mainImage = document.getElementById('largeImage');
        const imageCounter = document.querySelector('.image-counter span');
        
        if (thumbnails.length > 0 && mainImage && imageCounter) {
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', function() {
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    mainImage.src = this.src;
                    imageCounter.textContent = `${index + 1} / 4`;
                });
            });
        }

        // Flechas de navegación
        const leftArrow = document.querySelector('.left-arrow');
        const rightArrow = document.querySelector('.right-arrow');
        let currentIndex = 0;

        if (leftArrow && rightArrow && thumbnails.length > 0) {
            leftArrow.addEventListener('click', function() {
                currentIndex = currentIndex > 0 ? currentIndex - 1 : thumbnails.length - 1;
                thumbnails[currentIndex].click();
            });

            rightArrow.addEventListener('click', function() {
                currentIndex = currentIndex < thumbnails.length - 1 ? currentIndex + 1 : 0;
                thumbnails[currentIndex].click();
            });
        }
    });

    // Script del mapa
    <?php if (!empty($datos['in_latitud']) && !empty($datos['in_longitud'])): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const mapElement = document.getElementById('mapa-detalle');
        if (mapElement) {
            try {
                const map = L.map('mapa-detalle').setView([<?= $datos['in_latitud'] ?>, <?= $datos['in_longitud'] ?>], 16);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);
                
                L.marker([<?= $datos['in_latitud'] ?>, <?= $datos['in_longitud'] ?>])
                    .addTo(map)
                    .bindPopup("<?= htmlspecialchars($datos['in_titulo']) ?>")
                    .openPopup();
                    
                // Asegurar que el mapa se redimensione correctamente
                setTimeout(function() {
                    map.invalidateSize();
                }, 100);
            } catch (error) {
                console.error('Error al cargar el mapa:', error);
                mapElement.innerHTML = '<div style="display: flex; align-items: center; justify-content: center; height: 400px; background: #f0f0f0; border-radius: 15px; color: #666;"><p>Error al cargar el mapa</p></div>';
            }
        }
    });
    <?php endif; ?>
</script>

    <?php include('./partials/footer.php'); ?>
</body>
</html>