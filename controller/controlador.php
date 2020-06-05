<?php
require_once "./model/modeloGestion.php";
define('E1','pendiente');
define('E2','resuelta');

define('P1','media');
define('P2','urgente');
$_SESSION['cont'] = 0;
$check = '';
$pendiente = "class=\"e1\"";
$resuelta = "class=\"e2\"";
$media = "class=\"p1\"";
$urgente = "class=\"p2\"";
$content = "./vist/login.php";
$reg = "/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})\$/";
$reg_tel = "/^[0-9]{9}\$/";
$modelo = new Modelo();
$incidencias = new TablaIncidencias();

$usuarios = $modelo->getUsuarios();

$inc_pdte = $incidencias->cantidadE(E1);
$inc_resu = $incidencias->cantidadE(E2);
$gestores =$modelo->usuariosGestores();
filtradoCompleto();
if (isset($_POST['acceso'])) {
    $_POST[':correo'] = strtolower($_POST[':correo']);
    unset($_POST['acceso']);
    $mensaje = '';
    if (preg_match($reg,$_POST[':correo']) === 0) {
        $mensaje .= "<span class=\"mensaje\">!tiene que ser un correo valido!</span>";
    }
    if (strlen($_POST[':clave']) === 0) {
        $mensaje .= "<span class=\"mensaje\">!La contraseña no puede estar vacia¡</span>";
    }
    
    if (empty($mensaje)) {
        $usuario = $modelo->accesoUsuario($_POST);
        
        if ($usuario == null) {
            $mensaje .="<span class=\"mensaje\">¡El usuario no existe o contraseña incorrecta!</span>";
        }else{
            $content = "./vist/inicio.php";
            $_SESSION['acceso'] = $_POST;
        }
    }
    
}



if(isset($_SESSION['acceso'])) {
    
    $usuario = $modelo->accesoUsuario($_SESSION['acceso']);
    $id = array(':id_usu'=>$usuario->id_usu);
    $idRemitentes = $modelo->idRemitentes($id);
    if (is_a($usuario,'Administrador')) {
        $incRevisar = $incidencias->incGestor($usuario->id_usu,E1);
    }
    elseif (is_a($usuario,'Gestor')) {
        
        $incRevisar = $incidencias->incGestor($usuario->id_usu,E1);
    }
    elseif (is_a($usuario,'Emisor')) {
        $misIncidencias = $incidencias->misIncidencias($usuario->id_usu);
        $gest_inc[] = 1;
            for ($i=0; $i < count($misIncidencias); $i++) { 
                if (!in_array($misIncidencias[$i]['gestor'],$gest_inc)) {
                    $gest_inc[] = $misIncidencias[$i]['gestor'];
                }
            }
    }
    
}

if (isset($_GET['inicio'])) {
    $content = "./vist/inicio.php";
}
elseif (isset($_GET['incidencias'])) {
    $content = "./vist/incidencias.php";
}
elseif (isset($_GET['opciones'])) {
    $content = "./vist/perfil.php";
}
elseif (isset($_GET['mensajes'])) {
    $content = "./vist/mensajes.php";
}

if (isset($_POST['create_user']) ) {
    
    unset($_POST['create_user']);   
    $_POST[':tipo'] = "em";
    $mensaje = '';
    if (empty($_POST[':nombre']) || empty($_POST[':apellidos']) ) {
        $mensaje .= "<span class=\"mensaje\">!Tienes que rellenar todos los campos¡</span>";
    }
    if (preg_match($reg,$_POST[':correo']) === 0 ) {
        $mensaje .= "<span class=\"mensaje\">¡tiene que ser un correo valido!</span>";
    }
    if (strcmp($_POST[':clave'],$_POST['clave_b']) !== 0 || strlen($_POST[':clave']) < 8) {
        $mensaje .= "<span class=\"mensaje\">Las contraseñas minimo 8 caracteres  y deben de coincidir</span>";
    }
    if (in_array($_POST[':correo'],array_column($usuarios,'correo'))) {
        $mensaje .= "<span class=\"mensaje\">!El correo \"".$_POST[':correo']."\" ya esta registrado!</span>";
    }
    if (preg_match($reg_tel,$_POST[':movil']) === 0) {
        $mensaje .= "<span class=\"mensaje\">El movil tiene que tener 9 digitos</span>";
    }
    if (empty($mensaje)) {
        unset($_POST['clave_b']);
        $clave = Password::hash($_POST[':clave']);
        $_POST[':clave'] = $clave;
        if ($modelo->createUsuario($_POST) < 1) {
            $mensaje .= "<span class=\"mensaje\">No se ha podido registrar el usuario</span>";
        }else{
            $mensaje .= "<span class=\"mensaje\">¡te has registrado correctamente!</span>";
        }
    }
    
}


