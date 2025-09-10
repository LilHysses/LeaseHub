<?php
include('./partials/header.php');
require_once('../models/modelPagina.php');

$conexion = new Conexion();
$metodosPagina = new MetodosVista($conexion->getConexion());
?>
  <link rel="stylesheet" href="../../public/css/publicaciones.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="/public/css/inmuebles.css">
  <section id="section-publi">  <!--Contenido Principal-->
    <h1 style="margin-left: 12px ;">Publicaciones</h1>
      <div class="container" id="Publicaciones">
        <div class="contenido1">
          <div class="fila1">
    <?php

// Verificar si el correo del usuario está en la sesión
if (isset($_SESSION['correo'])) {
    $correo_usuario = $_SESSION['correo'];
    $metodosPagina->mostrarPublicaciones($correo_usuario);
} else {
    header("Location:../index.php");  
    exit();
}
  
?>
          </div>
      </div>
    </div>
        <div class="contenido2">
          <div class="fila1_1">
          <div style="display: flex;">          
          <div>
          <h3 class="tituloRe">REGISTRO DE INMUEBLE</h3>   
          <form class="col-4 p-3" enctype="multipart/form-data" method="post" action="../controllers/controlPublicaciones.php">
                <label for="" id="letras-publicacion">Imagen Principal</label><br>
                 <input type="file" id="recipient-name" name="imagen1"><br><br>
                 <label for="" id="letras-publicacion">Imagen Sala</label><br>
                 <input type="file" id="recipient-name" name="imagen2"><br><br>
                 <label for=""id="letras-publicacion">Imagen Cocina</label><br>
                 <input type="file" id="recipient-name" name="imagen3"><br><br>
                 <label for=""id="letras-publicacion">Imagen Cuarto</label><br>
                 <input type="file" id="recipient-name" name="imagen4"><br><br>

                 <!-- Mapa -->
                <div id="mapa" style="height: 400px; width: 300px; margin: 20px 0;"></div>
              </div>
              <div>
    <h3 class="text-center" style="color: white;">Inmuebles</h3>
    
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">ID</label>
    <input type="number" class="form-control" name="id">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Fecha de Publicación</label>
    <input type="date" class="form-control" name="fecha" value="<?= date('Y-m-d') ?>" required>
  </div>
<div class="mb-3">
  <label class="form-label" id="letras-publicacion">Dirección</label>

  <!-- Tipo de vía -->
  <select id="tipo_via" class="form-control" required>
    <option value="Calle">Calle</option>
    <option value="Carrera">Carrera</option>
    <option value="Avenida">Avenida</option>
    <option value="Transversal">Transversal</option>
  </select>

  <!-- Número completo (Ej: 6B #72-30) -->
  <input type="text" id="numero" class="form-control" placeholder="Ej: 6B #72" required>

  <!-- Ciudad -->
  <input type="text" id="ciudad" class="form-control" value="Barranquilla">

  <!-- Dirección combinada -->
  <input type="hidden" name="direccion" id="direccion">

      <!-- Coordenadas -->
    <input type="hidden" name="latitud" id="latitud">
    <input type="hidden" name="longitud" id="longitud">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    const mapa = L.map('mapa').setView([10.9878, -74.7889], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapa);

    const marcador = L.marker([10.9878, -74.7889], { draggable: true }).addTo(mapa);

    function actualizarInputs(lat, lng) {
      document.getElementById("latitud").value = lat;
      document.getElementById("longitud").value = lng;
    }

    function construirDireccion() {
      const tipo = document.getElementById("tipo_via").value;
      const numero = document.getElementById("numero").value;
      const ciudad = document.getElementById("ciudad").value;

      const direccion = `${tipo} ${numero}, ${ciudad}, Colombia`;
      document.getElementById("direccion").value = direccion;
      return direccion;
    }

    async function geolocalizarDireccion(direccion) {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(direccion)}`;
      const respuesta = await fetch(url, {
        headers: {
          'User-Agent': 'tu_correo@example.com'
        }
      });
      const resultados = await respuesta.json();
      if (resultados.length > 0) {
        const { lat, lon } = resultados[0];
        marcador.setLatLng([lat, lon]);
        mapa.setView([lat, lon], 17);
        actualizarInputs(lat, lon);
      }
    }

    function actualizarDireccion() {
      const direccion = construirDireccion();
      if (direccion.length > 5) {
        geolocalizarDireccion(direccion);
      }
    }

    document.getElementById("tipo_via").addEventListener("input", actualizarDireccion);
    document.getElementById("numero").addEventListener("input", actualizarDireccion);
    document.getElementById("ciudad").addEventListener("input", actualizarDireccion);

    marcador.on('dragend', function () {
      const { lat, lng } = marcador.getLatLng();
      actualizarInputs(lat, lng);
    });

    mapa.on('click', function (e) {
      marcador.setLatLng(e.latlng);
      actualizarInputs(e.latlng.lat, e.latlng.lng);
    });

    actualizarInputs(10.9878, -74.7889);
    </script>
</div>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Precio</label>
    <input type="number" class="form-control" name="precio">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Descripción</label>
    <input type="text" class="form-control" name="descripcion">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Título</label>
    <input type="text" class="form-control" name="titulo">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Barrio</label>
    <input type="text" class="form-control" name="barrio">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Estado</label>
    <select name="estado" class="form-control">
      <option>Seleccionar</option>
      <option>Disponible</option>
      <option>No Disponible</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"id="letras-publicacion">Tipo de pago</label>
    <select name="tipopago" class="form-control">
    <option>Seleccionar</option>
        <?php
       $metodosPagina->tipoPagoSelect($tipo_pago);?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label"id="letras-publicacion">Tipo de inmueble</label>
    <select name="tipoinmueble" class="form-control">
    <option>Seleccionar</option>
    <?php
    $metodosPagina->tipoInmuebleSelect($tipos_inmueble);
    ?>
    </select>
  </div>
  <script>
document.querySelector("form").addEventListener("submit", function (e) {
  const direccion = construirDireccion();

  if (!direccion || direccion.trim().length < 5) {
    alert("Por favor completa la dirección correctamente.");
    e.preventDefault(); // Evita el envío si la dirección está mal
  }
});
</script>
  <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Publicar</button>
          </div>
          </div>
</form>
        </div>
          </div>
        </div>    
      </div>

     </div>
      
        </section>


<?php include('./partials/footer.php'); ?>