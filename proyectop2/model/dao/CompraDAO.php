<?php
//autor: Garcia Alex
require_once('../config/Conexion.php');

class CompraDAO {
    private $con;

    public function __construct() {
        $this->con = Conexion::getConexion();
    }

    public function registrarCompra($usuario_id, $producto_id, $cedula, $tarjeta, $cvv, $ciudad, $pais, $fecha_compra) {
        // Recuperar el precio del producto
        $queryPrecio = "SELECT p.prod_precio FROM productos p WHERE p.prod_id = :producto_id";
        $stmtPrecio = $this->con->prepare($queryPrecio);
        $stmtPrecio->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmtPrecio->execute();
        $producto = $stmtPrecio->fetch(PDO::FETCH_ASSOC);
    
        if ($producto) {
            $precio_producto = $producto['prod_precio'];
        } else {
            // Maneja el caso si no se encuentra el producto
            throw new Exception("Producto no encontrado");
        }
    
        // Calcular el total (suponiendo que solo hay un producto por compra en este ejemplo)
        $total = $precio_producto; 
    
        // Insertar la compra en la tabla
        $query = "INSERT INTO compras (usuario_id, producto_id, cedula, tarjeta, cvv, ciudad, pais, fecha_compra, total) 
                  VALUES (:usuario_id, :producto_id, :cedula, :tarjeta, :cvv, :ciudad, :pais, :fecha_compra, :total)";
        $stmt = $this->con->prepare($query);
    
        // Asignar valores a parámetros
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':tarjeta', $tarjeta);
        $stmt->bindParam(':cvv', $cvv);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':fecha_compra', $fecha_compra);
        $stmt->bindParam(':total', $total);
    
        // Ejecutar la consulta de inserción
        $stmt->execute();
    }

    public function selectAll() {
        $query = "SELECT c.compra_id AS id, c.usuario_id, c.producto_id, c.cedula, c.ciudad, 
        c.pais, c.fecha_compra, c.total, 
        u.nombre AS usuario, 
        p.prod_nombre AS producto
        FROM compras c
        INNER JOIN usuarios u ON c.usuario_id = u.id
        INNER JOIN productos p ON c.producto_id = p.prod_id";


        $stmt = $this->con->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminarCompra($compra_id) {
        // Preparar la consulta SQL para eliminar la compra
        $query = "DELETE FROM compras WHERE compra_id = :compra_id";
        $stmt = $this->con->prepare($query);
    
        // Asignar el valor del parámetro
        $stmt->bindParam(':compra_id', $compra_id, PDO::PARAM_INT);
    
        // Ejecutar la consulta
        $stmt->execute();
    }
    public function editarCompra($compra_id, $usuario_id, $producto_id, $cedula, $tarjeta, $cvv, $ciudad, $pais, $fecha_compra, $total) {
        // Preparar la consulta SQL para actualizar la compra
        $query = "UPDATE compras SET 
                    usuario_id = :usuario_id, 
                    producto_id = :producto_id, 
                    cedula = :cedula, 
                    tarjeta = :tarjeta, 
                    cvv = :cvv, 
                    ciudad = :ciudad, 
                    pais = :pais, 
                    fecha_compra = :fecha_compra, 
                    total = :total
                  WHERE compra_id = :compra_id";
        
        $stmt = $this->con->prepare($query);
    
        // Asignar valores a los parámetros
        $stmt->bindParam(':compra_id', $compra_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->bindParam(':tarjeta', $tarjeta, PDO::PARAM_STR);
        $stmt->bindParam(':cvv', $cvv, PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $pais, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_compra', $fecha_compra, PDO::PARAM_STR);
        $stmt->bindParam(':total', $total, PDO::PARAM_STR);
    
        // Ejecutar la consulta
        $stmt->execute();
    }
    public function selectById($compra_id) {
        $query = "SELECT c.compra_id, c.usuario_id, c.producto_id, c.cedula, c.tarjeta, 
                         c.cvv, c.ciudad, c.pais, c.fecha_compra, c.total, 
                         u.nombre AS usuario, 
                         p.prod_nombre AS producto
                  FROM compras c
                  INNER JOIN usuarios u ON c.usuario_id = u.id
                  INNER JOIN productos p ON c.producto_id = p.prod_id
                  WHERE c.compra_id = :compra_id";
        
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':compra_id', $compra_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
  
    
    public function selectAllCedula($cedula) {
        try {
            $sql = "SELECT * FROM compras WHERE cedula LIKE :cedula";
            $stmt = $this->con->prepare($sql);
            $likeCedula = '%' . $cedula . '%';
            $stmt->bindParam(':cedula', $likeCedula, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en selectAll: " . $e->getMessage());
            return [];
        }
    }
    public function cedulaRegistrada($cedula) {
        $query = "SELECT COUNT(*) AS total FROM compras WHERE cedula = :cedula";
        $stmt = $this->con->prepare($query);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['total'] > 0; // Devuelve true si la cédula ya está registrada
    }
    

    
    
}
