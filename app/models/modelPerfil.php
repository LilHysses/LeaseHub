<?php

class ModelPerfil
{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function imgPerfil($correo)
    {
        $consulta = "SELECT u_imagen FROM usuario WHERE u_correo='$correo'";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function datosPerfil($correo)
    {
        $consulta = "SELECT u_id, u_nombre, u_apellido, u_direccion, u_telefono, u_descripcion, tu_id
            FROM usuario WHERE u_correo = '$correo'";
        $result = mysqli_query($this->con, $consulta);
        $array = mysqli_fetch_array($result);

        return $array;
    }

    public function ActualizarNombre($correo, $newname)
    {
        $consulta = "UPDATE usuario SET u_nombre = '$newname' WHERE u_correo = '$correo'";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function Favoritos($iduser)
    {
        $consulta = "SELECT i.in_id, i.in_titulo, i.in_direccion, i.in_precio, i.in_imagen 
              FROM favorito f 
              JOIN inmueble i ON f.in_id = i.in_id
              WHERE f.u_id = '$iduser'";

        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function procesarImagenPerfil($imagen, $newname, $directorio, $correo)
    {
        if ($_FILES[$imagen]["error"] === UPLOAD_ERR_OK) {
            $nombreImagen = $_FILES[$imagen]["name"];
           // Obtener la extensión del archivo
            $tipoImagen = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));

            // Verificar si el tipo de archivo es válido
            if (!in_array($tipoImagen, ["jpg", "jpeg", "png", "gif", "webp"])) {
                return false; // Tipo de archivo no permitido
            }
            // Generar un nombre aleatorio único
            $nombreAleatorio = uniqid("perfil_", true) . "." . $tipoImagen;
            // Ruta absoluta (para mover la imagen)
            $rutaAbsoluta = $directorio . $nombreAleatorio;
            // Ruta relativa (para guardar en la base de datos)
            $rutaRelativa = str_replace($_SERVER['DOCUMENT_ROOT'], '', $rutaAbsoluta);

            if (move_uploaded_file($_FILES[$imagen]["tmp_name"], $rutaAbsoluta)) {
                $rutaRelativa = mysqli_real_escape_string($this->con, $rutaRelativa);
                if (!empty($newname)) {
                    $consulta = "UPDATE usuario SET u_nombre='$newname', u_imagen = '$rutaRelativa' WHERE u_correo = '$correo'";
                } else {
                    $consulta = "UPDATE usuario SET u_imagen = '$rutaRelativa' WHERE u_correo = '$correo'";
                }
            } else {
                return false; // No se pudo mover la imagen
            }
        } else {
            $consulta = "UPDATE usuario SET u_nombre = '$newname' WHERE u_correo = '$correo'";
        }

        $result = mysqli_query($this->con, $consulta);

        return $result;
    }
}
