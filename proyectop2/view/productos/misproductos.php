<!--autor: Contreras Suarez Jordan Alexis-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f4f4f9;
        }

        /* Botones alineados */
        .actions {
            display: flex; /* Usamos Flexbox */
            gap: 10px; /* Espacio entre los botones */
        }

        /* Botón Eliminar */
        .btn-delete {
            background-color: #e74c3c; /* Rojo */
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
        }

        .btn-delete:hover {
            background-color: #c0392b; /* Rojo más oscuro */
        }

        /* Botón Comprar */
        .btn-buy {
            background-color: #2ecc71; /* Verde */
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
        }

        .btn-buy:hover {
            background-color: #27ae60; /* Verde más oscuro */
        }
    </style>
</head>
<?php include 'dashboard.php'; ?>
<body>

<h2>Mis Productos en el Carrito</h2>

<?php if (!empty($productos)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre del Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['prod_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['prod_descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($producto['prod_precio']); ?>€</td>
                    <td>
                        <div class="actions">
                            <form action="carrito.php?f=eliminar" method="POST">
                                <input type="hidden" name="carrito_id" value="<?php echo $producto['carrito_id']; ?>">
                                <button type="submit" name="eliminar" class="btn-delete">Eliminar</button>
                            </form>
                            <form action="compra.php?f=formularioCompra" method="POST">
                                <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto['prod_id']); ?>">
                                <button type="submit" name="comprar" class="btn-buy">Comprar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No tienes productos en el carrito.</p>
<?php endif; ?>

<?php include 'footer.php'; ?>
</body>
</html>
