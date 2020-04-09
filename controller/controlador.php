<?php
require_once "./model/modeloGestion.php";
$mensaje;
$modelo = new Modelo();
$incidencias = new TablaIncidencias();
if (isset($_POST['create_user'])) {
    if ($modelo->createUsuario($usuario) === 0) {
        $mensaje = "No se ha podido registrar el usuario";
    }
}
if (isset($_GET['acceso']) && !isset($_SESSION['usuario'])) {
    
    if (($usuario = $modelo->accesoUsuario($_POST['dni'],$_POST['clave']))==null) {
        $mensaje = "No se ha encontrado ningun usuario con dni ".$_POST['dni'] . 
        " o la contraseña no coincide";
    }else{
        $_SESSION['usuario'] = $usuario;
    }
}

if (isset($_POST['terminar_session'])) {
    $_SESSION['usuario'] = null;
}
if (isset($_POST['estado'])) {
    $incidencias->ordenEstado($_POST['estado']);
}
elseif (isset($_POST['prioridad'])) {
    $incidencias->ordenEstado($_POST['prioridad']);
}
elseif (isset($_POST['fecha'])) {
    $incidencias->ordenEstado($_POST['fecha']);
}
if (isset($_POST['create_deptno'])) {
    if ($modelo->createDepartamento($_POST) === 0) {
        $mensaje = "No se ha podido crear el departamento";
    }
}
if (isset($_POST['asignar_adm'])) {
    if ($modelo->asignaAdministrador($_POST)  == 0) {
        $mensaje = "No se ha podido asignar un administrador";
    }
}
?>