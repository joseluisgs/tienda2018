<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
    require_once CONTROLLER_PATH . "ControladorAcceso.php";
    // Cargamos el controlador de Acceso --> Cabiamos para incluir el paginador
    $controlador = ControladorAcceso::getControlador();
    $controlador->salirSesion();
    header("location: principal.php");
    exit();
?>

