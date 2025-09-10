<?php
require_once("conexion.php");
class MetodosVista
{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

      public function obtenerInmuebles() {
        $sql = "SELECT titulo, descripcion, imagen1 FROM inmuebles LIMIT 6";
        $resultado = $this->con->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    
    public function imgPerfil($correo){
        $consulta = "SELECT u_imagen FROM usuario WHERE u_correo='$correo'";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }
    public function validacionTpUser($correo) {
        $sql = "SELECT tu_id FROM usuario WHERE u_correo = '$correo'";
        $result = mysqli_query($this->con, $sql);
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['tu_id'] == 102) {
                $sqlUpd = "UPDATE usuario SET tu_id = 103 WHERE u_correo = '$correo'";
                $updateResult = mysqli_query($this->con, $sqlUpd);
                if ($updateResult) {
                    return true;
                } else {
                    // Log o print si falla el update
                    return "Error al actualizar tu_id.";
                }
            } else {
                return true; // Ya es 103 u otro tipo, no necesita actualización
            }
        } else {
            return "Usuario no encontrado.";
        }
    }

    public function IniciarSesion($correo, $contraseña)
    {
        $consulta = "SELECT * FROM usuario WHERE u_correo='$correo' AND u_contraseña='$contraseña'";
        $resultado = mysqli_query($this->con, $consulta);
        $filas = mysqli_fetch_array($resultado);

        return $filas;
    }

    public function VerificarUsuario($id)
    {

        $consulta = "SELECT COUNT(*) FROM usuario WHERE u_id='$id'";
        $resultado = mysqli_query($this->con, $consulta);
        $array = mysqli_fetch_array($resultado)[0];

        return $array;
    }

    public function RegistroUsuario($id, $nombres, $apellidos, $correo, $contraseña, $direccion, $telefono, $tipousuario, $descripcion, $ruta)
    {

        $consulta = "INSERT INTO usuario (u_id, u_nombre, u_apellido, u_correo, u_contraseña, u_direccion, u_telefono,tu_id,u_descripcion,u_imagen)
         VALUES ($id, '$nombres', '$apellidos', '$correo', '$contraseña', '$direccion', '$telefono',$tipousuario,'$descripcion','$ruta')";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function RecuperarPassword($email)
    {
        $consulta = "SELECT u_correo FROM usuario WHERE u_correo = '$email'";
        $result = mysqli_query($this->con, $consulta);
        $array = mysqli_fetch_array($result);

        return $array;
    }

    public function VerificarPassword($email, $password)
    {
        $consulta = "UPDATE usuario SET u_contraseña = '$password' WHERE u_correo = '$email'";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function RegistrarQueja($correo, $descripcion)
    {

        $consulta = "INSERT INTO quejas (u_correo, q_descripcion) VALUES ('$correo', '$descripcion')";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function TraerNotificaciones($correo)
    {

        $consult = "SELECT u_id, tu_id FROM usuario WHERE u_correo = '$correo'";
        $result = mysqli_query($this->con, $consult);

        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $id = $row['u_id'];
            $tuser = $row['tu_id'];


            $sql = "SELECT c.c_id FROM inmueble i LEFT JOIN comentario c ON i.in_id = c.in_id WHERE i.u_id = $id AND c.c_id IS NOT NULL AND c.c_visto = 0;";
            // echo "consulta:" . $sql;

            $result2 = mysqli_query($this->con, $sql);

            $sql1 = "SELECT r.r_estado, r.r_visto FROM inmueble i LEFT JOIN reservas r ON i.in_id = r.in_id WHERE r.u_id = $id AND (r.r_estado = 'Aceptado' OR r.r_estado = 'Cancelado') AND r.r_visto = 0";

            $result1 = $this->con->query($sql1);

            $sql3 = "SELECT r.r_estado FROM inmueble i LEFT JOIN reservas r ON i.in_id = r.in_id WHERE i.u_id = $id AND r.r_estado = 'Pendiente'";

            $result3 = mysqli_query($this->con, $sql3);

            if (($result2->num_rows > 0) || ($result1->num_rows > 0) || ($result3->num_rows > 0)) {

                echo "<img src='../../public/img/notificaciones2.png' id='buscar' alt='Notificaciones'>";
            } else {

                echo "<img src='../../public/img/iconoNotify.png' id='buscar' alt='Notificaciones'>";
            }
        } else {
            echo "Error al consultar la base de datos o usuario no encontrado.";
        }
    }

    public function UsuariosSelect($tipousuario)
    {

        $consulta = "SELECT tu_id, tu_nombre FROM tipo_de_usuario WHERE tu_id=102 OR tu_id=103";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['tu_id'] == $tipousuario) ? 'selected' : '';
                echo "<option value='" . $fila['tu_id'] . "' $selected>" . $fila['tu_nombre'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun tipo de usuario</option>";
        }
    }
    /* Publicaciones*/
    public function tipoPagoSelect($tipos_pago)
    {
        // Obtener tipos de usuario desde la base de datos
        $consulta = "SELECT * FROM tipo_de_pago";
        $tipos_pago = mysqli_query($this->con, $consulta);

        if (!$tipos_pago) {
            echo "<option>Error en la consulta</option>";
            return;
        }

        if ($tipos_pago->num_rows > 0) {
            while ($tipo = $tipos_pago->fetch_object()) {
                echo "<option value='{$tipo->tp_id}'>{$tipo->tp_pago}</option>";
            }
        } else {
            echo "<option value=''>No hay tipos de pago</option>";
        }
    }
    public function tipoInmuebleSelect($tipos_inmueble)
    {
        // Obtener tipos de usuario desde la base de datos
        $consulta = "SELECT * FROM tipo_de_inmueble";
        $tipos_inmueble = mysqli_query($this->con, $consulta);

        if (!$tipos_inmueble) {
            echo "<option>Error en la consulta</option>";
            return;
        }

        if ($tipos_inmueble->num_rows > 0) {
            while ($tipo = $tipos_inmueble->fetch_object()) {
                echo "<option value='{$tipo->tip_id}'>{$tipo->tip_nombre}</option>";
            }
        } else {
            echo "<option value=''>No hay tipos de pago</option>";
        }
    }

    // Función para registrar un inmueble
    public function procesarImagen($imagen, $idinmueble, $numeroImagen, $directorio)
    {
        if (!isset($_FILES[$imagen]) || $_FILES[$imagen]['error'] != UPLOAD_ERR_OK) {
            return null; // Retorna null si no hay imagen
        }
        $nombreImagen = $_FILES[$imagen]["name"];
        $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
        return $directorio . $idinmueble . "_imagen" . $numeroImagen . "." . $tipoImagen;
    }

    public function registrarInmueble($idinmueble, $fecha, $direccion, $precio, $descripcion, $titulo, $barrio, $estado, $tipoinmueble, $tipopago, $idusuario, $directorio, $latitud, $longitud){
        
        $fecha_ingresada = date("Y-m-d", strtotime($fecha));
        $fecha_actual = date("Y-m-d");

        if ($fecha_ingresada !== $fecha_actual) {
            return "La fecha debe ser igual a la actual. No se permite una fecha anterior ni posterior.";
        }

        // Validar que la fecha no sea anterior a la actual

        // Verificar que las 4 imágenes han sido subidas
        if (
            empty($_FILES["imagen1"]["name"]) ||
            empty($_FILES["imagen2"]["name"]) ||
            empty($_FILES["imagen3"]["name"]) ||
            empty($_FILES["imagen4"]["name"])
        ) {
            return "Debes subir las 4 imágenes obligatoriamente.";
        }

        // Obtener rutas de imágenes
        $ruta = $this->procesarImagen("imagen1", $idinmueble, 1, $directorio);
        $ruta2 = $this->procesarImagen("imagen2", $idinmueble, 2, $directorio);
        $ruta3 = $this->procesarImagen("imagen3", $idinmueble, 3, $directorio);
        $ruta4 = $this->procesarImagen("imagen4", $idinmueble, 4, $directorio);

        // Verificar si el inmueble ya existe
        $consultaInmueble = "SELECT * FROM inmueble WHERE in_id = '$idinmueble'";
        $result = mysqli_query($this->con, $consultaInmueble);
        if ($result->num_rows > 0) {
            return "El inmueble ya existe.";
        }


        // Insertar en la base de datos
        $sql = "INSERT INTO inmueble (in_id, in_fecha_publicacion, in_direccion, in_precio, in_descripcion, in_titulo, in_barrio, in_estado, u_id, tip_id, tp_id, in_imagen, in_imagen2, in_imagen3, in_imagen4, in_latitud, in_longitud) 
                VALUES ('$idinmueble', '$fecha', '$direccion', '$precio', '$descripcion', '$titulo', '$barrio', '$estado', '$idusuario', '$tipoinmueble','$tipopago', '$ruta', '$ruta2', '$ruta3', '$ruta4', '$latitud', '$longitud')";
        $result = mysqli_query($this->con, $sql);

        if ($result) {
            // Mover imágenes al directorio
            if (
                move_uploaded_file($_FILES["imagen1"]["tmp_name"], $ruta) &&
                move_uploaded_file($_FILES["imagen2"]["tmp_name"], $ruta2) &&
                move_uploaded_file($_FILES["imagen3"]["tmp_name"], $ruta3) &&
                move_uploaded_file($_FILES["imagen4"]["tmp_name"], $ruta4)
            ) {
                return "Inmueble registrado correctamente.";
            } else {
                return "Error al subir las imágenes.";
            }
        } else {
            return "Error al registrar el inmueble en la base de datos.";
        }
    }
    public function mostrarPublicaciones($correo_usuario)
    {
        $query1 = "SELECT * FROM inmueble WHERE u_id IN (SELECT u_id FROM usuario WHERE u_correo = '$correo_usuario')";
        $result1 = mysqli_query($this->con, $query1);

        // Verificar si hay inmuebles del usuario
        if (mysqli_num_rows($result1) > 0) {
            // Iterar a través de los inmuebles y mostrarlos
            while ($row = mysqli_fetch_array($result1)) {
                echo "
                <div class='card-publi'>
                  <a href='compra.php?id=" . $row['in_id'] . "'>
                    <img src='../../public/img/inmuebles/" . basename($row['in_imagen']) . "' alt='Imagen del inmueble'>
                  </a>
                  <div class='card-content2'>
                    <h2 class='card-title'>" . $row['in_titulo'] . "</h2>
                    <p class='card-description'>" . $row['in_direccion'] . "</p>
                  </div>
                  <p class='card-price'>" . number_format($row['in_precio'], 0, ',', '.') . "</p>
                </div>";
            }
        } else {
            echo "<div class='alert alert-warning'>No tienes inmuebles registrados.</div>";
        }
    }
    /*fin publiaciones*/


    /*Funciones de la pagina inmuebles.php*/

    public function barrioSelect($barrio)
    {

        $consulta = "SELECT in_id, in_barrio FROM inmueble";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['in_id'] == $barrio) ? 'selected' : '';
                echo "<option value='" . $fila['in_id'] . "' $selected>" . $fila['in_barrio'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun barrio</option>";
        }
    }

    public function TipInmuebleSelect($tipoinmueble)
    {

        $consulta = "SELECT tip_id, tip_nombre FROM tipo_de_inmueble";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['tip_id'] == $tipoinmueble) ? 'selected' : '';
                echo "<option value='" . $fila['tip_id'] . "' $selected>" . $fila['tip_nombre'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun tipo de inmueble</option>";
        }
    }

    public function PrecioInmuebleSelect($precios)
    {

        $consulta = "SELECT in_id, in_precio FROM inmueble";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['in_precio'] == $precios) ? 'selected' : '';
                echo "<option value='" . $fila['in_precio'] . "' $selected>" . $fila['in_precio'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun precio</option>";
        }
    }

    function mostrarInmueblesFiltrados()
    {
        if (!isset($_SESSION['correo'])) {
            echo "<div class='alert alert-warning'>Usuario no autenticado.</div>";
            return;
        }

        $correo_usuario = $_SESSION['correo'];

        $tipo_inmueble = $_GET['tipo'] ?? null;
        $precio_inmueble = $_GET['precio'] ?? null;
        $barrio_inmueble = $_GET['barrio'] ?? null;

        // Obtener nombre del tipo de inmueble (opcional)
        if ($tipo_inmueble !== null && is_numeric($tipo_inmueble)) {
            $con = "SELECT tip_nombre FROM tipo_de_inmueble WHERE tip_id = $tipo_inmueble";
            $res = mysqli_query($this->con, $con);
            if ($res && $row = mysqli_fetch_assoc($res)) {
                $tipo = $row['tip_nombre'];
            }
        }

        // Filtro por precio
        if ($precio_inmueble) {
            $precios = [
                200000000 => "200.000.000",
                150000000 => "150.000.000",
                300000000 => "300.000.000",
                350000000 => "350.000.000",
                500000000 => "500.000.000",
                700000000 => "700.000.000",
                320000000 => "320.000.000"
            ];
            $precio = $precios[$precio_inmueble] ?? "Precio no encontrado";
        }

        // Construcción de consulta según filtros
        if (isset($_GET['enviar'])) {
            $tip = (int) $_GET['tip'];
            $pre = (int) $_GET['pre'];
            $query1 = "SELECT in_id, in_imagen, in_titulo, in_barrio, in_direccion, in_precio 
                   FROM inmueble 
                   WHERE tip_id = $tip AND in_precio = $pre";
        } elseif ($tipo_inmueble) {
            $query1 = "SELECT in_id, in_imagen, in_titulo, in_barrio, in_direccion, in_precio 
                   FROM inmueble 
                   WHERE tip_id = '$tipo_inmueble'";
        } elseif ($precio_inmueble) {
            $query1 = "SELECT in_id, in_imagen, in_titulo, in_barrio, in_direccion, in_precio 
                   FROM inmueble 
                   WHERE in_precio = '$precio_inmueble'";
        } elseif ($barrio_inmueble) {
            $query1 = "SELECT in_id, in_imagen, in_titulo, in_barrio, in_direccion, in_precio 
                   FROM inmueble 
                   WHERE in_id = $barrio_inmueble";
        } else {
            $query1 = "SELECT in_id, in_imagen, in_titulo, in_barrio, in_direccion, in_precio 
                   FROM inmueble";
        }

        // Ejecutar y mostrar resultados
        $result1 = mysqli_query($this->con, $query1);
        if ($result1 && mysqli_num_rows($result1) > 0) {
            while ($row = mysqli_fetch_array($result1)) {
                $_SESSION['idinmueble'] = $row['in_id'];
            ?>
               <div class="card-publi">
    <a href="compra.php?id=<?= $row['in_id'] ?>">
        <img src="<?= $row['in_imagen'] ?>" alt="Imagen del inmueble">
    </a>
    <div class="card-content2">
        <h2 class="card-title"><?= $row['in_titulo'] ?></h2>
        <p class="card-description"><?= $row['in_barrio'] ?></p>
        <p class="card-description"><?= $row['in_direccion'] ?></p>
      
    </div>
    <p class="card-price"><?= number_format($row['in_precio'], 0, ',', '.') ?></p>
</div>
            <?php
            }
        } else {
            echo "<div class='alert alert-danger' style='margin-left:100px'>No hay inmuebles encontrados.</div>";
        }
    }


    function mostrarTodosInmuebles()
    {
        $query1 = "SELECT in_id, in_imagen, in_titulo, in_barrio, in_direccion, in_precio FROM inmueble";
        $result1 = mysqli_query($this->con, $query1);

        // Verificar si hay inmuebles
        if (mysqli_num_rows($result1) > 0) {
            while ($row = mysqli_fetch_array($result1)) {
            ?>
              <div class="card-publi">
    <a href="compra.php?id=<?= $row['in_id'] ?>">
        <img src="<?= $row['in_imagen'] ?>" alt="Imagen del inmueble">
    </a>
    <div class="card-content2">
        <h2 class="card-title"><?= $row['in_titulo'] ?></h2>
        <p class="card-description"><?= $row['in_barrio'] ?></p>
        <p class="card-description"><?= $row['in_direccion'] ?></p>
      
    </div>
    <p class="card-price"><?= number_format($row['in_precio'], 0, ',', '.') ?></p>
</div>
<?php
            }
        } else {
            echo '<p>No tienes inmuebles registrados.</p>';
        }
    }
     public function InmuebleBarrio($nombre)
    {

        if (isset($_GET['barrio']) && is_numeric($_GET['barrio'])) {
            $barrio = $_GET['barrio'];
            $sql = "SELECT in_barrio FROM inmueble WHERE in_id = $barrio";
            $result = mysqli_query($this->con, $sql);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $nombre = $row['in_barrio'];
            }
        }
        return $nombre;
    }
    public function InmuebleCarrusel($nombre = null) {
        $sql = "SELECT in_id, in_titulo, in_descripcion, in_imagen FROM inmueble LIMIT 6";
        $resultado = $this->con->query($sql);
    
        if ($resultado && $resultado->num_rows > 0) {
            echo '<div id="carrusel-pri">
                    <div class="slide">';
    
            while ($inmueble = $resultado->fetch_assoc()) {
                $id = htmlspecialchars($inmueble['in_id']);
                $titulo = htmlspecialchars($inmueble['in_titulo']);
                $descripcion = htmlspecialchars($inmueble['in_descripcion']);
                $imagen = htmlspecialchars($inmueble['in_imagen']);
    
                echo '<div class="item" style="background-image: url(' . $imagen . ');">
                        <div class="content">
                            <div class="name">' . $titulo . '</div>
                            <div class="des">' . $descripcion . '</div>
                            <button onclick="location.href=\'compra.php?id=' . $id . '\'" id="boton-carrusel">VER MAS...</button>
                        </div>
                    </div>';
                    
            }
    
            echo '</div>
                <div class="button">
                    <button class="prev" id="boton-carrusel-izquierda"><i class="fa-solid fa-arrow-left"></i></button>
                    <button class="next" id="boton-carrusel-derecha"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>';
        } else {
            echo "<p>No se encontraron inmuebles.</p>";
        }
    }
    
}
  /*Fin  de funciones de la pagina inmuebles.php*/


?>