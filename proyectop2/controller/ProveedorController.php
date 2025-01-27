<?php
 //autor:Cobo Abril Alvaro Norberto

require_once('../model/dto/Proveedor.php');

require_once '../model/dao/ProveedorDAO.php';

class ProveedorController {
    private $dao;

    public function __construct() {
        $this->dao = new ProveedorDAO();
    }

    // Método para mostrar el formulario de registro de un proveedor
    public function mostrarFormularioProveedor() {
        include_once('../view/Proveedor/registrar.php');
    }

    
    public function guardarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $errores = [];
            
            
            if (empty($_POST['nomPro'])) {
                $errores['nomPro'] = "El nombre del proveedor es obligatorio.";
            } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['nomPro'])) {
                $errores['nomPro'] = "El nombre del proveedor solo puede contener letras y espacios.";
            }
        
            
            if (empty($_POST['apellidoPro'])) {
                $errores['apellidoPro'] = "El apellido del proveedor es obligatorio.";
            } elseif (!preg_match("/^[a-zA-Z\s]+$/", $_POST['apellidoPro'])) {
                $errores['apellidoPro'] = "El apellido del proveedor solo puede contener letras y espacios.";
            }
        
            
            if (empty($_POST['correoPro'])) {
                $errores['correoPro'] = "El correo electrónico del proveedor es obligatorio.";
            } elseif (!filter_var($_POST['correoPro'], FILTER_VALIDATE_EMAIL)) {
                $errores['correoPro'] = "El correo electrónico no es válido.";
            }
        
           
            if (empty($_POST['telefonoPro']) || !preg_match("/^\d{10}$/", $_POST['telefonoPro'])) {
                $errores['telefonoPro'] = "El teléfono debe ser un número de 10 dígitos.";
            }
        
            
            if (empty($_POST['productoID']) ) {
                $errores['productoID'] = "El producto es obligatorio.";
            }
        
            
            if (empty($_POST['nomCalle1'])) {
                $errores['nomCalle1'] = "El nombre de la primera calle es obligatorio.";
            }
        
            
            if (empty($_POST['nomCalle2'])) {
                $errores['nomCalle2'] = "El nombre de la segunda calle es obligatorio.";
            }
        
            
            if (empty($_POST['codigoPostal']) || !preg_match("/^\d{6}$/", $_POST['codigoPostal'])) {
                $errores['codigoPostal'] = "El código postal debe ser un número de 6 dígitos.";
            }
        
            
            if (!empty($errores)) {
                $titulo = "Nuevo Proveedor";
                require_once '../view/Proveedor/registrar.php';
                return;
            }
        $proveedor = new Proveedor();
        $proveedor->setNomPro($_POST['nomPro']);
        $proveedor->setApellidoPro($_POST['apellidoPro']);
        $proveedor->setCorreoPro($_POST['correoPro']);
        $proveedor->setTelefonoPro($_POST['telefonoPro']);
        $proveedor->setEstado($_POST['estado']);
        $proveedor->setProductoID($_POST['productoID']);
        $proveedor->setNomCalle1($_POST['nomCalle1']);
        $proveedor->setNomCalle2($_POST['nomCalle2']);
        $proveedor->setCodigoPostal($_POST['codigoPostal']);
        
        $proveedorDAO = new ProveedorDAO();
        try {
            $exito = $proveedorDAO->insertt($proveedor); 
            if ($exito) {
                header("Location: proveedores.php?c=proveedores&f=index");
                exit;
            } else {
                echo "Error al insertar proveedor.";
            }
        } catch (Exception $e) {
            echo "Error al insertar proveedor: " . $e->getMessage();
        }
    } else {
        // Cargar la vista inicial para un nuevo producto
        $titulo = "Nuevo Proveedor";
        $errores = [];
        require_once '../view/Proveedor/registrar.php';
    }
    }

    public function index() {
        $resultados = $this->dao->SelectAll("");
        $titulo = "Gestión de Proveedores";
        require_once '../view/Proveedor/list.php'; 
    }
    
    // Método para mostrar el formulario de edición
    public function mostrarFormularioEdicion() {
        $id = $_GET['id'];
        $proveedor = $this->dao->obtenerProveedorPorId($id);  // Método para obtener el producto por ID
        require_once '../view/Proveedor/editar.php';
    }

    // Método para actualizar un proveedor
    public function actualizarProveedor() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'];
    
            $errores = [];
    
            // Validar cada campo
            if (empty($_POST['nomPro'])) {
                $errores['nomPro'] = "El nombre es obligatorio.";
            }
            if (empty($_POST['apellidoPro'])) {
                $errores['apellidoPro'] = "El apellido es obligatorio.";
            }
            if (empty($_POST['correoPro']) || !filter_var($_POST['correoPro'], FILTER_VALIDATE_EMAIL)) {
                $errores['correoPro'] = "El correo no es válido.";
            }
            if (empty($_POST['telefonoPro']) || !preg_match("/^[0-9]{7,15}$/", $_POST['telefonoPro'])) {
                $errores['telefonoPro'] = "El teléfono debe ser numérico.";
            }
    
            // Si hay errores, mostrar la vista de edición con errores
            if (!empty($errores)) {
                require_once '../view/Proveedor/editar.php';
                return;
            }
    
            // Crear el objeto proveedor
            $proveedor = new Proveedor();
            $proveedor->setId($id);
            $proveedor->setNomPro($_POST['nomPro']);
            $proveedor->setApellidoPro($_POST['apellidoPro']);
            $proveedor->setCorreoPro($_POST['correoPro']);
            $proveedor->setTelefonoPro($_POST['telefonoPro']);
            $proveedor->setEstado($_POST['estado']);
            $proveedor->setProductoID($_POST['productoID']);
            $proveedor->setNomCalle1($_POST['nomCalle1']);
            $proveedor->setNomCalle2($_POST['nomCalle2']);
            $proveedor->setCodigoPostal($_POST['codigoPostal']);
           
    
            $proveedoresDAO = new ProveedorDAO();
            try {
                $exito = $proveedoresDAO->update($proveedor);
                if ($exito) {
                    header("Location: proveedores.php?c=proveedores&f=index");
                    exit;
                } else {
                    echo "Error al actualizar el proveedor.";
                }
            } catch (Exception $e) {
                echo "Error al actualizar proveedor: " . $e->getMessage();
            }
        }
    }

    // Método para eliminar un proveedor
    public function eliminarProveedor() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $resultado = $this->dao->deleteProveedor($id);        
                $resultados = $this->dao->selectAll(""); 
                $titulo = "Lista de Proveedores";
                require_once('../view/Proveedor/list.php'); 
            } catch (Exception $e) {
                echo "Error al eliminar el proveedor: " . $e->getMessage();
            }
        }
    }

    public function buscar() {
        
            $b = isset($_GET['b']) ? $_GET['b'] : '';
        
        // Llamamos al modelo para obtener los productos que coinciden con la búsqueda
            $resultados = $this->dao->selectAll($b);
        
            if (!empty($resultados)) {
                foreach ($resultados as $proveedor) {
                    echo "<tr>";
                    echo "<td>" . $proveedor['id'] . "</td>";
                    echo "<td>" . $proveedor['nomPro'] . "</td>";
                    echo "<td>" . $proveedor['apellidoPro'] . "</td>";
                    echo "<td>" . $proveedor['telefonoPro'] . "</td>";
                    echo "<td>" . $proveedor['correoPro'] . "</td>";
                    echo "<td>" . $proveedor['estado'] . "</td>";
                    echo "<td>" . $proveedor['productoID'] . "</td>";
                    echo "<td>" . $proveedor['nomCalle1'] . "</td>";
                    echo "<td>" . $proveedor['nomCalle2'] . "</td>";
                    echo "<td>" . $proveedor['codigoPostal'] . "</td>";
                    echo "<td>
                            <a href='proveedores.php?c=proveedores&f=mostrarFormularioEdicion&id=" . $proveedor['id'] . "' style='background-color: #007BFF; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;'>Editar</a>
                            <a href='proveedores.php?c=proveedores&f=eliminarProveedor&id=" . $proveedor['id'] . "' onclick='return confirm(\"¿Está seguro de eliminar al proveedor seleccionado?\");' style='background-color: #dc3545; color: white; padding: 5px 10px; text-decoration: none; border-radius: 5px;'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No se encontraron proveedores</td></tr>";
            }
        
            }
}
?>