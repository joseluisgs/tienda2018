<?php

// Definimos con una constante cada uno de los directorios que tenemos para poder llamarlos
if (!defined('ROOT_PATH'))
    define('ROOT_PATH', dirname(__FILE__) . "/");

if (!defined('MODEL_PATH'))
    define('MODEL_PATH', ROOT_PATH . "modelos/");

if (!defined('VIEW_PATH'))
    define('VIEW_PATH', ROOT_PATH . "vistas/");

if (!defined('CONTROLLER_PATH'))
    define('CONTROLLER_PATH', ROOT_PATH . "controladores/");

if (!defined('UTILITY_PATH'))
    define('UTILITY_PATH', ROOT_PATH . "utilidades/");

if (!defined('RESOURCE_PATH'))
    define('RESOURCE_PATH', ROOT_PATH . "recursos/");

if (!defined('FOTO_PATH'))
    define('FOTO_PATH', "fotos/");

if (!defined('PICTURE_PATH'))
    define('PICTURE_PATH', "../fotos/");

if (!defined('IMAGES_PATH'))
    define('IMAGES_PATH', ROOT_PATH . "imagenes/");

if (!defined('ADMIN_PATH'))
    define('ADMIN_PATH', ROOT_PATH . "admin/");

if (!defined('TEMPLATE_PATH'))
    define('TEMPLATE_PATH', ROOT_PATH . "plantillas/");

?>