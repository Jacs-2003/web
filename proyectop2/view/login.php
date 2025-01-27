<!--autor:Castro Agudo Ricardo-->
<?php session_start(); 
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <section class="form-container">
            <h2>Iniciar Sesión</h2>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <form action="../controller/UsuarioController.php" method="post">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
                <input type="password" name="clave" placeholder="Contraseña" required>
                <input type="hidden" name="action" value="login">
                <button type="submit">Entrar</button>
            </form>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
