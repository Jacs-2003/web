
<?php
//autor: Contreras Suarez Jordan Alexis
require_once '../config/Conexion.php';

class ProductosDAO {
    private $con;

    public function __construct() {
        $this->con = Conexion::getConexion();
    }
    public function verificarProductoEnCarrito($id) {
        try {
            $checkQuery = "SELECT COUNT(*) FROM carritos WHERE prod_id = :id";
            $stmtCheck = $this->con->prepare($checkQuery);
            $stmtCheck->bindParam(":id", $id, PDO::PARAM_INT);
            $stmtCheck->execute();
            $count = $stmtCheck->fetchColumn();
            
            return $count > 0; // Retorna true si el producto está en el carrito, false si no lo está
        } catch (PDOException $e) {
            error_log("Error en verificarProductoEnCarrito: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($id) {
        try {
            // Verificar si el producto está en el carrito antes de eliminarlo
            $checkQuery = "SELECT COUNT(*) FROM carritos WHERE prod_id = :id";
            $stmtCheck = $this->con->prepare($checkQuery);
            $stmtCheck->bindParam(":id", $id, PDO::PARAM_INT);
            $stmtCheck->execute();
            $count = $stmtCheck->fetchColumn();
    
            // Si el producto está en el carrito, no permitir su eliminación
            if ($count > 0) {
                return "Este producto no se puede eliminar porque está en el carrito.";
            }
    
            // Si el producto no está en el carrito, proceder a eliminarlo
            $sql = "DELETE FROM productos WHERE prod_id = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                error_log("No se encontró el producto con ID: $id");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error en delete: " . $e->getMessage());
            return false;
        }
    }

    public function selectAll($parametro) {
        try {
            $sql = "SELECT * FROM productos WHERE prod_nombre LIKE :b1";
            $stmt = $this->con->prepare($sql);
            $conlike = '%' . $parametro . '%';
            $stmt->bindParam(":b1", $conlike, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en selectAll: " . $e->getMessage());
            return [];
        }
    }

    public function insert($producto) {
        try {
            $nombre = $producto->getNombre();
            $descripcion = $producto->getDescripcion();
            $precio = $producto->getPrecio();
            $stock = $producto->getStock();
            $estado = $stock == 0 ? 0 : $producto->getEstado(); // Si el stock es 0, el estado es inactivo
            $categoria = $producto->getCategoria();
    
            $sql = "INSERT INTO productos 
                        (prod_nombre, prod_descripcion, prod_precio, prod_estado, 
                        prod_stock, prod_categoria) 
                    VALUES 
                        (:nombre, :descripcion, :precio, :estado, :stock, :categoria)";
    
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Error en la consulta SQL: " . $errorInfo[2]);
            }
        } catch (PDOException $e) {
            error_log("Error en insert: " . $e->getMessage());
            throw new Exception("Error en la base de datos: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("Error en insert: " . $e->getMessage());
            return false;
        }
    }
    


    public function selectById($id) {
        try {
            $sql = "SELECT * FROM productos WHERE prod_id = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);  // Devuelve el producto
        } catch (PDOException $e) {
            error_log("Error en selectById: " . $e->getMessage());
            return null;
        }
    }
    
    public function update($producto) {
        try {
            $id = $producto->getId();
            $nombre = $producto->getNombre();
            $descripcion = $producto->getDescripcion();
            $precio = $producto->getPrecio();
            $stock = $producto->getStock();
            $estado = $stock == 0 ? 0 : $producto->getEstado(); // Si el stock es 0, el estado es inactivo
            $categoria = $producto->getCategoria();
    
            $sql = "UPDATE productos SET 
                        prod_nombre = :nombre, 
                        prod_descripcion = :descripcion, 
                        prod_precio = :precio, 
                        prod_estado = :estado, 
                        prod_stock = :stock, 
                        prod_categoria = :categoria 
                    WHERE prod_id = :id";
    
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
    
            if ($stmt->execute()) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Error en la consulta SQL: " . $errorInfo[2]);
            }
        } catch (PDOException $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Error en update: " . $e->getMessage());
            return false;
        }
    }
    
    
    public function selectAllOffStock($parametro) {
        try {
            // Agregamos la condición para filtrar productos con stock mayor a 0
            $sql = "SELECT * FROM productos WHERE prod_nombre LIKE :b1 AND prod_stock > 0";
            $stmt = $this->con->prepare($sql);
            $conlike = '%' . $parametro . '%';
            $stmt->bindParam(":b1", $conlike, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en selectAll: " . $e->getMessage());
            return [];
        }
    }
    
    
   

    
 
    
}

?>
