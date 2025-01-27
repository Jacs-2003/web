   <!--autor:Alvaro Cobo Abril-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
       $(document).ready(function() {
    // Función que se ejecuta cada vez que se escribe algo en el campo de búsqueda
    $('#buscar').on('input', function() {
        var query = $(this).val();  // Capturamos el texto que se escribe
        
        if (query.length >= 1) {  // Si el texto tiene al menos un carácter
            
            $.ajax({
                url: 'proveedores.php?c=proveedores&f=buscar',  
                method: 'GET',  
                data: { b: query },  
                success: function(response) {
                    $('#resultados tbody').html(response);  
                }
            });
        } else {
            // Si el campo está vacío, hacemos una nueva solicitud AJAX para obtener todos los productos
            $.ajax({
                url: 'proveedores.php?c=proveedores&f=buscar',  // El controlador y la acción para buscar
                method: 'GET',  // Método de la petición
                data: { b: '' },  // Pasamos un valor vacío para obtener todos los productos
                success: function(response) {
                    $('#resultados tbody').html(response);  // Actualizamos solo el cuerpo de la tabla con todos los productos
                }
            });
        }
    });
});


</script>
    <style>

/* Estilo para el título "Lista de Productos" */
h1 {
text-align: center; /* Centra el texto */
color: #007BFF;     /* Color azul */
}
/* Estilo para el botón */
button {
background-color: #007BFF; /* Color de fondo azul */
color: white;              /* Color de texto blanco */
border: none;              /* Sin borde */
padding: 10px 20px;        /* Relleno para que se vea más grande */
font-size: 16px;           /* Tamaño de fuente */
cursor: pointer;          /* Cursor de mano al pasar el ratón */
border-radius: 5px;        /* Bordes redondeados */
transition: background-color 0.3s ease; /* Efecto al pasar el ratón */
}

/* Cambiar color del botón al pasar el ratón */
button:hover {
background-color: #0056b3; /* Color azul más oscuro */
}

/* Estilo para el input de búsqueda */
/* Estilo para el input de búsqueda */
#buscar {
width: 50%;               /* Ajusta el ancho al 50% del contenedor */
max-width: 400px;         /* Limita el ancho máximo a 400px */
padding: 10px;            /* Relleno dentro del input */
font-size: 16px;          /* Tamaño de fuente */
border: 1px solid #007BFF;/* Borde azul */
border-radius: 5px;       /* Bordes redondeados */
box-sizing: border-box;   /* Para que el padding no afecte el ancho total */
margin-bottom: 20px;      /* Espacio debajo del input */
margin-left: auto;        /* Centra el input horizontalmente */
margin-right: auto;       /* Centra el input horizontalmente */
}

/* Estilo para el input de búsqueda al enfocarse */
#buscar:focus {
outline: none;            /* Eliminar borde por defecto */
border-color: #0056b3;    /* Color de borde cuando está enfocado */
box-shadow: 0 0 5px rgba(0, 91, 187, 0.5); /* Sombra azul al enfocar */
}


</style>
</head>
<body>
    <?php include 'dashboard.php'; ?>
    <h1><?php echo $titulo; ?></h1>
    
    <form method="GET" action="proveedores.php?c=proveedores&f=buscar">
        <input type="text" id="buscar" name="b" placeholder="Buscar por nombre">
    </form>

    <div id="resultados">
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Tipo de Producto</th>
                <th>Calle 1</th>
                <th>Calle 2</th>
                <th>Código Postal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($resultados)) { ?>
                <?php foreach ($resultados as $proveedor) { ?>
                    <tr>
                        <td><?php echo $proveedor['id']; ?></td>
                        <td><?php echo $proveedor['nomPro']; ?></td>
                        <td><?php echo $proveedor['apellidoPro']; ?></td>
                        <td><?php echo $proveedor['telefonoPro']; ?></td>
                        <td><?php echo $proveedor['correoPro']; ?></td>
                        <td><?php echo $proveedor['estado']; ?></td>
                        <td><?php echo $proveedor['productoID']; ?></td>
                        <td><?php echo $proveedor['nomCalle1']; ?></td>
                        <td><?php echo $proveedor['nomCalle2']; ?></td>
                        <td><?php echo $proveedor['codigoPostal']; ?></td>
                        <td>
                            <a href="proveedores.php?c=proveedores&f=mostrarFormularioEdicion&id=<?php echo $proveedor['id']; ?>"style="background-color: #007BFF; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Editar</a>
                            <a href="proveedores.php?c=proveedores&f=eliminarProveedor&id=<?php echo $proveedor['id']; ?>" onclick="return confirm('¿Está seguro de eliminar al proveedor seleccionado?');" style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Eliminar</a>
                        </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="10">No se encontraron proveedores</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <a href="proveedores.php?c=proveedores&f=mostrarFormularioProveedor">
        <button>Agregar Proveedor</button>
    </a>
    <?php include 'footer.php'; ?>
</body>
</html>

