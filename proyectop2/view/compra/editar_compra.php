<!--autor: Garcia Alex-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        /* Estilo general del formulario */
        form {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Contenedor de los campos en dos columnas */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Estilo para los campos en columnas */
        .form-row .form-group {
            flex: 1 1 45%; /* Dos columnas, cada una ocupa el 45% del ancho */
            margin-bottom: 15px;
        }

        /* Estilo para los campos a 100% de ancho (cuando se necesitan ocupar toda la fila) */
        .form-row .form-group.full-width {
            flex: 1 1 100%;
        }

        /* Estilo para las etiquetas */
        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Estilo para los inputs y textarea */
        form input[type="text"],
        form input[type="datetime-local"],
        form input[type="date"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Estilo para el botón */
        form button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        /* Estilo para los mensajes de error */
        form .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
        }

        /* Estilo para los encabezados */
        h2 {
            text-align: center;
            color: #007bff;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>

<?php include 'dashboard.php'; ?>
    <h2>Editar Compra</h2>
    <form action="compra.php?c=compra&f=guardarEdicion" method="POST">
    <input type="hidden" name="compra_id" value="<?php echo $compra['compra_id']; ?>">
    <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($compra['usuario_id']); ?>">
    <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($compra['producto_id']); ?>" >

    <!-- Contenedor para los campos en dos columnas -->
    <div class="form-row">
        <div class="form-group">
            <label for="cedula">Cédula:</label>
            <input type="text" name="cedula" value="<?php echo htmlspecialchars($compra['cedula']); ?>" >
            <?php if (!empty($errores['cedula'])): ?>
                <p class="error"><?php echo $errores['cedula']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="tarjeta">Tarjeta:</label>
            <input type="text" name="tarjeta" value="<?php echo htmlspecialchars($compra['tarjeta']); ?>" >
            <?php if (!empty($errores['tarjeta'])): ?>
                <p class="error"><?php echo $errores['tarjeta']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Nueva fila para la validación del CVV, ciudad y país -->
    <div class="form-row">
        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" value="<?php echo htmlspecialchars($compra['cvv']); ?>" >
            <?php if (!empty($errores['cvv'])): ?>
                <p class="error"><?php echo $errores['cvv']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="ciudad">Ciudad:</label>
            <input type="text" name="ciudad" value="<?php echo htmlspecialchars($compra['ciudad']); ?>" >
            <?php if (!empty($errores['ciudad'])): ?>
                <p class="error"><?php echo $errores['ciudad']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Nueva fila para el país, fecha de compra y total -->
    <div class="form-row">
        <div class="form-group">
            <label for="pais">País:</label>
            <input type="text" name="pais" value="<?php echo htmlspecialchars($compra['pais']); ?>">
            <?php if (!empty($errores['pais'])): ?>
                <p class="error"><?php echo $errores['pais']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="fecha_compra">Fecha de Compra:</label>
            <input type="date" name="fecha_compra" value="<?php echo date('Y-m-d', strtotime($compra['fecha_compra'])); ?>">
            <?php if (!empty($errores['fecha_compra'])): ?>
                <p class="error"><?php echo $errores['fecha_compra']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="number" name="total" step="1" value="<?php echo htmlspecialchars($compra['total']); ?>" >
            <?php if (!empty($errores['total'])): ?>
                <p class="error"><?php echo $errores['total']; ?></p>
            <?php endif; ?>
        </div>
    </div>

    <button type="submit">Guardar Cambios</button>
</form>

</body>
</html>
<?php include 'footer.php'; ?>
