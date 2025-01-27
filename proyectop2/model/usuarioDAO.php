<?php
//autor:Castro Agudo Ricardo
class UsuarioDAO {
    private $pdo;

    public function __construct() {
        // Obtén la conexión desde la clase Conexion
        $this->pdo = Conexion::getConexion();
    }

    
    public function autenticar($email, $clave) {
        $sql = "SELECT u.id, u.nombre, u.rol_id, r.nombre AS rol, u.clave 
                FROM usuarios u 
                JOIN roles r ON u.rol_id = r.id 
                WHERE u.email = :email AND u.clave = :clave";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email, ':clave' => $clave]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna el usuario con ID
    }
    

    public function listarUsuarios() {
        $sql = "SELECT u.id, u.nombre, u.apellido, u.email, r.nombre AS rol 
                FROM usuarios u 
                JOIN roles r ON u.rol_id = r.id";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    public function registrarUsuario($nombre, $apellido, $email, $telefono, $edad, $rol_id, $clave) {
        // Validaciones
        $this->validarTexto('nombre', $nombre);
        $this->validarTexto('apellido', $apellido);
    
        // Verificar duplicados
        $checkEmail = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($checkEmail);
        $stmt->execute([':email' => $email]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("El correo electrónico ya está registrado.");
        }
    
        // Insertar
        $sql = "INSERT INTO usuarios (nombre, apellido, email, telefono, edad, rol_id, clave) 
                VALUES (:nombre, :apellido, :email, :telefono, :edad, :rol_id, :clave)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':email' => $email,
            ':telefono' => $telefono,
            ':edad' => $edad,
            ':rol_id' => $rol_id,
            ':clave' => $clave
        ]);
    }

    
    
 
    public function actualizarUsuario($id, $nombre, $apellido, $email, $telefono, $edad, $rol_id, $clave) {
        // Validar ID
        if (empty($id) || !is_numeric($id)) {
            throw new Exception("El ID del usuario es inválido.");
        }
    
        // Validar nombre y apellido
        $this->validarTexto('nombre', $nombre);
        $this->validarTexto('apellido', $apellido);
    
        // Validar correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo electrónico no es válido.");
        }
    
        // Validar edad
        if (!is_numeric($edad) || $edad <= 0 || $edad > 120) {
            throw new Exception("La edad debe ser un número válido entre 1 y 120.");
        }
    
        // Verificar duplicados de email excluyendo al usuario actual
        $checkEmail = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id != :id";
        $stmt = $this->pdo->prepare($checkEmail);
        $stmt->execute([':email' => $email, ':id' => $id]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("El correo electrónico ya está registrado por otro usuario.");
        }
    
        // Construcción dinámica del SQL para actualizar solo la contraseña si se proporciona
        $sql = "UPDATE usuarios 
                SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, edad = :edad, rol_id = :rol_id" .
                (!empty($clave) ? ", clave = :clave" : "") .
                " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
    
        // Preparar parámetros dinámicamente
        $params = [
            ':id' => $id,
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':email' => $email,
            ':telefono' => $telefono,
            ':edad' => $edad,
            ':rol_id' => $rol_id
        ];
        if (!empty($clave)) {
            $params[':clave'] = $clave;
        }
    
        // Ejecutar la consulta
        $stmt->execute($params);
    }
    

    
    public function registrarcliente($nombre, $apellido, $email, $telefono, $edad, $rol_id, $clave) {
        $sql = "INSERT INTO usuarios (nombre, apellido, email, telefono, edad, rol_id, clave) 
                VALUES (:nombre, :apellido, :email, :telefono, :edad, :rol_id, :clave)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellido' => $apellido,
            ':email' => $email,
            ':telefono' => $telefono,
            ':edad' => $edad,
            ':rol_id' => $rol_id,
            ':clave' => $clave
        ]);
    }

    public function eliminarUsuario($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
    public function obtenerUsuarioPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function validarTexto($campo, $valor) {
        $soloLetrasRegex = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/";
        if (empty($valor) || !preg_match($soloLetrasRegex, $valor)) {
            throw new Exception("El campo {$campo} solo puede contener letras y espacios.");
        }
    }
    

    
}
?>
