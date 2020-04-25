

<div class="info_usu">
<p>incidencias asignadas: </p>
<table>
    <thead>
    <tr>
            <th>Referencia</th>
            <th>Asunto</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Fecha</th>
            <th>Creado por</th>
            <th>Departamento</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for ($i=0; $i < count($misIncidencias); $i++) { 
            echo "<tr>";
            echo "<td>".$misIncidencias[$i]['id_inc']."</td>";
            echo "<td>".$misIncidencias[$i]['asunto']."</td>";
            echo "<td>".$misIncidencias[$i]['estado']."</td>";
            echo "<td>".$misIncidencias[$i]['prioridad']."</td>";
            echo "<td>".$misIncidencias[$i]['f_creacion']."</td>";
            echo "<td>".$misIncidencias[$i]['nombre']."</td>";
            echo "<td>".$misIncidencias[$i]['id_inc']."</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<table>
</table>
</div>