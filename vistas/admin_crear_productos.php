<!-- Cabecera de la página web -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
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


// Procesamos el formulario al pulsar el botón aceptar de esta ficha
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = trim($_POST["tipo"]);
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = trim($_POST["precio"]);
    $stock = trim($_POST["stock"]);
    $oferta= trim($_POST["oferta"]);
    $nombreFoto = crearFoto();
    $controlador = ControladorProducto::getControlador();
    $controlador->crearProducto($tipo, $marca, $modelo, $descripcion, $precio, $stock, $oferta, $nombreFoto);
}

?>

<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Registro de producto:</h2>
                </div>
                <p>Por favor rellene este formulario para dar de alta el producto.</p>
                <!-- Formulario-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <!-- Tipo-->
                    <div class="form-group">
                        <label>Tipo:</label>
                        <!-- Lo ideal sería hacer una consulta a la BD sacando los tipos de productos-->
                        <select required name="tipo" class="form-control">
                            <option value="DISCODURO">Disco Duro</option>
                            <option value="MONITORES">Monitor</option>
                            <option value="PORTATILES">Portatil</option>
                        </select>
                    </div>
                    <!-- Marca -->
                    <div class="form-group">
                        <label>Marca:</label>
                        <input type="text" required name="marca" class="form-control" value="">
                    </div>
                    <!-- Modelo -->
                    <div class="form-group">
                        <label>Modelo:</label>
                        <input type="text" required name="modelo" class="form-control" value="">
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea type="text" required name="descripcion" class="form-control" value=""></textarea>
                    </div>
                    <!-- Precio -->
                    <div class="form-group">
                        <label>Precio:</label>
                        <input type="number" required name="precio" class="form-control" min="0.00" max="10000.00" step="0.01" value="">
                    </div>
                    <!-- Stock -->
                    <div class="form-group">
                        <label>Stock:</label>
                        <input type="number" required name="stock" class="form-control" min="1" max="10" value="1">
                    </div>
                    <!-- Oferta -->
                    <div class="form-group">
                        <label>Oferta:</label>
                        <label class="radio-inline"><input type="radio" name="oferta" checked value="0">No</label>
                        <label class="radio-inline"><input type="radio" name="oferta" value="1">Si</label>
                    </div>
                    <!-- Foto -->
                    <div class="form-group">
                        <label>Fotografía</label>
                        <input type="file" required name="foto" class="form-control-file" id="foto">
                    </div>
                    <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span>  Aceptar</button>
                    <a href="admin_listado_productos.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>