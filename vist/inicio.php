<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Carter+One&family=Poppins:ital,wght@1,500;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital@1&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/1f90017dce.js" crossorigin="anonymous"></script>
    <script src="./javascript/jquery-3.4.1.min.js"> </script>
    <script src="./javascript/index.min.js"> </script>
    <link rel="stylesheet" href="./sass/index.min.css">
    <title>Inicio</title>

</head>

<body>

    <?php include_once "header.php"; ?>
    <main>
        <span id="logo">IES ENRIQUE TIERNO GALVAN</span>
        <?php if (is_a($usuario, 'Administrador')) : ?>

            <?php include_once "administrador.php"; ?>
            <?php  ?>
        <?php elseif (is_a($usuario, 'Emisor')) : ?>
            <?php include_once "emisor.php"; ?>
        <?php elseif (is_a($usuario, 'Gestor')) : ?>
            <?php include_once "gestor.php"; ?>
        <?php endif; ?>


    </main>
    <?php include_once "nav.php"; ?>

</body>

</html>