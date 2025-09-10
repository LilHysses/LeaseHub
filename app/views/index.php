<?php
include('./partials/header.php');
require_once('../models/conexion.php');
require_once('../models/modelPagina.php');

$conexion = new Conexion();
$carrusel = new MetodosVista($conexion->getConexion());
?>

<!-- Llamada al método que imprime todo el carrusel -->
<?php $metodosInmueble = new MetodosVista($conexion->getConexion()); ?>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../public/css/index.css">
    
<section class="main-content"> <!--Contenido Principal-->
    <!--carrusel hero full screen-->
    <?php $metodosInmueble->InmuebleCarrusel(); ?>
</section>

<!-- Sección de contenido después del hero -->
<section class="content-section">
    <h3>Sobre nosotros</h3> <!--Descripcion de LEASEHUB-->
    <h3>LEASEHUB</h3>
    <img class="logo" src="/public/img/logo.png">
    <p class="justificar">Nuestra web facilita la compra y el alquiler de inmuebles con 
        una experiencia intuitiva y segura.
        Nos destacamos por nuestro conocimiento del mercado, ofreciendo
        funciones avanzadas como búsqueda detallada y perfiles personalizables.
        Garantizamos la seguridad de los datos y la privacidad
        mediante tecnología de vanguardia,respaldados por estrategias
        de marketing y un servicio al cliente dedicado.
        ¡Bienvenidos a una plataforma que prioriza la calidad y la satisfacción del usuario!</p>
        
    <!-- Características -->
    <div class="features-grid">
        <div class="feature-card">
            <img src="/public/img/iconprecio.png" alt="Precios económicos">
            <h4>Precios económicos</h4>
        </div>
        <div class="feature-card">
            <img src="/public/img/busqueda.png" alt="Búsqueda accesible">
            <h4>Búsqueda accesible</h4>
        </div>
        <div class="feature-card">
            <img src="/public/img/reloj.png" alt="Ahorro de tiempo">
            <h4>Ahorro de tiempo</h4>
        </div>
        <div class="feature-card">
            <img src="/public/img/analitica.png" alt="Flexibilidad">
            <h4>Flexibilidad en el uso de la página</h4>
        </div>
    </div>
    
    <!-- Ocultar las listas originales -->
    <div style="display: none;">
        <ul>
            <li class="listimagen">Precios económicos</li>
            <li class="listimagen">Búsqueda accesible</li>
            <li class="listimagen">Ahorro de tiempo</li>
            <li class="listimagen">Flexibilidad en el uso de la página</li>
        </ul>
        <ul>
            <li class="listimagen2"><img class="iconos" src="/public/img/iconprecio.png"></li>
            <li class="listimagen2"><img class="iconos" src="/public/img/busqueda.png"></li>
            <li class="listimagen2"><img class="iconos" src="/public/img/reloj.png"></li>
            <li class="listimagen2"><img class="iconos" src="/public/img/analitica.png"></li>
        </ul>
    </div>
</section>

<aside class="carousel-aside" id="publicidad2"> <!-- Aside derecho -->
    <div>
        <h5>CERCA DE TU UBICACIÓN</h5>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/public/img/ubic1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/public/img/ubic2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/public/img/ubic3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    
    <div>
        <h5>ESPACIO PUBLICITARIO</h5>
        <div id="carouselPublicidad" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="https://www.coca-cola.com/co/es"><img src="/public/img/public1.jpg" class="d-block w-100" alt="..."></a>
                </div>
                <div class="carousel-item">
                    <a href="https://www.pepsi.com/"><img src="/public/img/public2.jpg" class="d-block w-100" alt="..."></a>
                </div>
                <div class="carousel-item">
                    <a href="https://www.postobon.com/"><img src="/public/img/public3.jpg" class="d-block w-100" alt="..."></a>
                </div>
            </div>
        </div>
    </div>
</aside>

<?php include('./partials/footer.php'); ?>