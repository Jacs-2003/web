<?php
//autor:Castro Agudo Ricardo
require_once '../config/Conexion.php'; // Asegúrate de incluir la clase Conexion

class RolDAO {
    private $pdo;

    public function __construct() {
        // Obtén la conexión desde la clase Conexion
        $this->pdo = Conexion::getConexion();
    }

    public function listarRoles() {
        $sql = "SELECT * FROM roles";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
