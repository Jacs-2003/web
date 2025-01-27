<?php
//autor: Garcia Alex
class Compra {
    private $usuarioId;
    private $productoId;
    private $cedula;
    private $numeroTarjeta;
    private $cvv;
    private $ciudad;
    private $pais;
    private $fechaCompra;

    public function getUsuarioId() { return $this->usuarioId; }
    public function setUsuarioId($usuarioId) { $this->usuarioId = $usuarioId; }

    public function getProductoId() { return $this->productoId; }
    public function setProductoId($productoId) { $this->productoId = $productoId; }

    public function getCedula() { return $this->cedula; }
    public function setCedula($cedula) { $this->cedula = $cedula; }

    public function getNumeroTarjeta() { return $this->numeroTarjeta; }
    public function setNumeroTarjeta($numeroTarjeta) { $this->numeroTarjeta = $numeroTarjeta; }

    public function getCvv() { return $this->cvv; }
    public function setCvv($cvv) { $this->cvv = $cvv; }

    public function getCiudad() { return $this->ciudad; }
    public function setCiudad($ciudad) { $this->ciudad = $ciudad; }

    public function getPais() { return $this->pais; }
    public function setPais($pais) { $this->pais = $pais; }

    public function getFechaCompra() { return $this->fechaCompra; }
    public function setFechaCompra($fechaCompra) { $this->fechaCompra = $fechaCompra; }
}
?>
