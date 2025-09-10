<?php

class Usuarios
{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    public function VerificarUsuario($id)
    {

        $consulta = "SELECT COUNT(*) FROM usuario WHERE u_id='$id'";
        $resultado = mysqli_query($this->con, $consulta);
        $array = mysqli_fetch_array($resultado)[0];

        return $array;
    }

    public function RegistroUsuario($id, $nombres, $apellidos, $correo, $contraseña, $direccion, $telefono, $tipousuario, $descripcion)
    {

        $consulta = "INSERT INTO usuario (u_id, u_nombre, u_apellido, u_correo, u_contraseña, u_direccion, u_telefono,tu_id,u_descripcion)
         VALUES ($id, '$nombres', '$apellidos', '$correo', '$contraseña', '$direccion', '$telefono',$tipousuario,'$descripcion')";
        $result = mysqli_query($this->con, $consulta);

        return $result;
    }

    public function ConsultarUsuarios($id){
        $consulta="SELECT * FROM usuario WHERE u_id = $id";
        $result=mysqli_query($this->con,$consulta);
        if($result && mysqli_num_rows($result) > 0){
            return mysqli_fetch_assoc($result);
        }
        return null;
    }

    public function actualizarUsuario($idusuario,$nombre,$apellido,$correo,$contraseña,$direccion,$telefono,$tipousuario,$descripcion){
        $sql="UPDATE usuario SET
         u_id=$idusuario,
         u_nombre='$nombre',
         u_apellido='$apellido',
         u_correo='$correo',
         u_contraseña='$contraseña',
         u_direccion='$direccion',
         u_telefono=$telefono,
         tu_id=$tipousuario,
         u_descripcion='$descripcion'
         WHERE u_id=$idusuario";

        $actualizado=mysqli_query($this->con,$sql);

        if($actualizado){
            $consulta="SELECT * FROM usuario WHERE u_id='$idusuario'";
            $result=mysqli_query($this->con,$consulta);

            if($result && mysqli_num_rows($result)>0){
                return mysqli_fetch_assoc($result);
            }
        }
        return null;
    }

    public function eliminarUsuarios($idusuario){
        $sql="DELETE FROM usuario WHERE u_id='$idusuario'";
        $result=mysqli_query($this->con,$sql);

        return ($result && mysqli_affected_rows($this->con)> 0);
    }

    public function UsuariosSelect($tipousuario)
    {

        $consulta = "SELECT tu_id, tu_nombre FROM tipo_de_usuario";
        $result = mysqli_query($this->con, $consulta);

        if ($result->num_rows > 0) {

            while ($fila = $result->fetch_assoc()) {
                $selected = ($fila['tu_id'] == $tipousuario) ? 'selected' : '';
                echo "<option value='" . $fila['tu_id'] . "' $selected>" . $fila['tu_nombre'] . "</option>";
            }
        } else {
            echo "<option value=''>No seleccionaste ningun tipo de usuario</option>";
        }
    }

       //funciones para tipo de usuario 

       public function RegistrarTipoUsuario($id, $nombre)
       {
           $sql = "INSERT INTO tipo_de_usuario (tu_id,tu_nombre) VALUES ($id,'$nombre')";
           $result = mysqli_query($this->con, $sql);
   
           return $result;
       }
   
       public function consultarTipoUsuario($id)
       {
           $sql = "SELECT * FROM tipo_de_usuario WHERE tu_id = '$id'";
           $result = mysqli_query($this->con, $sql);
   
           if ($result && mysqli_num_rows($result) > 0) {
               return mysqli_fetch_assoc($result);
           }
           return null;
       }
   
       public function actualizarTipoUsuario($id, $nombre)
       {
           $sql = "UPDATE tipo_de_usuario SET
                tu_nombre='$nombre'
                WHERE tu_id=$id";
   
           $actualizado = mysqli_query($this->con, $sql);
   
           if ($actualizado) {
               $consulta = "SELECT * FROM tipo_de_usuario WHERE tu_id='$id'";
               $result = mysqli_query($this->con, $consulta);
   
               if ($result && mysqli_num_rows($result) > 0) {
                   return mysqli_fetch_assoc($result);
               }
           }
           return null;
       }
   
