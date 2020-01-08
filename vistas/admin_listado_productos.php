<!-- Cabecera de la página web -->
<?php 
// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
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
                    <h2 class="pull-left">Lista de Productos</h2>
                </div>
                <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mx-sm-5 mb-2">
                        <label for="producto" class="sr-only">Marca o modelo</label>
                        <input type="text" class="form-control" id="buscar" name="producto" placeholder="Marca o Modelo">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar</button>
                    <!-- Aquí va el nuevo botón para dar de alta, podría ir al final -->
                    <a href="/tienda/utilidades/descargar_productos.php" class="btn pull-right" target="_blank"><span class="glyphicon glyphicon-download"></span>  Descargar</a>
                    <a href="admin_crear_productos.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-hdd"></span>  Añadir Productos</a>

                </form>
            </div>
            <!-- Linea para dividir -->
            <div class="page-header clearfix">        
            </div>
            <?php
            // creamos la consulta dependiendo si venimos o no del formulario
            if (!isset($_POST["producto"])) {
                $marca = "";
                $modelo = "";
            } else {
                $marca = $_POST["producto"];
                $modelo = $_POST["producto"];
            }
            // Cargamos el controlador de usuarios --> Cabiamos para incluir el paginador
            $controlador = ControladorProducto::getControlador();

            // Parte del paginador
            $pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
            $enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;
            
            // Consulta a realizar
            $consulta = $controlador->getConsultaListado($marca, $modelo);
            // Sacamos cuatro por página
            $limite = 4;
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
                echo "<th>COD</th>";
                echo "<th>Tipo</th>";
                echo "<th>Marca</th>";
                echo "<th>Modelo</th>";
                echo "<th>Precio</th>";
                echo "<th>Stock</th>";
                echo "<th>Fotografía</th>";
                echo "<th>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                
                // Recorremos los registros encontrado
                foreach($resultados->datos as $dato){
                    $producto = new Producto($dato["ID"], $dato["TIPO"], $dato["MARCA"], $dato["MODELO"], $dato["DESCRIPCION"], $dato["PRECIO"], 
                            $dato["STOCK"], $dato["OFERTA"], $dato["FOTO"]);
                    // Pintamos cada fila con los datos que queramos
                    echo "<tr>";
                    echo "<td>" . $producto->getId() . "</td>";
                    echo "<td>" . $producto->getTipo() . "</td>";
                    echo "<td>" . $producto->getMarca() . "</td>";
                    echo "<td>" . $producto->getModelo() . "</td>";
                    echo "<td>" . $producto->getPrecio() . "€</td>";
                    echo "<td>" . $producto->getStock() . "</td>";
                    echo "<td> <div class='text-center'>";
                    echo "<img src='".PICTURE_PATH.$producto->getFoto()."' class='rounded' class='img-thumbnail' width='30' height='auto'>";
                    echo "</div>";
                    echo "</td>";
                    
                    echo "<td>";

                    // Forma Serializando
                    //$ser = $controlador->serializarProducto($producto);
                    echo "<a href='admin_leer_productos.php?id=" . base64_encode($producto->getId()) . "' title='Ver Productos' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                    echo "<a href='admin_actualizar_productos.php?id=" . base64_encode($producto->getId()) . "' title='Actualizar Productos' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                    echo "<a href='admin_borrar_productos.php?id=" . base64_encode($producto->getId()) . "' title='Borar Productos' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";

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
                echo "<p class='lead'><em>No se ha encontrado datos de productos.</em></p>";
            }
            ?>

        </div>
    </div>        
</div>

<!-- Pie de la página web -->
<?php require_once VIEW_PATH."pie.php"; ?>