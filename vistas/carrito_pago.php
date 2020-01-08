<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";

// Cabecera
require_once VIEW_PATH . "cabecera.php";

// Barra de Navegacion
require_once VIEW_PATH . "navbar.php";

?>
<main role="main">
    <section class="page-header clearfix text-center">
                    <h2>Pago electrónico</h2>
                    <img src="http://i76.imgup.net/accepted_c22e0.png">
    </section>
<div class="container">
    
  <form class="form-horizontal" role="form">
    <fieldset>
      <legend>Tarjeta de crédito o débito</legend> 
      
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-holder-name">Nombre de la tarjera</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Nombre del prepietario">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-number">Número de la tarjeta</label>
        <div class="col-sm-9">
          <input type="number" class="form-control" name="card-number" id="card-number" placeholder="Número de la tarjeta de crédito o débito">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="expiry-month">Fecha de Caducidad</label>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                <option>Mes</option>
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
              <select class="form-control" name="expiry-year">
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
          <input type="text" class="form-control" name="cvv" id="cvv" placeholder="CVV">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
          <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-credit-card"></span>  Pagar Compra
        </div>
      </div>
    </fieldset>
  </form>
</div>
    
    
</main>

<?php
require_once VIEW_PATH . "pie.php";
?>