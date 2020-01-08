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

// Procesamos la información obtenida del formulario mediante POST
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = trim($_POST["id"]);
    $tipo = trim($_POST["tipo"]);
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = trim($_POST["precio"]);
    $stock = trim($_POST["stock"]);
    $oferta= trim($_POST["oferta"]);
    // Procesamos la imagen
    $fotoAnterior = trim($_POST["fotoAnterior"]);
    // Procesamos la imagen
    $nombreFoto = actualizarFoto();
    $controlador = ControladorProducto::getControlador();
    $controlador->actualizarProducto($id, $tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $nombreFoto);

} else {

// Procesamos los datos que nos llegan al acceder a la web por la id en la barra, método GET
// Comprobamos que existe el id antes de ir más lejos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);
        $controlador = ControladorProducto::getControlador();
        // Versión serializada, directamente deerializamos el objeto obtenido
        //$usuario = $controlador->deserializarUsuario($_GET["id"]);
        // Version sin serializar
        $producto = $controlador->buscarProductoID(base64_decode($_GET["id"]));
        if (!is_null($producto)) {
            $id = $producto->getId();
            $tipo = $producto->getTipo();
            $marca = $producto->getMarca();
            $modelo = $producto->getModelo();
            $descripcion = $producto->getDescripcion();
            $precio = $producto->getPrecio();
            $stock = $producto->getStock();       
            $oferta = $producto->getOferta();
            $foto = $producto->getFoto();
            $fotoAnterior = $foto;
        } else {
            // hay un error
            header("location: error.php");
            exit();
        }
    } else {
        // hay un error
        header("location: error.php");
        exit();
    }
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
                <p>Por favor edite la nueva información para actualizar la ficha.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                            </td>
                            <td class="align-left">
                                <label>Fotografía</label><br>
                                <div class = 'thumbnail' >
                                        <img src='<?php echo "../" . FOTO_PATH . $producto->getFoto() ?>' class='rounded' class='img-thumbnail' width='150' height='auto' enctype="multipart/form-data">
                                </div>
                            </td>
                        </tr>
                    </table>


                    <!-- Tipo-->
                    <div class="form-group">
                        <label>Tipo:</label>
                        <!-- Lo ideal sería hacer una consulta a la BD sacando los tipos de productos-->
                        <select required name="tipo" class="form-control">
                            <option value="DISCODURO"<?php if ($tipo == "DISCODURO") echo " selected='selected'"; ?>>Disco Duro</option>
                            <option value="MONITORES"<?php if ($tipo == "MONITORES") echo " selected='selected'"; ?>>Monitor</option>
                            <option value="PORTATILES"<?php if ($tipo == "PORTATILES") echo " selected='selected'"; ?>>Portátil</option>
                        </select>
                    </div>
                    <!-- Marca -->
                    <div class="form-group">
                        <label>Marca:</label>
                        <input type="text" required name="marca" class="form-control" value="<?php echo $marca; ?>">
                    </div>
                    <!-- Modelo -->
                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="text" required name="modelo" class="form-control" value="<?php echo $modelo; ?>">
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea type="text" required name="descripcion" class="form-control"><?php echo utf8_encode($descripcion); ?></textarea>
                    </div>
                    <!-- Precio -->
                    <div class="form-group">
                        <label>Precio:</label>
                        <input type="number" required name="precio" class="form-control" min="0.00" max="10000.00" step="0.01" value="<?php echo $precio; ?>">
                    </div>
                    <!-- Stock -->
                    <div class="form-group">
                        <label>Stock:</label>
                        <input type="number" required name="stock" class="form-control" min="1" max="10" value="<?php echo $stock; ?>">
                    </div>
                    <!-- Oferta -->
                    <div class="form-group">
                        <label>Oferta:</label>
                        <label class="radio-inline"><input type="radio" name="oferta" <?php if (isset($oferta) && $oferta=="0") echo "checked";?> value="0">NO</label>
                        <label class="radio-inline"><input type="radio" name="oferta" <?php if (isset($oferta) && $oferta=="1") echo "checked";?> value="1">SI</label>
                    </div>
                    <!-- Foto -->
                    <div class="form-group">
                        <label>Fotografía</label>
                        <input type="file" required name="foto" class="form-control-file" id="foto">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="fotoAnterior" value="<?php echo $fotoAnterior; ?>"/>
                    <button type="submit" class="btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Modificar</button>
                    <a href="admin_listado_productos.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                </form>
            </div>
        </div>        
    </div>
</div>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>