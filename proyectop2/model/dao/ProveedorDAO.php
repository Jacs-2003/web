<?php
 //autor:Cobo Abril Alvaro Norberto
 require_once '../config/Conexion.php';

class ProveedorDAO {
    private $con;

    public function __construct() {
        $this->con = Conexion::getConexion();
    }

    public function selectAll($parametro) {
        try {
            $sql = "SELECT * FROM proveedor WHERE nomPro LIKE :b1";
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
    
    public function insertt($proveedor) {
        try {
            $nomPro = $proveedor->getNomPro();
            $apellidoPro = $proveedor->getApellidoPro();
            $correoPro = $proveedor->getCorreoPro();
            $telefonoPro = $proveedor->getTelefonoPro();
            $estado = $proveedor->getEstado();
            $productoID = $proveedor->getProductoID(); 
            $nomCalle1 = $proveedor->getNomCalle1();
            $nomCalle2 = $proveedor->getNomCalle2();
            $codigoPostal = $proveedor->getCodigoPostal();
    
            $sql = "INSERT INTO proveedor 
                        (nomPro, apellidoPro, correoPro, telefonoPro, estado, productoID, 
                        nomCalle1, nomCalle2, codigoPostal) 
                    VALUES 
                        (:nomPro, :apellidoPro, :correoPro, :telefonoPro, :estado, :productoID, :nomCalle1, :nomCalle2, :codigoPostal)";
            
            // Preparar la consulta
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(":nomPro", $nomPro, PDO::PARAM_STR);
            $stmt->bindParam(":apellidoPro", $apellidoPro, PDO::PARAM_STR);
            $stmt->bindParam(":correoPro", $correoPro, PDO::PARAM_STR);
            $stmt->bindParam(":telefonoPro", $telefonoPro, PDO::PARAM_STR);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
            $stmt->bindParam(":productoID", $productoID, PDO::PARAM_STR);
            $stmt->bindParam(":nomCalle1", $nomCalle1, PDO::PARAM_STR);
            $stmt->bindParam(":nomCalle2", $nomCalle2, PDO::PARAM_STR);
            $stmt->bindParam(":codigoPostal", $codigoPostal, PDO::PARAM_STR);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true; // Datos guardados correctamente
            } else {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Error en la consulta SQL: " . $errorInfo[2]);
            }
        } catch (PDOException $e) {
            error_log("Error en insertProveedor: " . $e->getMessage());
            throw new Exception("Error en la base de datos: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("Error en insertProveedor: " . $e->getMessage());
            return false; // Error en la inserción
        }
    }
    // Método para obtener un proveedor por su ID
    public function obtenerProveedorPorId($id) {
        try {
            $sql = "SELECT * FROM proveedor WHERE id = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            error_log("Error al obtener proveedor por ID: " . $e->getMessage());
            return null;
        }
    }

    // Método para actualizar un proveedor
    public function update($proveedor) {
        try {
            // Asignar las propiedades del proveedor a variables
            $id = $proveedor->getId();
            $nomPro = $proveedor->getNomPro();
            $apellidoPro = $proveedor->getApellidoPro();
            $correoPro = $proveedor->getCorreoPro();
            $telefonoPro = $proveedor->getTelefonoPro();
            $estado = $proveedor->getEstado();
            $productoID = $proveedor->getProductoID();
            $nomCalle1 = $proveedor->getNomCalle1();
            $nomCalle2 = $proveedor->getNomCalle2();
            $codigoPostal = $proveedor->getCodigoPostal();
    
            // Consulta SQL
            $sql = "UPDATE proveedor SET 
                        nomPro = :nomPro,
                        apellidoPro = :apellidoPro,
                        correoPro = :correoPro,
                        telefonoPro = :telefonoPro,
                        estado = :estado,
                        productoID = :productoID,
                        nomCalle1 = :nomCalle1,
                        nomCalle2 = :nomCalle2,
                        codigoPostal = :codigoPostal
                    WHERE id = :id";
    
            // Preparar la consulta
            $stmt = $this->con->prepare($sql);
    
            // Bind de variables
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nomPro", $nomPro, PDO::PARAM_STR);
            $stmt->bindParam(":apellidoPro", $apellidoPro, PDO::PARAM_STR);
            $stmt->bindParam(":correoPro", $correoPro, PDO::PARAM_STR);
            $stmt->bindParam(":telefonoPro", $telefonoPro, PDO::PARAM_STR);
            $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
            $stmt->bindParam(":productoID", $productoID, PDO::PARAM_STR);
            $stmt->bindParam(":nomCalle1", $nomCalle1, PDO::PARAM_STR);
            $stmt->bindParam(":nomCalle2", $nomCalle2, PDO::PARAM_STR);
            $stmt->bindParam(":codigoPostal", $codigoPostal, PDO::PARAM_STR);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                // Imprimir detalles del error para depuración
                $errorInfo = $stmt->errorInfo();
                echo "Error en la consulta SQL: " . $errorInfo[2]; // Detalle completo del error
                return false;
            }
        } catch (PDOException $e) {
            // Log de errores más detallado
            error_log("Error en update: " . $e->getMessage());
            echo "Error de base de datos: " . $e->getMessage(); // Mostrar error más específico
            return false;
        }
    }

    // Método para eliminar un proveedor por su ID
    public function deleteProveedor($id) {
        try {
            $sql = "DELETE FROM proveedor WHERE id = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                error_log("No se encontró el proveedor: $id");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al eliminar proveedor: " . $e->getMessage());
            return false;
        }
    }
    
}
?>