       public function eliminarTipoUsuario($id)
       {
           $sql = "DELETE FROM tipo_de_usuario WHERE tu_id=$id";
           $result = mysqli_query($this->con, $sql);
   
           return ($result && mysqli_affected_rows($this->con) > 0);
       }
   
       public function VerificarTipoUsuario($id)
       {
   
           $consulta = "SELECT COUNT(*) FROM tipo_de_usuario WHERE tu_id='$id'";
           $resultado = mysqli_query($this->con, $consulta);
           $array = mysqli_fetch_array($resultado)[0];
   
           return $array;
       }
   
       public function VerificarTipoUsuarioConUsuarios($idtipousuario){
           $sql = "SELECT COUNT(*) as count FROM usuario WHERE tu_id = $idtipousuario";
           $result=mysqli_query($this->con,$sql);
           $fila=mysqli_fetch_assoc($result);
   
           return $fila;
           
       }

}

class TraerElementos { 
    private $con;

    public function __construct($conexion) {
        $this->con = $conexion;
    }

    public function getTabla($id = null) {
        // Si se proporciona un ID, se filtra por él
        if ($id) {
            $consulta = "SELECT * FROM usuario WHERE u_id = $id";
            $result = mysqli_query($this->con, $consulta);
        } else {
            // Si no hay ID, traer todos los inmuebles
            $consulta = "SELECT * FROM usuario";
            $result = mysqli_query($this->con, $consulta);
        }

        // Si no hay resultados, mostrar un mensaje en la tabla
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron inmuebles</td></tr>";
            return;
        }

        // Mostrar los resultados en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['u_id']}</td>
                    <td>{$row['u_nombre']}</td>
                    <td>{$row['u_apellido']}</td>
                    <td>{$row['u_correo']}</td>
                    <td>{$row['u_contraseña']}</td>
                    <td>{$row['u_direccion']}</td>
                    <td>{$row['u_telefono']}</td>
                    <td>{$row['tu_id']}</td>
                    <td>{$row['u_descripcion']}</td>
                    <td>
                  <a href='../../views/viewEditarCruds/editarUsuarios.php?id=" . $row['u_id'] . "' class='btn btn-warning'>
                    <i class='fa-solid fa-pen-to-square'></i> 
                 </a>
                   <a onclick='return confirmarEliminar({$row['u_id']})' href='../../controllers/controlUsuarios.php?eliminar=1&id={$row['u_id']}' class='btn btn-small btn-danger'>
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
            $sql = "SELECT * FROM tipo_de_usuario WHERE tu_id = $id";
            $result = mysqli_query($this->con, $sql);
        } else {
            // Si no hay ID, traer todos los inmuebles
            $sql = "SELECT * FROM tipo_de_usuario";
            $result = mysqli_query($this->con, $sql);
        }

        // Si no hay resultados, mostrar un mensaje en la tabla
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron los tipos de usuario</td></tr>";
            return;
        }

        // Mostrar los resultados en la tabla
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['tu_id']}</td>
                    <td>{$row['tu_nombre']}</td>
                    <td>
                  <a href='../../views/viewEditarCruds/editarTipoUsuario.php?id=" . $row['tu_id'] . "' class='btn btn-warning'>
                    <i class='fa-solid fa-pen-to-square'></i> 
                 </a>
                   <a onclick='return confirmarEliminar({$row['tu_id']})' href='../../controllers/controlUsuarios.php?btneliminar=1&id={$row['tu_id']}' class='btn btn-small btn-danger'>
                      <i class='fa-solid fa-trash'></i>
                   </a>
                    </td>
                </tr>";
        }
    }
}
