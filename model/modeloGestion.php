<?php
require_once "ConexionPDO.php";
include_once "./modelo/Usuarios.php";
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
            
            
        } catch (PDOException $e) {
            echo "ERROR al acceder a la base de datos ".$e->getMessage();
        }
        return $result->fetchAll();
    }
    // Crea un tipo de usuario si es que la clave y dni coinciden ó NULL si no existe
    public function accesoUsuario($dni,$clave){
        $reg = $this->existUsuario($dni);
        $reg = $reg[0];
        $usuario = null;
        $em = "Emisor";
        $ge = "Gestor";
        $ad = "Administrador";
        
        if (!empty($reg)) {
            if (strcmp($clave,$reg['clave'])) {
                $usuario = new ${$reg['tipo']}($reg);
            }   
        }
        return $usuario;
    }
       
    //Crea un usuario en base de datos Devuelve filas afectadas ó cero filas
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
    public function createDepartamento($departamento){
        try {
            $query = "INSERT INTO usuarios VALUES(
                id_deptno = :id_deptno,
                nombre = :nombre,
                adm = null,
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
    // Asigna administrador a un departamento tiene que existir antes el usuario administrador
    public function asignaAdministrador($adm){
        try {
            $query = "UPDATE departamento SET 
                                                                      
                                    adm = :adm WHERE id_deptno = :id_deptno";
            $result = $this->pdo->prepare($query);
            $result->execute($adm);
        } catch (PDOException $e) {
                echo "ERROR al añadir jefe de departamento ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function getDeptno(){
        try {
            $query = "SELECT * FROM departamentos";
            $result = $this->pdo->prepare($query);
            $result->execute();
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
}


?>