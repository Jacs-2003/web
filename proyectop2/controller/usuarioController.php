<?php
//autor:Castro Agudo Ricardo
session_start();
require_once '../config/Conexion.php';
require_once '../model/UsuarioDAO.php';

$dao = new UsuarioDAO($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
                
                case 'login':
                        $email = trim($_POST['email']);
                        $clave = trim($_POST['clave']);
                        $usuario = $dao->autenticar($email, $clave);

                        if ($usuario) {
                            $_SESSION['usuario'] = $usuario;
                            header('Location: ../view/dashboard.php');
                            exit();
                        } else {
                            $_SESSION['error'] = 'Correo o contraseña incorrectos.';
                            header('Location: ../view/login.php');
                            exit();
                        }
                        break;
                
                        case 'register':
                            try {
                                // Validación del nombre y apellido: solo letras y espacios
                                $soloLetrasRegex = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/";
                                if (!preg_match($soloLetrasRegex, $_POST['nombre'])) {
                                    throw new Exception('El nombre solo puede contener letras y espacios.');
                                }
                                if (!preg_match($soloLetrasRegex, $_POST['apellido'])) {
                                    throw new Exception('El apellido solo puede contener letras y espacios.');
                                }
                        
                                // Validaciones adicionales
                                if (empty($_POST['nombre']) || strlen($_POST['nombre']) > 50) {
                                    throw new Exception('El nombre es obligatorio y no debe superar los 50 caracteres.');
                                }
                                if (empty($_POST['apellido']) || strlen($_POST['apellido']) > 50) {
                                    throw new Exception('El apellido es obligatorio y no debe superar los 50 caracteres.');
                                }
                                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                    throw new Exception('El correo electrónico no es válido.');
                                }
                                if (empty($_POST['telefono']) || !preg_match('/^[0-9]{7,10}$/', $_POST['telefono'])) {
                                    throw new Exception('El teléfono debe tener entre 7 y 10 dígitos.');
                                }
                                if (!is_numeric($_POST['edad']) || $_POST['edad'] <= 0 || $_POST['edad'] > 120) {
                                    throw new Exception('La edad debe ser un número válido entre 1 y 120.');
                                }
                                if (strlen($_POST['clave']) < 6) {
                                    throw new Exception('La contraseña debe tener al menos 6 caracteres.');
                                }
                        
                                // Llamar al modelo para registrar al usuario
                                $dao->registrarUsuario(
                                    $_POST['nombre'],
                                    $_POST['apellido'],
                                    $_POST['email'],
                                    $_POST['telefono'],
                                    $_POST['edad'],
                                    $_POST['rol_id'],
                                    $_POST['clave']
                                );
                        
                                // Redirigir a usuarios.php después del registro exitoso
                                $_SESSION['mensaje'] = 'Usuario registrado exitosamente.';
                                $_SESSION['color'] = 'success';
                                header('Location: ../view/usuarios.php');
                                exit();
                        
                            } catch (Exception $e) {
                                // Manejar errores y redirigir al formulario con un mensaje de error
                                $_SESSION['error'] = $e->getMessage();
                                $_SESSION['color'] = 'danger';
                                header('Location: ../view/adminRegisterUser.php');
                                exit();
                            }
                        
                
                    
    case 'update':
                        try {
                            // Validar ID
                            if (empty($_POST['id']) || !is_numeric($_POST['id'])) {
                                throw new Exception('El ID del usuario es inválido.');
                            }
                    
                            // Validación del nombre y apellido: solo letras y espacios
                            $soloLetrasRegex = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/";
                            if (!preg_match($soloLetrasRegex, $_POST['nombre'])) {
                                throw new Exception('El nombre solo puede contener letras y espacios.');
                            }
                            if (!preg_match($soloLetrasRegex, $_POST['apellido'])) {
                                throw new Exception('El apellido solo puede contener letras y espacios.');
                            }
                    
                            // Validar longitud de nombre y apellido
                            if (strlen($_POST['nombre']) > 50) {
                                throw new Exception('El nombre no debe superar los 50 caracteres.');
                            }
                            if (strlen($_POST['apellido']) > 50) {
                                throw new Exception('El apellido no debe superar los 50 caracteres.');
                            }
                    
                            // Validar correo electrónico
                            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                throw new Exception('El correo electrónico no es válido.');
                            }
                    
                            // Validar edad
                            if (!is_numeric($_POST['edad']) || $_POST['edad'] <= 0 || $_POST['edad'] > 120) {
                                throw new Exception('La edad debe ser un número válido entre 1 y 120.');
                            }
                    
                            // Validar rol
                            if (empty($_POST['rol_id']) || !is_numeric($_POST['rol_id'])) {
                                throw new Exception('El rol seleccionado es inválido.');
                            }
                    
                            // Validar contraseña si se proporciona
                            if (!empty($_POST['clave']) && strlen($_POST['clave']) < 6) {
                                throw new Exception('La contraseña debe tener al menos 6 caracteres.');
                            }
                    
                            // Llamar al modelo para actualizar el usuario
                            $dao->actualizarUsuario(
                                $_POST['id'],         // ID del usuario a actualizar
                                $_POST['nombre'],     // Nombre editado
                                $_POST['apellido'],   // Apellido editado
                                $_POST['email'],      // Email editado
                                $_POST['telefono'],   // Teléfono editado
                                $_POST['edad'],       // Edad editada
                                $_POST['rol_id'],     // Nuevo rol seleccionado
                                $_POST['clave']       // Contraseña editada (opcional)
                            );
                    
                            // Redirigir al listado de usuarios después de actualizar
                            header('Location: ../view/usuarios.php');
                        } catch (Exception $e) {
                            // Capturar errores y redirigir al formulario de edición con el mensaje
                            $_SESSION['error'] = $e->getMessage();
                            header('Location: ../view/edit_user.php?id=' . $_POST['id']);
                        }
                        exit();
                                       
                                    

 
                
            
            case 'delete':
                    $dao->eliminarUsuario($_POST['id']);
                    header('Location: ../view/usuarios.php');
                    exit();

                
                    case 'delete':
                        $dao->eliminarUsuario($_POST['id']);
                        header('Location: ../view/usuarios.php');
                        exit();
    
                    
                        case 'registercliente':
                            // Validación de datos enviados por POST
                            $nombre = trim($_POST['nombre']);
                            $apellido = trim($_POST['apellido']);
                            $email = trim($_POST['email']);
                            $telefono = trim($_POST['telefono']);
                            $edad = (int)$_POST['edad'];
                            $clave = trim($_POST['clave']);
                            
                            // Validaciones básicas
                            if (empty($nombre) || empty($apellido) || empty($email) || empty($telefono) || empty($edad) || empty($clave)) {
                                // Redirige con un mensaje de error si hay campos vacíos
                                header('Location: ../view/register.php?error=Campos incompletos');
                                exit();
                            }
                        
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                // Redirige con un mensaje de error si el correo no es válido
                                header('Location: ../view/register.php?error=Correo no válido');
                                exit();
                            }
                        
                            if (!preg_match('/^\d{10}$/', $telefono)) {
                                // Valida que el teléfono tenga 10 dígitos
                                header('Location: ../view/register.php?error=Teléfono inválido');
                                exit();
                            }
                        
                            if ($edad < 0|| $edad > 120) {
                                // Valida que la edad esté dentro de un rango razonable
                                header('Location: ../view/register.php?error=Edad no válida');
                                exit();
                            }
                        
                            if (strlen($clave) < 6) {
                                // Valida que la contraseña tenga al menos 6 caracteres
                                header('Location: ../view/register.php?error=Contraseña muy corta');
                                exit();
                            }
                        
                            if ($dao->emailExiste($email)) {
                                header('Location: ../view/register.php?error=El correo ya está registrado');
                                exit();
                            }
                            // Llama al modelo para registrar al cliente
                            $dao->registrarCliente(
                                $nombre,
                                $apellido,
                                $email,
                                $telefono,
                                $edad,
                                3, // Rol predeterminado: Cliente
                                $clave
                            );
                        
                            header('Location: ../view/usuarios.php?success=Usuario registrado exitosamente');
                            exit();
                            break;
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ../view/index.php'); // Redirige al inicio
    exit();
}
?>
