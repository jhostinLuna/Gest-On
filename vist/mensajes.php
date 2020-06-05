<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1f90017dce.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Poppins:ital,wght@1,500;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">
    <script src="./javascript/push.min.js"></script>
    <script src="./javascript/jquery-3.4.1.min.js"> </script>
    <script src="./javascript/index.min.js"> </script>
    <link rel="stylesheet" href="./sass/index.min.css">
    <title>Mensajes</title>

</head>

<body>
    <?php include_once "header.php"; ?>
    <main>

        <div class="contenedor">
            <div class="contactos">
                <ul>
                    <?php

                    if (is_a($usuario, 'Emisor')) {
                        for ($i = 0; $i < count($gest_inc); $i++) {

                            $indice = array_search($gest_inc[$i], array_column($usuarios, 'id_usu'));
                            echo "
                        <li>
                        <a href=\"index.php?chat=on&:id_dest=" . $usuarios[$indice]['id_usu'] . "\"><i class=\"fas fa-user-cog\"></i><span>" . ucwords($usuarios[$indice]['nombre']) . "</span></a>
                        </li>
                        ";
                        }
                    } else {
                        for ($i = 0; $i < count($idRemitentes); $i++) {

                            $indice = array_search($idRemitentes[$i]['id_rem'], array_column($usuarios, 'id_usu'));
                            echo "
                        <li>
                        <a href=\"index.php?chat=on&:id_dest=" . $idRemitentes[$i]['id_rem'] . "\"><i class=\"fas fa-user\"></i><span>" . ucwords($usuarios[$indice]['nombre']) . "</span></a>
                        </li>
                        ";
                        }
                    }
                    ?>
                </ul>
            </div>
            <?php if (isset($chat)) : ?>
                <div class="contenedor-chat" id="contenedor-chat">

                    <div class="chat" id="chat">
                        <?php for ($i = 0; $i < count($chat); $i++) : ?>

                            <div class="<?php if ($chat[$i]['id_rem'] == $usuario->id_usu) {
                                            echo 'm_rem';
                                        } else {
                                            echo 'm_dest';
                                        } ?>">

                                <span><?php echo $chat[$i]['mensaje']; ?></span>
                                <span> <?php echo date('H:i', strtotime($chat[$i]['hora'])); ?> </span>
                            </div>
                        <?php endfor; ?>
                    </div>




                </div>
                <div class="texto-enviar">
                    <textarea maxlength="300" name=":mensaje" id="mensaje" placeholder="Ingresa tu mensaje" required></textarea>
                    <input type="hidden" id=":id_dest" value="<?php echo $id_dest; ?>">
                    <input type="hidden" id=":id_rem" value="<?php echo $usuario->id_usu; ?>">
                    <button type="submit" id="enviar_men">Enviar</button>
                </div>
            <?php endif; ?>

        </div>


    </main>
    <?php include_once "nav.php"; ?>
</body>

</html>