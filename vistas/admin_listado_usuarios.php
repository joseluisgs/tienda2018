<!-- Cabecera de la página web -->
<?php 
// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "Paginador.php";



// Cabecera de la web
require_once VIEW_PATH."cabecera.php"; 

// Barra de navegacion
require_once VIEW_PATH."navbar.php";

// Comprobamos que somos administrador
require_once CONTROLLER_PATH . "ControladorAcceso.php";
$controlador = ControladorAcceso::getControlador();
$controlador->controlAccesoAdministrador();

?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <h2 class="pull-left">Lista de Usuarios/as</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="usuario" class="sr-only">Nombre o Apellidos</label>
                        <input type="text" class="form-control" id="buscar" name="usuario" placeholder="Nombre o E-Mail">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->
                    <a href="/tienda/utilidades/descargar_usuarios.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  Descargar</a>
                    <a href="admin_crear_usuarios.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-user"></span>  Añadir Usuario/a</a>

                </form>
            </div>
            <!-- Linea para dividir -->
            <div class="page-header clearfix">        
            </div>
            <?php
            // creamos la consulta dependiendo si venimos o no del formulario
            // para el buscador: select * from alumnado where nombre like "%%" or apellidos like "%%"
            if (!isset($_POST["usuario"])) {
                $nombre = "";
                $email = "";
            } else {
                $nombre = $_POST["usuario"];
                $email = $_POST["usuario"];
            }
            // Cargamos el controlador de usuarios --> Cabiamos para incluir el paginador
            $controlador = ControladorUsuario::getControlador();
            //$lista = $controlador->listarUsuarios($nombre, $apellidos);
            
            // Parte del paginador
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;
            
            // Consulta a realizar
            $consulta = $controlador->getConsultaListado($nombre, $email);
            $limite = 2;
            $paginador  = new Paginador($consulta, $limite);
            $resultados = $paginador->getDatos($pagina);
            
            //echo $resultados;

            
            
            // Si hay filas (no nulo), pues mostramos la tabla
            //if (!is_null($lista) && count($lista) > 0) {
            if (count( $resultados->datos)>0) {
                
                // Pintamos la tabla
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Nº</th>";
                echo "<th>Nombre</th>";
                echo "<th>E-Mail</th>";
                echo "<th>Dirección</th>";
                echo "<th>Fotografía</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                // Recorremos los registros encontrado
                foreach($resultados->datos as $dato){
                    $usuario = new Usuario($dato["ID"], $dato["NOMBRE"], $dato["PASS"], $dato["EMAIL"], $dato["DIRECCION"], $dato["FOTO"], $dato["ADMIN"]);
                    // Pintamos cada fila
                    echo "<tr>";
                    echo "<td>" . $usuario->getId() . "</td>";
                    echo "<td>" . utf8_encode($usuario->getNombre()) . "</td>";
                    echo "<td>" . $usuario->getEmail() . "</td>";
                    echo "<td>" . $usuario->getDireccion() . "</td>";
                    echo "<td> <div class='text-center'>";
                    echo "<img src='".PICTURE_PATH.$usuario->getFoto()."' class='rounded' class='img-thumbnail' width='30' height='auto'>";
                    echo "</div>";
                    echo "</td>";
                    
                    echo "<td>";

                    // Forma Serializando
                    //$ser = $controlador->serializarUsuario($usuario);
                    echo "<a href='admin_leer_usuarios.php?id=" . base64_encode($usuario->getId()) . "' title='Ver Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='admin_actualizar_usuarios.php?id=" . base64_encode($usuario->getId()) . "' title='Actualizar Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='admin_borrar_usuarios.php?id=" . base64_encode($usuario->getId()) . "' title='Borar Usuario/a' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";

                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                
                echo "<ul class='pager'>"; //  <ul class="pagination">
                echo $paginador->crearLinks($enlaces);
                echo "</ul>";
            } else {
                // Si no hay nada seleccionado
                echo "<p class='lead'><em>No se ha encontrado datos de usuarios/as.</em></p>";
            }
            ?>

        </div>
    </div>        
</div>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>