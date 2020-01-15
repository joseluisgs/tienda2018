 <?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";



// Cabecera
require_once VIEW_PATH . "cabecera.php";

// Barra de Navegacion
require_once VIEW_PATH . "navbar.php";

// Control de acceso
$controlador = ControladorAcceso::getControlador();
$controlador->controlAccesoUsuario();
?>
<?php

$contCarrito = ControladorCarrito::getControlador();
$carrito=0;

if (isset($_GET['VACIAR'])) {
    if ($_GET['VACIAR']) {
        //$_SESSION['CARRITO'] = "";
        $carrito=0;
        $contCarrito->destruirCarrito();
        //Consulta cual es la página que ha llamado a este script
        $page = $_SERVER['PHP_SELF']; 
        //Refresa la pagina, el valor 0 es el numero de segundos que espera para refrescar.
        header("Refresh: 0; url=$page"); 
    }
}

if($contCarrito->getTotalItems()>0){
    $carrito = $contCarrito->getCantidadPorItem();
}

// Si el carrito está vacío
if($carrito==0 || $_SESSION['CARRITO'] == "" || !isset($_SESSION['CARRITO'])){
   $contCarrito->carritoVacio();
}


// Codigo de procesamiento del formulario
// Si pulsmos vaciar

if (isset($_GET['BORRAR'])) {
    if (isset($_SESSION['CARRITO'])) {
        // str_replace Busca coincidnecia en un string y la reemplaza por una cadena.
        $carrito = str_replace($_GET['BORRAR'] . '%', '', $_SESSION['CARRITO']); 
        //si el string está vacío es que el carrito no tiene pedidos y lo hacemos desaparecer con unsset.
        if (!$carrito == "") { 
            $_SESSION['CARRITO'] = $carrito;
        } else {
            //si el string que genera la sesion carrito es igual a "" es que el carrito esta vacio y deja de existir.
            $_SESSION['CARRITO'] = ""; 
        }
        
        //Consulta cual es la página que ha llamado a este script
        $page = $_SERVER['PHP_SELF']; 
        //Refresa la pagina, el valor 0 es el numero de segundos que espera para refrescar.
        header("Refresh: 0; url=$page"); 
    }
}
?>

<main role="main">
    <section class="page-header clearfix text-center">
        <h2>Carrito de compra</h2>
    </section>
    <form name="form_carrito" method="POST" action="carrito_pago.php">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                
                <table class="table table-hover">
                    
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Precio</th>
                            <th>Cantidad</th>
                            <th class="text-center">Total</th>
                            <th>  </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
                        <?php
                            
                            foreach ($carrito as $id => $cantidad){
                                //echo $id."-".$cantidad."</br>";
                                // Imprimo cada fila del item
                                $contCarrito->getItem($id, $cantidad);
                            }
                        ?>
            
                    </tbody>
                    <!-- Pie de Tabla -->
                    <tfoot>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td>
                                <h3><strong>
                                        <span class="precioTotalTexto">Total</span>
                                </strong></h3>
                            <td class="text-right">
                                <?php
                                echo "<h3><strong>";
                                    echo "<span id='precioTotal'>".ControladorCarrito::$precioTotal." </span>";
                                echo " €</strong></h3>";
                                ?>
                            </td>
                            
                        </tr>
                            
                        <tr>
                            <td>
                                <a href="principal.php" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Seguir Comprando</a>
                            </td>
                            <td>   </td>
                            <td>   </td>
                            <td>
                                <a href="carrito_compra.php?VACIAR=1" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Vaciar Carrito</a>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-credit-card"></span>  Pagar compra</button>
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    </form>
</main>

<?php
require_once VIEW_PATH . "pie.php";
?>