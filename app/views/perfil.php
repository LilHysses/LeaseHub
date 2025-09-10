<?php
ob_start(); //evitar que se envíe salida antes de header().
include("./partials/header.php");
include("../models/modelPerfil.php");

$correo=$_SESSION['correo'];

$conexion = new Conexion();
$metodosPerfil = new ModelPerfil($conexion->getConexion());

$result = $metodosPerfil->imgPerfil($correo);

if ($result && mysqli_num_rows($result) > 0) {

    while ($fila = mysqli_fetch_assoc($result)) {

        $rutaImagen = htmlspecialchars($fila['u_imagen']);
    }
} else {
    echo "No se encontraron imágenes.";
}

$row = $metodosPerfil->datosPerfil($correo);

// Verificar si se obtuvo un resultado
if ($row) {
    // Almacenar los datos del usuario en variables para usarlas en el HTML
    $iduser = $row['u_id'];
    $nombre = $row['u_nombre'];
    $apellido = $row['u_apellido'];
    $direccion = $row['u_direccion'];
    $telefono = $row['u_telefono'];
    $desc = $row['u_descripcion'];
    $rol = $row['tu_id'];
    if ($rol == 101) {
        $rol = 'Administrador';
    } elseif ($rol == 102) {
        $rol = 'Usuario';
    } else {
        $rol = 'Propietario';
    }
    $_SESSION['rol'] = $rol;

    if (isset($_POST['crd']) && $rol == 'Administrador') {

        header("Location: ../views/viewCruds/vistaUsuarios.php");
        exit();
    } elseif (isset($_POST['crd']) && $rol == 'Propietario') {

        header("Location: ../views/viewCruds/vistaInmuebles.php");
        exit();
    }
} else {
    // Si no se encuentra el usuario (error de consulta o usuario no encontrado)
    echo "Error al cargar los datos del usuario.";
    exit();
}



?>
  <link rel="stylesheet" href="../../public/css/perfil.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="page-wrapper">
    <main class="contenido">
        <div class="perfil">
            <h4>MI PERFIL</h4>
        </div>
        <div class="information">
            <div class="profile-image-container">
            <img id="profileImage" src="<?php echo $rutaImagen; ?>" alt="Imagen de perfil">
            </div>
            <div>
                <h5><img src="/public/img/user.png" alt="user" id="user-name">Nombre:
                    <?php
                    echo $nombre . " " . $apellido;
                    ?>
                </h5>
                <h4><b>
                        <?php
                        echo $rol;
                        ?>
                    </b></h4>
                <h7><img src="/public/img/ubicacion.png" alt="location" style="width: 24px;">Dirección:
                    <?php
                    echo $row['u_direccion'];
                    ?>
                </h7>
                <br>
                <h7><img src="/public/img/idioma.png" alt="idioma" style="width: 20px;">Teléfono:
                    <?php
                    echo $row['u_telefono'];
                    ?>
                </h7>
                <br>
                <!-- Button trigger modal -->
                <button type="button" class="changeN" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Actualizar perfil
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content  act-1">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar perfil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body act-perfil">
                                <form action="../controllers/controlPagina.php" method="post" enctype="multipart/form-data">
                                    <label for="newname">Ingresa un nuevo nombre:</label>
                                    <br>
                                    <input type="text" name="newname" id="newname">
                                    <br>
                                    <label for="imagenPerfil">Cambiar imagen de perfil</label>
                                    <br>
                                    <input type="file" id="fileInput" accept="image/*" name="imagenPerfil">
                                    <hr>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" name="changesaves" class="btn btn-success">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="crud">
                    <form action="" method="post">
                        <?php
                        if ($rol == 'Propietario' || $rol == 'Administrador') { ?>

                            <button type="submit" name="crd" class="crd">CRUDS</button>

                        <?php } ?>
                    </form>
                </div>
            </div>
            <div class="redes">
                <a href=""><img src="/public/img/twitter.png" alt="Twitter" class="red1" style="width: 40px;"></a>
                <br>
                <br>
                <a href="" class="red2"><img src="/public/img/Messenger.png" alt="Messenger" class="red2" style="width: 40px;"></a>
                <br>
                <br>
                <a href="" class="red3"><img src="/public/img/correo.png" alt="Correo" class="red3" style="width: 40px;"></a>
            </div>
        </div>
        <div class="descripcion">
            <div class="desc">
                <h4>Descripción</h4>
            </div>
            <p><?php
                echo $desc;
                ?></p>
        </div>
        <div class="fav">
            <h4>Favoritos<img src="/public/img/favorito.png" alt="Favoritos"></h4>
        </div>
        <div class="favoritos">
            <?php
            $r_fav = $metodosPerfil->Favoritos($iduser);

            if ($r_fav && $r_fav->num_rows > 0) {
                while ($rowf = $r_fav->fetch_assoc()) { ?>

                    <div class="fav-card">
                        <a href="compra.php?id=<?php echo $rowf['in_id']; ?>"> <!-- Enlace a la página de compra o detalle -->
                            <!-- Imagen con un tamaño fijo y ajuste proporcional -->
                            <img src="<?= $rowf['in_imagen'] ?>" alt="Imagen del inmueble">
                        </a>
                        <p><?php echo $rowf['in_titulo'] ?></p>
                        <p><?php echo $rowf['in_direccion'] ?></p>
                        <p class="precio"><?php echo $rowf['in_precio'] ?></p>

                    </div>
            <?php
                }
            } else {
                echo "<p>No tienes inmuebles en tus favoritos.</p>";
            }

            ?>
        </div>
    </main>
</div>
<?php include("./partials/footer.php");
ob_end_flush(); ?>