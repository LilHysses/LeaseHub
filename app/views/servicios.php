<?php include("./partials/header.php"); ?>
<br><br>
<div class="container" id="servicios">
    <div style="display: flex;">
        <article>
            <img src="/public/img/inmuebles/desktop-wallpaper-luxury-homes-thumbnail.jpg" alt="">
            <h3>ESPACIO INMOBILIARIO</h3><br>
            <h4>Alquiler de propiedades: expertos en encontrar la solución perfecta para su hogar o negocio<br><br>
                -Apartamentos<br>
                -Apartaestudios<br>
                -Casa<br>
                -Local
            </h4>
        </article>
        <article>
            <img src="/public/img/inmuebles/una-casa-lujosa-2110.jpg" alt="">
            <h3>CONSIGNE SU INMUEBLE</h3>
            <h4>Con opción de exclusividad y nuestro compromiso al 100%<br><br>
                -Marketing Digital<br>
                -Avalúo comercial según mercado digital

            </h4>
        </article>
    </div>

    <div class="sidebar">
        <div class="sidebar-item">
            <aside class="carousel-aside"id="publicidad1"> <!-- Aside derecho -Carrusel de inmuebles cerca de tu ubicacion-->
                <center>
                    <h5>CERCA DE TU UBICACIÓN</h5>
                </center>
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div><br><br>
                <center>
                    <h5>ESPACIO PUBLICITARIO</h5>
                </center> <!--Carrusel de Publicidad-->
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
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
            </aside>
        </div>
    </div>
</div>
<?php include("./partials/footer.php");
