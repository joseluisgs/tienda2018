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
// Obtenemos los datos que nos vienen de la página anterior
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $controlador = ControladorProducto::getControlador();
    // Versión serializada, directamente deerializamos el objeto obtenido
    //$usuario = $controlador->deserializarUsuario($_GET["id"]);
    // Version sin serializar
    $producto = $controlador->buscarProductoID(base64_decode($_GET["id"]));
    
    if (is_null($producto)) {
        // hay un error
        header("location: error.php");
        exit();
    }else{
       $foto = $producto->getFoto(); 
    }
}

// Los datos del formulario al procesar el sí.
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // El id sin serializar
    $id = trim($_POST["id"]);
    $foto = trim($_POST["foto"]);

    $controlador = ControladorProducto::getControlador();
    $controlador->borrarProducto($_POST["id"]);
        // Se ha borrado y volvemos a la página principal
        // Debemos borrar la foto del producto
        borrarFoto($foto);
        exit();
}
?>

<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h1>Borrar Producto</h1>
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
                    <p class="form-control-static"><?php echo utf8_encode($producto->getDescripcion()); ?></p>
                </div>
                
                
                
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>"/>
                        <input type="hidden" name="foto" value="<?php echo $producto->getFoto(); ?>"/>
                        <p>¿Está seguro que desea borrar este producto?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href=admin_listado_productos.php class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
                
            </div>
        </div>        
    </div>
</div>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>
