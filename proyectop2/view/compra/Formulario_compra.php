<!--autor: Garcia Alex-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
    <style>
        /* Estilo general del formulario */
        form {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #007bff; /* Contorno azul */
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para los campos de entrada */
        form input[type="text"], form input[type="number"], form textarea, form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        /* Estilo para las etiquetas */
        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
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

        /* Contenedor de campos en columna */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1 1 45%; /* Dos columnas, cada una ocupa el 45% del ancho */
            margin-bottom: 15px;
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
    <div>
        <h2>Formulario de Compra</h2>
        <form action="compra.php?f=realizarCompra" method="POST">
            <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($_POST['usuario_id'] ?? $usuario_id); ?>">
            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($_POST['producto_id'] ?? $producto_id); ?>">

            <!-- Cédula -->
            <div class="form-group">
                <label for="cedula">Cédula:</label>
                <input type="text" id="cedula" name="cedula" value="<?php echo htmlspecialchars($_POST['cedula'] ?? ''); ?>">
                <?php if (!empty($errores['cedula'])): ?>
                    <p class="error"><?php echo $errores['cedula']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Tarjeta -->
            <div class="form-group">
                <label for="tarjeta">Número de Tarjeta:</label>
                <input type="text" id="tarjeta" name="tarjeta" value="<?php echo htmlspecialchars($_POST['tarjeta'] ?? ''); ?>">
                <?php if (!empty($errores['tarjeta'])): ?>
                    <p class="error"><?php echo $errores['tarjeta']; ?></p>
                <?php endif; ?>
            </div>

            <!-- CVV -->
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" value="<?php echo htmlspecialchars($_POST['cvv'] ?? ''); ?>">
                <?php if (!empty($errores['cvv'])): ?>
                    <p class="error"><?php echo $errores['cvv']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Ciudad -->
            <div class="form-group">
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" value="<?php echo htmlspecialchars($_POST['ciudad'] ?? ''); ?>">
                <?php if (!empty($errores['ciudad'])): ?>
                    <p class="error"><?php echo $errores['ciudad']; ?></p>
                <?php endif; ?>
            </div>

            <!-- País -->
            <div class="form-group">
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($_POST['pais'] ?? ''); ?>">
                <?php if (!empty($errores['pais'])): ?>
                    <p class="error"><?php echo $errores['pais']; ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">Realizar Compra</button>
        </form>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>
