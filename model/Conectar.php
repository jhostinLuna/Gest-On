<?php
class Conectar {
    private $id;
    private static $instancia;
    private $filas = array();
    private function __construct($database){
        $dsn = "mysql:host=localhost;dbname=$database";
        $this->id = new PDO($dsn,'gestion','Nohay2sin3');
    }

    public static function singleton($database){
        if (!isset(self::$instancia)) {
            self::$instancia = new Conectar($database);        
        }
        return self::$instancia->id;
    }
    public function __clone(){
        echo "No es posible clonar el objeto!!!!!";
    }

    public function crearIncidencia($incidencia){
        
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,dni,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:dni,:id_deptno
            )";
            $result = $this->id->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia crear incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function borraIncidencia($incidencia){
        try {
            $query = "DELETE FROM incidencias WHERE id_inc = :id_inc
            )";
            $result = $this->id->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia borrar incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    
}
?>