<?php 
session_start();
if (isset($_SESSION['acceso']) || isset($_POST['acceso']) || isset($_POST['create_user'])) {
    include_once "./controller/controlador.php";
}else {
    include_once "./vist/login.php";
}
 
?>