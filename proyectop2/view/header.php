<!--autor:Castro Agudo Ricardo-->
<header class="header">
    <nav class="navbar">
        <!-- Logo -->
        <div class="logo">
            <a href="index.php">Marketplace de Fiestas Infantiles</a>
        </div>


        <!-- Menú -->
        <ul class="menu">
            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><a href="../controller/UsuarioController.php?action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a></li>
                <li><a href="register.php"><i class="fas fa-user-plus"></i> Registrarse</a></li>
            <?php endif; ?>
        </ul>

        <!-- Menú desplegable (responsive) -->
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
    </nav>
</header>
