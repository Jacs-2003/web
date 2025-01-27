<!--autor:Castro Agudo Ricardo-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$_SESSION['usuario_id'] = $usuario['id'];
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* General */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    color: #333;
}

/* Header y Footer */
header, footer {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 20px;
}

header a, footer a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

header a:hover, footer a:hover {
    text-decoration: underline;
}

/* Main */
main {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Títulos y Textos */
h2 {
    font-size: 24px;
    color: #007bff;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    margin: 10px 0;
}

/* Dashboard Links */
.dashboard-links {
    display: flex;
    justify-content: space-between; /* Distribuye el espacio de manera equitativa */
    gap: 15px;
    margin: 20px 0;
    flex-wrap: nowrap; /* Asegura que los elementos no se acomoden en varias líneas */
}

.dashboard-links a {
    display: inline-block;
    width: 16%; /* Ajusta este valor según lo que necesites; ahora están más largos pero sin que salten */
    padding: 15px 20px;
    background: #007bff;
    color: white;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dashboard-links a:hover {
    background: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}


/* Para pantallas pequeñas, ajustar el tamaño */
@media (max-width: 768px) {
    .dashboard-links a {
        width: calc(100% - 10px); /* Se apilan en pantallas más pequeñas */
    }
}


    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h2>Bienvenido, <?php echo $usuario['nombre']; ?></h2>
        <p>Rol: <strong><?php echo ucfirst($usuario['rol']); ?></strong></p>
        <div class="dashboard-links">
            <?php if ($usuario['rol'] === 'gerente'): ?>
                <a href="usuarios.php">Gestión de Usuarios</aa>
                <a href="productos.php?c=productos&f=index">Gestión de Productos</a>

                <a href="proveedores.php">Gestión de Proveedores</a>
                <a href="compra.php?c=compra&f=listarCompras">Compras</a>
            <?php elseif ($usuario['rol'] === 'empleado'): ?>
                <a href="productos.php?c=productos&f=index">Gestión de Productos</a>

                <a href="compra.php?c=compra&f=listarCompras">Compras</a>
            <?php elseif ($usuario['rol'] === 'cliente'): ?>
                <a href="productos.php?c=productos&f=listarParaClientes">Ver Productos</a>
   
                <a href="carrito.php?c=productos&f=misProductos">Compras</a>
            <?php endif; ?>
        </div>
    </main>
    <?php
// Verifica si no estás en productos u otras páginas específicas para incluir el footer
$currentPage = basename($_SERVER['PHP_SELF']);
$excludedPages = ['productos.php', 'carrito.php', 'compra.php']; // Agrega aquí los nombres de las páginas

if (!in_array($currentPage, $excludedPages)) {
    include 'footer.php';
}
?>
</body>
</html>
