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

</head>

<body>
    <?php include_once "header.php"; ?>


    <main>
        <div>
            <span><b>Estado: </b></span>
            <span>Pendiente </span><span class="e1"></span>
            <span> Resuelto </span><span class="e2"></span>
        </div>
        <form action="index.php" method="POST">

            <div class="ordenar">

                <button name="estado" type="submit" value="on">Estado</button>
                <button name="prioridad" type="submit" value="on">Prioridad</button>
                <button name="fecha" type="submit" value="on">Fecha</button>

            </div>
        </form>


        <div class="thead">

            <div class="col">Asunto</div>
            <div class="col">Equipo</div>
            <div class="col">Ubicación</div>
            <div class="col">Estado</div>
            <div class="col">Prioridad</div>
            <div class="col">Gestor</div>
            <div class="col">Autor</div>
            <div class="col">Fecha</div>
            <div class="col">Hora</div>



        </div>
        <div class="tbody">


            <?php

            for ($i = 0; $i < count($incidencias->tabla); $i++) {
                $indice = array_search($incidencias->tabla[$i]['gestor'], array_column($usuarios, 'id_usu'));
                echo "<div class=\"row\">";

                echo "
            
            <div class=\"col\">" . $incidencias->tabla[$i]['asunto'] . "</div>
            
            <div class=\"col\">" . $incidencias->tabla[$i]['equipo'] . "</div>
            <div class=\"col\">" . $incidencias->tabla[$i]['ubicacion'] . "</div>
            <div class=\"col\"><span " . ${$incidencias->tabla[$i]['estado']} . "></span></div>
            <div class=\"col \" ><span " . ${$incidencias->tabla[$i]['prioridad']} . ">" . $incidencias->tabla[$i]['prioridad'] . "</span></div>
            <div class=\"col\">" . $usuarios[$indice]['nombre'] . "</div>
            
            <div class=\"col\">" . $incidencias->tabla[$i]['autor'] . "</div>
            
            <div class=\"col\">" . date('d-m-yy', strtotime($incidencias->tabla[$i]['f_creacion'])) . "</div>
            <div class=\"col\">" . date('H:i', strtotime($incidencias->tabla[$i]['f_creacion'])) . "</div>
            
            </div>
            ";
            }
            ?>


        </div>


    </main>
    <?php include_once "nav.php"; ?>
</body>

</html>