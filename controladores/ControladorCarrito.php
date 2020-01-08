<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorCarrito
 *
 * @author link
 */
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";

class ControladorCarrito {

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
     
    }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorCarrito();
        }
        return self::$instancia;
    }



    public function controlAccesoCarrito() {
        //session_start();
        if (!isset($_SESSION['USUARIO'])) {
            echo "<div class='wrapper'>";
            echo "<div class='container-fluid'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<div class='page-header'>";
            echo "<h1>No puede añadir producto al carrito</h1>";
            echo "</div>";
            echo "<div class='alert alert-danger fade in'>";
            echo "<p>Lo siento, las compras solo están permitidas a usuarios registrados. Por favor <a href='javascript:history.back()' class='alert-link'>regresa</a> y regístrese o identifíquese para realizar la compra.</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            //<!-- Pie de la página web -->
            require_once VIEW_PATH . "pie.php";
            exit();
        }
    }
    
    public function carritoVacio(){
        echo "<div class='wrapper'>";
            echo "<div class='container-fluid'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<div class='page-header'>";
            echo "<h1>El carito vacío</h1>";
            echo "</div>";
            echo "<div class='alert alert-warning fade in'>";
            echo "<p>El carrito se encuetra vacío en estos momentos, por lo que no se puede procesar. Por favor <a href='javascript:history.back()' class='alert-link'>regresa</a> y realice alguna compra para continuar.</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            //<!-- Pie de la página web -->
            require_once VIEW_PATH . "pie.php";
            exit();
    }

    
   

    public function añadirItem($id) {
        //session_start();
        if (isset($_SESSION['CARRITO'])) {
            $viejoCarrito = $_SESSION['CARRITO'];
            $_SESSION['CARRITO'] = $viejoCarrito . $id . '%';
        } else {
            //si no existe lo crea. Se crea en el momento de la primera compra.
            $_SESSION['CARRITO'] = $id . '%';
        }
        // Si existe la cookie la borro
        if (isset($_COOKIE['CARRITO'])) {
            unset($_COOKIE['CARRITO']);
            setcookie("CARRITO", '', time() - 3600);
            setcookie("CARRITO", $_SESSION['CARRITO'], time() + 3600 * 24 * 2); // Una hora * 24 horas * 2 días
        } else {
            setcookie("CARRITO", $_SESSION['CARRITO'], time() + 3600 * 24 * 2); // Una hora * 24 horas * 2 días
        }
    }

    public function leerCarritoCookie() {
        if (!isset($_SESSION['CARRITO'])) {
            $_SESSION['CARRITO'] = $_COOKIE['CARRITO'];
        }
    }

    function getListaItems() {
        $carrito = 0;
        if (isset($_SESSION['CARRITO'])) {

            if ($_SESSION['CARRITO'] != "") {
                $carrito = $_SESSION['CARRITO'];
                $carrito = (explode('%', trim($carrito, '%')));
            }
        }
        return $carrito;
    }

    function getTotalItems() {
        $num = 0;
        if ($tal = $this->getListaItems()) {
            $num = count($tal);
        }

        return $num;
    }

    function getCantidadPorItem() {
        $carrito = $this->getListaItems();
        //elimina los valores duplicados de un array; Repaso de tema 1
        $carrito = array_unique($carrito);
        $carrito = array_flip($carrito);
        reset($carrito); //establece el puntero del array a su primera posicion. PUEDE QUE NO SEA NECESARIO.

        foreach ($carrito as $clave => $valor) {
            // Contamos para cada clave la cantidad que hay
            $carrito[$clave] = (substr_count($_SESSION['CARRITO'], $clave));
        }
        return $carrito;
    }
    
    public function getItem($id, $cantidad){
        $contProducto = ControladorProducto::getControlador();
        $producto= $contProducto->buscarProductoID($id);
        echo "<div class = 'col-xs-12 col-sm-6 col-md-3'>";
            echo "<div class = 'thumbnail' >";
                echo "<h4 class = 'text-center' class = 'text-primary'>".$producto->getMarca(). " ".$producto->getModelo()."</h4>";
                echo "<img src = '".PICTURE_PATH.$producto->getFoto()."' class = 'img-responsive'>";
                //echo "<p class = 'text-justify'>".str_replace("\n", "<br/>",utf8_encode(substr($producto->getDescripcion(),0,125)))."...</p>";
                echo "<p class = 'text-justify'>".utf8_encode(substr($producto->getDescripcion(),0,117))."...</p>";
                echo "<div class = 'text-center'>";
                    echo "<h4 class = 'text-danger'>".$producto->getPrecio()."€</h4>";
                    echo "<a href = 'catalogo_producto.php?id=" . base64_encode($producto->getId()) . "' class = 'btn btn-info'><span class = 'glyphicon glyphicon-eye-open'></span> Ver más</a> ";
                    //echo "<a href = 'carrito_añadir.php?id=" .base64_encode($producto->getId()). "' class = 'btn btn-success'><span class = 'glyphicon glyphicon-shopping-cart'></span> Comprar</a>";
                    echo "<a href = 'carrito_añadir.php?id=" .base64_encode($producto->getId()). "&dest=".$pagina."' onclick='procesarCompra(".($itemsCarrito+1).");' class = 'btn btn-success'><span class = 'glyphicon glyphicon-shopping-cart'></span> Comprar</a>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }

}
