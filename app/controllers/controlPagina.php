<?php
require_once("../models/modelPagina.php");
require_once("../models/modelPerfil.php");
require_once("../models/conexion.php");
session_start();

$conexion = new Conexion();
$metodosPagina = new MetodosVista($conexion->getConexion());
$metodosPerfil=new ModelPerfil($conexion->getConexion());








if (isset($_POST['iniciar'])) {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    if (!empty($correo) && !empty($contraseña)) {
        $filas = $metodosPagina->IniciarSesion($correo, $contraseña);
        
        if ($filas) {
            $_SESSION['correo'] = $correo;
            $_SESSION['u_id'] = $filas['u_id'];
            $_SESSION['Login'] = true;

            if ($filas['tu_id'] == 101 || $filas['tu_id'] == 102 || $filas['tu_id'] == 103) {
                
                $_SESSION['alerta'] = [
                'tipo' => 'success',
                'titulo' => 'Bienvenido a Leasehub',
                'mensaje' => ''    
            ];
             header("Location: ../views/index.php");
                exit;
            }
        } else {
            $_SESSION['alerta'] = [
                'tipo' => 'error',
                'titulo' => 'Correo o contraseña incorrectos',
                'mensaje' => 'Por favor, verifica tus credenciales.'
            ];
            header("Location: ../views/partials/login.php");
            exit;
        }
    } else {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'titulo' => 'Campos vacíos',
            'mensaje' => 'Por favor, complete todos los campos.'
        ];
        header("Location: ../views/partials/login.ph");
        exit;
    }
}





session_start(); // Muy importante para que funcionen las sesiones

if (isset($_REQUEST['registrarme'])) {
    $id = $_REQUEST['identificacion'];
    $nombres = $_REQUEST['nombres'];
    $apellidos = $_REQUEST['apellidos'];
    $correo = $_REQUEST['correo'];
    $contraseña = $_REQUEST['contraseña'];
    $direccion = $_REQUEST['direccion'];
    $telefono = $_REQUEST['telefono'];
    $tipousuario = $_REQUEST['tipousuario'];
    $descripcion = $_REQUEST['descripcion'];

    $imagen = $_FILES['imagenperfil']['tmp_name'];
    $nombreImagen = $_FILES['imagenperfil']['name'];
    $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));
    $sizeImagen = $_FILES['imagenperfil']['size'];

    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/public/img/perfil/";
    $nombreAleatorio = uniqid("perfil_", true) . "." . $tipoImagen;
    $rutaAbsoluta = $directorio . $nombreAleatorio;
    $rutaRelativa = str_replace($_SERVER['DOCUMENT_ROOT'], '', $rutaAbsoluta);

    if (
        !empty($id) && !empty($nombres) && !empty($apellidos) &&
        !empty($correo) && !empty($contraseña) && !empty($direccion) &&
        !empty($telefono) && !empty($tipousuario) && !empty($descripcion)
    ) {

        $fila = $metodosPagina->VerificarUsuario($id);

        if ($fila > 0) {
            $_SESSION['alerta'] = [
                'tipo' => 'error',
                'titulo' => 'El usuario ya existe.',
                'mensaje' => 'Intenta con otra identificación.'
            ];
            header("Location: ../views/partials/register.php");
            exit;
        } else {
            $registro = $metodosPagina->RegistroUsuario($id, $nombres, $apellidos, $correo, $contraseña, $direccion, $telefono, $tipousuario, $descripcion, $rutaRelativa);

            if ($registro) {
                if (move_uploaded_file($imagen, $rutaAbsoluta)) {
                    $_SESSION['alerta'] = [
                        'tipo' => 'success',
                        'titulo' => 'Registro exitoso',
                        'mensaje' => 'Tu cuenta e imagen de perfil han sido guardadas.'
                    ];
                    header("Location: ../views/index.php");
                    exit;
                } else {
                    $_SESSION['alerta'] = [
                        'tipo' => 'success',
                        'titulo' => 'Registro exitoso',
                        'mensaje' => 'La imagen no se pudo guardar, pero tu cuenta fue creada.'
                    ];
                }

                header("Location: ../views/index.php");
                exit;
            } else {
                $_SESSION['alerta'] = [
                    'tipo' => 'error',
                    'titulo' => 'Error al registrarse',
                    'mensaje' => 'Hubo un problema al guardar tus datos.'
                ];
                header("Location: ../views/partials/register.php");
                exit;
            }
        }
    } else {
        $_SESSION['alerta'] = [
            'tipo' => 'warning',
            'titulo' => 'Hay campos vacíos',
            'mensaje' => 'Por favor digita todos los datos requeridos.'
        ];
        header("Location: ../views/partials/register.php");
        exit;
    }
}






//Cambiar imagen de perfil
if (isset($_POST['changesaves'])) {
    // Asegurar que la sesión esté iniciada
    $newname = $_POST['newname'];
    $correo = $_SESSION['correo'];

    // Ruta absoluta para guardar la imagen
    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/public/img/perfil/";

    // Verificar si el directorio existe, si no, crearlo
    if (!is_dir($directorio)) {
        if (!mkdir($directorio, 0777, true)) {
            die("Error: No se pudo crear la carpeta de imágenes.");
        }
    }

    // Llamada al modelo
    $resultado = $metodosPerfil->procesarImagenPerfil("imagenPerfil", $newname, $directorio, $correo);

    // Verificar resultado
    if ($resultado) {
        
         $_SESSION['alerta'] = [
            'tipo' => 'success',
            'titulo' => 'Usuario actualizado exitosamente!',
            'mensaje' => ''
        ];
        header("Location: ../views/perfil.php");
        exit;


    } else {
        $_SESSION['alerta'] = ['tipo' => 'error', 'titulo' => 'Error al actualizar el usuario', 'mensaje' => ''];
        header("Location: ../views/perfil.php");
        exit;
    }
}
// Enviar queja de la pagina
if(isset($_POST['queja'])){
    
    // Obtener datos del formulario
    $descripcion =$_POST['q_descripcion'];
    $correo = $_SESSION['correo']; // Asegúrate de que el usuario esté autenticado y este dato esté en la sesión

    // Insertar en la base de datos
   $result=$metodosPagina->RegistrarQueja($correo,$descripcion);

    if ($result) {
    $_SESSION['alerta'] = [ 'tipo' => 'success', 'titulo' => 'Queja registrada exitosamente!', 'mensaje' => '' ];
    header("Location: ../views/quejas.php");
        exit;

    } else {
        $_SESSION['alerta'] = ['tipo' => 'error', 'titulo' => 'Error al registrar la queja' ];

    }
 
class InmuebleController {
    private $inmuebleModel;

    public function __construct($conexion) {
        $this->inmuebleModel = new MetodosVista($conexion);
    }

    public function mostrarCarrusel() {
        $inmuebles = $this->inmuebleModel->getInmuebles();
        include 'index.php';  // Cargar la vista (index.php) para mostrar los inmuebles
    }
}


}


