<!--autor:Castro Agudo Ricardo-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
    <section class="form-container">
    <h2>Registrarse</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="error-message"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="success-message"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <form action="../controller/UsuarioController.php" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="tel" name="telefono" placeholder="Teléfono (10 dígitos)" required>
        <input type="number" name="edad" placeholder="Edad" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <input type="hidden" name="rol_id" value="3"> <!-- Rol cliente por defecto -->
        <input type="hidden" name="action" value="registercliente">
        <button type="submit">Registrarse</button>
    </form>
    </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
