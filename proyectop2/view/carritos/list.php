<!--autor: Contreras Suarez Jordan Alexis-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Carritos</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Ruta de tu CSS -->
</head>
<body>
    <h1>Lista de Carritos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario ID</th>
                <th>Producto ID</th>
                <th>Nombre del Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Fecha Agregado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carritos as $carrito): ?>
                <tr>
                    <td><?= htmlspecialchars($carrito['carrito_id']) ?></td>
                    <td><?= htmlspecialchars($carrito['usuario_id']) ?></td>
                    <td><?= htmlspecialchars($carrito['prod_id']) ?></td>
                    <td><?= htmlspecialchars($carrito['prod_nombre']) ?></td>
                    <td><?= htmlspecialchars($carrito['prod_descripcion']) ?></td>
                    <td><?= htmlspecialchars($carrito['prod_precio']) ?></td>
                    <td><?= htmlspecialchars($carrito['fecha_agregado']) ?></td>
                    <td>
                        <a href="carrito.php?c=carrito&f=edit&id=<?= $carrito['carrito_id'] ?>">Editar</a>
                        <a href="carrito.php?c=carrito&f=delete&id=<?= $carrito['carrito_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este carrito?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
