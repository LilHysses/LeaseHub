<?php

require_once('conexion.php');

class Quejas{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function consultarQueja($idqueja)
    {
        $sql = "SELECT * FROM quejas WHERE q_id = '$idqueja'";
        $result = mysqli_query($this->con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function getCorreoUsuarioPorQueja($idqueja) {
    $sql = "SELECT u.u_correo, u.u_nombre 
            FROM quejas q 
            INNER JOIN usuarios u ON q.u_correo = u.u_correo 
            WHERE q.q_id = $idqueja";
    $resultado = mysqli_query($this->con, $sql);

    if ($resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    return null;
}

    public function actualizarQueja($idqueja, $correo, $descripcion, $respuesta)
    {
        $sql = "UPDATE quejas SET
         u_correo='$correo',
         q_descripcion='$descripcion',
         q_respuesta='$respuesta'
         WHERE q_id=$idqueja";

        $actualizado = mysqli_query($this->con, $sql);

        if ($actualizado) {
            $consulta = "SELECT * FROM quejas WHERE q_id='$idqueja'";
            $result = mysqli_query($this->con, $consulta);

            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
        return null;
    }

    public function eliminarQueja($idqueja)
    {
        $sql = "DELETE FROM quejas WHERE q_id=$idqueja";
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

    public function getTabla($id = null)
    {
        // Si se proporciona un ID, se filtra por él
        if ($id) {
            $consulta = "SELECT * FROM quejas WHERE q_id = $id";
            $result = mysqli_query($this->con, $consulta);
        } else {
            // Si no hay ID, traer todos los inmuebles
            $consulta = "SELECT * FROM quejas";
            $result = mysqli_query($this->con, $consulta);
        }

        // Si no hay resultados, mostrar un mensaje en la tabla
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron quejas</td></tr>";
            return;
        }

        // Mostrar los resultados en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['q_id']}</td>
                    <td>{$row['u_correo']}</td>
                    <td>{$row['q_descripcion']}</td>
                    <td>
                  <a href='../../views/viewEditarCruds/editarQueja.php?id=" . $row['q_id'] . "' class='btn btn-warning'>
                    <i class='fa-solid fa-pen-to-square'></i> 
                 </a>
                   <a onclick='return confirmarEliminar({$row['q_id']})' href='../../controllers/controlQueja.php?eliminar=1&id={$row['q_id']}' class='btn btn-small btn-danger'>
                      <i class='fa-solid fa-trash'></i>
                   </a>
                    </td>
                </tr>";
        }
    }
}
?>