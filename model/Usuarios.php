<?php

class Usuario{
    
    private $pdo;
    private $id_usu;
    private $nombre;
    private $apellidos;
    private $movil;
    private $tipo;
    private $clave;
    private $departamento;
    public function __construct($registro) {
        
        $this->id_usu = $registro['id_usu'];
        $this->nombre = $registro['nombre'];
        $this->apellidos = $registro['apellidos'];
        $this->movil = $registro['movil'];
        $this->tipo = $registro['tipo'];
        $this->clave = $registro['clave'];
        $this->correo = $registro['correo'];
        $this->departamento = $registro['id_deptno'];
        $this->pdo = ConexionPDO::singleton("gestion");
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }

}
class Emisor extends Usuario{
    public function __construct($registro) {
        parent::__construct($registro);
    }
    
    public function createIncidencia($incidencia){
        $this->pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,id_usu,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:id_usu,:id_deptno
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia crear incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    /*
    public function cambiaEstado($estado){
        $this->pdo = ConexionPDO::singleton("gestion");
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
    */
}
class Gestor extends Usuario{
    public function __construct($registro) {
        parent::__construct($registro);
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
}
class Administrador extends Usuario{
    private $departamentos;
    public function __construct($registro) {
        $this->departamentos = $this->getDeptno();
        parent::__construct($registro);
        
    }
    public function __get($propiedad) {
        if(property_exists($this, $propiedad)) {
            return $this->$propiedad;
        }
    }
    public function createIncidencia($incidencia){
        
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,id_usu,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:id_usu,:id_deptno
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia crear incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function deleteIncidencia($incidencia){
        
        try {
            $query = "DELETE FROM incidencias WHERE id_inc = :id_inc
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia borrar incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function updateIncidencia($incidencia){
        
        try {
            $query = "UPDATE incidencia SET 
                                    asunto = :asunto,
                                    prioridad =:prioridad,
                                    estado = :estado,
                                    gestor = :gestor,
                                    f_creacion = :f_creacion,
                                    id_usu = :id_usu,
                                    id_deptno = :id_deptno WHERE id_inc = :id_inc";
            $result = $this->pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
                echo "ERROR actualizando la incidencia ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function asignarGestor($gestor){
        
        try {
            $query = "UPDATE incidencia SET                                     
                                    gestor = :gestor WHERE id_inc = :id_inc";
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
    public function crearAdmin($usuario){

        
        try {
            $query = "UPDATE usuarios SET                                     
                                    tipo = 'ad' WHERE id_usu = :id_usu";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando datos de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function updateUsuario($usuario){

        
        try {
            $query = "UPDATE usuarios SET 
                                    nombre = :nombre,
                                    apellidos = :apellidos,
                                    correo = :correo,
                                    tipo = :tipo,
                                    clave = :clave,                                    
                                    id_deptno = :id_deptno WHERE id_usu = :id_usu";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando datos de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function createDepartamento($departamento){
        
        
        try {
            $query = "INSERT INTO departamentos VALUES(
                :id_deptno,
                :nombre,
                null,
                :ciudad,
                :cp
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($departamento);

        } catch (PDOException $e) {
            echo "ERROR al crear depratamento ".$e->getMessage();
        }
        return $result->rowCount();
    }
    // Asigna administrador a un departamento tiene que existir antes el usuario administrador
    public function asignaAdministrador($adm){
        
        try {
            $query = "UPDATE departamento SET 
                                                                      
                                    adm = :id_usu WHERE id_deptno = :id_deptno";
            $result = $this->pdo->prepare($query);
            $result->execute($adm);
        } catch (PDOException $e) {
                echo "ERROR al añadir jefe de departamento ".$e->getMessage();
        }
        return $result->rowCount();
    }
    /*
    public function getDeptno(){
        
        
        try {
            $query = "select d.id_deptno,d.nombre as dnombre,d.ciudad,d.cp,u.nombre,
            u.apellidos,u.id_usu from departamentos d join usuarios u  group by d.id_deptno;";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    */
    public function getUsuariosGestores(){
        try {
            $query = "select u.*,count(i.id_inc) as asignadas from usuarios u  join incidencias i where u.id_usu = i.gestor  group by u.id_usu;;";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros Usuarios e Incidencias ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    
}
?>