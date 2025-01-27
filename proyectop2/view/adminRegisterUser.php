<!--autor:Castro Agudo Ricardo-->
<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'gerente') {
    header('Location: login.php');
    exit();
}

require_once '../model/RolDAO.php';
require_once '../config/Conexion.php';

$rolDao = new RolDAO(Conexion::getConexion());
$roles = $rolDao->listarRoles();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Usuario</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* General */
        form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Estilo para etiquetas y campos de entrada */
form label {
    font-size: 1rem;
    color: #333;
    font-weight: bold;
    margin-bottom: 5px;
}

form input, form select, form button {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

/* Botón de guardar cambios */
form button {
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #0056b3;
}
        /* Mensajes de Error */
        .alert {
            margin: 20px auto;
            padding: 15px;
            width: 90%;
            max-width: 600px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

 
    </style>

    <script>
    // Validación en el cliente
    function validarFormulario() {
        const nombre = document.querySelector('[name="nombre"]').value.trim();
        const apellido = document.querySelector('[name="apellido"]').value.trim();
        const email = document.querySelector('[name="email"]').value.trim();
        const telefono = document.querySelector('[name="telefono"]').value.trim();
        const edad = document.querySelector('[name="edad"]').value.trim();
        const clave = document.querySelector('[name="clave"]').value.trim();

        const soloLetrasRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (!nombre.match(soloLetrasRegex)) {
            alert('El nombre solo puede contener letras y espacios.');
            return false;
        }
        if (!apellido.match(soloLetrasRegex)) {
            alert('El apellido solo puede contener letras y espacios.');
            return false;
        }
        if (nombre.length > 50 || apellido.length > 50) {
            alert('El nombre y apellido no pueden superar los 50 caracteres.');
            return false;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert('Por favor, ingresa un correo electrónico válido.');
            return false;
        }
        if (!/^[0-9]{7,10}$/.test(telefono)) {
            alert('El número de teléfono debe tener entre 7 y 10 dígitos.');
            return false;
        }
        if (isNaN(edad) || edad <= 0 || edad > 120) {
            alert('La edad debe ser un número válido entre 1 y 120.');
            return false;
        }
        if (clave.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres.');
            return false;
        }
        return true;
    }
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Registrar Nuevo Usuario</h2>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <form action="../controller/UsuarioController.php" method="post" class="register-form" onsubmit="return validarFormulario()">
             <label for="Nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <label for="Apellido">Apellido:</label>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" placeholder="Teléfono">
            <label for="edad">Edad:</label>
            <input type="number" name="edad" placeholder="Edad" required>
            <label for="rol_id">Rol:</label>
            <select name="rol_id" required>
                <option value="" disabled selected>Selecciona un Rol</option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['id']; ?>"><?php echo ucfirst($rol['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="clave">Contraseña (opcional):</label>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <input type="hidden" name="action" value="register">
            <button type="submit">Registrar</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
