<?php
require_once "./model/modeloGestion.php";
session_start();
$content = "./vist/login.php";
$mensaje;
$modelo = new Modelo();
$incidencias = new TablaIncidencias();
if (isset($_POST['acceso'])) {
    unset($_POST['acceso']);
    $usuario = $modelo->accesoUsuario($_POST);
    if ($usuario == null) {
        $mensaje =="¡El usuario no existe o contraseña incorrecta!";
    }else{
        $content = "./vist/inicio.php";
        $_SESSION['usuario'] = $usuario;
    }
}
if (isset($_SESSION['usuario']) && isset($_GET['inicio'])) {
    $content = "./vist/inicio.php";
}
elseif (isset($_SESSION['usuario']) && isset($_GET['incidencias'])) {
    $content = "./vist/incidencias.php";
}
elseif (isset($_SESSION['usuario']) && isset($_GET['opciones'])) {
    $content = "./vist/opciones.php";
}
elseif (isset($_SESSION['usuario']) && isset($_GET['mensajes'])) {
    $content = "./vist/mensajes.php";
}
if (isset($_POST['create_user'])) {
    $_POST[':tipo'] = "em";
    
    unset($_POST['create_user']);
    
    if ($modelo->createUsuario($_POST) < 1) {
        $mensaje = "No se ha podido registrar el usuario";
    }else{
        $mensaje = "¡te has registrado correctamente!";
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

include_once $content;
?>