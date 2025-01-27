<!--autor: Contreras Suarez Jordan Alexis-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <title><?php echo $titulo; ?></title>

    <style>
       
.btn-agregar {
    background-color: #4CAF50; 
    color: white; 
    padding: 10px 20px; 
    text-align: center; 
    text-decoration: none; 
    display: inline-block;
    font-size: 16px; 
    border: none;
    border-radius: 5px; 
    cursor: pointer; 
    transition: background-color 0.3s; 
}


.btn-agregar:hover {
    background-color: #45a049; 
}

        </style>
</head>
<body>
<?php include 'dashboard.php'; ?>
    <h1><?php echo $titulo; ?></h1>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
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
                    <td><?php echo number_format($producto['prod_precio'], 2); ?> $</td>
                    
                    <td>
                    <form action="carrito.php?f=new" method="post">
                        <input type="hidden" name="prod_id" value="<?php echo $producto['prod_id']; ?>">
                        <input type="hidden" name="prod_nombre" value="<?php echo $producto['prod_nombre']; ?>">
                        <input type="hidden" name="prod_descripcion" value="<?php echo $producto['prod_descripcion']; ?>">
                        <input type="hidden" name="prod_precio" value="<?php echo $producto['prod_precio']; ?>">
                        <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">  
                        <button type="submit" class="btn-agregar">Agregar al carrito</button>

                    </form>


                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>
<?php include 'footer.php'; ?>