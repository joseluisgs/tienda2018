<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LineaVenta
 *
 * @author link
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once MODEL_PATH . "Venta.php";

class LineaVenta {
    //put your code here
    private $idVenta;
    // Datos del producto
    private $idProducto;
    private $marca;
    private $modelo;
    private $precio;
    private $cantidad;
    private $total;
    
    public function __construct($venta, $producto, $cantidad) {
        $this->idVenta = $venta->getIdVenta();
        $this->idProducto = $producto->getId();
        $this->marca = $producto->getMarca();
        $this->modelo = $producto->getModelo();
        $this->precio = round($producto->getPrecio(),2);
        $this->cantidad = $cantidad;
        $this->total = round($cantidad*$producto->getPrecio());
    }
    
    public function getIdVenta() {
        return $this->idVenta;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function setTotal($total) {
        $this->total = $total;
    }



}
