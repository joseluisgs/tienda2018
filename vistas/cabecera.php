<?php 
    header('Content-Type: text/html; charset=UTF-8');
    mb_internal_encoding('UTF-8');
    mb_http_output('UTF-8');
    //mb_http_intput('UTF-8');
    
?>

<!-- Cabecera de las páginas web común a todos -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Tienda DAW v.0.8.0</title>
        <!--
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/estilos.css">
        <script src="script/jquery.min.js"></script>
        <script src="script/bootstrap.js"></script>
        -->
        <link rel="icon" type="image/png" href="https://cdn1.iconfinder.com/data/icons/social-productivity-line-art-4/128/shopping-cart2-512.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <style type="text/css">
            .wrapper{
                width: 650px;
                margin: 0 auto;
            }
            .page-header h2{
                margin-top: 0;
            }
            table tr td:last-child a{
                margin-right: 15px;
            }
            
            #logo {
                align-items: center;
                color: red;
                display: flex;
            }

            


        </style>

        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
        <script type="text/javascript">
            //cod coincide con el valor de id de la etiqueta p y le pasa la etiqueta p entera.
             function actualizarPrecio(cant,cod,precio){  
                 cod.innerHTML = cant * precio;
                 actualizarTotal();
                 
             }
             //recoge todos las etiquetas p con clase "precio" en un array
             function actualizarTotal(){
                     var precios = document.getElementsByClassName('precios'); 
                     var total = 0;
                     //recorro el array de etiquetas p con el precio haciendo un parseInt para operar con el contenido y actualizar el total.
                     for(var i = 0; i < precios.length; i++){ 
                         total += parseInt(precios[i].innerHTML);
                     }
                     document.getElementById('precioTotal').innerHTML = total;
                 }
    
        </script>
    </head>
    <body>
<!-- Cabecera de las páginas web común a todos -->
