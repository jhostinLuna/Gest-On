<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1f90017dce.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Poppins:ital,wght@1,500;1,600&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./sass/index.min.css">
    <title>Perfil</title>
</head>
<body>
    <?php include_once "header.php";?>
    
    <main>
        
        
        <div class="info_user">
            <div>
            <div>nombre: <?php echo $usuario->nombre; ?></div>
            <div>apellidos: <?php echo $usuario->apellidos; ?></div>
            <div>correo: <?php echo $usuario->correo; ?></div>
            <div>movil <?php echo $usuario->movil; ?></div>
            </div>
        
        </div>


        <input type="checkbox" id="cambiar_clave" <?php if (strcmp($check,'cambiar_clave') === 0) {echo 'checked';} ?>><label for="cambiar_clave">Cambiar contraseña</label>
        
        
        <div class="cambiar_clave">
        
        <?php if (isset($m_cambia_clave)) { echo $m_cambia_clave; } ?>
        
        <form action="index.php" method="POST">
        
            <div>contraseña: <input type="password" name=":clave" required></div>
            <div>repetir: <input type="password" name="clave_b"></div>
        
        
        <input type="hidden" name=":id_usu" value="<?php echo $usuario->id_usu; ?>">
        <input type="submit" name="cambia_clave" value="enviar">
        </form>
        </div>



        <input type="checkbox" id="cambiar_datos" <?php if (strcmp($check,'cambiar_datos') === 0) {echo 'checked';} ?>><label for="cambiar_datos">Modificar datos</label>
        
        <div class="update_datos">
        <?php if (isset($m_datos)) { echo $m_datos; } ?>
            <div>
            
            <span>Escribe el correo o <br> el numero de telefono:</span>
            <form action="index.php" id="form_datos" method="POST">
                <input type="text" name="datos" >
            </form>
            <div>
                <button type="submit" name="telefono" form="form_datos" value="on">telefono</button>
                <button type="submit" name="correo" form="form_datos" value="on">correo</button>
            </div>
            
        </div>
            </div>
        
    </main>
    <?php include_once "nav.php"; ?>
</body>
</html>