
        <div id="info_usu">
            <h2>Incidencias</h2>
            <p>Pendientes de Asignar: <?php echo count($misIncidencias); ?></p>
            <?php if(!empty($misIncidencias)): ?>
            <form action="index.php" method="POST">
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
                    
                    <?php
                    for ($i=0; $i < count($misIncidencias); $i++) { 
                        echo "<tr>";
                        foreach ($misIncidencias as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "
                        <td><input type=\"radio\" name=\":id_inc\" value=\"".$misIncidencias[$i]['id_inc']."\"></td>
                        <td><input type=\"submit\" name=\"asignar\" value=\"asignar\"></td>
                        </tr>";
                        
                    }
                    ?>
                    
                </tbody>
            </table>
            </form>
            <?php else:?>
            <div><p>No hay Incidencias creadas</p></div>
            <?php endif; ?>
            <input type="checkbox" id="inc_revisar"><label for="inc_revisar"><h2>Resueltas</h2></label>
        </div>
        
        <div id="info_deptno">

            
            <h2>Departamentos</h2>
            <?php if(!empty($departamentos)):?>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>departamento</th>
                        
                        <th>ciudad</th>
                        
                        <th>cp</th>
                        <th>administrador</th>
                        <th>apellidos</th>
                        <th>id_Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    for ($i=0; $i < count($departamentos); $i++) { 
                        echo "<tr>";
                        foreach ($departamentos[$i] as $value) {
                        
                            echo "<td>".$value."</td>";
                            
                        }
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
        <div id="create_admin">
            <h2>Cambiar de administrador</h2>
            
                <table>
                <thead>
                    <tr><td>id</td>
                    <td>nombre</td>
                    <td>apellidos</td>
                    <td>movil</td>
                    <td>correo</td>
                    <td>usuario/gestor</td>
                    <td>id_deptno</td>
                    </tr>
                </thead>
                <tbody>
                
                    <?php

                    for ($i=0; $i < count($usuarios); $i++) { 
                        echo "<tr>";
                        
                        foreach ($usuarios[$i] as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "
                        <td><form action=\"index.php\" name=\"update$i\" method=\"POST\">
                        <input type=\"hidden\" name=\":id_usu\" value=\"".$usuarios[$i]['id_usu']."\">
                        <input type=\"hidden\" name=\":id_deptno\" value=\"".$usuarios[$i]['id_deptno']."\">
                        <input type=\"submit\" name=\"update_user\" value=\"asignar\">
                        </form></td>                    
                        </tr>";
                    }
                    //select u.*,count(i.id_inc) from usuarios u  join incidencias i where i.gestor=u.id_usu;
                    //select u.nombre,count(i.id_inc) from usuarios u  join incidencias i where u.id_usu = i.gestor  group by u.id_usu;
                    ?>
                    
                </tbody>
                </table>
                
        </div>

        

        