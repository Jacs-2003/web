<?php
class Conexion {
    private $host = "localhost";      // Servidor de la base de datos
    private $dbname = "marketplace"; // Nombre de la base de datos
    private $username = "root";      // Usuario de la base de datos
    private $password = "";          // Contraseña del usuario
    private $charset = "utf8mb4";    // Codificación
    private $pdo;                    // Variable para almacenar la conexión
    private static $instance;        // Instancia única para el patrón Singleton

    // Constructor privado para evitar múltiples instancias
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Método para obtener la instancia única
    public static function getConexion() {
        if (!self::$instance) {
            self::$instance = new Conexion();
        }
        return self::$instance->pdo;
    }
}
