
        <div id="info_usu">
            <h2>Incidencias</h2>
            <p>Pendientes de Asignar: <?php echo count($incE1); ?></p>
            <?php if(!empty($incE1)): ?>
            <form action="index.php" id="form_asignar" method="POST">
                
            <table>
                <thead class="oculto">
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
                    
                <?php
                for ($i=0; $i < count($incE1); $i++) { 
                    echo "<tr>";
                    echo "<td>".$incE1[$i]['id_inc']."</td>
                    <td>".$incE1[$i]['asunto']."</td>
                    <td>".$incE1[$i]['estado']."</td>
                    <td>".$incE1[$i]['prioridad']."</td>
                    <td>".$incE1[$i]['ges_nombre']."</td>
                    <td>".$incE1[$i]['f_creacion']."</td>
                    <td>".$incE1[$i]['autor']."</td>
                    <td>".$incE1[$i]['dnombre']."</td>";
                    echo "
                    <td><input type=\"radio\" name=\":id_inc\" value=\"".$incE1[$i]['id_inc'].
                    "\" id=\":id_inc$i\"><label for=\":id_inc$i\">asignar</label></td>                    
                    </tr>";                    
                }
                ?>                    
                </tbody>
            </table>
            <h2>Gestores</h2>
            
            <table>
            <thead>
                <tr>
                <td>nombre</td>
                <td>apellidos</td>
                <td>departamento</td>
                <td>asignadas</td>
                </tr>
            </thead>
            <tbody>
            
            <?php

            for ($i=0; $i < count($gestores); $i++) { 
                echo "<tr>";
                    echo "<td>".$gestores[$i]['nombre']."</td>";
                    echo "<td>".$gestores[$i]['apellidos']."</td>";
                    echo "<td>".$gestores[$i]['dnombre']."</td>";
                    echo "<td>".$gestores[$i]['asignadas']."</td>";
                    echo "<td><input type=\"radio\" name=\":gestor\" value=\"".
                    $gestores[$i]['id_usu']."\" id=\":id_usu$i\"><label for=\":id_usu$i\">asignar</label></td>";
                echo "</tr>";
                
            }
            
            ?>
                
            </tbody>
            </table>
            </form>
            <button type="submit" name="asignar_inc" form="form_asignar" value="on">Asignar</button>
            <?php if(isset($m_asig_inc)){
                echo "<div><p>$m_asig_inc</p></div>";
            } ?>
            <?php else:?>
            <div><p>No hay Incidencias creadas</p></div>
            <?php endif; ?>
            <input type="checkbox" id="inc_revisar"><label for="inc_revisar">Resueltas</label>
        </div>
        
        <div id="info_deptno">

            
            <h2>Departamentos</h2>
            <?php if(!empty($departamentos)):?>
            <table>
                <thead>
                    <tr>
                        
                        <th>departamento</th>                        
                        <th>ciudad</th>                        
                        <th>cp</th>
                        <th>administrador</th>
                        <th>apellidos</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    for ($i=0; $i < count($departamentos); $i++) { 
                        echo "<tr>";
                        echo "<td>".$departamentos[$i]['dnombre']."</td>";
                        echo "<td>".$departamentos[$i]['ciudad']."</td>";
                        echo "<td>".$departamentos[$i]['cp']."</td>";
                        echo "<td>".$departamentos[$i]['nombre']."</td>";
                        echo "<td>".$departamentos[$i]['apellidos']."</td>";
                        echo "</tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="mensaje"><p>!Nohay departamentos departamentos creados¡</p></div>
            <?php endif; ?>
            
        </div>
        <div id="crea_deptno">
            <h2>Crear departamento</h2>
            <form action="index.php" method="POST">
            <table>            
                <tbody>
                <tr><td><label for=":nombre">nombre: </label></td><td><input type="text" name=":nombre"><br/></td><?php if (isset($mensaje) && is_array($mensaje)) {
                    echo "<td>".$mensaje[1]."</td>";
                } ?></tr>
                <tr><td><label for=":ciudad">ciudad: </label></td><td><input type="text" name=":ciudad"><br/></td><?php if (isset($mensaje) && is_array($mensaje)) {
                    echo "<td>".$mensaje[2]."</td>";
                } ?></tr>

                <tr><td><label for=":cp">cp: </label></td><td><input type="text" name=":cp"><br/></td><?php if (isset($mensaje) && is_array($mensaje)) {
                    echo "<td>".$mensaje[4]."</td>";
                } ?></tr>
                <tr><td></td><td><input type="submit" name="create_deptno" value="crear"></td></tr>
                </tbody>
                
            </table>
            </form>
            <?php if (isset($m_deptno)) {
                echo "<div><p>$m_deptno</p></div>";
            } ?>
            
        </div>
        <div id="asignar_inc">
            
                
        </div>