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
                $indice = array_search($misIncidencias[$i]['gestor'],array_column($gestores,'id_usu'));
                echo "<a href=\"index.php?chat=on&:id_dest=".$misIncidencias[$i]['gestor']."\"><div><i class=\"fas fa-user-cog\"></i><span>".$gestores[$indice]['nombre']."</span></div></a>";

            }
        }
        ?>
    <?php if (isset($m_rem) && isset($m_dest)): ?>
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
        <form action="index.php" method="POST">
            <textarea name=":mensaje" id=":mensaje" placeholder="Ingresa tu mensaje"></textarea>
            <input type="hidden" name=":id_dest" value="<?php echo $aux['id_dest']; ?>">
            <input type="submit" name="enviar_men" value="Enviar">
        </form>
    </div>
        <?php endif; ?>
</body>
</html>