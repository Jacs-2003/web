<?php
//autor: Contreras Suarez Jordan Alexis
require_once '../config/Conexion.php';

class CarritoDAO {
    private $con;

    public function __construct() {
        $this->con = Conexion::getConexion();
    }

    public function selectAll() {
        $query = "SELECT * FROM carritos";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function insert($carrito) {
        $query = "INSERT INTO carritos (usuario_id, prod_id, prod_nombre, prod_descripcion, prod_precio, fecha_agregado) 
                  VALUES (:usuario_id, :prod_id, :prod_nombre, :prod_descripcion, :prod_precio, :fecha_agregado)";
        $stmt = $this->con->prepare($query);
    
        // Asignar valores a las variables
        $usuario_id = $carrito->getUsuarioId();
        $prod_id = $carrito->getProductoId();
        $prod_nombre = $carrito->getNombreProducto();
        $prod_descripcion = $carrito->getDescripcion();
        $prod_precio = $carrito->getPrecio();
        $fecha_agregado = $carrito->getFechaAgregado();
    
        // Vincula los parámetros usando las variables
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':prod_id', $prod_id);
        $stmt->bindParam(':prod_nombre', $prod_nombre);
        $stmt->bindParam(':prod_descripcion', $prod_descripcion);
        $stmt->bindParam(':prod_precio', $prod_precio);
        $stmt->bindParam(':fecha_agregado', $fecha_agregado);
    
        // Ejecuta la consulta
        $stmt->execute();
    
        // Ahora actualizamos el stock del producto
        $updateStockQuery = "UPDATE productos SET prod_stock = prod_stock - 1 WHERE prod_id = :prod_id AND prod_stock > 0";
        $updateStmt = $this->con->prepare($updateStockQuery);
        $updateStmt->bindParam(':prod_id', $prod_id);
        $updateStmt->execute();
    }
    

    public function mostrarProductosPropios($usuario_id) {
        $query = "SELECT * FROM carritos WHERE usuario_id = :usuario_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function delete($carrito_id) {
        $query = "DELETE FROM carritos WHERE carrito_id = :carrito_id";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':carrito_id', $carrito_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    
    

  
   
}
?>
