<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";

// Cabecera
require_once VIEW_PATH . "cabecera.php";

// Barra de Navegacion
require_once VIEW_PATH . "navbar.php";

?>
<main role="main">
    <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Factura</h2><h3 class="pull-right">Pedido nº: 12345</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturado a:</strong><br>
    					John Smith<br>
    					1234 Main<br>
    					Apt. 4B<br>
    					Springfield, ST 54321
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Enviado a:</strong><br>
    					Jane Smith<br>
    					1234 Main<br>
    					Apt. 4B<br>
    					Springfield, ST 54321
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Método de pago:</strong><br>
    					Visa ending **** 4242<br>
    					jsmith@email.com
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Fecha de compra:</strong><br>
    					March 7, 2014<br><br>
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
        							<td class="text-center"><strong>Precio</strong></td>
        							<td class="text-center"><strong>Cantidad</strong></td>
        							<td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>
    								<td>BS-200</td>
    								<td class="text-center">10.99€</td>
    								<td class="text-center">1</td>
    								<td class="text-right">10.99€</td>
    							</tr>
                                <tr>
        							<td>BS-400</td>
    								<td class="text-center">20.00€</td>
    								<td class="text-center">3</td>
    								<td class="text-right">60.00€</td>
    							</tr>
                                <tr>
            						<td>BS-1000</td>
    								<td class="text-center">600.00€</td>
    								<td class="text-center">1</td>
    								<td class="text-right">600.00€</td>
    							</tr>
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">670.99€</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>I.V.A</strong></td>
    								<td class="no-line text-right">15€</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>TOTAL</strong></td>
                                                                <td class="no-line text-right"><strong>685.99€</strong></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
</main>

<?php
require_once VIEW_PATH . "pie.php";
?>