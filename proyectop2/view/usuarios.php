<!--autor:Castro Agudo Ricardo-->
<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'gerente') {
    header('Location: login.php');
    exit();
}
require_once '../model/UsuarioDAO.php';
require_once '../config/Conexion.php';

$dao = new UsuarioDAO(Conexion::getConexion());
$usuarios = $dao->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* Estilo adicional para los mensajes */
        .alert {
            padding: 15px;
            margin: 20px auto;
            width: 90%;
            max-width: 600px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
            opacity: 1;
            transition: opacity 0.5s ease; /* Suavizado del desvanecimiento */
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Gestión de Usuarios</h2>
        
        <!-- Mostrar mensajes de notificación -->
         <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?php echo $_SESSION['color']; ?>">
                <?php echo $_SESSION['mensaje']; ?>
            </div>
            <?php unset($_SESSION['mensaje'], $_SESSION['color']); ?>
        <?php endif; ?>
        
        <a href="AdminRegisterUser.php" class="btn">Registrar Nuevo Usuario</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><?php echo $u['nombre']; ?></td>
                        <td><?php echo $u['apellido']; ?></td>
                        <td><?php echo $u['email']; ?></td>
                        <td><?php echo $u['rol']; ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $u['id']; ?>">Editar</a>
                            <form action="../controller/UsuarioController.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                <button type="submit" name="action" value="delete">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
      <!-- JavaScript para ocultar el mensaje después de 3 segundos -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const mensaje = document.getElementById('mensaje');
            if (mensaje) {
                setTimeout(function() {
                    mensaje.style.opacity = '0'; // Aplicar desvanecimiento
                    setTimeout(() => mensaje.remove(), 500); // Eliminar después del desvanecimiento
                }, 3000); // Esperar 3 segundos antes de iniciar
            }
        });
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
