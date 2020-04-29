<?php
require_once "./model/modeloGestion.php";
session_start();
define('E1','pdte.asignar');
define('E2','asignada');
define('E3','pdte.aprobar');
define('E4','resuelta');
define('P1','baja');
define('P2','media');
define('P3','alta');
$content = "./vist/login.php";
$reg = "/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})\$/";
$modelo = new Modelo();
$incidencias = new TablaIncidencias();
$usuarios = $modelo->getUsuarios();
$departamentos = $modelo->getDeptno();
$todoDeptno = $modelo->todoDeptno();
$pdteAsig = $incidencias->cantidadE(E1);
$asinada = $incidencias->cantidadE(E2);
$pdteApro = $incidencias->cantidadE(E3);
$resuelta = $incidencias->cantidadE(E4);
$orden = false;
$gestores =array_merge($modelo->usuariosGestores(),$modelo->usuariosGestores2());
$incE1 = $incidencias->getInc(E1);

filtradoCompleto();
if (isset($_POST['acceso'])) {
    $_POST[':correo'] = strtolower($_POST[':correo']);
    unset($_POST['acceso']);
    if (preg_match($reg,$_POST[':correo']) === 0) {
        $mensaje[0] = "¡tiene que ser un correo valido!";
    }
    if (strlen($_POST[':clave']) === 0) {
        $mensaje[1] = "!La contraseña no puede estar vacia¡";
    }
    
    if (!isset($mensaje)) {
        $usuario = $modelo->accesoUsuario($_POST);
        if ($usuario == null) {
            $mensaje ="¡El usuario no existe o contraseña incorrecta!";
        }else{
            $content = "./vist/inicio.php";
            $_SESSION['acceso'] = $_POST;
        }
    }
    
}

if (isset($_SESSION['acceso']) ) {
    
    $usuario = $modelo->accesoUsuario($_SESSION['acceso']);
    
    if (is_a($usuario,'Gestor')) {
        $misIncidencias = $incidencias->misIncidencias($usuario->id_usu);
        $incRevisar = $incidencias->misIncidencias($usuario->id_usu,E3);
    }
    elseif (is_a($usuario,'Emisor')) {
        $misIncidencias = $incidencias->misIncidencias($usuario->id_usu);
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
    
    
    unset($_POST['create_user']);
    $clave = Password::hash($_POST[':clave']);
    $_POST[':clave'] = $clave;
    if ($modelo->createUsuario($_POST) < 1) {
        $mensaje = "No se ha podido registrar el usuario";
    }else{
        $mensaje = "¡te has registrado correctamente!";
    }
}


if (isset($_POST['terminar_session'])) {
    unset($_SESSION['acceso']);
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
    $dep = end($todoDeptno);
    $_POST[':id_deptno'] = $dep['id_deptno'] + 10;
    
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
            $m_deptno = "No se ha podido crear el departamento";
        }else{
            $m_deptno = "¡Se ha creado correctamente!";
        }
    }
    
}
if (isset($_POST['asignar_adm'])) {
    
    if ( $usuario->asignaAdministrador($_POST)  == 0) {
        $mensaje = "No se ha podido asignar un administrador";
    }
}
if (isset($_POST['update_user'])) {
    $content ="./vist/inicio.php";
    unset($_POST['update_user']);
    $usuario->asignaAdministrador($_POST);
}
// Controlador Usuario Emisor

if (isset($_POST['crear_inc'])) {
    $content = "./vist/inicio.php";
    unset($_POST['crear_inc']);
    $_POST[':estado'] = E1;
    $_POST[':prioridad'] = null;
    $_POST[':gestor'] = null;
    $_POST[':f_creacion'] = date('yy-m-d');
    $_POST[':id_usu'] = $usuario->id_usu;
    
    $usuario->createIncidencia($_POST);
    $misIncidencias = $incidencias->misIncidencias($usuario->id_usu);
}
if (isset($_POST['asignar_inc'])) {
    $content = "./vist/inicio.php";
    if (!isset($_POST[':id_usu']) || !isset($_POST[':id_usu']) || !isset($_POST[':prioridad'])) {
        $m_asig_inc = "¡Tienes que elegir una INCIDENCIA, PRIORIDAD Y UN GESTOR !";
    }
    if (!isset($m_asig_inc)) {
        unset($_POST['asignar_inc']);
        $usuario->asignaGestor($_POST);
    }
}

if (isset($_GET['chat'])) {
    unset($_GET['chat']);
    $_GET[':id_rem'] = $usuario->id_usu;
    $modelo->menLeido($_GET);
    
    $m_rem = $modelo->getMensajes($_GET);    
    $aux = array(':id_rem'=>$_GET[':id_dest'],':id_dest'=>$usuario->id_usu );
    $m_dest = $modelo->getMensajes($aux);
    $content = "./vist/mensajes.php";
}
if (isset($_POST['enviar_men'])) {
    unset($_POST['enviar_men']);
    $_POST[':id_rem'] = $usuario->id_usu;
    $modelo->enviarMensaje($_POST);
    $content = "./vist/mensajes.php";

}
$departamentos = $modelo->getDeptno();
include_once $content;
?>