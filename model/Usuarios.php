<?php

class Usuario{
    
    
    private $dni;
    private $nombre;
    private $apellidos;
    private $movil;
    private $tipo;
    private $clave;
    private $departamento;
    public function __construct($registro)
    {
        
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
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,dni,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:dni,:id_deptno
            )";
            $result = $pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia crear incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function cambiaEstado($estado){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE incidencias SET
                                    estado = :estado
                                    WHERE id_inc = :id_inc";
            $result = $pdo->prepare($query);
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
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE incidencias SET
                                    estado = :estado
                                    WHERE id_inc = :id_inc";
            $result = $pdo->prepare($query);
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
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "INSERT INTO incidencias (asunto,prioridad,estado,gestor,f_creacion,dni,id_deptno) VALUE(
                :asunto,:prioridad,:estado,:gestor,:f_creacion,:dni,:id_deptno
            )";
            $result = $pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia crear incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function deleteIncidencia($incidencia){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "DELETE FROM incidencias WHERE id_inc = :id_inc
            )";
            $result = $pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
            echo "ERROR en la sentencia borrar incidencia".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function updateIncidencia($incidencia){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE incidencia SET 
                                    asunto = :asunto,
                                    prioridad =:prioridad,
                                    estado = :estado,
                                    gestor = :gestor,
                                    f_creacion = :f_creacion,
                                    dni = :dni,
                                    id_deptno = :id_deptno WHERE id_inc = :id_inc";
            $result = $pdo->prepare($query);
            $result->execute($incidencia);
        } catch (PDOException $e) {
                echo "ERROR actualizando la incidencia ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function asignarGestor($gestor){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE incidencia SET                                     
                                    gestor = :gestor,
                                    id_deptno = :id_deptno WHERE id_inc = :id_inc";
            $result = $pdo->prepare($query);
            $result->execute($gestor);
        } catch (PDOException $e) {
                echo "ERROR asignando un gestor \"incidencia\" ".$e->getMessage();
        }
        return $result->rowCount();
    }

    public function cambiaEstado($estado){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE incidencias SET
                                    estado = :estado
                                    WHERE id_inc = :id_inc";
            $result = $pdo->prepare($query);
            $result->execute($estado);
        } catch (PDOException $e) {
            echo "ERROR al cambiar de estado \"Incidencia\"".$e->getMessage();
        }
        return $result->rowCount();
    }

    //Usuarios
    public function deleteUsuario($dni){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "DELETE FROM usuarios WHERE dni = :dni
            )";
            $result = $pdo->prepare($query);
            $result->execute($dni);
        } catch (PDOException $e) {
            echo "ERROR al borrar un usuario".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function updateUsuario($usuario){

        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE usuarios SET 
                                    nombre = :nombre,
                                    apellidos = :apellidos,
                                    correo = :correo,
                                    tipo = :tipo,
                                    clave = :clave,                                    
                                    id_deptno = :id_deptno WHERE dni = :dni";
            $result = $pdo->prepare($query);
            $result->execute($usuario);
        } catch (PDOException $e) {
                echo "ERROR actualizando datos de usuario ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function createDepartamento($departamento){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "INSERT INTO usuarios VALUES(
                :id_deptno,
                :nombre,
                null,
                :ciudad,
                :cp
            )";
            $result = $pdo->prepare($query);
            $result->execute($departamento);

        } catch (PDOException $e) {
            echo "ERROR al crear depratamento ".$e->getMessage();
        }
        return $result->rowCount();
    }
    // Asigna administrador a un departamento tiene que existir antes el usuario administrador
    public function asignaAdministrador($adm){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "UPDATE departamento SET 
                                                                      
                                    adm = :dni WHERE id_deptno = :id_deptno";
            $result = $pdo->prepare($query);
            $result->execute($adm);
        } catch (PDOException $e) {
                echo "ERROR al añadir jefe de departamento ".$e->getMessage();
        }
        return $result->rowCount();
    }
    public function getDeptno(){
        $pdo = ConexionPDO::singleton("gestion");
        try {
            $query = "SELECT * FROM departamentos";
            $result = $pdo->prepare($query);
            $result->execute();
        } catch (PDOException $e) {
            echo "ERROR al leer registros de Usuarios ". $e->getMessage();
        }
        return $result->fetchAll();
    }
    public function pintaOpciones(){
        
        $content =  FOO
        <label for="add_deptno">Crear departamento</label>
        <input type="checkbox" name="add_deptno" id="add_deptno">
        <div id="crear_deptno">
            <form action="index.php" method="POST">
                <label for=":id_deptno">Identificador: </label>
                <input type="text" name=":id_deptno" ><br/>
                <label for=":nombre">Nombre: </label>
                <input type="text" name=":nombre"><br/>
                <label for=":ciudad">Ciudad: </label>
                <input type="text" name=":ciudad"><br/>
                <label for=":cp">CP: </label>
                <input type="text" name=":cp"><br/>
                <input type="submit" name="crear">
            </form>
        </div>
        <input type="checkbox" name="add_adm" id="add_adm">
        <div id="asigna_adm">
            <form action="index.php" method="POST">
                <label for=":id_deptno">Identificador: </label>
                <input type="text" name=":id_deptno" ><br/>
                <label for=":dni">dni administrador</label>
                <input type="text" name=":dni">
                <input type="text">
            </form>
        </div>

        FOO
    }
}
?>