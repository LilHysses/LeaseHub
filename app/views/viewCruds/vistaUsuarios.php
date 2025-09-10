<?php
require_once("../../models/conexion.php");
require_once("../../models/modelUsuarios.php");
include("../partials/headerCrud.php");

// Conexión a la base de datos
$conexion = new Conexion();
$tabla = new TraerElementos($conexion->getConexion());
$tipousuario=new Usuarios($conexion->getConexion());

$idConsultado = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Mensajes de sesión
if (isset($_SESSION['msg'])) {
    echo "<script>alert('{$_SESSION['msg']}');</script>";
    unset($_SESSION['msg']);
}
?>
<div class="container-fluid row">
    <form class="col-4 p-3" action="../../controllers/controlUsuarios.php"  method="post">
        <h3 class="text-center">Usuarios</h3>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ID</label>
            <input type="number" class="form-control" name="id">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Apellido</label>
            <input type="text" class="form-control" name="apellido">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Correo</label>
            <input type="email" class="form-control" name="correo">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Contraseña</label>
            <input type="number" class="form-control" name="contraseña">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Dirección</label>
            <input type="text" class="form-control" name="direccion">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Teléfono</label>
            <input type="number" class="form-control" name="telefono">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Tipo usuario</label>
            <select class="form-control" name="tipousuario">
                <option>Seleccionar</option>
                <?php $tipousuario->UsuariosSelect($usuario); ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Descripción</label>
            <input type="text" class="form-control" name="descripcion">
        </div>
        <button type="submit" class="btn btn-primary" name="btnregistrar" value="ok">Registrar</button>
        <button type="submit" class="btn btn-secondary" name="btnconsultar">Buscar</button>
    </form>
    <div class="col-8 p-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Tipo de usuario</th>
                    <th scope="col">Descripción</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                    <?php $tabla->getTabla($idConsultado); ?>
                     
            </tbody>
        </table><br><br>
    </div>
</div>
<?php include("../partials/footerCrud.php");?>