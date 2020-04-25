
<input type="checkbox" id="crear_inc"><label for="crear_inc"><h2>Crear Incidencia</h2></label>
<div class="crear_inc">
    <form action="index.php" method="POST">
        <label for="asunto">Asunto: </label>
        <input type="text" name=":asunto" id="asunto"><br/>
        
        <?php
        for ($i=0; $i < count($todoDeptno); $i++) { 
            echo "<input type=\"radio\" name=\":id_deptno\" value=\"".$todoDeptno[$i]['id_deptno']."\" class=\"tip\" id=\"dept$i\">
            <label for=\"dept$i\">".$todoDeptno[$i]['nombre']."</label>";
        }
        
        ?>
        <br/>
        <input type="submit" name="crear_inc" value="crear">
    </form>
</div>
<div id="info_usu">
<h2>Mis Incidencias</h2>
<input type="checkbox" name="todas" id="todas"><label for="todas">
    Todas: <?php echo count($misIncidencias); ?></label>
    <?php if(!empty($misIncidencias)): ?>
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
            <form action="index.php" method="POST">
            <?php
            for ($i=0; $i < count($misIncidencias); $i++) { 
                echo "<tr>";
                foreach ($misIncidencias[$i] as $value) {
                    echo "<td>$value</td>";
                }
                echo "
                
                
                </tr>";
            }
            ?>
            </form>
        </tbody>
    </table>
    <?php else:?>
        <div><p>No hay Incidencias creadas</p></div>
    <?php endif;?>
</div>

