<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>
    <style>
        table,td{
            border: 1px black solid;
        }
        .ocu{
            display: none;
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
<table>
<thead>
    <tr>
        <th>Referencia</th>
        <th>Asunto</th>
        <th>Estado</th>
        <th>Prioridad</th>
        <th>Asignado a</th>
        <th>Fecha</th>
        <th>Creado por</th>
        <th>Departamento</th>
    </tr>
</thead>
<tbody>
    <tr><td class="ocu"><input type="hidden" value="hola" ></td></tr>hola
    <tr><td class="ocu"><input type="hidden" value="hola" ></td></tr>
    <?php
    for ($i=0; $i < count($incidencias->tabla) ; $i++) { 
        echo "<tr>";
        foreach ($incidencias->tabla[$i] as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    
?>
</tbody>
</table>
</body>
</html>