<?php
 //autor:Cobo Abril Alvaro Norberto
class Proveedor{
    private $id, $nomPro, $apellidoPro, $correoPro, $telefonoPro, $estado, $productoID, $nomCalle1, $nomCalle2, $codigoPostal;

        // Getter y Setter para id
        public function getId() {
            return $this->id;
        }
    
        public function setId($id) {
            $this->id = $id;
        }
    
        // Getter y Setter para nomPro
        public function getNomPro() {
            return $this->nomPro;
        }
    
        public function setNomPro($nomPro) {
            $this->nomPro = $nomPro;
        }
    
        // Getter y Setter para apellidoPro
        public function getApellidoPro() {
            return $this->apellidoPro;
        }
    
        public function setApellidoPro($apellidoPro) {
            $this->apellidoPro = $apellidoPro;
        }
    
        // Getter y Setter para correoPro
        public function getCorreoPro() {
            return $this->correoPro;
        }
    
        public function setCorreoPro($correoPro) {
            $this->correoPro = $correoPro;
        }
    
        // Getter y Setter para telefonoPro
        public function getTelefonoPro() {
            return $this->telefonoPro;
        }
    
        public function setTelefonoPro($telefonoPro) {
            $this->telefonoPro = $telefonoPro;
        }
    
        // Getter y Setter para estado
        public function getEstado() {
            return $this->estado;
        }
    
        public function setEstado($estado) {
            $this->estado = $estado;
        }
    
        // Getter y Setter para productoID
        public function getProductoID() {
            return $this->productoID;
        }
    
        public function setProductoID($productoID) {
            $this->productoID = $productoID;
        }
    
        // Getter y Setter para nomCalle1
        public function getNomCalle1() {
            return $this->nomCalle1;
        }
    
        public function setNomCalle1($nomCalle1) {
            $this->nomCalle1 = $nomCalle1;
        }
    
        // Getter y Setter para nomCalle2
        public function getNomCalle2() {
            return $this->nomCalle2;
        }
    
        public function setNomCalle2($nomCalle2) {
            $this->nomCalle2 = $nomCalle2;
        }
    
        // Getter y Setter para codigoPostal
        public function getCodigoPostal() {
            return $this->codigoPostal;
        }
    
        public function setCodigoPostal($codigoPostal) {
            $this->codigoPostal = $codigoPostal;
        }
}

?>

