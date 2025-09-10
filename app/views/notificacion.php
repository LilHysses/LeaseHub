<?php
ob_start(); // evitar que se envíe salida antes de header()
include('./partials/header.php');
include("../models/modelNotificacion.php");


$correo=$_SESSION['correo'];

$conexion = new Conexion();
$notificacion = new ModelNotificacion($conexion->getConexion());

?>

  <link rel="stylesheet" href="../../public/css/notificaciones.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
<h2 class="titleNoti">NOTIFICACIONES</h2>

<section class="boxNoti">
    <div class="notifi">

        <?php if ($notificacion->getResultComentarios()->num_rows > 0): ?>
          <?php while ($row = $notificacion->getResultComentarios()->fetch_assoc()): ?>
            <div class="notifi1">
                <span class="menn">¡Tienes nuevos comentarios en tu inmueble!</span>
                <ul>
                  <li>
                    <a href="../views/compra.php?id=<?= $row['in_id'] ?>" class="enlace-reserva">
                      Ver reserva en <strong><?= htmlspecialchars($row['in_titulo']) ?></strong>
                    </a>
                  </li>
                </ul> 
                <form method="POST">
                  <input type="hidden" name="cerrar_comentario_id" value="<?= $row['c_id'] ?>">
                  <button type="submit" name="cerrar_comentario" class="closebtn">X</button>
                </form>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if ($notificacion->getResultReservas()->num_rows > 0): ?>
          <?php while ($row = $notificacion->getResultReservas()->fetch_assoc()): ?>
            <?php if ($row['r_estado'] === 'Cancelado'): ?>
              <div class="notifi1">
                <span class="menn">¡Tu cita ha sido cancelada!</span>
                <ul>
                  <li>
                    Ver motivo de cancelación en 
                    <strong>
                      <button type="button" class="changeN" data-bs-toggle="modal" data-bs-target="#modalMotivo<?= $row['r_id'] ?>">
                        <?= htmlspecialchars($row['in_titulo']) ?>
                      </button>
                    </strong>
            
                    <!-- Modal con el motivo de la cancelación -->
                    <div class="modal fade" id="modalMotivo<?= $row['r_id'] ?>" tabindex="-1" aria-labelledby="modalMotivoLabel<?= $row['r_id'] ?>" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content act-1">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalMotivoLabel<?= $row['r_id'] ?>">Motivo de la Cancelación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                          </div>
                          <div class="modal-body">
                            <p><?= !empty($row['r_motivo']) ? htmlspecialchars($row['r_motivo']) : 'Sin motivo registrado.' ?></p>
                            <div class="text-end">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <form method="POST">
                  <input type="hidden" name="cerrar_reserva_id" value="<?= $row['r_id'] ?>">
                  <button type="submit" name="cerrar_reserva" class="closebtn">X</button>
                </form>
              </div>
            
            <?php elseif ($row['r_estado'] === 'Aceptado'): ?>
              <div class="notifi1">
                <span class="menn">¡Tu cita ha sido aceptada!</span>
                <ul>
                  <li>
                    Ver cita en <strong><?= htmlspecialchars($row['in_titulo']) ?></strong>
                  </li>
                </ul>
                <form method="POST">
                  <input type="hidden" name="cerrar_reserva_id" value="<?= $row['r_id'] ?>">
                  <button type="submit" name="cerrar_reserva" class="closebtn">X</button>
                </form>
              </div>
            <?php endif; ?>
          <?php endwhile; ?>
        <?php endif; ?>


        <?php if ($notificacion->getResultPendientes()->num_rows > 0): ?>
          <?php while ($row = $notificacion->getResultPendientes()->fetch_assoc()): ?>
            <div class="notifi1">
              <span class="menn">¡Tienes una nueva cita en tu inmueble</span>
                <ul>
                  <li>
                    <a href="./viewEditarCruds/editarReserva.php?id=<?= $row['r_id'] ?>" class="enlace-reserva">
                      Ver cita en <strong><?= htmlspecialchars($row['in_titulo']) ?></strong>
                    </a>
                  </li>
                </ul> 
            </div>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php if ($notificacion->hayNoNotificaciones()): ?>
            <div class="no-noti">
            No hay notificaciones para mostrar.
            </div>
        <?php endif; ?>

    </div>
</section>
<aside class="carousel-aside"id="publicidad1"> <!-- Aside derecho -Carrusel de inmuebles cerca de tu ubicacion-->
  <center>
    <h5>CERCA DE TU UBICACIÓN</h5>
  </center>
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="/public/img/ubic1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="/public/img/ubic2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="/public/img/ubic3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div><br><br>
  <center>
    <h5>ESPACIO PUBLICITARIO</h5>
  </center> <!--Carrusel de Publicidad-->
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <a href="https://www.coca-cola.com/co/es"><img src="/public/img/public1.jpg" class="d-block w-100" alt="..."></a>
      </div>
      <div class="carousel-item">
        <a href="https://www.pepsi.com/"><img src="/public/img/public2.jpg" class="d-block w-100" alt="..."></a>
      </div>
      <div class="carousel-item">
        <a href="https://www.postobon.com/"><img src="/public/img/public3.jpg" class="d-block w-100" alt="..."></a>
      </div>
    </div>
  </div>
</aside>
<br><br><br>
<br><br><br>
<br><br><br>
<?php include('./partials/footer.php'); ?>
