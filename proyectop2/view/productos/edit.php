<!--autor: Contreras Suarez Jordan Alexis-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <style>
     
        form {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #007bff; 
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

    
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        
        .form-row .form-group {
            flex: 1 1 45%; 
            margin-bottom: 15px;
        }

        
        form label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        form input[type="text"], form input[type="number"], form textarea, form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

       
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

        
        form .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
        }

        
        h1 {
            text-align: center;
            color: #007bff;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
<?php include 'dashboard.php'; ?>
    <h1><?php echo $titulo; ?></h1>
    <form method="POST" action="productos.php?c=productos&f=edit&id=<?php echo $producto['prod_id']; ?>">

        <!-- Contenedor para los campos en dos columnas -->
        <div class="form-row">

            <!-- Nombre -->
            <div class="form-group">
                <label for="prod_nombre">Nombre:</label>
                <input type="text" name="prod_nombre" value="<?php echo htmlspecialchars($_POST['prod_nombre'] ?? $producto['prod_nombre']); ?>">

                <?php if (!empty($errores['prod_nombre'])): ?>
                    <p class="error"><?php echo $errores['prod_nombre']; ?></p>
                <?php endif; ?>
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="prod_descripcion">Descripción:</label>
                <textarea name="prod_descripcion" required><?php echo htmlspecialchars($_POST['prod_descripcion'] ?? $producto['prod_descripcion']); ?></textarea>
                <?php if (!empty($errores['prod_descripcion'])): ?>
                    <p class="error"><?php echo $errores['prod_descripcion']; ?></p>
                <?php endif; ?>
            </div>

        </div>

        
        <div class="form-row">

            
            <div class="form-group">
                <label for="prod_precio">Precio:</label>
                <input type="number" step="0.01" name="prod_precio" value="<?php echo htmlspecialchars($_POST['prod_precio'] ?? $producto['prod_precio']); ?>">
                <?php if (!empty($errores['prod_precio'])): ?>
                    <p class="error"><?php echo $errores['prod_precio']; ?></p>
                <?php endif; ?>
            </div>

            
            <div class="form-group">
                <label for="prod_stock">Stock:</label>
                <input type="number" name="prod_stock" value="<?php echo htmlspecialchars($_POST['prod_stock'] ?? $producto['prod_stock']); ?>">
                <?php if (!empty($errores['prod_stock'])): ?>
                    <p class="error"><?php echo $errores['prod_stock']; ?></p>
                <?php endif; ?>
            </div>

        </div>

        
        <div class="form-row">

            
        <div class="form-group">
    <label for="prod_categoria">Categoría:</label>
    <select id="prod_categoria" name="prod_categoria">
        
        <option value="Globos" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Globos') || $producto['prod_categoria'] === 'Globos' ? 'selected' : ''; ?>>Globos</option>
        <option value="Serpentinas" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Serpentinas') || $producto['prod_categoria'] === 'Serpentinas' ? 'selected' : ''; ?>>Serpentinas</option>
        <option value="Ropa para Fiesta" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Ropa para Fiesta') || $producto['prod_categoria'] === 'Ropa para Fiesta' ? 'selected' : ''; ?>>Ropa para Fiesta</option>
        <option value="Decoraciones" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Decoraciones') || $producto['prod_categoria'] === 'Decoraciones' ? 'selected' : ''; ?>>Decoraciones</option>
        <option value="Accesorios" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Accesorios') || $producto['prod_categoria'] === 'Accesorios' ? 'selected' : ''; ?>>Accesorios</option>
        <option value="Comida para Fiestas" <?php echo (isset($_POST['prod_categoria']) && $_POST['prod_categoria'] === 'Comida para Fiestas') || $producto['prod_categoria'] === 'Comida para Fiestas' ? 'selected' : ''; ?>>Comida para Fiestas</option>
    </select>
    <?php if (!empty($errores['prod_categoria'])): ?>
        <p class="error"><?php echo $errores['prod_categoria']; ?></p>
    <?php endif; ?>
</div>
        


            
          

        </div>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
<?php include 'footer.php'; ?>
