<?php

class Usuario{
    
    
    protected $id_usu;
    protected $nombre;
    protected $apellidos;
    protected $movil;
    protected $tipo;
    protected $clave;
    
    public function __construct($registro) {
        
        $this->id_usu = $registro['id_usu'];
        $this->nombre = $registro['nombre'];
        $this->apellidos = $registro['apellidos'];
        $this->movil = $registro['movil'];
        $this->tipo = $registro['tipo'];
        $this->clave = $registro['clave'];
        $this->correo = $registro['correo'];
        
        
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }

}
class Emisor extends Usuario{
    private $pdo;
    public function __construct($registro) {
        
        parent::__construct($registro);
        $this->pdo = ConexionPDO::singleton("jhostin");
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }
    
    public function createIncidencia($incidencia){
        
        try {
            $query = "INSERT INTO incidencias (equipo,ubicacion,asunto,id_usu) VALUE(
                :equipo,:ubicacion,:asunto,:id_usu
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR al crear incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    
    use Todos;
}
class Gestor extends Usuario{
    private $pdo;
    public function __construct($registro) {
        
        parent::__construct($registro);
        $this->pdo = ConexionPDO::singleton("jhostin");
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }
    
    public function cambiaEstado($estado){
        
        try {
            $query = "UPDATE incidencias SET
                                    estado = :estado
                                    WHERE id_inc = :id_inc";
            $result = $this->pdo->prepare($query);
            $result->execute($estado);
        } catch (PDOException $e) {
            echo "ERROR al cambiar de estado Incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    use Todos;
}
class Administrador extends Usuario{
    private $pdo;
    public function __construct($registro) {
        
        parent::__construct($registro);
        $this->pdo = ConexionPDO::singleton("jhostin");
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }
    
    public function deleteIncidencias(){
        
        try {
            $query = "DELETE FROM incidencias WHERE estado = 'resuelta'";
            $result = $this->pdo->prepare($query);
            $result->execute();
        } catch (PDOException $e) {
            echo "ERROR en la sentencia borrar incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    
    public function asignarGestor($gestor){
        
        try {
            $query = "UPDATE incidencias SET                                     
                                    gestor = :gestor,
                                    prioridad = :prioridad
                                    WHERE id_inc = :id_inc";
            $result = $this->pdo->prepare($query);
            $result->execute($gestor);
        } catch (PDOException $e) {
                echo "ERROR asignando un gestor \"incidencia\" ".$e->getMessage();
        }
        return $result->rowCount();
    }

    public function cambiaEstado($estado){
        
        try {
            $query = "UPDATE incidencias SET
                                    estado = :estado
                                    WHERE id_inc = :id_inc";
            $result = $this->pdo->prepare($query);
            $result->execute($estado);
        } catch (PDOException $e) {
            echo "ERROR al cambiar de estado \"Incidencia\"".$e->getMessage();
        }
        return $result->rowCount();
    }

    //Usuarios
    public function deleteUsuario($id_usu){
        
        try {
            $query = "DELETE FROM usuarios WHERE id_usu = :id_usu
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($id_usu);
        } catch (PDOException $e) {
            echo "ERROR al borrar un usuario".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function crearGestor($usuario){

        
        try {
            $query = "UPDATE usuarios SET                                     
                                    tipo = :tipo WHERE id_usu = :id_usu";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando tipo de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
    
    // Asigna administrador a un departamento tiene que existir antes el usuario administrador
    
    use Todos;
    
    
}
trait Todos {
    public function updateMovil($usuario){        
        try {
            $query = "UPDATE usuarios SET movil = :movil WHERE id_usu = :id_usu";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando datos de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function updateCorreo($usuario){       
        try {
            $query = "UPDATE usuarios SET                                 
                                    correo = :correo WHERE id_usu = :id_usu";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando datos de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
}
?>