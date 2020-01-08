<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorUsuario
 *
 * @author link
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once MODEL_PATH . "Usuario.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorUsuario {

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorUsuario();
        }
        return self::$instancia;
    }
    
    
    // Primitivas de la BD
    public function salvarUsuarioBD($usuario){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "insert into usuarios (NOMBRE, PASS, EMAIL, DIRECCION, FOTO, ADMIN) values ('" . $usuario->getNombre() . "','" . $usuario->getPass() . "','" . $usuario->getEmail() . "','" 
                . $usuario->getDireccion() ."', '" . $usuario->getFoto() . "','" . $usuario->getAdmin() ."')";
        //echo $consulta;
        if($bd->actualizarBD($consulta)){
            $bd->cerrarBD();
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
     public function borrarUsuarioBD($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "delete from usuarios where id = " . $id;
        if($bd->consultarBD($consulta)){
            $bd->cerrarBD();
            return TRUE; 
        }else{
            return FALSE;
        }
        
    }
    
     public function actualizarUsuarioBD($usuario){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "update usuarios set NOMBRE='" . $usuario->getNombre() . "', PASS='" . $usuario->getPass() . "', EMAIL='" . $usuario->getEmail() . "', DIRECCION='" . $usuario->getDireccion() ."', FOTO='" . $usuario->getFoto() . "', ADMIN='" . $usuario->getAdmin() ."' where ID= " . $usuario->getId();
        //echo $consulta;
        if($bd->actualizarBD($consulta)){
            $bd->cerrarBD();
            return TRUE;
        }else{
            return FALSE;
        }
    }



    public function buscarUsuarioEmail($email) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "select * from usuarios where email = '" . $email ."'";
        $filas = $bd->consultarBD($consulta);
        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $usuario = new Usuario($fila['ID'], $fila['NOMBRE'], $fila['PASS'], $fila['EMAIL'], $fila['DIRECCION'], $fila['FOTO'], $fila['ADMIN']);
                // Lo añadimos
            }
            //$filas->free();
            $bd->cerrarBD();
            return $usuario;
        } else {
            return null;
        }
    }
    
    public function buscarUsuarioID($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "select * from usuarios where ID = '" . $id ."'";
        $filas = $bd->consultarBD($consulta);
        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $usuario = new Usuario($fila['ID'], $fila['NOMBRE'], $fila['PASS'], $fila['EMAIL'], $fila['DIRECCION'], $fila['FOTO'], $fila['ADMIN']);
                // Lo añadimos
            }
            //$filas->free();
            $bd->cerrarBD();
            return $usuario;
        } else {
            return null;
        }
    }
    
    
    
    // Controlador de la parte de Registro
    public function almacenarUsuario($nombre, $pass, $email, $direccion, $foto) {
        $usuario = new Usuario("", $nombre, $pass, $email, $direccion, $foto, 0);
        if ($this->salvarUsuarioBD($usuario)) {
            echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a creado</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-success fade in'>";
                                    echo "<p>Registro realizado de manera exitosa. Por favor <a href='/tienda/vistas/identificacion.php' class='alert-link'>identíficate</a> y entra a la tienda.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
            echo "</div>";
            //<!-- Pie de la página web -->
            require_once VIEW_PATH."pie.php";
            exit();
    } else {
        header("location: error.php");
        exit();
    }
        
 }
 

    
    public function actualizarFichaUsuario($id, $nombre, $pass, $email, $direccion, $foto, $admin) {
        $usuario = new Usuario($id, $nombre, $pass, $email, $direccion, $foto, $admin);
        if ($this->actualizarUsuarioBD($usuario)) {
            echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a modificado</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-success fade in'>";
                                    echo "<p>Actualización realizada de manera exitosa. Por favor <a href='/tienda/vistas/identificacion.php' class='alert-link'>identíficate</a> y entra a la tienda.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
            echo "</div>";
            //<!-- Pie de la página web -->
            require_once VIEW_PATH."pie.php";
            exit();
    } else {
        header("location: error.php");
        exit();
    }
        
 }
 
 public function getConsultaListado($nombre, $email){
     return "select * from usuarios where nombre like '%".$nombre."%' or email like '%".$email."%'";
 }
 
 public function descargarUsuarios() {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "select * from usuarios";
        $filas = $bd->consultarBD($consulta);
        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $usuario = new Usuario($fila['ID'], $fila['NOMBRE'], $fila['PASS'], $fila['EMAIL'], $fila['DIRECCION'], $fila['FOTO'], $fila['ADMIN']);
                // Lo añadimos
                $lista[] = $usuario;
            }
            //$filas->free();
            $bd->cerrarBD();
            return $lista;
        } else {
            return null;
        }
    }
    
    // Funciones de administrador
    public function crearUsuario($nombre, $pass, $email, $direccion, $foto, $admin) {
            $usuario = new Usuario("", $nombre, $pass, $email, $direccion, $foto, $admin);
            if ($this->salvarUsuarioBD($usuario)) {
                echo "<div class='wrapper'>";
                        echo "<div class='container-fluid'>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-12'>";
                                    echo "<div class='page-header'>";
                                         echo "<h1>Usuario/a creado</h1>";
                                     echo "</div>";
                                    echo "<div class='alert alert-success fade in'>";
                                        echo "<p>Registro realizado de manera exitosa. Regresa a <a href='admin_listado_usuarios.php' class='alert-link'>listado</a> y sigue trabajando con los usuarios/as.</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                echo "</div>";
                //<!-- Pie de la página web -->
                require_once VIEW_PATH."pie.php";
                exit();
        } else {
            header("location: error.php");
            //exit();
        }
    }
    
    
    public function borrarUsuario($id) {
            if ($this->borrarUsuarioBD($id)) {
                echo "<div class='wrapper'>";
                        echo "<div class='container-fluid'>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-12'>";
                                    echo "<div class='page-header'>";
                                         echo "<h1>Usuario/a eliminado</h1>";
                                     echo "</div>";
                                    echo "<div class='alert alert-success fade in'>";
                                        echo "<p>Borrado realizado de manera exitosa. Regresa a <a href='admin_listado_usuarios.php' class='alert-link'>listado</a> y sigue trabajando con los usuarios/as.</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                echo "</div>";
                //<!-- Pie de la página web -->
                require_once VIEW_PATH."pie.php";
                //exit();
        } else {
            header("location: error.php");
            exit();
        }
    }
    
    public function actualizarUsuario($id, $nombre, $pass, $email, $direccion, $foto, $admin) {
        $usuario = new Usuario($id, $nombre, $pass, $email, $direccion, $foto, $admin);
        if ($this->actualizarUsuarioBD($usuario)) {
            echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a modificado</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-success fade in'>";
                                    echo "<p>Actualización realizada de manera exitosa. Regresa a <a href='admin_listado_usuarios.php' class='alert-link'>listado</a> y sigue trabajando con los usuarios/as.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
            echo "</div>";
            //<!-- Pie de la página web -->
            require_once VIEW_PATH."pie.php";
            //exit();
    } else {
        header("location: error.php");
        exit();
    }
        
 }


    public function serializarUsuario($usuario) {
        return (serialize($usuario));
    }

    public function deserializarUsuario($cadena) {
        return (unserialize($cadena));
    }
    
  

}
