<?php
require_once('conexion.php');

class Inmuebles
{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function revisarActualizarUsuario($idUsuario) {
    // Verificar cuántos inmuebles tiene publicados
        $sql = "SELECT COUNT(*) AS total FROM inmueble WHERE u_id = $idUsuario";
        $result = mysqli_query($this->con, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row['total'] == 0) {
                // No tiene inmuebles, volver a tipo USUARIO (102)
                $sqlUpdate = "UPDATE usuario SET tu_id = 102 WHERE u_id = $idUsuario AND tu_id = 103";
                return mysqli_query($this->con, $sqlUpdate);
            }
            return true; // Tiene inmuebles, no cambiar rol
        }
        return false; // Error en la consulta
    }
    public function consultarInmueble($idinmueble)
    {
        $sql = "SELECT * FROM inmueble WHERE in_id = '$idinmueble'";
        $result = mysqli_query($this->con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function eliminarInmueble($idinmueble)
    {
        $sql = "DELETE FROM inmueble WHERE in_id='$idinmueble'";
        $result = mysqli_query($this->con, $sql);

        return ($result && mysqli_affected_rows($this->con) > 0);
    }

    public function actualizarInmueble($idinmueble, $fecha, $direccion, $precio, $descripcion, $titulo, $barrio, $estado, $idusuario, $tipoinmueble, $tipopago)
    {
        $sql = "UPDATE inmueble SET
             in_id=$idinmueble,
             in_fecha_publicacion='$fecha',
             in_direccion='$direccion',
             in_precio=$precio,
             in_descripcion='$descripcion',
             in_titulo='$titulo',
             in_barrio='$barrio',
             in_estado='$estado',
             u_id=$idusuario,
             tip_id=$tipoinmueble,
             tp_id=$tipopago 
             WHERE in_id=$idinmueble";

        $actualizado = mysqli_query($this->con, $sql);

        if ($actualizado) {
            $consulta = "SELECT * FROM inmueble WHERE in_id='$idinmueble'";
            $result = mysqli_query($this->con, $consulta);

            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
        return null;
    }

    //funciones para tipo de inmueble 

    public function RegistrarTipoInmueble($id, $nombre)
    {
        $sql = "INSERT INTO tipo_de_inmueble (tip_id,tip_nombre) VALUES ($id,'$nombre')";
        $result = mysqli_query($this->con, $sql);

        return $result;
    }

    public function consultarTipoInmueble($id)
    {
        $sql = "SELECT * FROM tipo_de_inmueble WHERE tip_id = '$id'";
        $result = mysqli_query($this->con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function actualizarTipoInmueble($id, $nombre)
    {
        $sql = "UPDATE tipo_de_inmueble SET
             tip_nombre='$nombre'
             WHERE tip_id=$id";

        $actualizado = mysqli_query($this->con, $sql);

        if ($actualizado) {
            $consulta = "SELECT * FROM tipo_de_inmueble WHERE tip_id='$id'";
            $result = mysqli_query($this->con, $consulta);

            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
        return null;
    }

    public function eliminarTipoInmueble($id)
    {
        $sql = "DELETE FROM tipo_de_inmueble WHERE tip_id=$id";
        $result = mysqli_query($this->con, $sql);

        return ($result && mysqli_affected_rows($this->con) > 0);
    }

    public function VerificarTipoInmueble($id)
    {

        $consulta = "SELECT COUNT(*) FROM tipo_de_inmueble WHERE tip_id='$id'";
        $resultado = mysqli_query($this->con, $consulta);
        $array = mysqli_fetch_array($resultado)[0];

        return $array;
    }

    public function VerificarInmueblesConTipoInmueble($idtipoinmueble){
        $sql = "SELECT COUNT(*) as count FROM inmueble WHERE tip_id = $idtipoinmueble";
        $result=mysqli_query($this->con,$sql);
        $fila=mysqli_fetch_assoc($result);

        return $fila;
        
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

        if ($id !== null) {
        $sql = "SELECT * FROM inmueble WHERE in_id = $id";
        } else {
            if ($rol == 'Administrador') {
                $sql = "SELECT * FROM inmueble";

            } elseif ($rol == 'Propietario') {
                // Traer los inmuebles del propietario
                $sql = "SELECT * FROM inmueble WHERE u_id = $u_id";
            } else {
                $sql = "SELECT * FROM reservas WHERE u_id = $u_id";
            }
        }

        $result = mysqli_query($this->con, $sql);

        // Si no hay resultados, mostrar un mensaje en la tabla
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron reservas</td></tr>";
            return;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['in_id']}</td>
                    <td>{$row['in_fecha_publicacion']}</td>
                    <td>{$row['in_direccion']}</td>
                    <td>{$row['in_precio']}</td>
                    <td>{$row['in_descripcion']}</td>
                    <td>{$row['in_titulo']}</td>
                    <td>{$row['in_barrio']}</td>
                    <td>{$row['in_estado']}</td>
                    <td>{$row['u_id']}</td>
                    <td>{$row['tip_id']}</td>
                    <td>{$row['tp_id']}</td>
                    <td>
                        <a href='../../views/viewEditarCruds/editarInmueble.php?id=" . $row['in_id'] . "' class='btn btn-warning'>
                            <i class='fa-solid fa-pen-to-square'></i> 
                        </a>
                        <a onclick='return confirmarEliminar({$row['in_id']})' href='../../controllers/controlnmuebles.php?eliminar=1&id={$row['in_id']}' class='btn btn-small btn-danger'>
                            <i class='fa-solid fa-trash'></i>
                        </a>
                    </td>
                </tr>";
        }
    }
    
    public function getTabla2($id = null)
    {
        // Si se proporciona un ID, se filtra por él
        if ($id) {
            $sql = "SELECT * FROM tipo_de_inmueble WHERE tip_id = $id";
            $result = mysqli_query($this->con, $sql);
        } else {
            // Si no hay ID, traer todos los inmuebles
            $sql = "SELECT * FROM tipo_de_inmueble";
            $result = mysqli_query($this->con, $sql);
        }

        // Si no hay resultados, mostrar un mensaje en la tabla
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron los tipos de inmueble</td></tr>";
            return;
        }

        // Mostrar los resultados en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['tip_id']}</td>
                    <td>{$row['tip_nombre']}</td>
                    <td>
                  <a href='../../views/viewEditarCruds/editarTipoInmueble.php?id=" . $row['tip_id'] . "' class='btn btn-warning'>
                    <i class='fa-solid fa-pen-to-square'></i> 
                 </a>
                   <a onclick='return confirmarEliminar({$row['tip_id']})' href='../../controllers/controlnmuebles.php?btneliminar=1&id={$row['tip_id']}' class='btn btn-small btn-danger'>
                      <i class='fa-solid fa-trash'></i>
                   </a>
                    </td>
                </tr>";
        }
    }
}