elseif (isset($_POST['cerrar_session']) ) {
    unset($_SESSION['acceso']);
    
    
}
elseif (isset($_POST['estado']) ) {
    $incidencias->ordenEstado();
    
    $content = "./vist/incidencias.php";
}
elseif (isset($_POST['prioridad']) ) {
    $incidencias->ordenPrioridad();
    $content = "./vist/incidencias.php";
}
elseif (isset($_POST['fecha']) ) {
    $incidencias->iniciaTabla();
    $content = "./vist/incidencias.php";
}
//FUNCIONES DE ADMINISTRADOR
elseif (isset($_POST['asignar_adm']) ) {
    $check = "asignar_adm";
    if ( $usuario->asignaAdministrador($_POST)  == 0) {
        $mensaje = "<span class=\"mensaje\">No se ha podido asignar un administrador</span>";
    }
}
elseif (isset($_POST['update_user']) ) {
    $content ="./vist/inicio.php";
    unset($_POST['update_user']);
    $usuario->asignaAdministrador($_POST);
}
elseif (isset($_POST['asignar_inc']) ) {
    
    $check = "asignar_inc";
    if (!isset($_POST[':id_inc']) || !isset($_POST[':gestor']) || !isset($_POST[':prioridad'])) {
        $m_asig_inc = "<span class=\"mensaje\">¡Tienes que elegir una INCIDENCIA, PRIORIDAD Y UN GESTOR !</span>";
    }
    if (!isset($m_asig_inc)) {
        unset($_POST['asignar_inc']);
        $aux = array(':id_rem' => $_POST[':id_rem'],":id_dest"=>$_POST[':gestor'],":mensaje"=>"tienes una incidencia asignada de ...." );
        unset($_POST[':id_rem']);
        $usuario->asignarGestor($_POST);
        $modelo->enviarMensaje($aux);
        
    }
    $content = "./vist/inicio.php";
}
elseif (isset($_POST['crear_ges']) ) {
    unset($_POST['crear_ges']);
    $check = "crear_ges";
    if (isset($_POST[':id_usu'])) {
        $_POST[':tipo'] = 'ge';
        if ($usuario->crearGestor($_POST) === 0) {
            $m_asig_ges = "<span class=\"mensaje\">¡No se ha podido actualizar a Gestor!</span>";
        }
    }
    elseif(isset($_POST[':gestor'])){
        $_POST[':id_usu'] = $_POST[':gestor'];
        unset($_POST[':gestor']);
        $_POST[':tipo'] = 'em';
        if ($usuario->crearGestor($_POST) === 0) {
            $m_asig_ges = "<span class=\"mensaje\">¡No se ha podido actualizar a Usuario!</span>";
        }
    }else{
        $m_asig_ges = "<span class=\"mensaje\">!tienes que elegir un usuario¡</span>";
    }
    $content = "./vist/inicio.php";

    
}
// Controlador Usuario Emisor

