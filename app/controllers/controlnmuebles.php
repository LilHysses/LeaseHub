<?php
session_start();
require_once("../models/modelInmuebles.php");
require_once("../models/conexion.php");

$conexion = new Conexion();
$inmuebleModel = new Inmuebles($conexion->getConexion());

if (isset($_POST['consultar'])) {
    $idinmueble = $_POST['idinmueble'];

    if (!empty($idinmueble)) {
        $inmueble = $inmuebleModel->consultarInmueble($idinmueble);

        if ($inmueble) {
            $_SESSION['idinmueble'] = $idinmueble; // Guardamos el ID consultado
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Consulta realizada correctamente','mensaje'=>''];
        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'No se encontró el inmueble','mensaje'=>''];
            unset($_SESSION['idinmueble']);
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Por favor, ingresa un ID para consultar','mensaje'=>''];
        unset($_SESSION['idinmueble']);
    }

    header('location: ../views/viewCruds/vistaInmuebles.php');
    exit();
}

if (isset($_GET['eliminar']) && $_GET['eliminar'] == 1) {
    $idinmueble = $_GET['id'];
    $idusuario = $_SESSION['u_id'];

    if (!empty($idinmueble)) {
        $inmueble = $inmuebleModel->eliminarInmueble($idinmueble);

        if ($inmueble) {
            
            $inmuebleModel->revisarActualizarUsuario($idusuario);
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro eliminado correctamente','mensaje'=>''];

        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al eliminar el registro','mensaje'=>''];

        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'ID no válido','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaInmuebles.php');
    exit();
}

if (isset($_POST['actualizar'])) {

    $idinmueble = $_POST["idinmueble"];
    $fecha = $_POST["fecha"];
    $direccion = $_POST["direccion"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    $titulo = $_POST["titulo"];
    $barrio = $_POST["barrio"];
    $estado = $_POST["estado"];
    $idusuario = $_POST["idusuario"];
    $tipoinmueble = $_POST["tipoinmueble"];
    $tipopago = $_POST["tipopago"];

    $fechaActual = date("Y-m-d");

    // Validación de campos no vacíos
    if (!empty($idinmueble) && !empty($fecha) && !empty($direccion) && !empty($precio) &&
        !empty($descripcion) && !empty($titulo) && !empty($barrio) && !empty($estado) &&
        !empty($idusuario) && !empty($tipoinmueble) && !empty($tipopago)) {

        
            $inmueble = $inmuebleModel->actualizarInmueble($idinmueble, $fecha, $direccion, $precio, $descripcion, $titulo, $barrio, $estado, $idusuario, $tipoinmueble, $tipopago);

            if ($inmueble) {
                $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro actualizado correctamente','mensaje'=>''];
            } else {
                $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Error al actualizar registro','mensaje'=>''];

            }
    } else {
        $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Por favor, complete todos los campos para actualizar.','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaInmuebles.php');
    exit();
}

//FUNCIONES PARA TIPO DE INMUEBLE
if (isset($_POST["btnregistrar"])) {

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    if (!empty($id) && !empty($nombre)) {

        $count = $inmuebleModel->VerificarTipoInmueble($id);

        if ($count > 0) {
            $_SESSION['msg'] = "El tipo de inmueble ya existe";
        } else {
            $result = $inmuebleModel->RegistrarTipoInmueble($id,$nombre);

            if ($result) {
                $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Tipo de inmueble registrado correctamente','mensaje'=>''];

            } else {
                $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al registrar el tipo de inmueble','mensaje'=>''];

            }
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Algunos campos están vacíos','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaTipoInmueble.php'); // 🔹 Redirigir después de registrar
    exit();
}

if (isset($_GET['btneliminar'])) {
    $id = $_GET['id'];

    $fila=$inmuebleModel->VerificarInmueblesConTipoInmueble($id);

        if ($fila['count'] > 0) {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'No puedes eliminar este tipo de inmueble porque tiene inmuebles asociados. Primero, elimina los inmuebles.','mensaje'=>''];
            
        } else{
            if (!empty($id)) {
                $tipoinmueble = $inmuebleModel->eliminarTipoInmueble($id);
        
                if ($tipoinmueble) {
                    $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro eliminado correctamente','mensaje'=>''];

                } else {
                    $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al eliminar el registro','mensaje'=>''];

                }
            } else {
                $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'ID no válido de tipo inmueble','mensaje'=>''];
            }
        }

        header('location: ../views/viewCruds/vistaTipoInmueble.php');
    exit();
}

if (isset($_POST['btnmodificar'])) {

    $id = $_POST["id"];
    $nombre= $_POST['nombre'];

    // Validación de campos no vacíos
    if (!empty($id) && !empty($nombre)) {

        
            $inmueble = $inmuebleModel->actualizarTipoInmueble($id,$nombre);

            if ($inmueble) {
                $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro actualizado correctamente','mensaje'=>''];
            } else {
                $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al actualizar registro','mensaje'=>''];

            }
    } else {
        $_SESSION['alerta'] = ['tipo'=>'info','titulo'=>'Por favor, complete todos los campos para actualizar.','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaTipoInmueble.php');
    exit();
}
class controlInmueble {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new MetodosVista($conexion);
    }

    public function mostrarCarrusel() {
        $inmuebles = $this->modelo->obtenerInmuebles();
        include 'index.php';
    }
}