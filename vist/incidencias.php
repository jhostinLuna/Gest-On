<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>
    <style>
        .col {
            display: inline-block;
                       
        }
        .row,.thead {   
            display: flex;
            justify-content:space-around;
            align-items:flex-start;         
            border-bottom: 1px black solid;
        }
        .col {
            flex-basis: 10%;
        }
        
    </style>
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
<div>
<div class="thead">
    
        <div class="col">Referencia</div>
        <div class="col">Asunto</div>
        <div class="col">Estado</div>
        <div class="col">Prioridad</div>
        <div class="col">Asignado a</div>        
        <div class="col">Creado por</div>
        <div class="col">Departamento</div>
        <div class="col">Fecha</div>
    
</div>
<div class="tbody">
    
    <?php
    for ($i=0; $i < count($incidencias->tabla) ; $i++) { 
        echo "<div class=\"row\">";
        
        echo "<div class=\"col\">".$incidencias->tabla[$i]['id_inc']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['asunto']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['estado']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['prioridad']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['ges_nombre']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['autor']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['dnombre']."</div>
        <div class=\"col\">".$incidencias->tabla[$i]['f_creacion']."</div>

        ";
        
        echo "</div>";
    }
    
?>
</div>
</div>
</body>
</html>