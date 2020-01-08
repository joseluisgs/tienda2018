<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
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
    $controlador = ControladorUsuario::getControlador();
    // Versión serializada, directamente deerializamos el objeto obtenido
    //$usuario = $controlador->deserializarUsuario($_GET["id"]);
    // Version sin serializar
    $usuario = $controlador->buscarUsuarioID(base64_decode($_GET["id"]));
    
    if (is_null($usuario)) {
        // hay un error
        header("location: error.php");
        exit();
    }else{
       $foto = $usuario->getFoto(); 
    }
}

// Los datos del formulario al procesar el sí.
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // El id sin serializar
    $id = trim($_POST["id"]);
    $foto = trim($_POST["foto"]);

    $controlador = ControladorUsuario::getControlador();
    $controlador->borrarUsuario($_POST["id"]);
        // Se ha borrado y volvemos a la página principal
        // Debemos borrar la foto del usuario
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
                    <h1>Borrar Usuario/a</h1>
                </div>
                <table>
                    <tr>
                        <td class="col-xs-11" class="align-top">
                            <div class="form-group" class="align-left">
                                <!-- Muestro los datos del usuario-->
                                <div class="form-group">
                                    <label>ID</label>
                                    <p class="form-control-static"><?php echo $usuario->getId(); ?></p>
                                </div>
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
                    <label>Nombre:</label>
                    <p class="form-control-static"><?php echo utf8_encode($usuario->getNombre()); ?></p>
                </div>

                <div class="form-group">
                    <label>E-Mail:</label>
                    <p class="form-control-static"><?php echo $usuario->getEmail(); ?></p>
                </div>
                <div class="form-group">
                    <label>Direccion:</label>
                    <p class="form-control-static"><?php echo utf8_encode($usuario->getDireccion()); ?></p>
                </div>
                
                <div class="form-group">
                    <label>Administrador:</label>
                    <p class="form-control-static">
                        <?php 
                            if ($usuario->getAdmin()==0)
                                echo "NO";
                            else
                                echo "SÍ"
                        ?>
                    </p>
                </div>
                
                
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>"/>
                        <input type="hidden" name="foto" value="<?php echo $usuario->getFoto(); ?>"/>
                        <p>¿Está seguro que desea borrar este usuario/a?</p><br>
                        <p>
                            <button type="submit" class="btn btn-danger"> <span class="glyphicon glyphicon-trash"></span>  Borrar</button>
                            <a href=admin_listado_usuarios.php class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left"></span> Volver</a>
                        </p>
                    </div>
                </form>
                
            </div>
        </div>        
    </div>
</div>
<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>
