<!--autor: Contreras Suarez Jordan Alexis-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto</title>
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

        /* Estilo para las etiquetas */
        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Estilo para los inputs y textarea */
        form input[type="text"], form input[type="number"], form textarea, form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Estilo para los botones */
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
        h1 {
            text-align: center;
            color: #007bff;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
<?php include 'dashboard.php'; ?>
    <h1>Registrar un Nuevo Producto</h1>
    <form action="productos.php?c=productos&f=new" method="post">

        <!-- Contenedor para los campos en dos columnas -->
        <div class="form-row">

            <!-- Nombre del Producto -->
            <div class="form-group">
                <label for="prod_nombre">Nombre del Producto:</label>
                <input type="text" id="prod_nombre" name="prod_nombre" value="<?php echo htmlspecialchars($_POST['prod_nombre'] ?? ''); ?>">
                <?php if (!empty($errores['prod_nombre'])): ?>
                    <p class="error"><?php echo $errores['prod_nombre']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Precio -->
            <div class="form-group">
                <label for="prod_precio">Precio:</label>
                <input type="number" id="prod_precio" name="prod_precio" step="0.01" value="<?php echo htmlspecialchars($_POST['prod_precio'] ?? ''); ?>">
                <?php if (!empty($errores['prod_precio'])): ?>
                    <p class="error"><?php echo $errores['prod_precio']; ?></p>
                <?php endif; ?>
            </div>

        </div>

        <!-- Contenedor para los siguientes campos en dos columnas -->
        <div class="form-row">

            <!-- Descripción -->
            <div class="form-group" style="flex: 1 1 100%;">
                <label for="prod_descripcion">Descripción:</label>
                <textarea id="prod_descripcion" name="prod_descripcion" rows="4"><?php echo htmlspecialchars($_POST['prod_descripcion'] ?? ''); ?></textarea>
                <?php if (!empty($errores['prod_descripcion'])): ?>
                    <p class="error"><?php echo $errores['prod_descripcion']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Stock -->
            <div class="form-group">
                <label for="prod_stock">Cantidad en Stock:</label>
                <input type="number" id="prod_stock" name="prod_stock" value="<?php echo htmlspecialchars($_POST['prod_stock'] ?? ''); ?>">
                <?php if (!empty($errores['prod_stock'])): ?>
                    <p class="error"><?php echo $errores['prod_stock']; ?></p>
                <?php endif; ?>
            </div>

        </div>

        <!-- Contenedor para los últimos campos en dos columnas -->
        <div class="form-row">

          
            <!-- Categoría -->
            <div class="form-group" style="flex: 1 1 100%;">
                <label for="prod_categoria">Categoría:</label>
                <select id="prod_categoria" name="prod_categoria">
                    <option value="">Seleccione una categoría</option>
                    <option value="Globos" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Globos') ? 'selected' : ''; ?>>Globos</option>
                    <option value="Serpentinas" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Serpentinas') ? 'selected' : ''; ?>>Serpentinas</option>
                    <option value="Ropa para Fiesta" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Ropa para Fiesta') ? 'selected' : ''; ?>>Ropa para Fiesta</option>
                    <option value="Decoraciones" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Decoraciones') ? 'selected' : ''; ?>>Decoraciones</option>
                    <option value="Accesorios" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Accesorios') ? 'selected' : ''; ?>>Accesorios</option>
                    <option value="Comida para Fiestas" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Comida para Fiestas') ? 'selected' : ''; ?>>Comida para Fiestas</option>
                </select>
                <?php if (!empty($errores['prod_categoria'])): ?>
                    <p class="error"><?php echo $errores['prod_categoria']; ?></p>
                <?php endif; ?>
            </div>

        </div>

        <button type="submit">Guardar Cambios</button>
    </form>

</body>
</html>
<?php include 'footer.php'; ?>