elseif (isset($_POST['crear_inc']) ) {
    $content = "./vist/inicio.php";
    $check = "crear_inc";
    
    if (empty($_POST[':asunto']) || empty($_POST[':equipo']) || empty($_POST[':ubicacion'])) {
        $m_crear_inc = "!Tienes que rellenar todos los campos¡";
    }else {             

        $cuerpo = "Nueva Incidencia<br>
        Asunto: ".ucfirst($_POST[':asunto'])."<br>".
        "Equipo: ".ucfirst($_POST[':equipo'])."<br>".
        "Ubicación: ".ucfirst($_POST[':ubicacion'])."<br>".
        "Creado por: ".ucfirst($usuario->nombre)."<br>".
        "Descripcion: ".ucfirst($_POST[':descripcion'])
        ;
        
        Mailer::sendMail(array($usuarios[0]),"Nueva incidencia",$cuerpo);
        unset($_POST['crear_inc']);
        unset($_POST[':descripcion']);
        
        $_POST[':id_usu'] = $usuario->id_usu;
        $usuario->createIncidencia($_POST);
        $misIncidencias = $incidencias->misIncidencias($usuario->id_usu);
        $m_crear_inc = "!Se ha creado correctamente¡";
        
    }
    
    die($m_crear_inc);
    
}
// FUNCIONES DE GESTOR y ADMINISTRADOR
elseif (isset($_POST['resolver_inc']) ) {
    unset($_POST['resolver_inc']);
    $check = "resolver_inc";
    if (isset($_POST[':id_inc'])) {
        $_POST[':estado'] = E2;
        $usuario->cambiaEstado($_POST);
        $i = array_search($_POST[':id_inc'],array_column($incRevisar,'id_inc'));
        $cuerpo = "Resuelta la incidencia...<br>
        Asunto: \n".$incRevisar[$i]['asunto']."<br>"
        ."Equipo: ".$incRevisar[$i]['equipo']."<br>"
        ."Ubicación: ".$incRevisar[$i]['ubicacion']."<br>"
        ."Creado por: ".$incRevisar[$i]['autor']."<br>"
        ;
        Mailer::sendMail($usuarios,'Incidencia Resuelta',$cuerpo);
    }else{
        $m_resolver_inc = "<span class=\"mensaje\">!Tienes que elegir una incidencia¡</span>";
    }
    $content = "./vist/inicio.php";
}
// FUNCIONES COMUNES A TODOS
elseif (isset($_GET['chat']) ) {
    unset($_GET['chat']);
    $_GET[':id_rem'] = $usuario->id_usu;
    $id_usu = array(":id_rem"=>$_GET[':id_dest'],':id_dest'=>$_GET[':id_rem']);
    $modelo->menLeido($id_usu);    
    $chat = $modelo->getMensajes($_GET);
    $content = "./vist/mensajes.php";
    $id_dest = $_GET[':id_dest'];
    $gest_inc = null;
    $gest_inc[] = $_GET[':id_dest'];
    $idRemitentes = null;
    $idRemitentes[]['id_rem'] = $_GET[':id_dest']; 
}
elseif (isset($_POST['chat']) ) {
    unset($_POST['chat']);
    $_POST[':id_rem'] = $usuario->id_usu;
    $mensajes = $modelo->getMensajesNoLeidos($_POST);
    $id_usu = array(":id_rem"=>$_POST[':id_dest'],':id_dest'=>$_POST[':id_rem']);
    $modelo->menLeido($id_usu); 
    $aux = json_encode($mensajes);
    echo $aux;
    die();
}
elseif (isset($_POST['enviar_men']) ) {    
    unset($_POST['enviar_men']);
    $_POST[':id_rem'] = $usuario->id_usu;
    $aux = $modelo->enviarMensaje($_POST);
    $i = array_search($_POST[':id_dest'],array_column($usuarios,'id_usu'));
    $destino = array(array('correo'=>$usuario[$i]['correo'],'nombre'=>$usuario[$i]['nombre']));
    if ($_SESSION['cont'] === 0) {
        Mailer::sendMail($destino);
        $_SESSION['cont'] = 1;
    }
    die();
}
elseif (isset($_POST['cambia_clave']) ) {
    $check = "cambiar_clave";
    $content = "./vist/perfil.php";
    unset($_POST['cambia_clave']);
    if (strcmp($_POST[':clave'],$_POST['clave_b']) !== 0 || strlen($_POST[':clave']) < 8) {
        $m_cambia_clave = "<span class=\"mensaje\">Las contraseñas minimo 8 caracteres  y deben de coincidir</span>";
    }
    
    if (!isset($m_cambia_clave)) {
        unset($_POST['clave_b']);
        $aux = $_POST[':clave'];
        $clave = Password::hash($_POST[':clave']);
        $_POST[':clave'] = $clave;
        if ($modelo->cambiarClave($_POST) < 1) {
            $mensaje = "<span class=\"mensaje\">no se ha podido actualizar la clave intentalo de nuevo</span>";
        }else{
            $mensaje = "<span class=\"mensaje\">¡contraseña actualizada!</span>";
            $_SESSION['acceso'][':clave'] = $aux;
        }
    }
}
elseif (isset($_POST['telefono'])) {
    if (preg_match($reg_tel,$_POST['datos']) === 1) {
        $datos = array(':id_usu' => $usuario->id_usu,':movil' => $_POST['datos'] );
        $usuario->updateMovil($datos);        
    }else{
        $m_datos = "<span class=\"mensaje\">¡el número tiene que tener 9 digitos¡</span>";
    }
    $check = "cambiar_datos";
    $content = "./vist/perfil.php";
}
elseif (isset($_POST['correo'])) {
    if (preg_match($reg,$_POST['datos']) === 1) {
        $datos = array(':id_usu' => $usuario->id_usu,':correo' => $_POST['datos'] );
        $usuario->updateCorreo($datos);
        
        $_SESSION['acceso'][':correo'] = $_POST['datos'];
    }else{
        $m_datos = "<span class=\"mensaje\">¡El correo tiene que ser valido¡</span>";
    }
    $check = "cambiar_datos";
    $content = "./vist/perfil.php";
}
elseif(isset($_GET['act'])){
    $check = "act";
    $content = "./vist/inicio.php";
}
elseif(isset($_POST['delete_inc'])){
    $aux = $usuario->deleteIncidencias();
    die("¡se ha borrardo $aux Incidencias!");
}
$usuarios = $modelo->getUsuarios();
$inc_pdte = $incidencias->cantidadE(E1);
$inc_resu = $incidencias->cantidadE(E2);
$incE1 = $incidencias->getInc(E1);
$gestores =$modelo->usuariosGestores();
include_once $content;
?>