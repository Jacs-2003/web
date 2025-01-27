<!--autor:Castro Agudo Ricardo-->
<?php
session_start();
require_once '../config/Conexion.php';
require_once '../model/UsuarioDAO.php';
require_once '../model/RolDAO.php';

// Verificar si el usuario ha iniciado sesión y si tiene permisos de gerente
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'gerente') {
    header('Location: login.php');
    exit();
}

$dao = new UsuarioDAO(Conexion::getConexion());
$rolDao = new RolDAO($pdo);

// Obtener el ID del usuario desde el parámetro GET
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID de usuario no válido.");
}

// Obtener los datos del usuario y los roles disponibles
$usuario = $dao->obtenerUsuarioPorId($id);
$roles = $rolDao->listarRoles();

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
    gap: 12px;
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

/* Mensaje de error */
.error-message {
    margin-bottom: 15px;
    padding: 10px;
    background-color: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
    border-radius: 5px;
}

</style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Editar Usuario</h2>

        <!-- Mostrar mensajes de error si existen -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo $_SESSION['error']; ?>
                <?php unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo ?>
            </div>
        <?php endif; ?>

        <form action="../controller/UsuarioController.php" method="post" onsubmit="return validarFormulario();">
            <!-- ID oculto -->
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

            <!-- Nombre -->
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            
            <!-- Apellido -->
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
            
            <!-- Email -->
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            
            <!-- Teléfono -->
            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
            
            <!-- Edad -->
            <label for="edad">Edad:</label>
            <input type="number" name="edad" id="edad" value="<?php echo htmlspecialchars($usuario['edad']); ?>" required>
            
            <!-- Rol -->
            <label for="rol_id">Rol:</label>
            <select name="rol_id" id="rol_id" required>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['id']; ?>" <?php echo $usuario['rol_id'] == $rol['id'] ? 'selected' : ''; ?>>
                        <?php echo ucfirst($rol['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <!-- Contraseña -->
            <label for="clave">Contraseña (opcional):</label>
            <input type="password" name="clave" id="clave" placeholder="Dejar en blanco para no cambiar">

            <!-- Botón de guardar cambios -->
            <button type="submit" name="action" value="update">Guardar Cambios</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
    <script>
        function validarFormulario() {
            // Validación del cliente
            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const email = document.getElementById('email').value.trim();
            const edad = document.getElementById('edad').value.trim();
            const soloLetrasRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

            if (!nombre.match(soloLetrasRegex)) {
                alert('El nombre solo puede contener letras y espacios.');
                return false;
            }

            if (!apellido.match(soloLetrasRegex)) {
                alert('El apellido solo puede contener letras y espacios.');
                return false;
            }

            if (nombre.length > 50) {
                alert('El nombre no debe superar los 50 caracteres.');
                return false;
            }

            if (apellido.length > 50) {
                alert('El apellido no debe superar los 50 caracteres.');
                return false;
            }

            if (!email.includes('@')) {
                alert('Por favor, ingresa un correo electrónico válido.');
                return false;
            }

            if (isNaN(edad) || edad <= 0 || edad > 120) {
                alert('La edad debe ser un número válido entre 1 y 120.');
                return false;
            }
            if (!/^[0-9]{7,10}$/.test(telefono)) {
            alert('El número de teléfono debe tener entre 7 y 10 dígitos.');
            return false;
        }

            return true; // Formulario válido
        }
    </script>
</body>
</html>
