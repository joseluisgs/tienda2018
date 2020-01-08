<!-- Cabecera de la página web -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once UTILITY_PATH . "funciones.php";

// Cabecera
require_once VIEW_PATH."cabecera.php";

//Barra
require_once "navbar.php";

// Control de usuarios
require_once CONTROLLER_PATH . "ControladorAcceso.php";
$controlador = ControladorAcceso::getControlador();
$controlador->controlAccesoAdministrador();

?>

<?php

// Procesamos los datos que nos llegan al acceder a la web por la id en la barra, método GET
// Comprobamos que existe el id antes de ir más lejos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);
        $controlador = ControladorProducto::getControlador();
         // Versión serializada, directamente deerializamos el objeto obtenido
        //$producto = $controlador->deserializarProducto($_GET["id"]);
        // Version sin serializar
        $producto= $controlador->buscarProductoID(base64_decode($_GET["id"]));
        if (is_null($producto)) {
            // hay un error
            //header("location: error.php");
            exit();
        }
} else {
        // hay un error
        header("location: error.php");
        exit();
    }

?>

<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Datos de Producto:</h2>
                </div>
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <div class="form-group" class="align-left">
                                    <label>COD:</label>
                                    <p class="form-control-static"><?php echo $producto->getId(); ?></p>
                                </div>
                            </td>
                            <td class="align-left">
                                    <label>Fotografía:</label><br>
                                    <div class = 'thumbnail' >
                                        <img src='<?php echo "../" . FOTO_PATH . $producto->getFoto() ?>' class='rounded' class='img-thumbnail' width='150' height='auto' enctype="multipart/form-data">
                                    </div>
                            </td>
                        </tr>
                    </table>

                <div class="form-group">
                    <label>Marca:</label>
                    <p class="form-control-static"><?php echo $producto->getMarca(); ?></p>
                </div>

                <div class="form-group">
                    <label>Modelo:</label>
                    <p class="form-control-static"><?php echo $producto->getModelo(); ?></p>
                </div>
                <div class="form-group">
                    <label>Precio:</label>
                    <p class="form-control-static"><?php echo $producto->getPrecio()."€"; ?></p>
                </div>
                <div class="form-group">
                    <label>Unidades disponibles:</label>
                    <p class="form-control-static"><?php echo $producto->getStock(); ?></p>
                </div>
                
                <div class="form-group">
                    <label>Oferta:</label>
                    <p class="form-control-static">
                        <?php 
                            if ($producto->getOferta()==0)
                                echo "NO";
                            else
                                echo "SÍ"
                        ?>
                    </p>
                </div>
                
                <div class="form-group">
                    <label>Descripción:</label>
                    <p class="form-control-static"><?php echo str_replace("\n", "<br/>", utf8_encode($producto->getDescripcion())); ?></p>
                </div>
                
                <p><a href="admin_listado_productos.php" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a></p>
                    
            </div>
        </div>        
    </div>
</div>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>