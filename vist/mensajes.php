<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1f90017dce.js" crossorigin="anonymous"></script>
    <title>Mensajes</title>
</head>
<body>
    <div class="contactos">
        <?php
        for ($i=0; $i < count($misIncidencias); $i++) {
            if ($misIncidencias[$i]['gestor']!=null) {
                echo "<a href=\"index.php?chat=on&gestor=".$misIncidencias[$i]['gestor']."\"><div><i class=\"fas fa-user-cog\"></i><span>".$misIncidencias[$i]['ges_nombre']."</span></div></a>";

            }
        }
        ?>

    </div>
    <div id="contenedor">
        <div id="chat">
        <?php for ($i=0; $i < count($m_dest); $i++):?>
            <div class="m_dest">
                
                <span><?php echo $m_dest[$i]['destinatario']; ?></span>
                <span><?php echo $m_dest[$i]['mensaje'] ?></span>
                <span><?php echo $m_dest[$i]['hora']?></span>
            </div>
        <?php endfor; ?>
        <?php for ($i=0; $i < count($m_rem); $i++):?>
            <div class="m_rem">
                
                <span><?php echo $m_rem[$i]['destinatario']; ?></span>
                <span><?php echo $m_rem[$i]['mensaje'] ?></span>
                <span><?php echo $m_rem[$i]['hora']?></span>
            </div>
        <?php endfor; ?>
        </div>
        <form action="index.php">
            <textarea name=":mensaje" id=":mensaje" placeholder="Ingresa tu mensaje"></textarea>
            <input type="submit" name="chat" value="Enviar">
        </form>
    </div>
</body>
</html>