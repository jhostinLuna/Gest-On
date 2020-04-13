<?php
require_once "./model/modeloGestion.php";
session_start();
define('E1','pdte.asignar');
define('E2','asignada');
define('E3','pdte.aprobar');
define('E4','resuelta');
$content = "./vist/login.php";
$reg = "/^[0-9]{8}[a-z]\$/";
$modelo = new Modelo();
$incidencias = new TablaIncidencias();
$departamentos = $modelo->getDeptno();
$pdteAsig = $incidencias->cantidadE(E1);
$asinada = $incidencias->cantidadE(E2);
$pdteApro = $incidencias->cantidadE(E3);
$resuelta = $incidencias->cantidadE(E4);
if (isset($_SESSION['acceso'])) {
    
    $usuario = $modelo->accesoUsuario($_SESSION['acceso']);
}
if (isset($_POST['acceso'])) {
    unset($_POST['acceso']);
    if (preg_match($reg,$_POST[':dni']) === 0) {
        $mensaje[0] = "El dni tiene que tener 8 digitos y un caracter a-z";
    }
    if (strlen($_POST[':clave']) === 0) {
        $mensaje[1] = "!La contraseña no puede estar vacia¡";
    }
    
    if (!isset($mensaje)) {
        $usuario = $modelo->accesoUsuario($_POST);
        if ($usuario == null) {
            $mensaje =="¡El usuario no existe o contraseña incorrecta!";
        }else{
            $content = "./vist/inicio.php";
            $_SESSION['acceso'] = $_POST;
        }
    }
    
}
if (isset($_SESSION['acceso']) && isset($_GET['inicio'])) {
    $content = "./vist/inicio.php";
}
elseif (isset($_SESSION['acceso']) && isset($_GET['incidencias'])) {
    $content = "./vist/incidencias.php";
}
elseif (isset($_SESSION['acceso']) && isset($_GET['opciones'])) {
    $content = "./vist/opciones.php";
}
elseif (isset($_SESSION['acceso']) && isset($_GET['mensajes'])) {
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
    $_SESSION['acceso'] = null;
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
    unset($_POST['create_deptno']);
    $content = "./vist/inicio.php";
    
    $cp = "/^[0-9]{5}/";
    if (strlen($_POST[':dni']) > 9 || strlen($_POST[':dni']) < 9  || preg_match($reg,$_POST[':dni']) === 0 ) {
        $mensaje[3] = "El dni tiene que empezar con 8 digitos y un caracter a-z ";
    }
    if (strlen($_POST[':nombre']) > 15 || strlen($_POST[':nombre']) === 0 ) {
        $mensaje[1] ="El nombre no puede estar vacio o tener mas de 15 caracteres";
    }
    if (strlen($_POST[':ciudad']) > 10 || strlen($_POST[':ciudad']) === 0) {
        $mensaje[2] = "ciudad no puede estar vacio ó tener mas de 10 caracteres";
    }
    if (strlen($_POST[':cp']) > 5 || preg_match($cp,$_POST[':cp']) === 0 ) {
        $mensaje[4] = "El codigo postal no puede estar vacio ó tener mas de 5 digitos";
    }
    if (!isset($mensaje)) {
        if ($usuario->createDepartamento($_POST) === 0) {
            $mensaje = "No se ha podido crear el departamento";
        }else{
            $mensaje = "¡Se ha creado correctamente!";
        }
    }
    
}
if (isset($_POST['asignar_adm'])) {
    
    if ( $usuario->asignaAdministrador($_POST)  == 0) {
        $mensaje = "No se ha podido asignar un administrador";
    }
}

include_once $content;
?>