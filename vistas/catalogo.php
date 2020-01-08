<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorCatalogo.php";
require_once CONTROLLER_PATH . "ControladorProducto.php";
require_once CONTROLLER_PATH . "Paginador.php";


// Recogemos el tipo de catalogo
$opcion = "";
if (isset($_GET["tipo"]) && !empty(trim($_GET["tipo"]))) {
    $tipo = trim($_GET["tipo"]);
    switch ($tipo) {
    case "Todo":
        $opcion= "";
        break;
    case "DiscoDuro":
        $opcion= "DiscoDuro";
        break;
    case "Monitores":
        $opcion= "Monitores";
        break;
    case "Portatiles":
        $opcion= "Portatiles";
        break;
    case "Ofertas":
        $opcion= "Ofertas";
        break;
    }

}

// Procesamos el buscador
if (!isset($_POST["producto"])) {
    $marca = "";
    $modelo = "";
} else {
    $marca = $_POST["producto"];
    $modelo = $_POST["producto"];
    $opcion = $_POST["opcion"];
}

 // Consulta a realizar
$controlador = ControladorCatalogo::getControlador();
$consulta = $controlador->getConsultaCatalogo($marca, $modelo, $opcion);
//echo $consulta;

// Configuramos el paginador
$filas = 2;
$columnas = 4;
$limite = $filas * $columnas; // Dos filas de 4

$pagina = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$enlaces = ( isset($_GET['enlaces']) ) ? $_GET['enlaces'] : 10;

$paginador  = new Paginador($consulta, $limite);
$resultados = $paginador->getDatos($pagina);


?>

<!-- Codigo HTML -->
<main role="main">

    <section class="page-header clearfix text-center">
        <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group mx-sm-5 mb-2">
                        <input type="text" class="form-control" id="buscar" name="producto" placeholder="Marca o Modelo">
                    </div>
                    <input type="hidden" name="opcion" value="<?php echo $opcion; ?>"/>
                    <button type="submit" class="btn btn-primary mb-2"> <span class="glyphicon glyphicon-search"></span>  Buscar en <?php echo $opcion; ?></button>
                </form>
    </section>

    <div class="container">
        
        <?php
        if (count( $resultados->datos)>0) {
            // Contador de items
            $item = 0;
            // Inicio de Fila
            echo $controlador->filaInicio();
            // Sacamos los resultados
            foreach($resultados->datos as $dato){
                // Obtenemos el producto
                $producto = new Producto($dato["ID"], $dato["TIPO"], $dato["MARCA"], $dato["MODELO"], $dato["DESCRIPCION"], $dato["PRECIO"], 
                            $dato["STOCK"], $dato["OFERTA"], $dato["FOTO"]);
                // Imprimimos los resultados
                 echo $controlador->getProducto($producto, base64_encode("principal.php"));
                $item++;
                if($item % 4 == 0){
                    $controlador->filaFin();
                    echo $controlador->filaInicio();
                }
            }
            $controlador->filaFin();
            // Paginador
            echo "<ul class='pager'>"; //  <ul class="pagination">
                echo $paginador->crearLinks($enlaces);
            echo "</ul>";
            
        } else {
                // Si no hay nada seleccionado
            echo "<p class='lead'><em>No se ha encontrado datos de productos.</em></p>";
        }
        ?>


    </div>

</main>

<!-- Codigo HTML -->