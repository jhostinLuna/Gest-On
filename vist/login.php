<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gest-On login</title>
    
</head>
<body>
    <?php if (!empty($mensaje)) {
        echo $mensaje;
    }
        
    ?>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
    <label for=":dni">Dni: </label>
    <input type="text" name=":dni" id="dni"><br>
    <label for=":clave">Contraseña: </label>
    <input type="password" name=":clave" id="clave"><br>
    <input type="submit" name="acceso" value="acceso">
</form>
    

<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
    <div id="registrar">
        <label for=":nombre">Nombre: </label>
        <input type="text" name=":nombre" id="nombre"><br>
        <label for=":apellidos">Apellidos: </label>
        <input type="text" name=":apellidos" id="apellidos"><br>
        <label for=":correo">correo: </label>
        <input type="text" name=":correo" id="correo"><br>
    </div>
    <label for=":dni">Dni: </label>
    <input type="text" name=":dni" id="dni_reg"><br>
    <label for=":clave">Contraseña: </label>
    <input type="password" name=":clave" id="clave_reg"><br>
    <select name=":id_deptno" id="id_deptno">
        <option value="10">Finanzas</option>
    </select> 
    
    <input type="submit" name="create_user" value="registrar">
</form>

        
    
</body>
</html>