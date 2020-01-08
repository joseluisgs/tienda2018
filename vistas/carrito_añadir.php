<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";


// Cabecera
require_once VIEW_PATH."cabecera.php";
// Barra de navegacion
//<!-- Barra de Navegacion -->
require_once "navbar.php"; 

// Comprobamos que estamos indentificados
$controlador = ControladorCarrito::getControlador();
$controlador->controlAccesoCarrito();

//session_start();
// Cogemos el carrito, pero antes debemos estar identificados



if(isset($_GET["dest"])&& !empty(trim($_GET["id"])) && isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = base64_decode($_GET["id"]);
    $dest = base64_decode($_GET["dest"]);
    // Vamos a trabajar con arrays concatenndo
     $controlador->añadirItem($id);
    //alerta($controlador->getNumeroProductosTotal());
    header("Location: ".$dest);

}
?>
