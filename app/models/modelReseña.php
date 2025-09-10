<?php

require_once('conexion.php');

class Reseña
{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function consultarReseña($idreseña)
    {
        $sql = "SELECT * FROM reseña WHERE re_id = '$idreseña'";
        $result = mysqli_query($this->con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function registrarReseña($id, $calificacion, $fecha, $idusuario, $idinmueble)
{
    // Validación interna de que no exista el ID
    $check = "SELECT re_id FROM reseña WHERE re_id = '$id'";
    $result = mysqli_query($this->con, $check);

    if ($result && mysqli_num_rows($result) > 0) {
        return false; // Ya existe
    }

    $sql = "INSERT INTO reseña (re_id, re_calificacion, re_fecha, u_id, in_id) 
            VALUES ('$id', '$calificacion', '$fecha', '$idusuario', '$idinmueble')";
    $resultado = mysqli_query($this->con, $sql);

    return $resultado;
}

    public function actualizarReseña($idreseña, $calificacion, $fecha, $idusuario, $idinmueble)
    {
        $sql = "UPDATE reseña SET
         re_calificacion='$calificacion',
         re_fecha='$fecha',
         u_id=$idusuario,
         in_id=$idinmueble 
         where re_id=$idreseña";

        $actualizado = mysqli_query($this->con, $sql);

        if ($actualizado) {
            $consulta = "SELECT * FROM reseña WHERE re_id='$idreseña'";
            $result = mysqli_query($this->con, $consulta);

            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
        return null;
    }

    public function eliminarReseña($idreseña)
    {
        $sql = "DELETE FROM reseña WHERE re_id=$idreseña";
        $result = mysqli_query($this->con, $sql);

        return ($result && mysqli_affected_rows($this->con) > 0);
    }

    public function UsuariosSelect($usuario)
    {

        $consulta = "SELECT * FROM usuario";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['u_id'] == $usuario) ? 'selected' : '';
                echo "<option value='" . $fila['u_id'] . "' $selected>" . $fila['u_nombre'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun usuario</option>";
        }
    }

    public function InmuebleSelect($inmueble)
    {

        $consulta = "SELECT * FROM inmueble";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['in_id'] == $inmueble) ? 'selected' : '';
                echo "<option value='" . $fila['in_id'] . "' $selected>" . $fila['in_titulo'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun inmueble</option>";
        }
    }

}


class TraerElementos
{
    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function getTabla($id = null){

        $rol = $_SESSION['rol'];
        $u_id = $_SESSION['u_id']; // ID del usuario logueado

        if ($rol == 'Administrador') {

            $sql = "SELECT * FROM reseña";

        } elseif ($rol == 'Propietario') {
            // Traer reservas hechas a los inmuebles del propietario
            $sql = "SELECT r.* 
                    FROM reseña r
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

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['re_id']}</td>
                    <td>{$row['re_calificacion']}</td>
                    <td>{$row['re_fecha']}</td>
                    <td>{$row['u_id']}</td>
                    <td>{$row['in_id']}</td>";
        
            // Mostrar botones solo si el rol es Administrador
            if ($rol == 'Administrador') {
                echo "<td>
                        <a href='../../views/viewEditarCruds/editarReseña.php?id={$row['re_id']}' class='btn btn-warning'>
                            <i class='fa-solid fa-pen-to-square'></i> 
                        </a>
                        <a onclick='return confirmarEliminar({$row['re_id']})' href='../../controllers/controlReseña.php?eliminar=1&id={$row['re_id']}' class='btn btn-small btn-danger'>
                            <i class='fa-solid fa-trash'></i>
                        </a>
                      </td>";
            } else {
                echo "<td>—</td>"; // O dejar la celda vacía si no es admin
            }
        
            echo "</tr>";
        }
    }
}
