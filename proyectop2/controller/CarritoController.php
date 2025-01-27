<?php
//autor: Contreras Suarez Jordan Alexis


require_once('../model/dto/Carrito.php');
require_once '../model/dao/CarritoDAO.php';

class CarritoController {
    private $model;

    public function __construct() {
        $this->model = new CarritoDAO();
    }

 
    public function list() {
        $carritos = $this->model->selectAll();
        require_once('../view/carritos/list.php'); 
    }
    

    public function new() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $prod_id = $_POST['prod_id'];
            $prod_nombre = $_POST['prod_nombre'];
            $prod_descripcion = $_POST['prod_descripcion'];
            $prod_precio = $_POST['prod_precio'];
            $usuario_id = $_POST['usuario_id']; 
    
            
            $carrito = new Carrito();
            $carrito->setProductoId($prod_id);
            $carrito->setNombreProducto($prod_nombre);
            $carrito->setDescripcion($prod_descripcion);
            $carrito->setPrecio($prod_precio);
            $carrito->setUsuarioId($usuario_id);  
            $carrito->setFechaAgregado(date('Y-m-d H:i:s'));
    
            
            $this->model->insert($carrito);
            header("Location: productos.php?c=productos&f=listarParaClientes");
        }
    }
    
    public function misProductos() {
        session_start();
        $usuario_id = $_SESSION['usuario_id']; 
        $productos = $this->model->mostrarProductosPropios($usuario_id);
        require_once('../view/productos/misproductos.php'); 
    }

    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $carrito_id = $_POST['carrito_id'];
            $this->model->delete($carrito_id); 
            header("Location: carrito.php?f=misProductos"); 
        }
    }
    
}
?>
