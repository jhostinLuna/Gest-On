<?php

class Usuario{
    
    private $pdo;
    private $dni;
    private $nombre;
    private $apellidos;
    private $movil;
    private $tipo;
    private $clave;
    private $departamento;
    public function __construct($registro)
    {
        $this->pdo = ConexionPDO::singleton("gestion");
        $this->dni = $registro['dni'];
        $this->nombre = $registro['nombre'];
        $this->apellidos = $registro['apellidos'];
        $this->movil = $registro['movil'];
        $this->tipo = $registro['tipo'];
        $this->clave = $registro['clave'];
        $this->correo = $registro['correo'];
        $this->departamento = $registro['id_deptno'];
    }

}
class Emisor extends Usuario{
    public function __construct($registro) {
        parent::__construct($registro);
    }
    public function createIncidencia($incidencia){
        
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,dni,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:dni,:id_deptno
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia crear incidencia".$e->getMessage();
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
    public function __construct($registro) {
        parent::__construct($registro);
    }
    public function createIncidencia($incidencia){
        
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,dni,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:dni,:id_deptno
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
                                    dni = :dni,
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
                                    gestor = :gestor,
                                    id_deptno = :id_deptno WHERE id_inc = :id_inc";
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
    public function deleteUsuario($dni){
        try {
            $query = "DELETE FROM usuarios WHERE dni = :dni
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($dni);
        } catch (PDOException $e) {
            echo "ERROR al borrar un usuario".$e->getMessage();
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
                                    id_deptno = :id_deptno WHERE dni = :dni";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando datos de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
}
?>