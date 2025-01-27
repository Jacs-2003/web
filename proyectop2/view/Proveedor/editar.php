   <!--autor:Alvaro Cobo Abril-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proveedor</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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
<h1>Editar proveedor</h1>
<form method="POST" action="proveedores.php?c=proveedores&f=actualizarProveedor&id=<?php echo $proveedor['id']; ?>">

    <div class="form-row">
        <div class="form-group">
            <label for="nomPro">Nombre:</label>
            <input type="text" name="nomPro" value="<?php echo htmlspecialchars($_POST['nomPro'] ?? $proveedor['nomPro']); ?>">
            <?php if (!empty($errores['nomPro'])): ?>
                <p class="error"><?php echo $errores['nomPro']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Apellido del Proveedor -->
        <div class="form-group">
            <label for="apellidoPro">Apellido:</label>
            <input type="text" name="apellidoPro" value="<?php echo htmlspecialchars($_POST['apellidoPro'] ?? $proveedor['apellidoPro']); ?>">
            <?php if (!empty($errores['apellidoPro'])): ?>
                <p class="error"><?php echo $errores['apellidoPro']; ?></p>
            <?php endif; ?>
        </div>

    </div>

    <div class="form-row">

        <!-- Email -->
        <div class="form-group">
            <label for="correoPro">Correo Electrónico:</label>
            <input type="email" name="correoPro" value="<?php echo htmlspecialchars($_POST['correoPro'] ?? $proveedor['correoPro']); ?>">
            <?php if (!empty($errores['correoPro'])): ?>
                <p class="error"><?php echo $errores['correoPro']; ?></p>
            <?php endif; ?>
        </div>

        <!-- Teléfono -->
        <div class="form-group">
            <label for="telefonoPro">Teléfono:</label>
            <input type="text" name="telefonoPro" value="<?php echo htmlspecialchars($_POST['telefonoPro'] ?? $proveedor['telefonoPro']); ?>">
            <?php if (!empty($errores['telefonoPro'])): ?>
                <p class="error"><?php echo $errores['telefonoPro']; ?></p>
            <?php endif; ?>
        </div>

    </div>

    <div class="form-row">

        <!-- Dirección -->
        <div class="form-group">
            <label for="nomCalle1">Calle 1:</label>
            <input type="text" name="nomCalle1" value="<?php echo htmlspecialchars($_POST['nomCalle1'] ?? $proveedor['nomCalle1']); ?>">
        </div>
        <div class="form-group">
            <label for="nomCalle2">Calle 2:</label>
            <input type="text" name="nomCalle2" value="<?php echo htmlspecialchars($_POST['nomCalle2'] ?? $proveedor['nomCalle2']); ?>">
        </div>
        <div class="form-group">
            <label for="codigoPostal">Código Postal:</label>
            <input type="text" name="codigoPostal" value="<?php echo htmlspecialchars($_POST['codigoPostal'] ?? $proveedor['codigoPostal']); ?>">
        </div>
        <div>
        <label for="estado">Estado:</label>
                <select name="estado">
                <option value="1" <?php echo (isset($_POST['estado']) && $_POST['estado'] === 1) || $proveedor['estado'] === 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo (isset($_POST['estado']) && $_POST['estado'] === 0) || $proveedor['estado'] === 0 ? 'selected' : ''; ?>>Inactivo</option>
                </select>
        </div>
        <div class="form-group">
        <label for="productoID">Tipo deProducto:</label>
        <select id="productoID" name="productoID">
            <option value="">Seleccione un producto</option>
            <option value="Globos" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Globos') || $proveedor['productoID'] === 'Globos' ? 'selected' : ''; ?>>Globos</option>
            <option value="Serpentinas" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Serpentinas') || $proveedor['productoID'] === 'Serpentinas'? 'selected' : ''; ?>>Serpentinas</option>
            <option value="Ropa para Fiesta" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Ropa para Fiesta') || $proveedor['productoID'] === 'Ropa para Fiesta'? 'selected' : ''; ?>>Ropa para Fiesta</option>
            <option value="Decoraciones" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Decoraciones') || $proveedor['productoID'] === 'Decoraciones'? 'selected' : ''; ?>>Decoraciones</option>
            <option value="Accesorios" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Accesorios') || $proveedor['productoID'] === 'Accesorios'? 'selected' : ''; ?>>Accesorios</option>
            <option value="Comida para Fiestas" <?php echo (isset($_POST['productoID']) && $_POST['productoID'] === 'Comida para Fiestas') || $proveedor['productoID'] === 'Comida para Fiestas'? 'selected' : ''; ?>>Comida para Fiestas</option>
        </select>
        </div>
    </div>
    

    <button type="submit">Actualizar Proveedor</button>
</form>
</body>
</html>
<?php include 'footer.php'; ?>
<div class="form-group">
