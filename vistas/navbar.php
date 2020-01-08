<!-- ¡Barra de navegacion -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";
require_once CONTROLLER_PATH . "ControladorUsuario.php";
require_once CONTROLLER_PATH . "ControladorCarrito.php";

// Antes de nada vamos a manejar las sesiones
session_start();

// Manejamos las variables
if(isset($_SESSION['USUARIO'])){
    $contUsuario = ControladorUsuario::getControlador();
    $id = base64_decode($_SESSION['USUARIO']);
    $usuario = $contUsuario->buscarUsuarioID($id);
    $ser = $_SESSION['USUARIO'];
} else{
    $usuario = new Usuario(-1, "", "", "", "", "", -1);
}

// Vamos con el carrito
$itemsCarrito = 0;
$contCarrito = ControladorCarrito::getControlador();
if (isset($_SESSION['CARRITO'])) {
    $itemsCarrito = $contCarrito->getTotalItems();
} else if (isset($_COOKIE['CARRITO'])) {
    //$contCarrito->leerCarritoCookie();
    $itemsCarrito = $contCarrito->getTotalItems();
}






// Barra de navegación superior
echo "<nav class='navbar navbar-inverse navbar-fixed-top'>";
  echo "<div class='container-fluid'>";
    // Logotipo
    echo "<div class='navbar-header'>";
        echo "<a class='navbar-brand' href='/tienda/index.php'>";
            echo "<span id='foo'>";
                echo "<img src='/tienda/imagenes/logo.png' height='30' width='90' alt='logo'/>";
            echo "</span>";
        echo "</a>";
    echo "</div>";
    
    // Opciones de navegación dependiendo de si es administrador o no
     echo "<ul class='nav navbar-nav'>";
    if($usuario->getAdmin()<=1){
      echo "<li><a href='principal.php?tipo=Todo'>Todo</a></li>";
      echo "<li><a href='principal.php?tipo=DiscoDuro'>Discos Duro</a></li>";
      echo "<li><a href='principal.php?tipo=Monitores'>Monitores</a></li>";
      echo "<li><a href='principal.php?tipo=Portatiles'>Portatiles</a></li>";
      echo "<li><a href='principal.php?tipo=Ofertas'>Ofertas</a></li>";
      
// Opciones de aministrador
    }if($usuario->getAdmin()==1) {
      echo "<li><a href='admin_listado_productos.php'>Productos</a></li>";
      echo "<li><a href='admin_listado_usuarios.php'>Usuarios</a></li>";
    }
    echo "</ul>";
      
// Parte de la derecha de la página web
    echo "<ul class='nav navbar-nav navbar-right'>";
      if($usuario->getAdmin()>=0){
          
          // Carrito y su color, cosas mías
        if($itemsCarrito>0){
            echo "<li><a id='carrito' href='carrito_compra.php'><span class='glyphicon glyphicon-shopping-cart'></span><font color='darksalmon'> ".$itemsCarrito."</font></a></li>";
        }else{
            echo "<li><a id='carrito' href='carrito_compra.php'><span class='glyphicon glyphicon-shopping-cart'></span>  </a></li>";
        }
        // Resto del menú
        echo "<li><a href='ficha.php?id=" .  base64_encode($usuario->getId()) . "''><span class='glyphicon glyphicon-user'></span>  ".$usuario->getNombre()."</a></li>";
        echo "<li><a href='salir.php'><span class='glyphicon glyphicon-log-out'></span> Salir</a></li>";
      
      // Vamos  
      }else if($usuario->getAdmin()==-1){
        echo "<li><a href='registro.php'><span class='glyphicon glyphicon-user'></span> Registrarse</a></li>";
        echo "<li><a href='identificacion.php'><span class='glyphicon glyphicon-log-in'></span> Identificarse</a></li>";
      }
    echo "</ul>";
  echo "</div>";
echo "</nav>";
echo "<br><br>";
// Fin PHP
?>
