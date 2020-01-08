<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function alerta($texto) {
    echo '<script type="text/javascript">alert("' . $texto . '")</script>';
}

function crearFoto() {
    $extension = explode("/", $_FILES['foto']['type']);
    $nombreFoto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name']) . "." . $extension[1];

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], ROOT_PATH . "/fotos/" . $nombreFoto)) {
        header("location: error.php");
        exit();
    }
    return $nombreFoto;
}

function borrarFoto($nombreFoto) {
    $fichero = ROOT_PATH . "fotos/" . $nombreFoto;
    //echo $fichero;
    if (file_exists($fichero)) {
        @unlink($fichero);
        //throw new Exception('No se puede borrar el fichero ' . $fichero . ' Por favor cierre otras aplicaciones que lo pueden estar usando.');
    }
    return true;
}

function actualizarFoto(){
    $fotoAnterior = trim($_POST["fotoAnterior"]);
    // Procesamos la imagen
    $extension = explode("/", $_FILES['foto']['type']);
    $nombreFoto = md5($_FILES['foto']['tmp_name'] . $_FILES['foto']['name']) . "." . $extension[1];
    //echo ROOT_PATH . "fotos/$nombreFoto";
    //exit();
    if (!move_uploaded_file($_FILES['foto']['tmp_name'], ROOT_PATH . "fotos/$nombreFoto")) {
        //header("location: error.php");
        //exit();
        $nombreFoto = $fotoAnterior;
    }else{
        borrarFoto($fotoAnterior);
    }
    return $nombreFoto;
}
