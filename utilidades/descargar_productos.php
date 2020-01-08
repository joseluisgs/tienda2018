<?php

// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";



$nombre = 'lista_de_productos.txt'; // Nombre del archivo final

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida

$controlador = ControladorProducto::getControlador();
$lista = $controlador->descargarProductos();

// Si hay filas (no nulo), pues mostramos la tabla
if (!is_null($lista) && count($lista) > 0) {
    foreach ($lista as &$producto) {
        echo "COD: " .$producto->getId(). " -- Marca: ".$producto->getMarca(). " -- Modelo: ".$producto->getModelo()." -- Precio: ".$producto->getPrecio(). "\r\n";
    }
}else{
    echo "No se ha encontrado datos de productos";
}

?>
