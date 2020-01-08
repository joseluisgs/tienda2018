<!-- Cabecera de la página web -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once UTILITY_PATH . "funciones.php";

//Debemos decir que no estamos identificando
?>

<?php require_once VIEW_PATH."cabecera.php"; ?>
<!-- Barra de Navegacion -->
<?php require_once "navbaroff.php"; ?>

<?php


// Procesamos el formulario al pulsar el botón aceptar de esta ficha
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $pass = md5(trim($_POST["pass"]));
    $email = trim($_POST["email"]);
    $direccion = trim($_POST["direccion"]);
    $nombreFoto = crearFoto();
    $controlador = ControladorUsuario::getControlador();
    $controlador->almacenarUsuario($nombre, $pass, $email, $direccion, $nombreFoto);
}

?>

<!-- Cuerpo de la página web -->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Registro de usuario/a:</h2>
                </div>
                <p>Por favor rellene este formulario para poder comprar en la tienda.</p>
                <!-- Formulario-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <!-- Nombre-->
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" required name="nombre" class="form-control" value="">
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" required name="pass" class="form-control" value="">
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label>E-Mail:</label>
                        <input type="email" required name="email" class="form-control" value="">
                    </div>
                    <!-- Direccion -->
                    <div class="form-group">
                        <label>Direccion:</label>
                        <input type="text" required name="direccion" class="form-control" value="">
                    </div>
                    <!-- Foto -->
                    <div class="form-group">
                        <label>Fotografía</label>
                        <input type="file" required name="foto" class="form-control-file" id="foto">
                    </div>
                    <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span>  Aceptar</button>
                    <a href="principal.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>