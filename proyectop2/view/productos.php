
<?php
//autor: Contreras Suarez Jordan Alexis
require_once('../controller/ProductosController.php');


// Inicializamos el controlador
$controller = new ProductosController();

// Verificamos la acción a ejecutar (por defecto muestra la lista de productos)
$action = $_GET['f'] ?? 'index';
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Acción no válida";
}
?>
