<!DOCTYPE html>
<html lang="en">
<head>
    <!--autor:Alvaro Cobo Abril-->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Proveedor</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
<?php include 'dashboard.php'; ?>
    <h1>Registrar un Nuevo Proveedor</h1>
    <form action="proveedores.php?c=proveedores&f=guardarProveedor" method="post">
        <div class="form-row">
            <div class="form-group">
                <label for="nomPro">Nombre del Proveedor:</label>
                <input type="text" id="nomPro" name="nomPro" value="<?php echo htmlspecialchars($_POST['nomPro'] ?? ''); ?>">
                <?php if (!empty($errores['nomPro'])): ?>
                    <p class="error"><?php echo $errores['nomPro']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="apellidoPro">Apellido del Proveedor:</label>
                <input type="text" id="apellidoPro" name="apellidoPro" value="<?php echo htmlspecialchars($_POST['apellidoPro'] ?? ''); ?>">
                <?php if (!empty($errores['apellidoPro'])): ?>
                    <p class="error"><?php echo $errores['apellidoPro']; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="correoPro">Correo Electrónico:</label>
                <input type="email" id="correoPro" name="correoPro" value="<?php echo htmlspecialchars($_POST['correoPro'] ?? ''); ?>">
                <?php if (!empty($errores['correoPro'])): ?>
                    <p class="error"><?php echo $errores['correoPro']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="telefonoPro">Teléfono:</label>
                <input type="tel" id="telefonoPro" name="telefonoPro" value="<?php echo htmlspecialchars($_POST['telefonoPro'] ?? ''); ?>">
                <?php if (!empty($errores['telefonoPro'])): ?>
                    <p class="error"><?php echo $errores['telefonoPro']; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="nomCalle1">Direccion de la calle #1:</label>
                <input type="text" id="nomCalle1" name="nomCalle1" value="<?php echo htmlspecialchars($_POST['nomCalle1'] ?? ''); ?>">
                <?php if (!empty($errores['nomCalle1'])): ?>
                    <p class="error"><?php echo $errores['nomCalle1']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="nomCalle2">Direccion de la calle #2:</label>
                <input type="text" id="nomCalle2" name="nomCalle2" value="<?php echo htmlspecialchars($_POST['nomCalle2'] ?? ''); ?>">
                <?php if (!empty($errores['nomCalle2'])): ?>
                    <p class="error"><?php echo $errores['nomCalle2']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="codigoPostal">Codigo Postal:</label>
                <input type="numero" id="codigoPostal" name="codigoPostal" value="<?php echo htmlspecialchars($_POST['codigoPostal'] ?? ''); ?>">
                <?php if (!empty($errores['codigoPostal'])): ?>
                    <p class="error"><?php echo $errores['codigoPostal']; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="estado">Estado:</label>
            <select id="estado" name="estado">
                <option value="1" <?php echo isset($producto['estado']) && $producto['estado'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo isset($producto['estado']) && $producto['estado'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>

        </div>
        <label for="productoID">Categoria de producto q vende el Proveedor:</label>
        <select id="productoID" name="productoID" required>
            <option value="">Seleccione un producto</option>
            <option value="Globos" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Globos') ? 'selected' : ''; ?>>Globos</option>
            <option value="Serpentinas" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Serpentinas') ? 'selected' : ''; ?>>Serpentinas</option>
            <option value="Ropa para Fiesta" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Ropa para Fiesta') ? 'selected' : ''; ?>>Ropa para Fiesta</option>
            <option value="Decoraciones" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Decoraciones') ? 'selected' : ''; ?>>Decoraciones</option>
            <option value="Accesorios" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Accesorios') ? 'selected' : ''; ?>>Accesorios</option>
            <option value="Comida para Fiestas" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Comida para Fiestas') ? 'selected' : ''; ?>>Comida para Fiestas</option>
        </select>


        <button type="submit">Registrar</button>
    </form>
</body>
</html>
<?php include 'footer.php'; ?>
