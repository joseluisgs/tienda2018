<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paginador
 * Clase Paginador
 * @author link
 */
require_once CONTROLLER_PATH . "ControladorBD.php";

class Paginador {

    //private $conexion;
    private $limite = 5;
    private $pagina;
    private $consulta;
    private $total;
    private $bd;

    /**
     * Constructor por defecto
     * @param type $consulta
     * @param type $limite
     */
    public function __construct($consulta, $limite) {
        $this->limite = $limite;
        $this->consulta = $consulta;
        $this->bd = ControladorBD::getControlador();
        $this->bd->abrirBD();
        $filas = $this->bd->consultarBD($this->consulta);
        $this->total = $filas->rowCount();
        $this->bd->cerrarBD();
    }

    /**
     * Obtiene los datos de una página
     * @param type $p
     * @return \stdclass
     */
    public function getDatos($p) {
        $this->pagina = $p;

        $inicio = ( $this->pagina - 1 ) * $this->limite;
        if ($inicio < 0) {
            $inicio = 0;
            $this->pagina = 1;
        }

        if ($inicio > ($this->total - $this->limite)) {
           //$inicio = $this->total - $this->limite;
           $this->pagina = $this->pagina - 1;
        }
        

        

        // El objeto que devuelvo
        $result = new stdclass();
        $result->pagina = $this->pagina;
        $result->limite = $this->limite;
        $result->total = $this->total;
        $result->datos = Array();

        // Lanzo la consulta, solo si el inicio es mayor o igual a cero
        if($inicio>=0){
            $consultar = $this->consulta . ' limit ' . $inicio . ',' . $this->limite;
            //echo $consultar;
            $this->bd->abrirBD();
            $respuesta = $this->bd->consultarBD($consultar);

            while ($row = $respuesta->fetch())
                $result->datos[] = $row;
            
            $this->bd->cerrarBD();
        }

        return $result;
    }

    /**
     * Crea los enlaces
     * @param type $enlaces
     * @return string
     */
    public function crearLinks($enlaces, $filtro, $pagina) {
         //Omitimos o definimos el parámetro "filter"
        $filtro = ($filtro === "" ? "" : "&filter=" . urlencode($filtro));
        
        $ultimo = ceil($this->total / $this->limite);
        $comienzo = (($pagina - $enlaces) > 0) ? $$pagina - $enlaces : 1;
        $fin = (($pagina + $enlaces ) < $ultimo) ? $pagina + $enlaces : $ultimo;

        $clase = ($pagina == 1) ? "disabled" : "";
        $html = '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . ($comienzo) . $filtro . '">&laquo;</a></li>';

        if ($comienzo > 1) {
            $html .= '<li><a href="?limit=' . $this->limite . '&page=1' . $filtro . '">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }
        //echo $pagina;
        
        for ($i = $comienzo; $i <= $fin; $i++) {
            $clase = ( $pagina == $i ) ? "active" : "";
            $html .= '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . $i . $filtro . '">' . $i . '</a></li>';
        }

        if ($fin < $ultimo) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="?limit=' . $this->limite . '&page=' . $ultimo . $filtro . '">' . $ultimo . '</a></li>';
        }

        $clase = ( $pagina == $fin ) ? "disabled" : "enabled";                     // ($fin) --> si queremos ir a la ultima
        $html .= '<li class="' . $clase . '"><a href="?limit=' . $this->limite . '&page=' . ($fin) . $filtro . '">&raquo;</a></li>';
        return $html;
    }

}
