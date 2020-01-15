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
require_once MODEL_PATH . "Venta.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "ControladorBD.php";

class ControladorCarrito {

    // Variable instancia para Singleton
    static private $instancia = null;
    static public $precioTotal=0;
    static private $venta = null;

    // constructor--> Private por el patrón Singleton
    private function __construct() {
        self::$precioTotal=0;

     
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
        error_reporting(E_ALL & ~E_NOTICE);
        session_start();
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
            echo "<h1>Carito vacío</h1>";
            echo "</div>";
            echo "<div class='alert alert-warning fade in'>";
            echo "<p>El carrito se encuetra vacío en estos momentos, por lo que no se puede procesar. Por favor <a href='principal.php' class='alert-link'>regresa</a> y realice alguna compra para continuar.</p>";
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
        error_reporting(E_ALL & ~E_NOTICE);
        session_start();
       
        // sesion del carrito para el codigo de venta
        if(!isset($_SESSION['SESION'])){
            $controlador = ControladorUsuario::getControlador();
            $id = base64_decode($_SESSION['USUARIO']);
            $usuario = $controlador->buscarUsuarioID($id);
            $venta= $usuario->getId(). "-". (microtime()) * 1000000 ."-".strftime("%Y%M%d"); 
            $_SESSION['SESION']=base64_encode($venta);
        }
        
        if (isset($_SESSION['CARRITO'])) {
            $viejoCarrito = $_SESSION['CARRITO'];
            $_SESSION['CARRITO'] = $viejoCarrito . $id . '%';
        } else {
            //si no existe lo crea. Se crea en el momento de la primera compra.
            $_SESSION['CARRITO'] = $id . '%';
        }
        /*
        // Si existe la cookie la borro
        if (isset($_COOKIE['CARRITO'])) {
            unset($_COOKIE['CARRITO']);
            setcookie("CARRITO", '', time() - 3600);
            setcookie("CARRITO", $_SESSION['CARRITO'], time() + 3600 * 24 * 2); // Una hora * 24 horas * 2 días
        } else {
            setcookie("CARRITO", $_SESSION['CARRITO'], time() + 3600 * 24 * 2); // Una hora * 24 horas * 2 días
        }
        */
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
        // Inicio de Fila
        echo "<tr>";
            // Inicio de columna Producto
             echo '<td class="col-sm-8 col-md-6">
                <div class="media">
                    <img class="thumbnail pull-left" class="media-object" src="'.PICTURE_PATH.$producto->getFoto().'" style="width: 90px; height: 90px;">
                    <div class="media-body">
                    <h4 class="media-heading">'.$producto->getModelo().'</h4>
                    <h5 class="media-heading"> de '.$producto->getMarca().'</h5>
                    <span>ID: </span><input type="text" name="COD[]" value="ID'.$producto->getId().'" readonly /> </br>
                    <span>Descripción: </span><span class="text-success">'.utf8_encode(substr($producto->getDescripcion(),0,55)).'...</span>
                </div>
            </div></td>
                                ';
            // Fin de columna
            echo "</td>";
            // Inicio de Columna Precio Unitario
            echo "<td class='col-sm-1 col-md-1 text-center'>";
                echo "<strong>".$producto->getPrecio()." €</strong>";
            echo "</td>";
            // Fin de columna de Precio Unitario
            // Inicio columna Cantidad
            echo "<td class='col-sm-1 col-md-1' style='text-align: center'>";
                echo "<input type='number' class='form-control' min='1' max='".$producto->getStock()."' onchange='actualizarPrecio(this.value,ID".$producto->getId().",".$producto->getPrecio().");' name='CANT[]' value='".$cantidad."'>";
            echo "</td>";
            // Fin de Columna Cantidad
            // Inicio de Columna de precio Producto total
            echo "<td class='col-sm-1 col-md-1 text-center'>";
                echo "<strong>";
                echo "<span class='precios' id='ID".$producto->getId()."'>".$producto->getPrecio() * $cantidad." </span>";
                echo " €</strong>";
            echo "</td>";
            //Fin de Columna precio producto total
            // Inicio columna botón borrar
            echo "<td class='col-sm-1 col-md-1'>";
                    echo "<a href=carrito_compra.php?BORRAR=" . $producto->getId() . " class = 'btn btn-danger'><span class = 'glyphicon glyphicon-remove'></span> Eliminar</a>";
            echo "</td>";
            // Fin de columna botón borrar
        // Fin de fila
        echo "</tr>";
         self::$precioTotal += $producto->getPrecio() * $cantidad;
         //self::$subTotal =  round(self::$precioTotal/self::$IMP, 2);
         //self::$iva = (self::$precioTotal-self::$subTotal);
         //echo self::$subTotal."</br>";
         //echo self::$iva."</br>";
         //echo self::$precioTotal."</br>";
    }
    
    
    /// Parte de la venta
    public function getVenta() {
        return self::$venta;
    }

