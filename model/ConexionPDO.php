<?php
class ConexionPDO {
    private $id;
    private static $instancia;
    
    private function __construct($database){
        $dsn = "mysql:host=localhost;dbname=$database";
        $this->id = new PDO($dsn,'gest','Nohay2sin3');
    }

    public static function singleton($database){
        if (!isset(self::$instancia)) {
            self::$instancia = new ConexionPDO($database);        
        }
        return self::$instancia->id;
    }
    public function __clone(){
        echo "No es posible clonar el objeto!!!!!";
    }

    
    
}
?>