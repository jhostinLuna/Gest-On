<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>
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
    <main>
        <?php if (is_a($usuario,'Administrador')):?>
        <div id="info_usu">
            <h2>Incidencias</h2>
            <p>Pendientes de Asignar: <?php echo $pdteAsig; ?></p>
        </div>
        <div id="info_deptno">

            
            <h2>Departamentos</h2>
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
                    
                    for ($i=0; $i < count($usuario->departamentos); $i++) { 
                        echo "<tr>";
                        foreach ($usuario->departamentos[$i] as $value) {
                        
                            echo "<td>".$value."</td>";
                            
                        }
                        echo "</tr>";
                    }
                    
                    ?>
                </tbody>
            </table>
                
        </div>
        <div id="crea_deptno">
            <h2>Crear departamento</h2>
            <form action="index.php" method="POST">
            <table>
            
                <tbody>
                <tr><td><label for=":nombre">nombre: </label></td><td><input type="text" name=":nombre"><br/></td><?php if (isset($mensaje[1])) {
                    echo "<td>".$mensaje[1]."</td>";
                } ?></tr>
                <tr><td><label for=":ciudad">ciudad: </label></td><td><input type="text" name=":ciudad"><br/></td><?php if (isset($mensaje[2])) {
                    echo "<td>".$mensaje[2]."</td>";
                } ?></tr>
                <tr><td><label for=":dni">dni administrador: </label></td><td><input type="text" name=":dni"></td><?php if (isset($mensaje[3])) {
                    echo "<td>".$mensaje[3]."</td>";
                } ?></tr>
                <tr><td><label for=":cp">cp</label></td><td><input type="text" name=":cp"><br/></td><?php if (isset($mensaje[4])) {
                    echo "<td>".$mensaje[4]."</td>";
                } ?></tr>
                <tr><td></td><td><input type="submit" name="create_deptno" value="crear"></td></tr>
                </tbody>
                
            </table>
            </form>
        </div>
        <div id="create_admin">
                
        </div>
        
        <figure><img src="grafico.php" alt="graficoIncidencias"></figure>

        <?php endif; ?>
    </main>
    
</body>
</html>