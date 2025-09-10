<?php

class tipoPago{

    private $con;

    public function __construct($conexion)
    {
        $this->con = $conexion;
    }

    //Fucion Consultar id de tipo de pago cuando se le de al boton de Editar/Actualizar
    public function consultarTipoPago($idtipopago){
        $consulta = "SELECT * FROM tipo_de_pago WHERE tp_id = $idtipopago";
        $resultado = mysqli_query($this->con, $consulta);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }
    //Funcion para saber si hay un tipo de pago ya existente con el el id que se ingresara..
    public function consultarIdTipoPago($idtipopago){
        
        $consulta="SELECT COUNT(*) as count FROM tipo_de_pago WHERE tp_id=$idtipopago";
        $resultado=mysqli_query($this->con, $consulta);

        $fila=mysqli_fetch_assoc($resultado);
        return $fila['count'] > 0;
    }
    
    //Guardar Tipo de Pago.
    public function registrarTipoPago($idtipopago, $nombretipopago){

        $sql="INSERT INTO tipo_de_pago(tp_id,tp_pago)VALUES($idtipopago,'$nombretipopago')";
        $resultado=mysqli_query($this->con, $sql);

        return $resultado;
    }
    
    //Funcion para saber si hay algun inmueble con este tipo de pago.
    public function consultarTipoPago2($idtipopago){

        $consulta = "SELECT COUNT(*) as count FROM inmueble WHERE tp_id = $idtipopago";
        $resultado = mysqli_query($this->con, $consulta);

        $row = mysqli_fetch_assoc($resultado);
        return $row['count'] > 0;
    }

    //Funcion para eliminar el tipo de pago.
    public function eliminarTipoPago($idtipopago){
        
        $sql = "DELETE FROM tipo_de_pago WHERE tp_id = $idtipopago";
        $resultado = mysqli_query($this->con, $sql);

        return $resultado;
    }
    public function actualizarTipoPago($idtipopago, $nombretipopago){

        $sql="UPDATE tipo_de_pago SET tp_id=$idtipopago,tp_pago='$nombretipopago' WHERE tp_id=$idtipopago";
        $resultado=mysqli_query($this->con, $sql);
        
        if ($resultado) {
            $consulta = "SELECT * FROM tipo_de_pago WHERE tp_id=$idtipopago";
            $result = mysqli_query($this->con, $consulta);

            if ($result && mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result);
            }
        }
        return null;
    }
}


class ModelTipoPago { 

    private $con;

    public function __construct($conexion) {
        $this->con = $conexion;
    }

    public function getTabla(){
        $sql = "SELECT * FROM tipo_de_pago";
        $result = mysqli_query($this->con, $sql);

        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='11'>No se encontraron Tipos de Pagos</td></tr>";
            return;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['tp_id']}</td>
                    <td>{$row['tp_pago']}</td>
                    <td>
                        <a href='../../views/viewEditarCruds/editarTipoPago.php?id=" . $row['tp_id'] . "' class='btn btn-warning'>
                            <i class='fa-solid fa-pen-to-square'></i> 
                        </a>
                        <a onclick='return confirmarEliminar({$row['tp_id']})' href='../../controllers/controlTipoPago.php?eliminar=1&id={$row['tp_id']}' class='btn btn-small btn-danger'>
                            <i class='fa-solid fa-trash'></i>
                        </a>
                    </td>
                </tr>";
        }
    }
}   
?>