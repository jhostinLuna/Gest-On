<?php
require_once "./model/ConexionPDO.php";
include_once "./model/Usuarios.php";
include_once "./model/TablaIncidencias.php";
include_once "./model/Password.php";

class Modelo{
    private $pdo;
    private $usuarios;
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("gestion");
        $this->usuarios = $this->getUsuarios();
        $this->createRoot();
    }
//USUARIOS:
    /*
    Devuelve el array asociativo con datos de usuario que coincida con el dni 
    pasado por parametro
    */
    public function createRoot(){
        $pass = Password::hash('Nohay2sin3');
        $admin = array(':nombre'=>'jhostin',':apellidos'=>'luna huanca',
        ':movil'=>'622852648',':correo'=>'jhostinluna89@gmail.com',':tipo'=>'ad',
        ':clave'=>$pass,':id_deptno'=>0);
        if (empty($this->usuarios)) {
            echo $this->createUsuario($admin);
        }
    }
    public function existUsuario($id_usu){
        $usuario = null;
        try {
            $query = "select * from usuarios WHERE correo = :correo";
            $result = $this->pdo->prepare($query);
            
            $result->execute($id_usu);
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
        
        $usuario = null;
        $em = "Emisor";
        $ge = "Gestor";
        $ad = "Administrador";
        
        if (!empty($reg)) {
            $hash = $reg[0]['clave'];
            
            if (Password::verify($clave,$hash)) {
               
                $usuario = new ${$reg[0]['tipo']}($reg[0]);
            }   
        }
        return $usuario;
    }
       
    //Crea un usuario en base de datos Devuelve filas afectadas ó cero filas
    public function createUsuario($usuario){
        try {
            $query = "INSERT INTO usuarios(nombre,apellidos,movil,correo,tipo,clave,id_deptno) VALUES(
                
                :nombre,
                :apellidos,
                :movil,
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
            $query = "SELECT id_usu, nombre, apellidos, movil, correo, tipo, id_deptno FROM usuarios";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
//DEPARTAMENTOS:
    //Crea departamento en base de datos Devuelve cantidad de filas afectadas
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
    public function todoDeptno(){
        $pdo = ConexionPDO::singleton("gestion");
        
        try {
            $query = "select * from departamentos";
            $result = $pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
}

function filtrado($datos){
    
	$datos= trim($datos); //Elimina espacios antes y despues
	$datos= stripslashes($datos); //Elimina \ para que no te joda el codigo
	$datos= htmlspecialchars($datos); //Transforma caracteres especiales para que se lean en HTML
	return $datos;
}
function filtradoCompleto(){
    
    foreach ($_POST as $key => $value) {
        $_POST[$key] = filtrado($value);
    }
}
?>