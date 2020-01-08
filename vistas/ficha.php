<!-- Cabecera de la página web -->
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once UTILITY_PATH . "funciones.php";

require_once VIEW_PATH."cabecera.php";

$controlador = ControladorAcceso::getControlador();
$controlador->controlAccesoUsuario();

//<!-- Barra de Navegacion -->
require_once "navbaroff.php"; 
?>

<?php

// Procesamos la información obtenida del formulario mediante POST
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = trim($_POST["id"]);
    $nombre = trim($_POST["nombre"]);
    $pass = md5(trim($_POST["pass"]));
    $email = trim($_POST["email"]);
    $direccion = trim($_POST["direccion"]);
    $admin = trim($_POST["admin"]);
    // Procesamos la imagen
    $fotoAnterior = trim($_POST["fotoAnterior"]);
    // Procesamos la imagen
    $nombreFoto = actualizarFoto();
    $controlador = ControladorUsuario::getControlador();
    $controlador->actualizarFichaUsuario($id, $nombre, $pass, $email, $direccion, $nombreFoto, $admin);

} else {

// Procesamos los datos que nos llegan al acceder a la web por la id en la barra, método GET
// Comprobamos que existe el id antes de ir más lejos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);
        $controlador = ControladorUsuario::getControlador();
        $id = base64_decode($_SESSION['USUARIO']);
        $usuario = $controlador->buscarUsuarioID($id);

        if (!is_null($usuario)) {
            $id = $usuario->getId();
            $nombre = $usuario->getNombre();
            $pass = $usuario->getPass();
            $email = $usuario->getEmail();
            $direccion = $usuario->getDireccion();
            $admin = $usuario->getAdmin();
            $foto = $usuario->getFoto();
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
                    <h2>Datos de usuario/a:</h2>
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
                                        <img src='<?php echo "../" . FOTO_PATH . $usuario->getFoto() ?>' class='rounded' class='img-thumbnail' width='150' height='auto' enctype="multipart/form-data">
                                </div>
                            </td>
                        </tr>
                    </table>


                    <div class="form-group">
                        <!-- Nombre-->
                        <label>Nombre:</label>
                        <input type="text" required name="nombre" class="form-control" value="<?php echo utf8_encode($nombre); ?>">
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" required name="pass" class="form-control" value="">
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label>E-Mail:</label>
                        <input type="email" required name="email" class="form-control" value="<?php echo $email; ?>">
                    </div>
                    <!-- Direccion -->
                    <div class="form-group">
                        <label>Dirección:</label>
                        <input type="text" required name="direccion" class="form-control" value="<?php echo $direccion; ?>">
                    </div>
                    <!-- Foto -->
                    <div class="form-group">
                        <label>Nueva Fotografía</label>
                        <input type="file" required name="foto" class="form-control-file" id="foto">
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="admin" value="<?php echo $admin; ?>"/>
                    <input type="hidden" name="fotoAnterior" value="<?php echo $fotoAnterior; ?>"/>
                    <button type="submit" class="btn btn-warning"> <span class="glyphicon glyphicon-refresh"></span>  Modificar</button>
                    <a href="principal.php" class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                </form>
            </div>
        </div>        
    </div>
</div>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>