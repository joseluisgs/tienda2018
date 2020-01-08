<!-- Cabecera de la página web -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
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
    $nombre = trim($_POST["nombre"]);
    $pass = md5(trim($_POST["pass"]));
    $email = trim($_POST["email"]);
    $direccion = trim($_POST["direccion"]);
    $admin = trim($_POST["admin"]);
    $nombreFoto = crearFoto();
    $controlador = ControladorUsuario::getControlador();
    $controlador->crearUsuario($nombre, $pass, $email, $direccion, $nombreFoto, $admin);
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
                <p>Por favor rellene este formulario para dar de alta al usuario/a.</p>
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
                    <!-- Administrador -->
                    <div class="form-group">
                        <label>Administrador:</label>
                        <label class="radio-inline"><input type="radio" name="admin" checked value="0">No</label>
                        <label class="radio-inline"><input type="radio" name="admin" value="1">Si</label>
                    </div>
                    <!-- Foto -->
                    <div class="form-group">
                        <label>Fotografía</label>
                        <input type="file" required name="foto" class="form-control-file" id="foto">
                    </div>
                    <button type="submit" class="btn btn-primary"> <span class="glyphicon glyphicon-ok"></span>  Aceptar</button>
                    <a href="admin_listado_usuarios.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</a>
                </form>
            </div>
        </div>        
    </div>
</div>
<br>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>