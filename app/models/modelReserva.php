<?php
require_once('conexion.php');

class Reserva
{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function obtenerIdInmueble($idinmueble){
        $sql = "SELECT in_id FROM inmueble WHERE in_id = $idinmueble";
        $result = mysqli_query($this->con,$sql);

        $fila=mysqli_fetch_assoc($result);
        return $fila['in_id'];

    }
    //Funcion para traernos el nombre y apellido del usuario y mostrarlo cuando se hace una reserva.
    public function datosReserva($correo){
        $sql = "SELECT * FROM usuario WHERE u_correo = '$correo'";
        $result = mysqli_query($this->con,$sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }
    public function consultarReserva($idusuario)
    {
        $sql = "SELECT * FROM reservas WHERE u_id = '$idusuario'";
        $result = mysqli_query($this->con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function consultarReserva2($idreserva)
    {
        $sql = "SELECT * FROM reservas WHERE r_id = '$idreserva'";
        $result = mysqli_query($this->con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }
    //Funcion de validacion para saber si es propietario del inmueble
    public function PropietarioDelInmueble($uid, $inmuebleId) {

        $sql = "SELECT 1 FROM inmueble WHERE in_id = $inmuebleId AND u_id = $uid";
        $res = mysqli_query($this->con, $sql);

        return mysqli_num_rows($res) > 0;

    }
    //Funcion para Guardar la reserva
    public function guardarReserva($fecha, $estado, $hora, $uid, $idinmueble){
            
        $result = "INSERT INTO reservas (r_fecha_inicio, r_estado, r_hora, u_id, in_id) VALUES ('$fecha', '$estado', '$hora', '$uid', '$idinmueble')";
        $flec = mysqli_query($this->con, $result);

        return $flec;

    }

public function actualizarReserva($idreserva, $fecha, $estado, $hora, $usuario, $inmueble, $motivo = '') {

    if ($estado === 'Cancelado') {
        $sql = "UPDATE reservas SET 
                    r_fecha_inicio = '$fecha',
                    r_estado = 'Cancelado',
                    r_hora = '$hora',
                    r_motivo = '$motivo',
                    u_id = $usuario,
                    in_id = $inmueble
                WHERE r_id = $idreserva";
    } else {
        $sql = "UPDATE reservas SET 
                    r_fecha_inicio = '$fecha',
                    r_estado = '$estado',
                    r_hora = '$hora',
                    r_motivo = NULL,
                    u_id = $usuario,
                    in_id = $inmueble
                WHERE r_id = $idreserva";
    }
    $actualizado = mysqli_query($this->con, $sql);

    if ($actualizado) {
        $consulta = "SELECT * FROM reservas WHERE r_id = $idreserva";
        $result = mysqli_query($this->con, $consulta);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result); // Devuelve datos actualizados
        }
    }

    return null;
}

    public function eliminarReserva($idreserva)
    {
        $sql = "DELETE FROM reservas WHERE r_id=$idreserva";
        $result = mysqli_query($this->con, $sql);

        return ($result && mysqli_affected_rows($this->con) > 0);
    }
}

class TraerElementos
{
    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function getTabla($id = null) {

        $rol = $_SESSION['rol'];
        $u_id = $_SESSION['u_id']; // ID del usuario logueado

        if ($rol == 'Administrador') {

            $sql = "SELECT * FROM reservas";

        } elseif ($rol == 'Propietario') {
            // Traer reservas hechas a los inmuebles del propietario
            $sql = "SELECT r.* 
                    FROM reservas r
                    INNER JOIN inmueble i ON r.in_id = i.in_id
                    WHERE i.u_id = $u_id";
        } else {
            // Usuario normal: solo sus reservas
            $sql = "SELECT * FROM reservas WHERE u_id = $u_id";
        }

        $result = mysqli_query($this->con, $sql);

        // Si no hay resultados, mostrar un mensaje en la tabla
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron reservas</td></tr>";
            return;
        }

        // Mostrar los resultados en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['r_id']}</td>
                    <td>{$row['r_fecha_inicio']}</td>
                    <td>{$row['r_estado']}</td>
                    <td>{$row['r_hora']}</td>
                    <td>{$row['u_id']}</td>
                    <td>{$row['in_id']}</td>
                    <td>
                        <a href='../../views/viewEditarCruds/editarReserva.php?id=" . $row['r_id'] . "' class='btn btn-warning'>
                            <i class='fa-solid fa-pen-to-square'></i> 
                        </a>
                        <a onclick='return confirmarEliminar({$row['r_id']})' href='../../controllers/controlReserva.php?eliminar=1&id={$row['r_id']}' class='btn btn-small btn-danger'>
                            <i class='fa-solid fa-trash'></i>
                        </a>
                    </td>
                </tr>";
        }
    }

}
