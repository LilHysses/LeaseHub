<?php
class ModelNotificacion {
    private $conexion;
    private $idUsuario;
    private $tpUsuario;
    public $resultComentarios;
    public $resultReservas;
    public $estadoReserva;
    public $resultPendientes;
    public $noNotificaciones;

    public function __construct($conexion) {
        $this->conexion = $conexion;
        $this->inicializar();
    }

    //Inicializa todas la funciones
    private function inicializar() {
        $this->obtenerIdUsuario();
        $this->cargarNotificaciones();
        $this->manejarCerrarComentario();
        $this->manejarCerrarReserva();
    }

    //Obtener el id del usuario
    private function obtenerIdUsuario() {
        if (isset($_SESSION['correo'])) {
            $correo = $_SESSION['correo'];
            $consulta = "SELECT u_id, tu_id FROM usuario WHERE u_correo = '$correo'";
            $resultado = mysqli_query($this->conexion, $consulta);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $row = mysqli_fetch_assoc($resultado);
                $this->idUsuario = $row['u_id'];
                $this->tpUsuario = $row['tu_id'];
            }
        }
    }
    //Funcion de todas las notificaciones
    private function cargarNotificaciones() {
        $id = $this->idUsuario;

        // Comentarios no vistos
        $sqlComentarios = "SELECT c.c_id, c.c_com, i.in_id, i.in_titulo FROM inmueble i 
                           LEFT JOIN comentario c ON i.in_id = c.in_id 
                           WHERE i.u_id = $id AND c.c_visto = 0";
        $this->resultComentarios = $this->conexion->query($sqlComentarios);

        // Reservas aceptadas o canceladas no vistas
        $sqlReservas = "SELECT r.r_id, r.r_estado, r.r_motivo, i.in_titulo FROM inmueble i 
                        LEFT JOIN reservas r ON i.in_id = r.in_id 
                        WHERE r.u_id = $id AND (r.r_estado = 'Aceptado' OR r.r_estado = 'Cancelado') AND r.r_visto = 0";
        $this->resultReservas = $this->conexion->query($sqlReservas);


        // Reservas pendientes
        $sqlPendientes = "SELECT r.r_id, i.in_titulo FROM inmueble i 
                          LEFT JOIN reservas r ON i.in_id = r.in_id 
                          WHERE i.u_id = $id AND r.r_estado = 'Pendiente'";
        $this->resultPendientes = $this->conexion->query($sqlPendientes);

        $this->noNotificaciones = (
            ($this->resultComentarios->num_rows == 0) && 
            ($this->resultReservas->num_rows == 0) && 
            ($this->resultPendientes->num_rows == 0)
        );
    }
    //Funcion de cerrar la notificacion de Comentarios nuevos!!
    private function manejarCerrarComentario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cerrar_comentario']) && isset($_POST['cerrar_comentario_id'])) {
            $comentarioId = intval($_POST['cerrar_comentario_id']);

            $update = "UPDATE comentario 
                       SET c_visto = 1 
                       WHERE c_id = $comentarioId";

            $this->conexion->query($update);

            echo "<script language='javascript'>window.location='/app/views/notificacion.php'</script>";
            exit();
        }
    }


    private function manejarCerrarReserva() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cerrar_reserva']) && isset($_POST['cerrar_reserva_id'])) {
            $reservaId = intval($_POST['cerrar_reserva_id']);

            $update = "UPDATE reservas 
                       SET r_visto = 1 
                       WHERE r_id = $reservaId";

            $this->conexion->query($update);

            echo "<script>window.location='/app/views/notificacion.php'</script>";
            exit();
        }
    }


    // Métodos públicos para acceder a los resultados

    public function getResultComentarios() {
        return $this->resultComentarios;
    }

    public function getResultReservas() {
        return $this->resultReservas;
    }

    public function getResultPendientes() {
        return $this->resultPendientes;
    }

    public function hayNoNotificaciones() {
        return $this->noNotificaciones;
    }
}
?>
