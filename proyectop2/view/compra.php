<!--autor: Garcia Alex-->
<?php
require_once('../controller/CompraController.php');


// Inicializamos el controlador
$controller = new CompraController();

// Verificamos la acción a ejecutar (por defecto muestra la lista de productos)
$action = $_GET['f'] ?? 'index';
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "Acción no válida";
}
?>
