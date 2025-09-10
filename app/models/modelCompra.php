<?php
require_once('conexion.php');

class modelCompra {
    private $con;

    public function __construct($conexion) {
        $this->con = $conexion;
    }

    // Obtener un inmueble por ID
    public function obtenerPorId($idinmueble) {
        $consult = "SELECT * FROM inmueble WHERE in_id = $idinmueble";
        $result = mysqli_query($this->con, $consult);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    // Obtener promedio de calificación
    public function obtenerPromedioCalificacion($id) {
        $consult = "SELECT AVG(re_calificacion) AS promedio FROM reseña WHERE in_id = $id";
        $result = mysqli_query($this->con, $consult);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row ? round($row['promedio'], 1) : 0;
        }
        return 0;
    }

    // Obtener la calificación específica que hizo un usuario sobre un inmueble
    public function obtenerCalificacionUsuario($inmuebleId, $userId) {
        $query = "SELECT re_calificacion FROM reseña WHERE in_id = $inmuebleId AND u_id = $userId LIMIT 1";
        $result = mysqli_query($this->con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return (int)$row['re_calificacion'];
        }

        return 0;
    }

    // Obtener todos los comentarios de un inmueble
    public function obtenerComentarios($inmuebleId) {
        $consult = "
            SELECT c.c_id, c.c_com, c.u_id, u.u_nombre, u.u_apellido, u.u_imagen 
            FROM comentario c
            JOIN usuario u ON c.u_id = u.u_id
            WHERE c.in_id = $inmuebleId";
        $resultado = mysqli_query($this->con, $consult);

        if ($resultado) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Insertar un nuevo comentario
    public function insertarComentario($coment, $userId, $inmuebleId) {
        $consult = "INSERT INTO comentario (c_com, u_id, in_id) VALUES ('$coment', $userId, $inmuebleId)";
        return mysqli_query($this->con, $consult);
    }

    // Eliminar comentario (solo si pertenece al usuario)
    public function eliminarComentario($comentarioId, $userId) {
        $consult = "DELETE FROM comentario WHERE c_id = $comentarioId AND u_id = $userId";
        return mysqli_query($this->con, $consult);
    }

    // Añadir o quitar de favoritos
    public function manejarFavorito($userId, $inmuebleId) {
        $consult = "SELECT * FROM favorito WHERE u_id = $userId AND in_id = $inmuebleId";
        $result = mysqli_query($this->con, $consult);

        if ($result && mysqli_num_rows($result) > 0) {
            $delete = "DELETE FROM favorito WHERE u_id = $userId AND in_id = $inmuebleId";
            return mysqli_query($this->con, $delete);
        } else {
            $insert = "INSERT INTO favorito (u_id, in_id) VALUES ($userId, $inmuebleId)";
            return mysqli_query($this->con, $insert);
        }
    }

    // Insertar o actualizar calificación de un usuario para un inmueble
    public function manejarCalificacion($userId, $inmuebleId, $calificacion) {
        $check = $this->con->prepare("SELECT * FROM reseña WHERE u_id = ? AND in_id = ?");
        $check->bind_param("ii", $userId, $inmuebleId);
        $check->execute();
        $result = $check->get_result();
        $fecha = date("Y-m-d H:i:s");

        if ($result->num_rows > 0) {
            $update = $this->con->prepare("UPDATE reseña SET re_calificacion = ?, re_fecha = ? WHERE u_id = ? AND in_id = ?");
            $update->bind_param("isii", $calificacion, $fecha, $userId, $inmuebleId);
            return $update->execute();
        } else {
            $insert = $this->con->prepare("INSERT INTO reseña (re_calificacion, re_fecha, u_id, in_id) VALUES (?, ?, ?, ?)");
            $insert->bind_param("isii", $calificacion, $fecha, $userId, $inmuebleId);
            return $insert->execute();
        }
    }

    // Obtener datos del propietario del inmueble
    public function obtenerDatosPropietario($u_id) {

        $sql = "SELECT * FROM usuario WHERE u_id = $u_id";

        $resultado = mysqli_query($this->con, $sql);
        return $resultado->fetch_assoc();
    }
    
    public function obtenerPublicacionesPropietario($u_id) {
        
    $sql = "SELECT * FROM inmueble WHERE u_id = $u_id";
    $resultado = mysqli_query($this->con, $sql);
    
        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return []; // Retorna array vacío si no hay resultados
        }
    }
}   
?>
