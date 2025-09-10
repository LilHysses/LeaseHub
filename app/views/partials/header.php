<?php
// Comprobamos si el usuario ha iniciado sesión
session_start();

if (isset($_SESSION['correo'])) {
    // Código de index2.php (cuando el usuario ha iniciado sesión)
    include("../models/modelPagina.php");
    $conexion = new Conexion();
    $metodosPagina = new MetodosVista($conexion->getConexion());
    $correo = $_SESSION['correo'];
    $result = $metodosPagina->imgPerfil($correo);
    if ($result && mysqli_num_rows($result) > 0) {

    while ($fila = mysqli_fetch_assoc($result)) {

        $rutaImagen = htmlspecialchars($fila['u_imagen']);
    }
    } else {
        echo "No se encontraron imágenes.";
    }
    
    
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>LEASEHUB</title>
        <link rel="icon" href="../../../public/img/logo.png" type="image/png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="/public/css/header.css">
        <link rel="stylesheet" href="/public/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

    <body>
        <header> <!--Encabezado de la pagina -->
            <div class="header-container">
                <img src="/public/img/logo.png" id="logo" alt="Logo">
                <p id="texto"><a href="/app/views/index.php" style="text-decoration: none; color: white;">LEASEHUB</a></p>
                <form class="buscar">
                    <a href="/app/views/notificacion.php"><button type="button" class="iconob">
                            <?php $metodosPagina->TraerNotificaciones($correo); ?>
                        </button></a>
                    <button type="button" class="iconob" onclick="window.location.href='/app/views/perfil.php';">
                        <img src="<?php echo $rutaImagen; ?>" id="buscar" alt="Perfil">
                    </button>
                    <ul class="menu-horizontal">
                        <li><a href="/app/views/perfil.php" class="enlace-correo"><?php echo $_SESSION['correo']; ?></a>
                            <ul class="menu-vertical">
                            </ul>
                        </li>
                    </ul>
                    <a href='./partials/cerrar.php' class='boton-login'>Cerrar Sesion</a>
                </form>
            </div>
        </header>

        <nav class="navbar navbar-dark bg-green"> <!--Menu de la Pagina y menu lateral-->
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!--Enlaces de Inicio, Inmuebles y Servicios-->
                <a class="enlaces" href="/app/views/index.php" style="text-decoration: none; color: white; margin-right: 20px;">Inicio</a>
                <a class="enlaces" href="/app/views/inmuebles.php" style="text-decoration: none; color: white;  margin-right: 20px;">Inmuebles</a>
                <a class="enlaces" href="/app/views/servicios.php" style="text-decoration: none; color: white; ">Servicios</a>
                <a class="enlaces" id="boton-publicar" href="/app/views/publicaciones.php" style="font-size: 30px; color: white; text-decoration: none;">+</a>
                <!--Contenido del Menu Lateral-->
                <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header" style="background-color: gray;">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div><br><br>
                    <div class="offcanvas-body" style="background-color: gray;">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/app/views/index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/app/views/publicaciones.php">Publicaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/app/views/notificacion.php">Notificaciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/app/views/terminos.php">Terminos y condiciones</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/app/views/quejas.php">Quejas</a>
                            </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
    <?php
} else {

    // Código de index.php (cuando el usuario no ha iniciado sesión)
    include("../models/modelPagina.php");
    $conexion = new Conexion();
    $metodosPagina = new MetodosVista($conexion->getConexion());
    ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>LEASEHUB</title>
            <link rel="icon" href="../../../public/img/logo.png" type="image/png">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <link rel="stylesheet" href="/public/css/header.css">
            <link rel="stylesheet" href="/public/css/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        </head> 

        <body>
            <header> <!--Encabezado de la pagina -->
                <div class='header-container'>
                    <img src='/public/img/logo.png' id='logo' alt='Logo'>
                    <p id='texto'>
                        <a href='/app/views/index.php' style='text-decoration: none; color: white;'>LEASEHUB</a>
                    </p>

                    <form class='buscar'>
                        <button type='button' class='iconob'>
                            <img src='/public/img/iconoperfil.png' id='buscar' alt='Perfil'>
                        </button>
                        <a href='/app/views/partials/login.php' class='boton-login'>Ingresar</a>
                    </form>
                </div>
            </header>


            <nav class="navbar navbar-dark bg-green"> <!--Menu de la Pagina y menu lateral-->
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!--Enlaces de Inicio, Inmuebles y Servicios-->
                    <a class="enlaces" href="/app/views/index.php" style="text-decoration: none; color: white; font-size: 20px; margin-right: 20px;">Inicio</a>
                    <a class="enlaces" href="/app/views/inmuebles.php" style="text-decoration: none; color: white; font-size: 20px; margin-right: 20px;">Inmuebles</a>
                    <a class="enlaces" href="/app/views/servicios.php" style="text-decoration: none; color: white; font-size: 20px; ">Servicios</a>
                    <a href=""></a>
                    <!--Contenido del Menu Lateral-->
                    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                        <div class="offcanvas-header" style="background-color: gray;">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div><br><br>
                        <div class="offcanvas-body" style="background-color: gray;">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/app/views/index.php">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/app/views/terminos.php">Terminos y condiciones</a>
                                </li>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <div id="modalPerfil" class="modal"> <!--Ventana Modal cuando undes el icono de perfil-->
                <div class="modal-content" style="background-color: gray; color:white; border-radius: 20px;">
                    <span class="close">&times;</span>
                    <h2>Usuario</h2>
                    <div class="modal-buttons" style="background-color: gray;">
                        <button id="login-btn" onclick="IniciarSesion()">Iniciar Sesión</button>
                        <button id="register-btn">Registrarse</button>
                    </div><br>
                </div>
            </div>
            <div id="modalRegister" class="modal"> <!--Ventana Modal cuando undes el boton de Registrarse-->
                <div class="modal-content2" style="background-color: gray; color:white; border-radius: 20px;">
                    <div class="contenidoR">
                        <h3 class="tituloRe">REGISTRO DE USUARIO</h3>
                        <img src="imagenes/fotoPerfil.png" class="imgPerfil" id="profileImage">
                        <a href="#" id="changeImageLink">Cambiar Imagen</a>
                    </div>
                    <form class="form-grid" method="post" enctype="multipart/form-data" action="/app/controllers/controlPagina.php">
                        <input type="file" id="imageInput" style="display: none;" name="imagenperfil">
                        <div class="form-group">
                            <p>Identificación</p>
                            <input type="number" name="identificacion" class="campo" style="width: 300px;">
                        </div>
                        <div class="form-group">
                            <p>Correo Electrónico</p>
                            <input type="email" name="correo" class="campo" style="width: 300px;">
                        </div>
                        <div class="form-group">
                            <p>Nombres</p>
                            <input type="text" name="nombres" class="campo">
                        </div>
                        <div class="form-group">
                            <p>Dirección</p>
                            <input type="text" name="direccion" class="campo">
                        </div>
                        <div class="form-group">
                            <p>Apellidos</p>
                            <input type="text" name="apellidos" class="campo">
                        </div>
                        <div class="form-group">
                            <p>Teléfono</p>
                            <input type="number" name="telefono" class="campo">
                        </div>
                        <div class="form-group">
                            <p>Tipo de usuario</p>
                            <select name="tipousuario">
                                <option>Seleccione</option>
                                <?php

                                $metodosPagina->UsuariosSelect($tipousuario);

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <p>Contraseña</p>
                            <input type="password" name="contraseña" class="campo">
                        </div>
                        <div class="form-group full-width">
                            <p>Descripción</p>
                            <textarea placeholder="Escribe aquí" name="descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="register-confirm-btn" style="margin-top: 20px;" name="registrarme">REGISTRARME</button>
                        </div>
                    </form>
                    <span class="close-register">&times;</span>
                </div>
            </div>
            <div id="modalLogin" class="modal"> <!--Ventana Modal cuando undes el boton de Iniciar sesion-->
                <div class="modal-content3" style="background-color: gray; color:white; border-radius: 20px;">
                    <span class="close-login">&times;</span>
                    <form class="form-iniciarsesion" action="/app/controllers/controlPagina.php" method="post">
                        <label for="login-correo">Correo electronico</label><br>
                        <input type="email" placeholder="Correo" id="login-correo" style="border-radius: 20px;" name="correo"><br>
                        <label for="login-password">Contraseña</label><br>
                        <input type="number" placeholder="Contraseña" id="login-password" style="border-radius: 20px;" name="contraseña"><br>
                        <button type="submit" id="login-confirm-btn" name="iniciar">Iniciar Sesión</button>
                    </form>
                    <br>
                    <button id="recup-btn">Olvidaste tu contraseña?</button>
                </div>
            </div>
            <div id="modalRecuperar" class="modal"> <!--Ventana Modal cuando undes el boton de Iniciar sesion-->
                <div class="modal-content4" style="background-color: gray; color:white; border-radius: 20px;">
                    <span class="close-recup">&times;</span>
                    <h2>Recuperar</h2>
                    <form class="form-iniciarsesion" action="../controllers/controlPassword.php" method="post">
                        <label for="login-correo">Correo electronico</label><br>
                        <input type="email" name="correo" placeholder="ej: user@example.com"><br>
                        <button type="submit" name="Recuperar" class="btn_form" id="login-confirm-btn">Recuperar</button>
                    </form>
                    <br>
                </div>
            </div>
            <script>
                function IniciarSesion(){
                      window.location.href = "login.php";
                }
            </script>
        <?php
    }
        ?>