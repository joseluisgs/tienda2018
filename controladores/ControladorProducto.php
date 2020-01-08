<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorProducto
 *
 * @author link
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once MODEL_PATH . "Producto.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorProducto {

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
            self::$instancia = new ControladorProducto();
        }
        return self::$instancia;
    }
    
    
    // Primitivas de la BD
    public function salvarProductoBD($producto){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "insert into productos (TIPO, MARCA, MODELO, DESCRIPCION, PRECIO, STOCK, OFERTA, FOTO) values "
                . "('" . $producto->getTipo() . "','" . $producto->getMarca() . "','" . $producto->getModelo() . 
                "','" . $producto->getDescripcion() ."', '" . $producto->getPrecio() ."', '" 
                . $producto->getStock() . "', '" . $producto->getStock() ."','" . $producto->getFoto() . "')";
        //echo $consulta;
        if($bd->actualizarBD($consulta)){
            $bd->cerrarBD();
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
     public function borrarProductoBD($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "delete from productos where id = " . $id;
        if($bd->consultarBD($consulta)){
            $bd->cerrarBD();
            return TRUE; 
        }else{
            return FALSE;
        }
        
    }
    
     public function actualizarProductoBD($producto){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "update productos set TIPO='" . $producto->getTipo() . "', MARCA='" . $producto->getMarca() . "', MODELO='" . $producto->getModelo() . "'"
                . ", DESCRIPCION='" . $producto->getDescripcion() ."', PRECIO='" . $producto->getPrecio() ."',  STOCK='" . $producto->getStock() ."',  "
                . "OFERTA='" . $producto->getOferta() ."',  FOTO='" . $producto->getFoto() . "' "
                . "where ID= " . $producto->getId();
        //echo $consulta;
        if($bd->actualizarBD($consulta)){
            $bd->cerrarBD();
            return TRUE;
        }else{
            return FALSE;
        }
    }



    public function buscarProductoID($id) {
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "select * from productos where id = '" . $id ."'";
        //echo $consulta;
        $filas = $bd->consultarBD($consulta);
        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $producto = new Producto($fila['ID'], $fila['TIPO'], $fila['MARCA'], $fila['MODELO'], $fila['DESCRIPCION'], $fila['PRECIO'], 
                        $fila['STOCK'], $fila['OFERTA'], $fila['FOTO']);
            }
            //$filas->free();
            $bd->cerrarBD();
            return $producto;
        } else {
            return null;
        }
    }
      
    
 public function getConsultaListado($marca, $modelo){
     return "select * from productos where marca like '%".$marca."%' or modelo like '%".$modelo."%'";
 }
 
 public function descargarProductos() {
        // Creamos la conexión a la BD
        $lista = [];
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        // creamos la consulta
        $consulta = "select * from productos";
        $filas = $bd->consultarBD($consulta);
        if ($filas->rowCount() > 0) {
            while ($fila = $filas->fetch()) {
                $producto = new Producto($fila['ID'], $fila['TIPO'], $fila['MARCA'], $fila['MODELO'], $fila['DESCRIPCION'], $fila['PRECIO'], 
                        $fila['STOCK'], $fila['OFERTA'], $fila['FOTO']);
                // Lo añadimos
                $lista[] = $producto;
            }
            //$filas->free();
            $bd->cerrarBD();
            return $lista;
        } else {
            return null;
        }
    }
    
    // Funciones de administrador
    public function crearProducto($tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $nombreFoto) {
            $producto = new Producto("", $tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $nombreFoto);
            if ($this->salvarProductoBD($producto)) {
                echo "<div class='wrapper'>";
                        echo "<div class='container-fluid'>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-12'>";
                                    echo "<div class='page-header'>";
                                         echo "<h1>Producto creado</h1>";
                                     echo "</div>";
                                    echo "<div class='alert alert-success fade in'>";
                                        echo "<p>Registro realizado de manera exitosa. Regresa a <a href='admin_listado_productos.php' class='alert-link'>listado</a> y sigue trabajando con los productos.</p>";
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
    
    
    public function borrarProducto($id) {
            if ($this->borrarProductoBD($id)) {
                echo "<div class='wrapper'>";
                        echo "<div class='container-fluid'>";
                            echo "<div class='row'>";
                                echo "<div class='col-md-12'>";
                                    echo "<div class='page-header'>";
                                         echo "<h1>Producto eliminado</h1>";
                                     echo "</div>";
                                    echo "<div class='alert alert-success fade in'>";
                                        echo "<p>Borrado realizado de manera exitosa. Regresa a <a href='admin_listado_productos.php' class='alert-link'>listado</a> y sigue trabajando con los productos.</p>";
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
    
    public function actualizarProducto($id, $tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $nombreFoto) {
        $producto = new Producto($id, $tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $nombreFoto);
        if ($this->actualizarProductoBD($producto)) {
            echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Producto modificado</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-success fade in'>";
                                    echo "<p>Actualización realizada de manera exitosa. Regresa a <a href='admin_listado_productos.php' class='alert-link'>listado</a> y sigue trabajando con los productos.</p>";
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


    public function serializarProducto($producto) {
        return (serialize($producto));
    }

    public function deserializarProducto($cadena) {
        return (unserialize($cadena));
    }
    
  

}
