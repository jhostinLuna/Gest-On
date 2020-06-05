<input type="checkbox" id="crear_inc" <?php if (strcmp($check, 'crear_inc') === 0) {
                                            echo 'checked';
                                        } ?>><label for="crear_inc">Crear Incidencia</label>
<div class="crear_inc" id="cmen">
    <label for="asunto">Asunto: </label>
    <input type="text" maxlength="20" name=":asunto" id="asunto" required><br />
    <label for="equipo">Dispositivo</label>
    <input type="text" maxlength="15" name=":equipo" id="equipo" required><br />
    <label for="ubicacion">Ubicación</label>
    <input type="text" maxlength="20" name=":ubicacion" id="ubicacion" required><br />
    <textarea name=":descripcion" placeholder="Descripción de incidencia" id="descripcion"></textarea>
    <button type="submit" id="c_inc">Crear</button>
</div>
<input type="checkbox" id="todas" <?php if (strcmp($check, 'act') === 0) {
                                        echo 'checked';
                                    } ?>>
<label for="todas">Tienes <?php echo count($misIncidencias); ?> Incidencias creada/s</label>
<div id="info_usu">
    <form action="index.php" method="GET" id="act"></form>
    <button type="submit" name="act" form="act" value="on">Actualizar</button>
    <?php if (!empty($misIncidencias)) : ?>
        <div class="thead">

            <div class="col">Asunto</div>
            <div class="col">Equipo</div>
            <div class="col">Ubicación</div>
            <div class="col">Gestor</div>
            <div class="col">Fecha</div>
            <div class="col">Hora</div>
            <div class="col">Estado</div>
        </div>
        <div class="tbody">


            <?php

            for ($i = 0; $i < count($misIncidencias); $i++) {
                $indice = array_search($misIncidencias[$i]['gestor'], array_column($usuarios, 'id_usu'));
                echo "<div class=\"row\">";

                echo "
                        
                        <div class=\"col\">" . $misIncidencias[$i]['asunto'] . "</div>
                        
                        <div class=\"col\">" . $misIncidencias[$i]['equipo'] . "</div>
                        <div class=\"col\">" . $misIncidencias[$i]['ubicacion'] . "</div>
                        
                        
                        <div class=\"col\">" . $usuarios[$indice]['nombre'] . "</div>
                        
                        <div class=\"col\">" . $misIncidencias[$i]['autor'] . "</div>
                        
                        <div class=\"col\">" . date('d-m-yy', strtotime($misIncidencias[$i]['f_creacion'])) . "</div>
                        <div class=\"col\">" . date('H:i', strtotime($misIncidencias[$i]['f_creacion'])) . "</div>
                        <div class=\"col\"><span " . ${$misIncidencias[$i]['estado']} . "></span></div>
                        ";
                echo "
                        
                        </div>";
            }
            ?>


        </div>


    <?php else : ?>
        <div>
            <p>No hay Incidencias creadas</p>
        </div>
    <?php endif; ?>
</div>