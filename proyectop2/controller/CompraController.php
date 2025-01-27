<?php
//autor: Garcia Alex
require_once('../model/dao/CompraDAO.php');

require_once('../model/dto/Compra.php');

class CompraController {


    public function __construct() {
        $this->dao = new CompraDAO(); // Asegúrate de inicializar el DAO aquí
    }
    public function formularioCompra() {
        session_start();
        // Verifica que el usuario esté autenticado
        if (!isset($_SESSION['usuario_id'])) {
            die("Error: Usuario no autenticado.");
        }
        $usuario_id = $_SESSION['usuario_id'];

        // Verifica si el producto_id está definido
        if (isset($_POST['producto_id'])) {
            $producto_id = $_POST['producto_id'];
        } else {
            die("Error: Producto no especificado.");
        }

        // Carga la vista del formulario
        require_once('../view/compra/Formulario_compra.php');
    }

    public function realizarCompra() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Inicialización de variables
            $errores = [];
            $producto_id = $_POST['producto_id'] ?? null;
            $usuario_id = $_POST['usuario_id'] ?? null;
    
            // Validaciones de los datos
            if (empty($producto_id)) {
                $errores['producto'] = "Producto no encontrado.";
            }
    
            if (empty($usuario_id)) {
                $errores['usuario'] = "Usuario no autenticado.";
            }
    
            // Validar cédula (solo números, de longitud 10 o 11 dependiendo del país)
            if (empty($_POST['cedula']) || !is_numeric($_POST['cedula']) || strlen($_POST['cedula']) < 10 || strlen($_POST['cedula']) > 11) {
                $errores['cedula'] = "La cédula debe ser un número válido de 10 o 11 dígitos.";
            }
    
            // Validar tarjeta (solo números, longitud de tarjeta típica)
            if (empty($_POST['tarjeta']) || !is_numeric($_POST['tarjeta']) || strlen($_POST['tarjeta']) != 16) {
                $errores['tarjeta'] = "El número de tarjeta debe ser válido (16 dígitos).";
            }
    
            // Validar CVV (solo números, longitud típica de 3 dígitos)
            if (empty($_POST['cvv']) || !is_numeric($_POST['cvv']) || strlen($_POST['cvv']) != 3) {
                $errores['cvv'] = "El CVV debe ser un número de 3 dígitos.";
            }
    
           // Validar ciudad
           if (empty($_POST['ciudad'])) {
            $errores['ciudad'] = "La ciudad es obligatoria.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['ciudad'])) {
            $errores['ciudad'] = "La ciudad solo puede contener letras.";
        }


        // Validar país
        if (empty($_POST['pais'])) {
            $errores['pais'] = "El país es obligatorio.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['pais'])) {
            $errores['pais'] = "El pais solo puede contener letras.";
        }
    
            // Si hay errores, enviar los datos a la vista
            if (!empty($errores)) {
                // Enviar los errores al formulario para que el usuario los vea
                require_once('../view/compra/Formulario_compra.php');
                return;
            }
    
            // Si no hay errores, realizar la compra
            $cedula = $_POST['cedula'];
            $tarjeta = $_POST['tarjeta'];
            $cvv = $_POST['cvv'];
            $ciudad = $_POST['ciudad'];
            $pais = $_POST['pais'];
            $fecha = date('Y-m-d H:i:s');
    
