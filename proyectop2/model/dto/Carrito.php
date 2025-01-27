<?php
//autor: Contreras Suarez Jordan Alexis
class Carrito {
    private $id;                 // ID único para cada registro del carrito
    private $usuarioId;          // ID del usuario que añadió el producto
    private $nombreUsuario;      // Nombre del usuario
    private $productoId;         // ID del producto añadido
    private $nombreProducto;     // Nombre del producto
    private $descripcion;        // Descripción del producto
    private $precio;             // Precio del producto
    private $fechaAgregado;      // Fecha en que se añadió al carrito

    // Getters y Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function setUsuarioId($usuarioId) {
        $this->usuarioId = $usuarioId;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function getProductoId() {
        return $this->productoId;
    }

    public function setProductoId($productoId) {
        $this->productoId = $productoId;
    }

    public function getNombreProducto() {
        return $this->nombreProducto;
    }

    public function setNombreProducto($nombreProducto) {
        $this->nombreProducto = $nombreProducto;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getFechaAgregado() {
        return $this->fechaAgregado;
    }

    public function setFechaAgregado($fechaAgregado) {
        $this->fechaAgregado = $fechaAgregado;
    }
}
?>
