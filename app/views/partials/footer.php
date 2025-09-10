<footer>
    <div class="footer-container">
        <!-- Logo o Nombre de la marca -->
        <div class="footer-logo">
            <h3>LeaseHub</h3>
        </div>

        <!-- Información de contacto -->
        <div class="footer-contact">
            <p class="email">Email: <a href="mailto:contacto@leasehub.com">contacto@leasehub.com</a></p>
            <p>Tel: +123 456 7890</p>
        </div>

        <!-- Redes sociales -->
        <div class="footer-social">
            <a href="https://facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom">
        <p>&copy; 2024 LeaseHub. Todos los derechos reservados.</p>
    </div>
</footer>
  <!--Importacion de la biblioteca de Jquery-->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/public/js/jquery.hislide.js"></script>
  <!--Animacion del carrusel principal con sus funciones-->
  <script>
    $('.slide').hiSlide();
  </script>
  

  <?php if (isset($_SESSION['alerta'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION['alerta']['tipo'] ?>',
            title: '<?= $_SESSION['alerta']['titulo'] ?>',
            text: '<?= $_SESSION['alerta']['mensaje'] ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>

  <script src="/public/js/funciones.js"></script>
  <script src="/public/js/main.js"></script>
  <script src="/public/js/tutorial.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.css"/>
</body>
</html>