    public function setVenta($venta) {
        self::$venta = $venta;
    }
    
    public function crearVenta($venta, $usuario, $idsProductos, $cantidades){
        self::$venta = new Venta($venta, $usuario, $idsProductos, $cantidades);        
        //return  self::$venta->getTotal()."-".self::$venta->getSubtotal()."-".self::$venta->getIva();
        
    }
    
    public function setSesionVenta(){
        error_reporting(E_ALL & ~E_NOTICE);
        session_start();
        $_SESSION["VENTA"]= self::$venta;
    }
    
    public function getSesionVenta(){
        error_reporting(E_ALL & ~E_NOTICE);
        session_start();
        self::$venta = $_SESSION["VENTA"];
    }
    
    public function destruirCarrito(){
        error_reporting(E_ALL & ~E_NOTICE);
         self::$venta = null;
        session_start();
        $_SESSION['CARRITO'] = "";
        unset($_SESSION['CARRITO']);
        unset($_SESSION['VENTA']);
        unset($_SESSION['SESION']);
        
    }
    
    private function eliminarVentaBD(){
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "DELETE FROM lineasventas WHERE idVenta='".self::$venta->getIdVenta()."'";
        $bd->actualizarBD($consulta);
        $consulta = "DELETE FROM ventas WHERE idVenta='".self::$venta->getIdVenta()."'";
        $bd->actualizarBD($consulta);
        $bd->cerrarBD();
        
    }
    
    public function almacenarVentaBD(){
        // Primero destruimos las ventas y líneas de ventas que hayamos insertado antes... (recarga de la web)
        $this->eliminarVentaBD();
        
        // insertamos la venta
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        
        $consulta = "INSERT INTO ventas VALUES "
                . "('".self::$venta->getIdVenta()."','".self::$venta->getFecha()."','".self::$venta->getTotal()."',"
                . "'".self::$venta->getSubtotal()."','".self::$venta->getIva()."',"
                . "'".self::$venta->getIdUsuario()."','".self::$venta->getNombre()."','".self::$venta->getEmail()."',"
                . "'".self::$venta->getDireccion()."','".self::$venta->getNombreTarjeta()."','".self::$venta->getNumTarjeta()."')";
        
        $bd->actualizarBD($consulta);
        
        
        //insertamos las líneas de venta
        $lineas = self::$venta->getLineas();
        foreach ($lineas as $linea){
            $consulta = "INSERT INTO lineasventas VALUES ('".$linea->getIdVenta()."','".$linea->getIdProducto()."',"
                    . "'".$linea->getMarca()."','".$linea->getModelo()."','".$linea->getPrecio()."',"
                    . "'".$linea->getCantidad()."','".$linea->getTotal()."')";
            
             $bd->actualizarBD($consulta);
        }
        
        // Fin
        $bd->cerrarBD();
    }
    



}
