<?php
require_once "./model/ConexionPDO.php";
include_once "./model/Usuarios.php";
include_once "./model/TablaIncidencias.php";
include_once "./model/Password.php";
include_once "./model/Mailer.php";

class Modelo{
    private $pdo;
    private $usuarios;
    public function __construct(){
        $this->pdo = ConexionPDO::singleton("jhostin");
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
        ':clave'=>$pass);
        if (empty($this->usuarios)) {
            $this->createUsuario($admin);
        }
    }
    public function cambiarClave($clave){
        try {
            $query = "UPDATE usuarios SET 
                                    clave = :clave WHERE id_usu = :id_usu";
            $result = $this->pdo->prepare($query);
            $result->execute($clave);
        } catch (PDOException $e) {
                echo "ERROR actualizar estado mensaje en base de datos ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function existUsuario($id_usu){
        
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
            $query = "INSERT INTO usuarios(nombre,apellidos,movil,correo,tipo,clave) VALUES(
                
                :nombre,
                :apellidos,
                :movil,
                :correo,
                :tipo,
                :clave
                
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
            $query = "SELECT * FROM usuarios";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
/*
            $query = "SELECT u.nombre,u.apellidos,movil,
            count(i.id_inc) AS asignadas,
            u.id_usu FROM usuarios u  JOIN incidencias i ON u.id_usu = i.gestor  
            GROUP BY u.id_usu";
            */
    public function usuariosGestores(){
        try {
            $query = "SELECT u.nombre,u.apellidos,u.movil,count(i.id_inc) AS asignadas,u.id_usu FROM usuarios u  JOIN incidencias i ON u.id_usu = i.gestor  group by u.id_usu ";
            $result = $this->pdo->prepare($query);
            $result->execute();
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registros Usuarios e Incidencias ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    //select u.nombre,u.apellidos,d.nombre as dnombre,case when(count(i.id_inc)=1)then 0 end as asignadas,u.id_usu from usuarios u  join incidencias i on u.id_usu <> i.gestor join departamentos d on u.id_deptno = d.id_deptno  group by u.id_usu;
    
    //SELECT m.* FROM mensajes m JOIN usuarios u ON  m.id_rem = :id_rem AND m.id_dest = :id_dest GROUP BY m.id_men ORDER BY m.hora ASC;
    public function getMensajes($usuarios){
        try {
            $query = "
            select m.*, u.nombre as des_nombre from mensajes m join usuarios u on m.id_dest = u.id_usu and (m.id_rem = :id_rem and m.id_dest = :id_dest) or (m.id_rem = :id_dest and m.id_dest = :id_rem) group by m.id_men  order by hora ASC
            ";
            $result = $this->pdo->prepare($query);
            $result->execute($usuarios);
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registro de mensajes ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    public function getMensajesNoLeidos($usuarios){
        try {
            $query = "SELECT m.*, u.nombre AS des_nombre FROM mensajes m JOIN usuarios u ON 
            m.id_dest = u.id_usu AND (m.id_rem = :id_dest AND m.id_dest = :id_rem) 
            AND m.leido = 'n'  GROUP BY m.id_men  ORDER BY hora ASC
            ";
            $result = $this->pdo->prepare($query);
            $result->execute($usuarios);
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al leer registro de mensajes ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    public function idRemitentes($id){
        try {
            $query = "SELECT distinct m.id_rem from mensajes m join usuarios u on id_dest = :id_usu
            ";
            $result = $this->pdo->prepare($query);
            $result->execute($id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "ERROR al acceder a la tabla de mensajes  ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    public function menLeido($usuarios){
        try {
            $query = "UPDATE mensajes SET 
                                    leido = 'y' WHERE id_rem = :id_rem and id_dest = :id_dest and leido = 'n'";
            $result = $this->pdo->prepare($query);
            $result->execute($usuarios);
        } catch (PDOException $e) {
                echo "ERROR actualizar estado mensaje en base de datos ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function enviarMensaje($mensaje){
        try {
            $query = "INSERT INTO mensajes (id_rem,id_dest,mensaje) VALUE (
                                    :id_rem,
                                    :id_dest,
                                    :mensaje
                                    )";
            $result = $this->pdo->prepare($query);
            $result->execute($mensaje);
        } catch (PDOException $e) {
                echo "ERROR actualizar estado mensaje en base de datos ".$e->getMessage();
        }
        return $result->rowCount();
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