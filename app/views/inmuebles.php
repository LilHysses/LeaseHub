<?php
include('./partials/header.php');
require_once('../models/conexion.php');
require_once('../models/modelPagina.php');

$conexion=new Conexion();
$metodosInmueble=new MetodosVista($conexion->getConexion());

?>
<br><br><br><br><br>
<?php if (isset($_SESSION['correo'])) {?>

<h2 style="margin-left:100px; font-size: 50px; margin-top: -45px; color:black;">Inmuebles</h2><br><br><br><br>

<div id="filtro-inmuebles">
<div class="grupo-filtros">
<form method="GET" action="">
  <ul class="menu-horizontal-filtro">
    <li><a href="#" class="filtro-desplegable">Tipos de inmuebles</a>
      <ul class="menu-vertical-filtro">
        <li><button type="submit" name="tipo" value="101">Apartamento</button></li>
        <li><button type="submit" name="tipo" value="102">Apartaestudio</button></li>
        <li><button type="submit" name="tipo" value="103">Casa</button></li>
        <li><button type="submit" name="tipo" value="104">Local</button></li>
      </ul>
    </li>
  </ul>
</form>
</div>

<br>

<!-- VENTANA MODAL DE PRECIO DE INMUEBLE -->
<div class="grupo-filtros">
<form method="GET" action="">
  <ul class="menu-horizontal-filtro">
    <li><a href="#" class="filtro-desplegable">Categoría por Precios </a>
      <ul class="menu-vertical-filtro">
        <li><button type="submit" name="precio" value="200000000">200.000.000</button></li>
        <li><button type="submit" name="precio" value="150000000">150.000.000</button></li>
        <li><button type="submit" name="precio" value="300000000">300.000.000</button></li>
        <li><button type="submit" name="precio" value="350000000">350.000.000</button></li>
        <li><button type="submit" name="precio" value="500000000">500.000.000</button></li>
        <li><button type="submit" name="precio" value="700000000">700.000.000</button></li>
        <li><button type="submit" name="precio" value="320000000">320.000.000</button></li>
      </ul>
    </li>
  </ul>
</form>



<!-- FILTRO DE BARRIOS -->

<form method="GET" action="">
  <select name="barrio" id="barrio" style="margin-left: 30px; margin-top:39px; border:none;" onchange="this.form.submit()">
    <option value="">Barrio</option>
    <?php
    // Obtener el valor del barrio seleccionado
    $barrio = isset($_GET['barrio']) ? $_GET['barrio'] : ''; // Verificar si el formulario se ha enviado
    // Consulta SQL para obtener los barrios
    $metodosInmueble->barrioSelect($barrio);
    ?>
  </select>
</form>
<?php
  $metodosInmueble->InmuebleBarrio($nombre=null);
?>


<!-- FILTRO DE PRECIO Y TIPO -->
 
<form method="GET" action="">
  <select name="tip" id="tip" style="margin-left: 30px; margin-top:39px; border:none;">
    <option value="">Tipo</option>
    <?php
    $tipos =  isset($_GET['tip']) ? $_GET['tip'] : '';
    // Consulta SQL para obtener los barrios
    $metodosInmueble->TipInmuebleSelect($tipos)
    ?>
  </select>

  <select name="pre" id="pre" style="margin-left: 30px; margin-top:39px; border:none;">
    <option value="">Precio</option>
    <?php
    $precios = isset($_GET['pre']) ? $_GET['pre'] : '';

    // Consulta SQL para obtener los barrios
    $metodosInmueble->PrecioInmuebleSelect($precios);
    ?>
  </select>

  <button type="submit" name="enviar" id="boton-filtro">Filtrar</button>
</form>
</div>
</div>
  
<br><br>
<?php } ?>
<link rel="stylesheet" href="../../public/css/inmuebles.css">
<section style="display: flex; margin-left:40px; margin-top: -70px;" class="tarjetas1"> <!-- Primeras 4 tarjetas -->
<div class="fila1">
  <?php 
     if (isset($_SESSION['correo'])) {
    $metodosInmueble->mostrarInmueblesFiltrados();
     }else{
      $metodosInmueble->mostrarTodosInmuebles();
     }
  ?>
</div>
</section>

<br>
    <br>
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
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
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
  </div>
</aside>
<?php include('./partials/footer.php'); ?>