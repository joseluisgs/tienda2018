<?php

// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";



$nombre = 'lista_de_usuarios.txt'; // Nombre del archivo final

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $nombre . ""); //archivo de salida

$controlador = ControladorUsuario::getControlador();
$lista = $controlador->descargarUsuarios();

// Si hay filas (no nulo), pues mostramos la tabla
if (!is_null($lista) && count($lista) > 0) {
    foreach ($lista as &$usuario) {
        echo "ID: " .$usuario->getId(). " -- Nombre: ".$usuario->getNombre(). " -- E-Mail: ".$usuario->getEmail()." -- Dirección: ".$usuario->getDireccion(). "\r\n";
    }
}else{
    echo "No se ha encontrado datos de productos";
}

?>
