<!-- Cabecera de la página web -->
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

// Procesamos los datos que nos llegan al acceder a la web por la id en la barra, método GET
// Comprobamos que existe el id antes de ir más lejos
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);
        $controlador = ControladorUsuario::getControlador();
        // Versión serializada, directamente deerializamos el objeto obtenido
        //$usuario = $controlador->deserializarUsuario($_GET["id"]);
        // Version sin serializar
        $usuario = $controlador->buscarUsuarioID(base64_decode($_GET["id"]));
        if (is_null($usuario)) {
            // hay un error
            header("location: error.php");
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
                    <h2>Datos de usuario/a:</h2>
                </div>
                    <table>
                        <tr>
                            <td class="col-xs-11" class="align-top">
                                <div class="form-group" class="align-left">
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
                    <p class="form-control-static"><?php echo str_replace("\n", "<br/>", utf8_encode($usuario->getDireccion())); ?></p>
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
                
                <p><a href="admin_listado_usuarios.php" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</a></p>
                    
            </div>
        </div>        
    </div>
</div>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH . "pie.php"; ?>