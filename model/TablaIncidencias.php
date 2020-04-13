<?php

class TablaIncidencias {
    private $pdo;
    private $tabla;
    private $estado;
    private $prioridad;
    private $fecha;
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("gestion");
        $this->tabla = $this->iniciaTabla();
        
    }
    private function iniciaTabla(){
    
        try {
            $query = "SELECT * FROM incidencias";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de incidencias ". $e->getMessage();
        }
        
        return $result->fetchAll();
    }
    public function ordenEstado($orden){
        $estados = array('Pdte.Asignar','Asignado','Pdte.Aprobado','Resuelto');
        $indice = array_search($orden,$estados);
        ($indice == 3)?  $indice = 0 : $indice++;
        $this->estado = $estados[$indice];
        usort($this->tabla,"cmpEstado");
    }
    private function cmpEstado($a,$b){
        $e = $this->estado;
        $aux = false;
        if (strcmp($b['estado'],$e) === 0) {
            $aux = 1;
        }
        elseif (strcmp($a['estado'],$e) === 0) {
            $aux = -1;
        }
        elseif (strcmp($a['estado'],$b['estado']) === 0) {
            $aux = 0;
        }
        return $aux;
    }
    public function ordenPrioridad($orden){
        $prioridad = array("baja","media","alta");
        $indice = array_search($orden,$prioridad);
        ($indice == 3)?  $indice = 0 : $indice++;
        $this->estado = $prioridad[$indice];
        usort($this->tabla,"cmpPrioridad");
    }
    private function cmpPrioridad($a,$b){
        $p = $this->prioridad;
        $aux = false;
        if (strcmp($b['prioridad'],$p) === 0) {
            $aux = 1;
        }
        elseif (strcmp($a['prioridad'],$p) === 0) {
            $aux = -1;
        }
        elseif (strcmp($a['prioridad'],$b['prioridad']) === 0) {
            $aux = 0;
        }
        return $aux;
    }
    //Recibe como paramatro true o false 
    public function ordenFecha($orden){
        $this->fecha = !$orden;
        usort($this->tabla,"cmpFecha");
    }
    private function cmpFecha($a,$b){
        $x = $this->fecha;
        $aux = 0;
        if ($x) {
            (time($a['f_creacion']) < time($b['f_creacion']))? $aux = -1: $aux = 1;
        }else{
            (time($a['f_creacion']) > time($b['f_creacion']))? $aux = -1: $aux = 1;
        }
        
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }
    public function cantidadE($estado){
        $cont = 0;
        for ($i=0; $i < count($this->tabla); $i++) { 
            foreach ($this->tabla[$i] as $key => $value) {
                if ($key == $estado) {
                    $cont++;
                }
            }
        }
        return $cont;
    }

    
}

?>