<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";

// Cabecera
require_once VIEW_PATH . "cabecera.php";

// Barra de Navegacion
//require_once VIEW_PATH . "navbaroff.php";
$contCarrito = ControladorCarrito::getControlador();

// Parte del pago
if (isset($_POST["propietarioT"]) && isset($_POST["numeroT"])) {
    // Recuperamos el carro salvado
    $contCarrito->getSesionVenta();
    $contCarrito->getVenta()->setNombreTarjeta(trim($_POST["propietarioT"]));
    $contCarrito->getVenta()->setNumTarjeta(substr(trim($_POST["numeroT"]),-4));
    // Almancenar la venta 
    $contCarrito->almacenarVentaBD();
    
    //exit();
}else{
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['finalizar'])){
        $contCarrito->destruirCarrito();
        $contCarrito->carritoVacio();
    }
    else{
        header("Refresh: 0; url=principal.php"); 
    }
}

?>
<main role="main">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<section class="page-header clearfix text-center">
                    <h3 class="pull-left">Factura</h3>
                    <h3 class="pull-right">Pedido nº: <?php echo $contCarrito->getVenta()->getIdVenta(); ?></h3>
                </section>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturado a:</strong><br>
    					<?php echo $contCarrito->getVenta()->getNombreTarjeta(); ?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Enviado a:</strong><br>
    					<?php echo $contCarrito->getVenta()->getNombre(); ?><br>
    					<?php echo $contCarrito->getVenta()->getDireccion(); ?><br>
    					<?php echo $contCarrito->getVenta()->getEmail(); ?><br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Método de pago:</strong><br>
    					Tarejta de Credito/debito: **** <?php echo $contCarrito->getVenta()->getNumTarjeta(); ?><br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Fecha de compra:</strong><br>
    					<?php echo $contCarrito->getVenta()->getFecha(); ?><br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Productos</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Precio (PVP)</strong></td>
        							<td class="text-center"><strong>Cantidad</strong></td>
        							<td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                        <?php
                                                        $lineas = $contCarrito->getVenta()->getLineas();
                                                        foreach ($lineas as $linea) {
                                                            echo "<tr>";
                                                            echo "<td>".$linea->getMarca()." ".$linea->getModelo()."</td>";
                                                            echo "<td class='text-center'>".$linea->getPrecio()." €</td>";
                                                            echo "<td class='text-center'>".$linea->getCantidad()."</td>";
                                                            echo "<td class='text-right'>".$linea->getTotal()." €</td>";
                                                            echo "</tr>";
                                                        }
                                                        ?>
    							
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Total sin IVA</strong></td>
    								<td class="thick-line text-right"><?php echo $contCarrito->getVenta()->getSubtotal(); ?> €</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>I.V.A</strong></td>
    								<td class="no-line text-right"><?php echo $contCarrito->getVenta()->getIva(); ?> €</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>TOTAL</strong></td>
                                                                <td class="no-line text-right"><strong><?php echo $contCarrito->getVenta()->getTotal(); ?> €</strong></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
<form class="form-horizontal" role="form" method="POST" action="carrito_factura.php">
<div class="form-group">
          <div class='text-center'>
              <button type="button" class="btn btn-info" name="finalizar" onclick="window.print()"> <span class="glyphicon glyphicon-print"></span> Imprimir</button>
            <button type="submit" class="btn btn-success" name="finalizar"> <span class="glyphicon glyphicon-ok"></span>  Finalizar</button>
          </div>
          </div>
</form>
 
</main>

<?php
//require_once VIEW_PATH . "pie.php";
?>