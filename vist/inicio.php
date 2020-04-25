<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php?inicio=on">Incicio</a></li>
                <li><a href="index.php?incidencias=on">Incidencias</a></li>
                <li><a href="index.php?opciones=on">Opciones</a></li>
                <li><a href="index.php?mensajes=on">Mensajes</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <button><a href="index.php?terminar_session=on">Cerrar</a></button>
    <?php if (is_a($usuario,'Administrador')):?>
        
        <?php include_once "administrador.php"; ?>
    <?php  ?>
    <?php elseif (is_a($usuario,'Emisor')):?>
        <?php include_once "emisor.php"; ?>
    <?php elseif (is_a($usuario,'Gestor')):?>
        <?php include_once "gestor.php"; ?>
    <?php endif;?>
    </main>
    
</body>
</html>