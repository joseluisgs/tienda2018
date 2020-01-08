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
class Usuario implements Serializable {
    //put your code here
    private $id;
    private $nombre;
    private $pass;
    private $email;
    private $direccion;
    private $foto;
    private $admin;

    
    
    public function __construct($id, $nombre, $pass, $email, $direccion, $foto, $admin) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->pass = $pass;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->foto = $foto;
        $this->admin = $admin;
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }
    

    function getEmail() {
        return $this->email;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }


    function setEmail($email) {
        $this->email = $email;
    }
    
    
    function getFoto() {
        return $this->foto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }
    
    function getPass() {
        return $this->pass;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getAdmin() {
        return $this->admin;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setDireccion($dir) {
        $this->direccion = $direccion;
    }

    function setAdmin($admin) {
        $this->admin = $admin;
    }

            
    // Para serializar unos objetos, y no pasar el ID y ahorrarme una consulta
    // NO hace falta definirlo, el por defecto.
    public function serialize(){
        return serialize([
            $this->id,
            $this->nombre,
            $this->pass,
            $this->email,
            $this->direccion,
            $this->foto,
            $this->admin,
        ]);
    }

    public function unserialize($serialized) {
        list(
            $this->id,
            $this->nombre,
            $this->pass,
            $this->email,
            $this->direccion,
            $this->foto,
            $this->admin
        ) = unserialize($serialized);
    }

}

