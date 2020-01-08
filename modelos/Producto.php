<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author link
 */
class Producto implements Serializable {
    //put your code here
    private $id;
    private $tipo;
    private $marca;
    private $modelo;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $foto;


    public function __construct($id, $tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $foto) {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->oferta = $oferta;
        $this->foto = $foto;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getOferta() {
        return $this->oferta;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function setOferta($oferta) {
        $this->oferta = $oferta;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

       
    // Para serializar unos objetos, y no pasar el ID y ahorrarme una consulta
    // NO hace falta definirlo, el por defecto.
    public function serialize(){
        return serialize([
            $this->id,
            $this->tipo,
            $this->marca,
            $this->modelo,
            //$this->descripcion,
            $this->precio,
            $this->stock,
            $this->oferta,
            $this->foto,
        ]);
    }

    public function unserialize($serialized) {
        list(
            $this->id,
            $this->tipo,
            $this->marca,
            $this->modelo,
            //$this->descripcion,
            $this->precio,
            $this->stock,
            $this->oferta,
            $this->foto
        ) = unserialize($serialized);
    }

}

