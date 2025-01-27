<?php
//autor: Contreras Suarez Jordan Alexis
require_once('../model/dto/Producto.php');

require_once '../model/dao/ProductosDAO.php';

class ProductosController {
    private $model;

    public function __construct() {
        $this->model = new ProductosDAO();
    }

    public function index() {
        $resultados = $this->model->selectAll("");
        $titulo = "Lista de Productos";
        require_once '../view/productos/list.php';
    }
   


    public function view_new() {
        $titulo = "Nuevo Producto";
        require_once '../view/productos/new.php';
    }
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                // Verificar si el producto está en el carrito
                $resultado = $this->model->verificarProductoEnCarrito($id);
                
                if ($resultado === true) {
                    // Si el producto está en el carrito, mostrar un mensaje de alerta
                    echo "<script>alert('No se puede eliminar un producto que está agregado al carrito');</script>";
                } else {
                    // Si el producto no está en el carrito, continuar con la eliminación
                    $resultado = $this->model->delete($id);
    
                    if ($resultado === true) {
                        $mensaje = "Producto eliminado correctamente.";
                    } elseif (is_string($resultado)) {
                        
                        $mensaje = $resultado;
                    } else {
                        $mensaje = "Error al eliminar el producto.";
                    }
                }
    
                
                $resultados = $this->model->selectAll(""); 
                $titulo = "Lista de Productos";
                require_once('../view/productos/list.php');
            } catch (Exception $e) {
                echo "Error al eliminar el producto: " . $e->getMessage();
            }
        }
    }
    

   

    public function new() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $errores = [];
    
            
            if (empty($_POST['prod_nombre'])) {
                $errores['prod_nombre'] = "El nombre del producto es obligatorio.";
            } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['prod_nombre'])) {
                $errores['prod_nombre'] = "El nombre del producto solo puede contener letras y espacios.";
            }
    
            
            if (empty($_POST['prod_descripcion'])) {
                $errores['prod_descripcion'] = "La descripción es obligatoria.";
            }
    
           
            if (empty($_POST['prod_precio']) || !is_numeric($_POST['prod_precio']) || $_POST['prod_precio'] <= 0) {
                $errores['prod_precio'] = "El precio debe ser un número mayor a 0.";
            }
    
           
            if (!isset($_POST['prod_stock']) || !is_numeric($_POST['prod_stock']) || $_POST['prod_stock'] < 0) {
                $errores['prod_stock'] = "El stock debe ser un número no negativo.";
            }
    
           
            if (empty($_POST['prod_categoria'])) {
                $errores['prod_categoria'] = "La categoría es obligatoria.";
            }
    
            
            if (!empty($errores)) {
                $titulo = "Nuevo Producto";
                require_once '../view/productos/new.php';
                return;
            }
    
          
            $producto = new Producto();
            $producto->setNombre($_POST['prod_nombre']);
            $producto->setDescripcion($_POST['prod_descripcion']);
            $producto->setPrecio($_POST['prod_precio']);
            $producto->setStock($_POST['prod_stock']);
            $producto->setCategoria($_POST['prod_categoria']);
            $producto->setEstado(1); // Activo
    
            $productosDAO = new ProductosDAO();
            try {
                $exito = $productosDAO->insert($producto);
                if ($exito) {
                    header("Location: productos.php?c=productos&f=index");
                    exit;
                } else {
                    echo "Error al insertar producto.";
                }
            } catch (Exception $e) {
                echo "Error al insertar producto: " . $e->getMessage();
            }
        } else {
            
            $titulo = "Nuevo Producto";
            $errores = [];
            require_once '../view/productos/new.php';
        }
    }
    

    public function view_edit() {
        $id = $_GET['id'];
        $producto = $this->model->selectById($id);  
        $titulo = "Editar Producto";
        require_once '../view/productos/edit.php';
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
    
            $errores = [];
    
            // Validar nombre (solo letras y espacios)
            if (empty($_POST['prod_nombre'])) {
                $errores['prod_nombre'] = "El nombre del producto es obligatorio.";
            } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $_POST['prod_nombre'])) {
                $errores['prod_nombre'] = "El nombre del producto solo puede contener letras, espacios y acentos.";
            }
    
            // Validar descripción
            if (empty($_POST['prod_descripcion'])) {
                $errores['prod_descripcion'] = "La descripción es obligatoria.";
            }
    
            // Validar precio (debe ser numérico y positivo)
            if (empty($_POST['prod_precio']) || !is_numeric($_POST['prod_precio']) || $_POST['prod_precio'] <= 0) {
                $errores['prod_precio'] = "El precio debe ser un número mayor a 0.";
            }
    
            // Validar stock (debe ser numérico y no negativo)
            if (!isset($_POST['prod_stock']) || !is_numeric($_POST['prod_stock']) || $_POST['prod_stock'] < 0) {
                $errores['prod_stock'] = "El stock debe ser un número no negativo.";
            }
    
            // Validar categoría
            if (empty($_POST['prod_categoria'])) {
                $errores['prod_categoria'] = "La categoría es obligatoria.";
            }
    
            // Si hay errores, volver a la vista de edición con los errores y los datos
            if (!empty($errores)) {
                $titulo = "Editar Producto";
                $producto = $this->model->selectById($id);  // Trae los datos originales para prellenar el formulario
                require_once '../view/productos/edit.php';
                return;
            }
    
            // Crear el objeto producto y asignar los valores desde el formulario
            $producto = new Producto();
            $producto->setId($id);
            $producto->setNombre($_POST['prod_nombre']);
            $producto->setDescripcion($_POST['prod_descripcion']);
            $producto->setPrecio($_POST['prod_precio']);
            $producto->setStock($_POST['prod_stock']);
            $producto->setCategoria($_POST['prod_categoria']);
            $producto->setEstado($_POST['prod_estado']);
    
            // Verificar si el stock es mayor que 0 para activar el producto
            if ($_POST['prod_stock'] > 0) {
                $producto->setEstado(1); // Activo
            } else {
                $producto->setEstado(0);
            }
    
            $productosDAO = new ProductosDAO();
            try {
                $exito = $productosDAO->update($producto); 
                if ($exito) {
                    header("Location: productos.php?c=productos&f=index");
                    exit;
                } else {
                    echo "Error al actualizar producto.";
                }
            } catch (Exception $e) {
                echo "Error al actualizar producto: " . $e->getMessage(); // Mostrar mensaje de error detallado
            }
        }
    }
    
    
    public function listarParaClientes() {
        $productosDAO = new ProductosDAO();
        $productos = $productosDAO->selectAllOffStock(""); // Obtiene todos los productos
        $productosFiltrados = [];
    
        // Filtra productos inactivos (estado == 0)
        foreach ($productos as $producto) {
            if ($producto['prod_estado'] == 1) {
                $productosFiltrados[] = $producto;
            }
        }
    
        $titulo = "Productos Disponibles";
        require_once '../view/productos/cliente_list.php'; // Vista para los clientes
    }
    
    
    public function search() {
        // Capturamos el valor de búsqueda desde el parámetro GET
        $b = isset($_GET['b']) ? $_GET['b'] : '';
        
        // Llamamos al modelo para obtener los productos que coinciden con la búsqueda
        $resultados = $this->model->selectAll($b);
        
        // Verificamos si hay resultados y devolvemos solo las filas de la tabla con los productos
        if (!empty($resultados)) {
            foreach ($resultados as $producto) {
                echo '<tr>';
                echo '<td>' . $producto['prod_id'] . '</td>';
                echo '<td>' . $producto['prod_nombre'] . '</td>';
                echo '<td>' . $producto['prod_descripcion'] . '</td>';
                echo '<td>' . $producto['prod_precio'] . '</td>';
                echo '<td>' . $producto['prod_stock'] . '</td>';
                echo '<td>' . $producto['prod_categoria'] . '</td>';
                echo '<td>' . ($producto['prod_estado'] == 1 ? 'Activo' : 'Inactivo') . '</td>';
                echo '<td>' . $producto['prod_fecha_creacion'] . '</td>';
                echo '<td>' . $producto['prod_fecha_actualizacion'] . '</td>';
                echo '<td>';
                echo '<a href="productos.php?c=productos&f=view_edit&id=' . $producto['prod_id'] . '" style="background-color: #007BFF; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Editar</a> ';
                echo '<a href="productos.php?c=productos&f=delete&id=' . $producto['prod_id'] . '" onclick="return confirm(\'¿Está seguro de eliminar este producto?\');"style="background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;">Eliminar</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="10">No se encontraron productos</td></tr>';
        }
    }
   
}

?>
