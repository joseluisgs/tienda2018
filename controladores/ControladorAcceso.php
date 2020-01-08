<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControladorAcceso {
    // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia de controlador
     * @return instancia del controlador
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorAcceso();
        }
        return self::$instancia;
    }
    
    public function salirSesion() {
        // Recuperamos la información de la sesión
        session_start();
        // Y la eliminamos las variables de la sesión y coockies
        unset($_SESSION['USUARIO']);
        unset($_SESSION['CARRITO']);
        unset($_COOKIE['ACCESO']);
        session_unset();
        session_destroy();
    }
    
    public function procesarIdentificacion($email, $password){
 
            $password = md5($password);

            // Conectamos a la base de datos
            $controlador = ControladorUsuario::getControlador();
            $usuario = $controlador->buscarUsuarioEmail($email);

            // Esto se puede remplazar por un usuario real guardado en la base de datos.
            if ($email == $usuario->getEmail() && $password == $usuario->getPass()) {
                session_start();
                $_SESSION['USUARIO'] = base64_encode($usuario->getId());
                header("location: ../index.php");
            } else {
                echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Usuario/a incorrecto</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-warning fade in'>";
                                    echo "<p>Lo siento, el emial o password es incorrecto. Por favor <a href='/tienda/vistas/identificacion.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                //<!-- Pie de la página web -->
                require_once VIEW_PATH."pie.php";
                exit();
            }
    }
    
    public function controlAccesoUsuario(){
        session_start();
        if(!isset($_SESSION['USUARIO'])){
            echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Página no permitida</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-danger fade in'>";
                                    echo "<p>Lo siento, está intentando aceder a una página no permitida. Por favor <a href='../index.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                //<!-- Pie de la página web -->
                require_once VIEW_PATH."pie.php";
                exit();
        }
    }
    
    public function controlAccesoAdministrador(){
        //session_start();
        if(isset($_SESSION['USUARIO'])){
            $controlador = ControladorUsuario::getControlador();
            $id = base64_decode($_SESSION['USUARIO']);
            $usuario = $controlador->buscarUsuarioID($id);
        }else{ 
        if(!isset($usuario)||($usuario->getAdmin()!=1)){
            echo "<div class='wrapper'>";
                    echo "<div class='container-fluid'>";
                        echo "<div class='row'>";
                            echo "<div class='col-md-12'>";
                                echo "<div class='page-header'>";
                                     echo "<h1>Página no permitida</h1>";
                                 echo "</div>";
                                echo "<div class='alert alert-danger fade in'>";
                                    echo "<p>Lo siento, está intentando aceder a una página no permitida. Por favor <a href='../index.php' class='alert-link'>regresa</a> e inténtelo de nuevo.</p>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                //<!-- Pie de la página web -->
                require_once VIEW_PATH."pie.php";
                exit();
            }
        }
    }

}
