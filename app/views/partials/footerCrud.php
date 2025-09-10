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



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="/public/js/mensajes.js"></script>

</body>
</html>