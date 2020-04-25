<?php

class TablaIncidencias {
    private $pdo;
    private $tabla;
    private $estado;
    private $prioridad;
    private $fecha;
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("gestion");
        $this->iniciaTabla();
        
    }
    private function iniciaTabla(){
        
        try {
            $query = "select i.asunto,case when (i.prioridad is null) then null else i.prioridad 
            end as prioridad,i.estado,i.gestor,case when(i.gestor is null) then null else u.nombre 
            end as ges_nombre,i.f_creacion,i.id_inc,i.id_usu,u.nombre as autor,d.nombre as dnombre 
            from incidencias i join departamentos d on i.id_deptno = d.id_deptno join usuarios 
            u on u.id_usu = i.id_usu;";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de incidencias ". $e->getMessage();
        }
        
        $this->tabla = $result->fetchAll();

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
    /*
    Devuelve todas las incidencias si le pasan el segundo parametro y si no 
    devuelve las del estado que le pasan como parametro y del usuario que las pide
    */

    public function misIncidencias($usuario,$estado = "*"){
        $this->iniciaTabla();
        $nuevo = null;
        if ($estado =="*") {
            for ($i=0; $i < count($this->tabla); $i++) { 
                if (strcmp($this->tabla[$i]['id_usu'],$usuario) === 0) {
                    $nuevo[] = $this->tabla[$i];
                }
            }
        }else{
            for ($i=0; $i < count($this->tabla); $i++) { 
                if (strcmp($this->tabla[$i]['estado'],$estado) === 0 && strcmp($this->tabla[$i]['id_usu'],$usuario) === 0) {
                    $nuevo[] = $this->tabla[$i];
                }
            }
        }
        
        return $nuevo;
    }
    public function getInc($estado){
        $this->iniciaTabla();
        $nuevo = null;
        for ($i=0; $i < count($this->tabla); $i++) { 
            if (strcmp($this->tabla[$i]['estado'],$estado) === 0 ) {
                $nuevo[] = $this->tabla[$i];
            }
        }
        return $nuevo;
    }
}

?>