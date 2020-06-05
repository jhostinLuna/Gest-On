<?php

class TablaIncidencias {
    private $pdo;
    private $tabla;
    
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("jhostin");
        $this->iniciaTabla();
        
    }
    public function iniciaTabla(){
        
        try {
            $query = "SELECT i.equipo,i.ubicacion,i.asunto,case when (i.prioridad is null) then null else i.prioridad 
            end as prioridad,i.estado,i.gestor,i.f_creacion,i.id_inc,i.id_usu,u.nombre as autor 
            from incidencias i  join usuarios u on u.id_usu = i.id_usu order by f_creacion  DESC";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de incidencias ". $e->getMessage();
        }
        
        $this->tabla = $result->fetchAll();

    }
    
    public function ordenEstado(){
        try {
            $query = "SELECT i.equipo,i.ubicacion,i.asunto,case when (i.prioridad is null) then null else i.prioridad 
            end as prioridad,i.estado,i.gestor,i.f_creacion,i.id_inc,i.id_usu,u.nombre as autor 
            from incidencias i  join usuarios u on u.id_usu = i.id_usu order by estado ASC,f_creacion  DESC";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de incidencias ". $e->getMessage();
        }
        
        $this->tabla = $result->fetchAll();
    }
    public function ordenPrioridad(){
        try {
            $query = "SELECT i.equipo,i.ubicacion,i.asunto,case when (i.prioridad is null) then null else i.prioridad 
            end as prioridad,i.estado,i.gestor,i.f_creacion,i.id_inc,i.id_usu,u.nombre as autor 
            from incidencias i  join usuarios u on u.id_usu = i.id_usu order by prioridad DESC,f_creacion  DESC";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de incidencias ". $e->getMessage();
        }
        
        $this->tabla = $result->fetchAll();
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
    public function incGestor($usuario,$estado = "*"){
        
        $nuevo = null;
        if ($estado =="*") {
            for ($i=0; $i < count($this->tabla); $i++) { 
                if (strcmp($this->tabla[$i]['gestor'],$usuario) === 0) {
                    $nuevo[] = $this->tabla[$i];
                }
            }
        }else{
            for ($i=0; $i < count($this->tabla); $i++) { 
                if (strcmp($this->tabla[$i]['estado'],$estado) === 0 && strcmp($this->tabla[$i]['gestor'],$usuario) === 0) {
                    $nuevo[] = $this->tabla[$i];
                }
            }
        }
        
        return $nuevo;
    }
    public function misIncidencias($usuario,$estado = "*"){
        
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