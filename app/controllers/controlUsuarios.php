<?php
session_start();
require_once("../models/modelUsuarios.php");
require_once("../models/conexion.php");

$conexion=new Conexion();
$metodosUsuarios=new Usuarios($conexion->getConexion());

if (isset($_POST["btnregistrar"])) {
    if (!empty($_POST["id"]) && !empty($_POST["nombre"]) && !empty($_POST["apellido"]) && 
        !empty($_POST["correo"]) && !empty($_POST["direccion"]) && !empty($_POST["telefono"]) && 
        !empty($_POST["tipousuario"]) && !empty($_POST["descripcion"])) {

        $idusuario = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $correo = $_POST["correo"];
        $contraseña = $_POST["contraseña"];
        $direccion = $_POST["direccion"];
        $telefono = $_POST["telefono"];
        $tipousuario = $_POST["tipousuario"];
        $descripcion = $_POST["descripcion"];

        $count = $metodosUsuarios->VerificarUsuario($idusuario);

        if ($count > 0) {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'El usuario ya existe','mensaje'=>''];
            
        } else {
            $result = $metodosUsuarios->RegistroUsuario($idusuario, $nombre, $apellido, $correo, $contraseña, $direccion, $telefono, $tipousuario, $descripcion);

            if ($result) {
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Usuario registrado correctamente','mensaje'=>''];

            } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al registrar usuario','mensaje'=>''];

            }
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Algunos campos están vacíos','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaUsuarios.php'); // 🔹 Redirigir después de registrar
    exit();
}

if (isset($_POST['btnconsultar'])) {
    $idusuario = $_POST['id'];

    if (!empty($_POST['id'])) {
       
      // Verificar si el usuario existe en la base de datos
        $usuario = $metodosUsuarios->ConsultarUsuarios($idusuario);
        
        if ($usuario) {
            $_SESSION['id'] = $idusuario;
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Usuario encontrado correctamente','mensaje'=>''];
        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'No se encontró el usuario con ID','mensaje'=>$idusuario];

            unset($_SESSION['id']);
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'info','titulo'=>'Por favor, ingresa un ID para consultar','mensaje'=>''];

        unset($_SESSION['id']);
    }

    header('location: ../views/viewCruds/vistaUsuarios.php'); // Redirigir para actualizar la vista
    exit();
}
if (isset($_GET['eliminar'])) {
    $idusuario = $_GET['id'];

    if (!empty($idusuario)) {
        $usuario = $metodosUsuarios->eliminarUsuarios($idusuario);

        if ($usuario) {
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro eliminado correctamente','mensaje'=>''];
        } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al eliminar el registro','mensaje'=>''];
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'ID no válido','mensaje'=>''];
    }

    header('location: ../views/viewCruds/vistaUsuarios.php');
    exit();
}

if (isset($_POST['btnmodificar'])) {

    $idusuario=$_POST["id"];
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
    $correo=$_POST["correo"];
    $contraseña=$_POST["contraseña"];
    $direccion=$_POST["direccion"];
    $telefono=$_POST["telefono"];
    $tipousuario=$_POST["tipousuario"];
    $descripcion=$_POST["descripcion"];

    $fechaActual = date("Y-m-d");

    // Validación de campos no vacíos
    if (!empty($idusuario) && !empty($nombre) && !empty($apellido) && !empty($correo) &&
        !empty($contraseña) && !empty($direccion) && !empty($telefono) && !empty($tipousuario) &&
        !empty($descripcion)) {

            $usuarios = $metodosUsuarios->actualizarUsuario($idusuario, $nombre, $apellido, $correo, $contraseña, $direccion, $telefono, $tipousuario,$descripcion);
            if ($usuarios) {
                $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro actualizado correctamente','mensaje'=>''];

            } else {
                $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al actualizar registro','mensaje'=>''];
            }
    } else {
                $_SESSION['alerta'] = ['tipo'=>'info','titulo'=>'Por favor, complete todos los campos para actualizar.','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaUsuarios.php');
    exit();
}

//FUNCIONES PARA TIPO DE USUARIO
if (isset($_POST["registrar"])) {

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    if (!empty($id) && !empty($nombre)) {

        $count = $metodosUsuarios->VerificarTipoUsuario($id);

        if ($count > 0) {
            $_SESSION['alerta'] = ['tipo'=>'info','titulo'=>'El tipo de usuario ya existe','mensaje'=>''];
        
        } else {
            $result = $metodosUsuarios->RegistrarTipoUsuario($id,$nombre);

            if ($result) {
            $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Tipo de usuario registrado correctamente','mensaje'=>''];

            } else {
            $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al registrar el tipo de usuario','mensaje'=>''];

            }
        }
    } else {
            $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Algunos campos están vacíos','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaTipoUsuario.php'); // 🔹 Redirigir después de registrar
    exit();
}

if (isset($_GET['btneliminar'])) {
    $id = $_GET['id'];

    $fila=$metodosUsuarios->VerificarTipoUsuarioConUsuarios($id);

        if ($fila['count'] > 0) {
            $_SESSION['alerta'] = ['tipo'=>'info','titulo'=>'No puedes eliminar este tipo de usuario porque tiene usuarios asociados','mensaje'=>'Elimina los usuarios primero.'];

        } else{
            if (!empty($id)) {
                $tipousuario = $metodosUsuarios->eliminarTipoUsuario($id);
        
                if ($tipousuario) {
                    $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro eliminado correctamente','mensaje'=>''];

                } else {
                    $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al eliminar el registro','mensaje'=>''];

                }
            } else {
                    $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'ID no válido de tipo inmueble','mensaje'=>''];

            }
        }

        header('location: ../views/viewCruds/vistaTipoUsuario.php');
    exit();
}

if (isset($_POST['modificar'])) {

    $id = $_POST["id"];
    $nombre= $_POST['nombre'];

    // Validación de campos no vacíos
    if (!empty($id) && !empty($nombre)) {

        
            $tipousuario = $metodosUsuarios->actualizarTipoUsuario($id,$nombre);

            if ($tipousuario) {
                    $_SESSION['alerta'] = ['tipo'=>'success','titulo'=>'Registro actualizado correctamente','mensaje'=>''];

            } else {
                    $_SESSION['alerta'] = ['tipo'=>'error','titulo'=>'Error al actualizar registro','mensaje'=>''];

            }
    } else {
                    $_SESSION['alerta'] = ['tipo'=>'warning','titulo'=>'Por favor, complete todos los campos para actualizar.','mensaje'=>''];

    }

    header('location: ../views/viewCruds/vistaTipoUsuario.php');
    exit();
}