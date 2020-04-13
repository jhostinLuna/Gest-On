<?php
require_once "./model/ConexionPDO.php";
include_once "./model/Usuarios.php";
include_once "./model/TablaIncidencias.php";
class Modelo{
    private $pdo;
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("gestion");
    }
//USUARIOS:
    /*
    Devuelve el array asociativo con datos de usuario que coincida con el dni 
    pasado por parametro
    */
    public function existUsuario($dni){
        $usuario = null;
        try {
            $query = "select * from usuarios WHERE dni = :dni";
            $result = $this->pdo->prepare($query);
            $result->execute($dni);
            $result->setFetchMode(PDO::FETCH_ASSOC);            
        } catch (PDOException $e) {
            echo "ERROR al acceder a la base de datos ".$e->getMessage();
        }
        
        return $result->fetchAll();
    }
    // Crea un tipo de usuario si es que la clave y dni coinciden ó NULL si no existe
    public function accesoUsuario($acceso){
        
        $clave = $acceso[':clave'];
        unset($acceso[':clave']);
        $reg = $this->existUsuario($acceso);
        $reg = $reg[0];
        $usuario = null;
        $em = "Emisor";
        $ge = "Gestor";
        $ad = "Administrador";
        
        if (!empty($reg)) {
            if (strcmp($clave,$reg['clave']) === 0) {
                $usuario = new ${$reg['tipo']}($reg);
            }   
        }
        return $usuario;
    }
       
    //Crea un usuario en base de datos Devuelve filas afectadas ó cero filas
    public function createUsuario($usuario){
        try {
            $query = "INSERT INTO usuarios VALUES(
                :dni,
                :nombre,
                :apellidos,
                :correo,
                :tipo,
                :clave,
                :id_deptno
            )";
            $result = $this->pdo->prepare($query);
            $result->execute($usuario);

        } catch (PDOException $e) {
            echo "ERROR al crear usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
    //Devuelve array con todos los usuarios o un array vacio
    public function getUsuarios(){
        try {
            $query = "SELECT dni nombre apellidos correo tipo id_deptno FROM usuarios";
            $result = $this->pdo->prepare($query);
            $result->execute();
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
//DEPARTAMENTOS:
    //Crea departamento en base de datos Devuelve cantidad de filas afectadas
    public function getDeptno(){
        try {
            $query = "select d.id_deptno,d.nombre as dnombre,d.ciudad,d.cp,u.nombre,u.apellidos,u.dni from departamentos d join usuarios u 
            where d.dni is not null group by d.id_deptno";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
}


?>