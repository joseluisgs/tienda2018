<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorAcceso.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";

error_reporting(E_ALL & ~E_NOTICE);

// Cabecera
require_once VIEW_PATH . "cabecera.php";

// Barra de Navegacion
require_once VIEW_PATH . "navbaroff.php";

$controlador = ControladorAcceso::getControlador();
$controlador->controlAccesoUsuario();

$contCarrito = ControladorCarrito::getControlador();

?>
<?php
// Recogemos el usuario
if(isset($_SESSION['USUARIO'])){
    $contUsuario = ControladorUsuario::getControlador();
    $id = base64_decode($_SESSION['USUARIO']);
    $usuario = $contUsuario->buscarUsuarioID($id);
    
    // Recogemos el carrito y los elementos
    if (isset($_SESSION['CARRITO']) && $_SESSION['CARRITO'] != "") {
        if (isset($_REQUEST['COD']) && isset($_REQUEST['CANT'])) {
            $ids = $_REQUEST['COD'];
            $cantidades = $_REQUEST['CANT'];
            $venta = base64_decode($_SESSION['SESION']);
            $contCarrito->crearVenta($venta, $usuario, $ids, $cantidades);
            // Almacenamos la venta en la sesion
            $contCarrito->setSesionVenta();
        }
    }
}
 
?>
<main role="main">
    <section class="page-header clearfix text-center">
                    <h2>Pago electrónico</h2>
                    <img src="http://i76.imgup.net/accepted_c22e0.png">
                    
    </section>
    <section class="text-center">
                    <h3>Información de la venta</h3>
                    
                    <?php
                        echo "<p class='text-center'><strong>Venta: </strong>". $contCarrito->getVenta()->getIdVenta()."</p>";
                        //echo "<p class='text-center'><strong>Nombre: </strong>". $contCarrito->getVenta()->getNombre()."</p>";
                        echo "<p class='text-center'><strong>Total: </strong>" . $contCarrito->getVenta()->getTotal()." €</p>";
                    ?>
    </section>
<div class="container">
    
    <form class="form-horizontal" role="form" method="POST" action="carrito_factura.php">
    <fieldset>
      <legend>Tarjeta de crédito o débito</legend> 
      
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-holder-name">Nombre de la tarjera</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" required name="propietarioT" id="card-holder-name" placeholder="Nombre del prepietario">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="numeroT">Número de la tarjeta</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" required name="numeroT" id="card-number" pattern="[0-9]{13,16}" placeholder="Número de la tarjeta de crédito o débito">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="expiry-month">Fecha de Caducidad</label>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" required name="mesT" id="expiry-month">
                <option value="01">Enero (01)</option>
                <option value="02">Febrero (02)</option>
                <option value="03">Marzo (03)</option>
                <option value="04">Abril (04)</option>
                <option value="05">Mayo (05)</option>
                <option value="06">Junio (06)</option>
                <option value="07">Julio (07)</option>
                <option value="08">Aagosto (08)</option>
                <option value="09">Septiembre (09)</option>
                <option value="10">Octubre (10)</option>
                <option value="11">Noviembre (11)</option>
                <option value="12">Deciembre (12)</option>
              </select>
            </div>
            <div class="col-xs-3">
              <select class="form-control" required name="añoT">
                <option value="19">2019</option>
                <option value="20">2020</option>
                <option value="21">2021</option>
                <option value="22">2022</option>
                <option value="23">2023</option>
                 <option value="24">2024</option>
                  <option value="25">2025</option>
                   <option value="26">2026</option>
                   <option value="27">2027</option>
                   <option value="28">2028</option>
                   <option value="29">2029</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="cvv">CVV</label>
        <div class="col-sm-3">
          <input type="number" class="form-control" required name="cvvT" id="cvv" pattern="[0-9]{3}" placeholder="CVV">
        </div>
      </div>
      <div class="form-group">
          <div class='text-center'>
              <a href="carrito_compra.php" class="btn btn-primary"><span class="glyphicon glyphicon-shopping-cart"></span> Volver al carro</a>
              <a href="carrito_compra.php?VACIAR=1" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Cancelar compra</a>        
        <button type="submit" class="btn btn-success"> <span class="glyphicon glyphicon-credit-card"></span>  Pagar y finalizar</button>
          </div>
          </div>
    </fieldset>
  </form>
</div>
    
    
</main>

<?php
require_once VIEW_PATH . "pie.php";
?>