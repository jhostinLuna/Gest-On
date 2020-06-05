<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Poppins:ital,wght@1,500;1,600&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./sass/index.min.css">
    <title>Gest-On login</title>
    
</head>
<body id="log">
<main>
    
    <div id="acceso">
    <header>Login</header>
    <?php 
    if (isset($mensaje)) {
        echo $mensaje;
    }
    
    ?>
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
        <table>
            <tbody>
            <tr><td><label for="log_correo">correo: </label></td>
            <td><input type="text" name=":correo" id="log_correo"></td></tr>
            
            <tr><td><label for="clave">Contraseña: </label></td>
            <td><input type="password" name=":clave" id="clave"></td></tr>
            <tr><td><input type="submit" name="acceso" value="ACCESO"></td>
            </tr>           
            
            
            </tbody>
        </table>
    </form>
        
    </div>

<div id="registrar">
<h2>Registro</h2>

<form action="index.php" method="POST">
    <table>
        <tbody>
            <tr><td><label for="nombre">Nombre: </label></td><td><input type="text" maxlength="10" name=":nombre" id="nombre" required></td></tr>
            <tr><td><label for="apellidos">Apellidos: </label></td><td><input type="text" maxlength="20" name=":apellidos" id="apellidos" required></td></tr>
            <tr><td><label for="movil">movil: </label></td><td><input type="text" name=":movil" maxlength="9" id="movil"></td></tr>
            <tr><td><label for="correo">correo: </label></td><td><input type="text" maxlength="40" name=":correo" id="correo"></td></tr>
            <tr><td><label for="clave">Contraseña: </label></td><td><input type="password" name=":clave" id="clave_reg"></td></tr>
            <tr><td><label for="clave_b">Repite: </label></td><td><input type="password" name="clave_b" id="clave_b"></td></tr>
            
            <tr><td><input type="submit" name="create_user" value="REGISTRAR"></td></tr>
        </tbody>
    </table>
    
</form>

</div>
</main>
    
    
</body>
</html>