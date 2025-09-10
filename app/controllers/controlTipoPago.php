<?php
session_start();
require_once(__DIR__ . "/../models/modelTipoPago.php");
require_once(__DIR__ . "/../models/conexion.php");

$conexion = new Conexion();
$TipoPagoModel = new tipoPago($conexion->getConexion());


if(!empty($_POST["btnregistrar"])) {
    if(!empty($_POST["id"]) && !empty($_POST["nombre"])){

        $idtipopago=$_POST["id"];
        $nombretipopago=$_POST["nombre"];
        
        if($TipoPagoModel->consultarIdTipoPago($idtipopago)){
            $_SESSION['alerta']=['tipo'=>'info','titulo'=>'Este tipo de pago ya existe!!!','mensaje'=>''];
            header("location: ../views/viewCruds/vistaTipoPago.php");
            exit;
        }else{
            if($TipoPagoModel->registrarTipoPago($idtipopago, $nombretipopago)){
            $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Tipo de Pago Guardado Correctamente!!!','mensaje'=>''];
            header("location: ../views/viewCruds/vistaTipoPago.php");
            exit;

            } else {
                $_SESSION['alerta']=['tipo'=>'error','titulo'=>'Error al registrar tipo de pago','mensaje'=>''];
                header("location: ../views/viewCruds/vistaTipoPago.php");
                exit;
            }
        }
       
    }else{
       $_SESSION['alerta']=['tipo'=>'warning','titulo'=>'Algunos de los campos esta vacio','mensaje'=>''];
       header("location: ../views/viewCruds/vistaTipoPago.php");
       exit;
    }
}

if(!empty($_GET["id"])) {
    $idtipopago = $_GET["id"];

    if($TipoPagoModel->consultarTipoPago2($idtipopago)){
        // Si hay inmuebles asociados, muestra una advertencia
       $_SESSION['alerta']=['tipo'=>'warning','titulo'=>'No puedes eliminar este tipo de pago porque tiene inmuebles asociados. Elimina los inmuebles primero.','mensaje'=>''];
       header("location: ../views/viewCruds/vistaTipoPago.php");
       exit;
    } else {
        // Si no hay dependencias, procede a eliminar
        if($TipoPagoModel->eliminarTipoPago($idtipopago)){
            $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Tipo de pago eliminado correctamente.','mensaje'=>''];
            header("location: ../views/viewCruds/vistaTipoPago.php");
            exit;
        }else{
            $_SESSION['alerta']=['tipo'=>'error','titulo'=>'Error al Eliminar el Tipo de Pago.','mensaje'=>''];
            header("location: ../views/viewCruds/vistaTipoPago.php");
            exit;
        }
    }
}

if(!empty($_POST["btnmodificar"])){
    if(!empty($_POST["id"]) and !empty($_POST["nombre"])){

        $idtipopago=$_POST["id"];
        $nombretipopago=$_POST["nombre"];

        if ($TipoPagoModel->actualizarTipoPago($idtipopago, $nombretipopago)) {
            $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Tipo de Pago Actulazado Correctamente!.','mensaje'=>''];
            header("location: ../views/viewCruds/vistaTipoPago.php");
            exit;
        } else {
            $_SESSION['alerta']=['tipo'=>'success','titulo'=>'Error al modificar tipo de pago','mensaje'=>''];
        }
        
    }else{
            $_SESSION['alerta']=['tipo'=>'warning','titulo'=>'Campos vacios','mensaje'=>''];

    }
}

?>