<!--autor: Garcia Alex-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Compras</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#buscarCedula').on('input', function() {
                var cedula = $(this).val();

                $.ajax({
                    url: 'compra.php?c=compra&f=search',
                    method: 'GET',
                    data: { cedula: cedula },
                    success: function(response) {
                        $('#resultados tbody').html(response);
                    }
                });
            });
        });
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar esta compra?');
        }
    </script>
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

        .btn-delete {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }
        .btn-edit {
            background-color: green;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-edit:hover {
            background-color: green;
        }
    </style>
</head>
<body>
<?php include 'dashboard.php'; ?>
    <h2>Lista de Compras</h2>

    <input type="text" id="buscarCedula" placeholder="Buscar por cédula">
    <div id="resultados">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Cédula</th>
                    <th>Ciudad</th>
                    <th>País</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($compras)): ?>
                    <?php foreach ($compras as $compra): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($compra['id']); ?></td>
                            <td><?php echo htmlspecialchars($compra['usuario']); ?></td>
                            <td><?php echo htmlspecialchars($compra['producto']); ?></td>
                            <td><?php echo htmlspecialchars($compra['cedula']); ?></td>
                            <td><?php echo htmlspecialchars($compra['ciudad']); ?></td>
                            <td><?php echo htmlspecialchars($compra['pais']); ?></td>
                            <td><?php echo htmlspecialchars($compra['fecha_compra']); ?></td>
                            <td><?php echo htmlspecialchars($compra['total']); ?></td>
                            <td>
                            <a href="compra.php?c=compra&f=eliminarCompra&id=<?php echo htmlspecialchars($compra['id']); ?>"
                            class="btn-delete" onclick="return confirmarEliminacion();">Eliminar</a>
                                <a href="compra.php?c=compra&f=editarCompra&id=<?php echo $compra['id']; ?>"class="btn-edit">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9">No se encontraron compras</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>
<?php include 'footer.php'; ?>

