<?php
//autor: Contreras Suarez Jordan Alexis
class Producto {
    private $id, $nombre, $descripcion, $estado, $precio, $stock, $categoria, $usuario, $fechaCreacion, $fechaActualizacion;

    function __construct() { }

    // Getters
    function getId() { return $this->id; }
    function getNombre() { return $this->nombre; }
    function getDescripcion() { return $this->descripcion; }
    function getEstado() { return $this->estado; }
    function getPrecio() { return $this->precio; }
    function getStock() { return $this->stock; }
    function getCategoria() { return $this->categoria; }
    function getUsuario() { return $this->usuario; }
    function getFechaCreacion() { return $this->fechaCreacion; }
    function getFechaActualizacion() { return $this->fechaActualizacion; }

    // Setters
    function setId($id) { $this->id = $id; }
    function setNombre($nombre) { $this->nombre = $nombre; }
    function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    function setEstado($estado) { $this->estado = $estado; }
    function setPrecio($precio) { $this->precio = $precio; }
    function setStock($stock) { $this->stock = $stock; }
    function setCategoria($categoria) { $this->categoria = $categoria; }
    function setUsuario($usuario) { $this->usuario = $usuario; }
    function setFechaCreacion($fechaCreacion) { $this->fechaCreacion = $fechaCreacion; }
    function setFechaActualizacion($fechaActualizacion) { $this->fechaActualizacion = $fechaActualizacion; }
}
?>
