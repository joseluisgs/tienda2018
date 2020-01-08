<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";

// Cabecera
require_once VIEW_PATH . "cabecera.php";



// Barra de Navegacion
require_once VIEW_PATH . "navbar.php";
?>


<?php
// Codigo de procesamiento del formulario

// Si pulsmos vaciar
if (isset($_GET['VACIAR'])) {
    if ($_GET['VACIAR']) {
        $_SESSION['CARRITO'] = "";
        echo '<script type="text/javascript">
                    document.getElementById("carrito").innerHTML = 0;
              </script>';
    }
}

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

$contCarrito = ControladorCarrito::getControlador();

$carrito = $contCarrito->getCantidadPorItem();
$precioTotal = 0;

// Si el carrito está vacío
if($carrito==0 || $_SESSION['CARRITO'] == ""){
   $carrito->carritoVacio();
}
?>

<main role="main">
    <section class="page-header clearfix text-center">
        <h2>Carrito de compra</h2>
    </section>
    <form name="form_carrito" method="POST" action="validar_pedido.php">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                
                <table class="table table-hover">
                    
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Total</th>
                            <th>  </th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        
                        <?php
                            foreach ($carrito as $id => $cantidad){
                                //echo $cod."-".$cant."</br>";
                                // Imprimo cada fila del item
                            }
                        ?>
                        
                        <tr>
                            <td class="col-sm-8 col-md-6">
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;"> </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#"> Modelo</a></h4>
                                        <h5 class="media-heading"> by <a href="#"> Marca</a></h5>
                                        <span>Descripción: </span><span class="text-success"><strong>bla bla bla</strong></span>
                                    </div>
                                </div></td>
                            <td class="col-sm-1 col-md-1" style="text-align: center">
                                <input type="number" class="form-control" min="1" max="10" id="exampleInputEmail1" value="3">
                            </td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>4.87€</strong></td>
                            <td class="col-sm-1 col-md-1 text-center"><strong>14.61€</strong></td>
                            <td class="col-sm-1 col-md-1">
                                <button type="button" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span> Eliminar
                                </button></td>
                        </tr>
                        <tr>
                            <td class="col-md-6">
                                <div class="media">
                                    <a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;"> </a>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#">Modelo/a></h4>
                                        <h5 class="media-heading"> by <a href="#">Marca</a></h5>
                                        <span>Descripción: </span><span class="text-warning"><strong>bla bla bla</strong></span>
                                    </div>
                                </div></td>
                            <td class="col-md-1" style="text-align: center">
                                <input type="number" class="form-control" min="1" max="10" id="exampleInputEmail1" value="2">
                            </td>
                            <td class="col-md-1 text-center"><strong>4.99€</strong></td>
                            <td class="col-md-1 text-center"><strong>9.98€</strong></td>
                            <td class="col-md-1">
                                <button type="button" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span> Eliminar
                                </button></td>
                        </tr>
                    </tbody>
                    <!-- Pie de Tabla -->
                    <tfoot>
                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td><h5>Subtotal<br>I.V.A</h5><h3>Total</h3></td>
                            <td class="text-right"><h5><strong>24.59€<br>6.94€</strong></h5><h3>31.53€</h3></td>
                        </tr>

                        <tr>
                            <td>
                                <a href="principal.php" class="btn btn-default"><span class="glyphicon glyphicon-shopping-cart"></span> Seguir Comprando</a>
                            </td>
                            <td>   </td>
                            <td>   </td>
                            <td>
                                <button type="button" class="btn btn-info">
                                    <span class="glyphicon glyphicon-refresh"></span> Actualizar Carro
                                </button></td>
                            <td>
                                <button type="button" class="btn btn-success">
                                    <span class="glyphicon glyphicon-credit-card"></span>  Pagar Compra
                                </button></td>
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