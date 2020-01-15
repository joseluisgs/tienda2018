<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Venta
 *
 * @author link
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once MODEL_PATH . "Producto.php";
require_once MODEL_PATH . "LineaVenta.php";

class Venta {
    //put your code here
    private $idVenta;
    private $fecha;
    private $total;
    private $subtotal;
    private $iva;
    private $lineas;
    // Datos de usuario
    private $idUsuario;
    private $nombre;
    private $email;
    private $direccion;
    //Datos del pago
    private $nombreTarjeta;
    private $numTarjeta;
    
    

        
    
    public function __construct($venta, $usuario, $productos, $cantidades) {
        $this->idVenta=$venta;
        setlocale(LC_ALL, 'es_ES');
        $this->fecha = strftime("%d-%B-%Y");
        //$this->total = $this->calcularTotalVenta($productos, $cantidades);
        //$this->lineas = $this->asignarLineasVenta($productos, $cantidades);
        $this->idUsuario = $usuario->getId();
        $this->nombre = $usuario->getNombre();
        $this->email = $usuario->getEmail();
        $this->direccion = $usuario->getDireccion();
        // Completamos el importe económico y las líneas de venta
        $this->completarVenta($productos, $cantidades);
    }
    
    public function getIdVenta() {
        return $this->idVenta;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getSubtotal() {
        return $this->subtotal;
    }

    public function getIva() {
        return $this->iva;
    }

    public function getLineas() {
        return $this->lineas;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function setSubtotal($subtotal) {
        $this->subtotal = $subtotal;
    }

    public function setIva($iva) {
        $this->iva = $iva;
    }

    public function setLineas($lineas) {
        $this->lineas = $lineas;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    
    public function getNombreTarjeta() {
        return $this->nombreTarjeta;
    }

    public function getNumTarjeta() {
        return $this->numTarjeta;
    }

    public function setNombreTarjeta($nombreTarjeta) {
        $this->nombreTarjeta = $nombreTarjeta;
    }

    public function setNumTarjeta($numTarjeta) {
        $this->numTarjeta = $numTarjeta;
    }
    
    private function completarVenta($productos, $cantidades){
        $total=0;
        $lineas=array();
        $controlador= ControladorProducto::getControlador();

        for ($i = 0; $i < count($productos); $i++) {
            $id = substr($productos[$i], 2);
            $producto = $controlador->buscarProductoID($id);
            $total += $producto->getPrecio()*$cantidades[$i];
            // Construimos la linea de venta
            $linea = new LineaVenta($this, $producto, $cantidades[$i]);
            $lineas[]= $linea;
            
        }
        $this->total= round($total, 2);
        $this->subtotal = round($this->total/1.21, 2);
        $this->iva = ($this->total-$this->subtotal);
        $this->lineas=$lineas;
        
    }




}