            // Insertar en la base de datos
            $compraDAO = new CompraDAO();
            try {
                $compraDAO->registrarCompra($usuario_id, $producto_id, $cedula, $tarjeta, $cvv, $ciudad, $pais, $fecha);
                // Redirigir después de una compra exitosa
                header("Location: carrito.php?f=misProductos");
                exit();
            } catch (Exception $e) {
                echo "Error al realizar la compra: " . $e->getMessage();
            }
        }
    }
    


    public function listarCompras() {
        $compraDAO = new CompraDAO();
        $compras = $compraDAO->selectAll();
        require_once('../view/compra/compras_list.php');
    }
   
    public function eliminarCompra() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                // Llamamos al método delete del DAO
                $resultado = $this->dao->eliminarCompra($id);
    
                if ($resultado === true) {
                    // Si se eliminó la compra correctamente, mostrar un mensaje de éxito
                    $mensaje = "Compra eliminada correctamente.";
                } else {
                    // Si ocurrió un error desconocido
                    $mensaje = "Error al eliminar la compra.";
                }
    
                // Recargar la lista de compras después de la eliminación
                $compras = $this->dao->selectAll(); // Recargar las compras
                $titulo = "Lista de Compras";
                // Pasar el mensaje y las compras a la vista sin redirigir
                require_once('../view/compra/compras_list.php'); // Asegúrate de tener esta vista para mostrar las compras
            } catch (Exception $e) {
                echo "Error al eliminar la compra: " . $e->getMessage();
            }
        }
    }
    public function editarCompra() {
        // Verifica si se ha proporcionado el id de la compra
        if (isset($_GET['id'])) {
            $compra_id = $_GET['id'];
    
            // Obtener los detalles de la compra
            $compraDAO = new CompraDAO();
            $compra = $compraDAO->selectById($compra_id);
    
            if ($compra) {
                // Mostrar el formulario de edición con los datos actuales
                require_once('../view/compra/editar_compra.php');
            } else {
                echo "Error: Compra no encontrada.";
            }
        } else {
            echo "Error: No se ha proporcionado un ID de compra.";
        }
    }
    public function guardarEdicion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errores = [];
    
            // Validar cédula (solo números, longitud 10 o 11)
            if (empty($_POST['cedula']) || !is_numeric($_POST['cedula']) || strlen($_POST['cedula']) < 10 || strlen($_POST['cedula']) > 11) {
                $errores['cedula'] = "La cédula debe ser un número válido de 10 o 11 dígitos.";
            }
    
            // Validar tarjeta (solo números, longitud 16)
            if (empty($_POST['tarjeta']) || !is_numeric($_POST['tarjeta']) || strlen($_POST['tarjeta']) != 16) {
                $errores['tarjeta'] = "El número de tarjeta debe ser válido (16 dígitos).";
            }
    
            // Validar CVV (solo números, longitud 3)
            if (empty($_POST['cvv']) || !is_numeric($_POST['cvv']) || strlen($_POST['cvv']) != 3) {
                $errores['cvv'] = "El CVV debe ser un número de 3 dígitos.";
            }
            
            // Validar ciudad
            if (empty($_POST['ciudad'])) {
                $errores['ciudad'] = "La ciudad es obligatoria.";
            } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['ciudad'])) {
                $errores['ciudad'] = "La ciudad solo puede contener letras.";
            }
    
    
            // Validar país
            if (empty($_POST['pais'])) {
                $errores['pais'] = "El país es obligatorio.";
            } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['pais'])) {
                $errores['pais'] = "El pais solo puede contener letras.";
            }
            // Validar total (obligatorio)
            if (empty($_POST['total'])) {
                $errores['total'] = "El total es obligatorio.";
            } elseif (!is_numeric($_POST['total']) || $_POST['total'] <= 0) {
                $errores['total'] = "El total debe ser un número mayor a 0.";
            }
    
            // Si hay errores, enviar los datos a la vista
            if (!empty($errores)) {
                // Recuperar los datos de la compra original para mantenerlos en los campos del formulario
                $compra = $_POST;
                require_once('../view/compra/editar_compra.php');
                return;
            }
    
            // Procesar la edición si no hay errores
            $compra_id = $_POST['compra_id'];
            $usuario_id = $_POST['usuario_id'];
            $producto_id = $_POST['producto_id'];
            $cedula = $_POST['cedula'];
            $tarjeta = $_POST['tarjeta'];
            $cvv = $_POST['cvv'];
            $ciudad = $_POST['ciudad'];
            $pais = $_POST['pais'];
            $fecha_compra = $_POST['fecha_compra'];
            $total = $_POST['total'];
    
            // Llamar al método de edición en el DAO
            $this->dao->editarCompra($compra_id, $usuario_id, $producto_id, $cedula, $tarjeta, $cvv, $ciudad, $pais, $fecha_compra, $total);
    
            // Llamar a selectAll() para obtener las compras actualizadas
            $compras = $this->dao->selectAll();
    
            // Ahora pasamos las compras actualizadas a la vista
            require_once('../view/compra/compras_list.php');
            exit();
        }
    }
    
    public function search() {
        $cedula = isset($_GET['cedula']) ? $_GET['cedula'] : '';
        $compras = $this->dao->selectAllCedula($cedula);
    
        if (!empty($compras)) {
            foreach ($compras as $compra) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($compra['compra_id']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['usuario_id']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['producto_id']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['cedula']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['ciudad']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['pais']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['fecha_compra']) . '</td>';
                echo '<td>' . htmlspecialchars($compra['total']) . '</td>';
                echo '<td>';
                echo '<a href="compra.php?c=compra&f=eliminarCompra&id=' . htmlspecialchars($compra['compra_id']) . '"style="background-color:#c0392b; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px; margin-right: 5px;">Eliminar</a>';
                echo '<a href="compra.php?c=compra&f=editarCompra&id=' . htmlspecialchars($compra['compra_id']) . '"style="background-color:green; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Editar</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="9">No se encontraron compras</td></tr>';
        }
    }
    
    
    
}
