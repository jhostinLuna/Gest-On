<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Gest-On login</title>
    
</head>
<body>
<main>
    <div id="acceso">
    <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
        <table>
            <tbody>
            <tr><td><label for=":dni">Dni: </label></td>
            <td><input type="text" name=":dni" id="dni"></td><?php if (isset($mensaje) && is_array($mensaje)) {
                echo "<td>".$mensaje[0]."</td>";
            } ?></tr>
            <tr><td><label for=":clave">Contraseña: </label></td>
            <td><input type="password" name=":clave" id="clave"></td><?php if (isset($mensaje) && is_array($mensaje)) {
                echo "<td>".$mensaje[1]."</td>";
            } ?></tr>
            <tr><td><input type="submit" name="acceso" value="acceso"></td>
            </tr>           
            
            
            </tbody>
        </table>
        </form>
        <?php 
            if (isset($mensaje) && is_string($mensaje)) {
                    echo  "<div id=\"mensaje\"><p>$mensaje</p></div>";
            }
            ?>
    </div>

<div id="registrar">
<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
    <table>
        <tbody>
            <tr><td><label for=":nombre">Nombre: </label></td><td><input type="text" name=":nombre" id="nombre"></td></tr>
            <tr><td><label for=":apellidos">Apellidos: </label></td><td><input type="text" name=":apellidos" id="apellidos"></td></tr>
            <tr><td><label for=":correo">correo: </label></td><td><input type="text" name=":correo" id="correo"></td></tr>
            <tr><td><label for=":dni">Dni: </label></td><td><input type="text" name=":dni" id="dni_reg"></td></tr>
            <tr><td><label for=":clave">Contraseña: </label></td><td><input type="password" name=":clave" id="clave_reg"></td></tr>
            <tr><td><input type="checkbox" name=":tipo" value="ge"></td><td><label for=":tipo">Usuario: </label>.-</td></tr>
            <tr><td>departamento: </td>
                <td>
                    <?php
                    echo "<select name=\":id_deptno\" id=\"id_deptno\">";
                    for ($i=0; $i < count($departamentos); $i++) { 
                        echo "<option value=\"".$departamentos[$i]['id_deptno']."\">".$departamentos[$i]['dnombre']."</option>";
                    }
                    echo "</select>";

?>
                
                </td>
            </tr>
            <tr><td><input type="submit" name="create_user" value="registrar"></td></tr>
        </tbody>
    </table>
    
</form>

</div>
</main>
    
    
</body>
</html>