<!--author: Cobo Abril Alvaro Norberto-->
<?php
require_once('../controller/ProveedorController.php');


// Inicializamos el controlador
$controller = new ProveedorController();

// Verificamos la acción a ejecutar (por defecto muestra la lista de productos)
$action = $_GET['f'] ?? 'index';
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Acción no válida";
}
?>



