<!-- ¡Barra de navegacion -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/tienda/dirs.php";

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
     /*
    if(!isset($_SESSION['USR_ADMIN'])){
      echo "<li><a href='#'>Todo</a></li>";
      echo "<li><a href='#'>Discos Duro</a></li>";
      echo "<li><a href='#'>Monitores</a></li>";
      echo "<li><a href='#'>Portatiles</a></li>";
      echo "<li><a href='#'>Ofertas</a></li>";
      // Opciones de aministrador
    }else {
      echo "<li><a href='#'>Productos</a></li>";
      echo "<li><a href='#'>Usuarios</a></li>";
    }
      */
    echo "</ul>";
      // Parte de la derecha de la página web
      echo "<ul class='nav navbar-nav navbar-right'>";
      /*
      if(isset($_SESSION['USUARIO'])|| isset($_SESSION['USR_ADMIN'])){
        echo "<li><p class='navbar-text'>".$_SESSION['USUARIO']['nombre']."</p></li>";
        //echo "<li><a href='#'><span class='glyphicon glyphicon-user'></span> Registrarse</a></li>";
        echo "<li><a href='vistas/salir.php'><span class='glyphicon glyphicon-log-out'></span> Salir</a></li>";
      }else {
        echo "<li><a href='#'><span class='glyphicon glyphicon-user'></span> Registrarse</a></li>";
        echo "<li><a href='vistas/identificarse.php'><span class='glyphicon glyphicon-log-in'></span> Identificarse</a></li>";
      }
       */
    echo "</ul>";
  echo "</div>";
echo "</nav>";
echo "<br><br>";
// Fin PHP
?>
