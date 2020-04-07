<?php
include_once "ConexionPDO.php";
class Modelo{
    private $pdo;
    private $registros;
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("gestion");
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
    public function cambiaEstado($estado){
        try {
            $query = "UPDATE incidencias SET
                                    estado = :estado
                                    WHERE id_inc = :id_inc";
            $result = $this->pdo->prepare($query);
            $result->execute($estado);
        } catch (PDOException $e) {
            echo "ERROR al camiar de estado \"Incidencia\"".$e->getMessage();
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
    //USUARIOS:
    public function createUsuario($usuario){
        try {
            $query = "INSERT INTO usuarios VALUES(
                dni = :dni,
                nombre = :nombre,
                apellidos = :apellidos,
                correo = :correo,
                tipo = :tipo,
                clave = :clave,
                id_deptno = :id_deptno
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);

        } catch (PDOException $e) {
            echo "ERROR al crear usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
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
    public function createDepartamento($departamento){
        try {
            $query = "INSERT INTO usuarios VALUES(
                id_deptno = :id_deptno,
                nombre = :nombre,
                mgr = null,
                ciudad = :ciudad,
                cp = :cp
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($departamento);

        } catch (PDOException $e) {
            echo "ERROR al crear depratamento ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function asignaAdministrador(){
        
    }
}
?>