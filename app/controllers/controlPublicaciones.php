<?php
include_once '../models/modelPagina.php';
require_once("../models/conexion.php");

session_start();
$conexion = new Conexion();
$modelo = new MetodosVista($conexion->getConexion());

$correo = $_SESSION['correo'];
$TipoIdUser = $modelo->validacionTpUser($correo);

// Verificar si se presionó el botón de registrar
if (isset($_POST["btnregistrar"])) {

    if($TipoIdUser === true){
        // Validar que todos los campos necesarios estén presentes
        if (!empty($_POST["id"]) && !empty($_POST["fecha"]) && !empty($_POST["direccion"]) && !empty($_POST["precio"]) && !empty($_POST["descripcion"]) && !empty($_POST["titulo"]) && !empty($_POST["barrio"]) && !empty($_POST["estado"]) && !empty($_POST["tipoinmueble"]) && !empty($_POST["tipopago"])) {

            // Obtener los valores del formulario
            $idinmueble = $_POST["id"];
            $fecha = $_POST["fecha"];
            $precio = $_POST["precio"];
            $descripcion = $_POST["descripcion"];
            $titulo = $_POST["titulo"];
            $barrio = $_POST["barrio"];
            $estado = $_POST["estado"];
            $tipoinmueble = $_POST["tipoinmueble"];
            $tipopago = $_POST["tipopago"];
            $idusuario = $_SESSION['u_id']; // Obtener el idusuario de la sesión
            $direccion = $_POST["direccion"];
            $latitud = $_POST["latitud"];
            $longitud = $_POST["longitud"];


            $directorio = $_SERVER['DOCUMENT_ROOT'] . "/public/img/inmuebles/";
            $rutaRelativa = "../../public/img/inmuebles/";
            if (!is_dir($directorio)) { // Verificar si es una carpeta
                mkdir($directorio, 0777, true);
            }

            // Llamar a la función del modelo para registrar el inmueble
            $registroExitoso = $modelo->registrarInmueble($idinmueble, $fecha, $direccion, $precio, $descripcion, $titulo, $barrio, $estado, $tipoinmueble, $tipopago, $idusuario, $rutaRelativa, $latitud, $longitud);

            if ($registroExitoso === "Inmueble registrado correctamente.") {

                $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Inmueble publicado correctamente','mensaje'=>''];
                header('Location: ../views/publicaciones.php');

            } elseif ($registroExitoso === "Error al subir las imágenes.") {

                $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Hubo un error al guardar esta imagen','mensaje'=>''];
                header('Location: ../views/publicaciones.php');

            } elseif ($registroExitoso === "El inmueble ya existe.") {

                $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'El inmueble ya existe!!!','mensaje'=>''];
                header('Location: ../views/publicaciones.php');

            } elseif ($registroExitoso === "La fecha ingresada no puede ser anterior a la actual.") {

                $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'La fecha ingresada no puede ser anterior a la actual!!','mensaje'=>''];
                header('Location: ../views/publicaciones.php');

            } elseif ($registroExitoso === "Debes subir las 4 imágenes obligatoriamente.") {

                $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'','mensaje'=>'Debes subir las 4 imágenes obligatoriamente.'];
                header('Location: ../views/publicaciones.php');

            } else {
                
                echo "<script language='javascript'>alert('$registroExitoso');window.location='../views/publicaciones.php'</script>";

            }

        } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Algunos campos están vacíos, por favor completa los campos','mensaje'=>''];
            header("location: ../views/publicaciones.php");
            exit;
        }
    }else{
        echo "<script language='javascript'>alert('Error Update');window.location='../views/publicaciones.php'</script>";
        
    }
}
?>