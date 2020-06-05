<?php
if ($usuario->id_usu == 1) {
    include "gestor.php";
} ?>
<input type="checkbox" id="crea_gestor" <?php if (strcmp($check, 'crear_ges') === 0) {
                                            echo 'checked';
                                        } ?>><label for="crea_gestor">Crear Gestor</label>
<div class="crea_gestor">
    <?php if (isset($m_asig_ges)) {
        echo $m_asig_ges;
    } ?>
    <form action="" method="POST">
        <?php

        for ($i = 1; $i < count($usuarios); $i++) {
            echo "
        <div class=\"row\">
        <div class=\"col\">" . $usuarios[$i]['nombre'] . "</div>
        <div class=\"col\">" . $usuarios[$i]['apellidos'] . "</div>
        
        ";

            if (strcmp($usuarios[$i]['tipo'], 'em') === 0) {
                echo "
            <div class=\"col\">
            <input type=\"radio\" name=\":id_usu\" id=\"em$i\" value=\"" . $usuarios[$i]['id_usu'] . "\"><label for=\"em$i\">gestor</label>
            </div>";
            } elseif (strcmp($usuarios[$i]['tipo'], 'ge') === 0) {
                echo "
            <div class=\"col\">
            <input type=\"radio\" name=\":gestor\" id=\"ges$i\" value=\"" . $usuarios[$i]['id_usu'] . "\"><label for=\"ges$i\">emisor</label>
            </div>";
            }
            echo "</div>";
        }

        ?>

        <input type="submit" name="crear_ges" value="Cambiar">
    </form>
</div>

<input type="checkbox" id="asignar_inc" <?php if (strcmp($check, 'asignar_inc') === 0) {
                                            echo 'checked';
                                        } ?>><label for="asignar_inc">Asignar Incidencia</label>
<div class="asignar_inc">

    <p>Pendientes de Asignar: <?php echo count($incE1); ?></p>
    <?php if (!empty($incE1)) : ?>
        <form action="index.php" id="form_asignar" method="POST">
            <h3>Elegir prioridad: </h3>

            <input type="radio" name=":prioridad" value="<?php echo P1;  ?>" id="p1">
            <label for="p1">MEDIA</label>
            <input type="radio" name=":prioridad" value="<?php echo P2;  ?>" id="p2">
            <label for="p2">URGENTE</label>

            <h3>Eligir una Incidencia: </h3>

            <div class="thead">
                <div class="col">Asunto</div>
                <div class="col">Equipo</div>
                <div class="col">Ubicación</div>
                <div class="col">Gestor</div>
                <div class="col">Autor</div>
                <div class="col">Fecha</div>
                <div class="col">Hora</div>
                <div class="col">Estado</div>
                <div class="col"></div>
            </div>
            <div class="tbody">
                <?php
                for ($i = 0; $i < count($incE1); $i++) {
                    $indice = array_search($incE1[$i]['gestor'], array_column($usuarios, 'id_usu'));
                    echo "<div class=\"row\">";

                    echo "            
            <div class=\"col\">" . $incE1[$i]['asunto'] . "</div>            
            <div class=\"col\">" . $incE1[$i]['equipo'] . "</div>
            <div class=\"col\">" . $incE1[$i]['ubicacion'] . "</div>           
            <div class=\"col\">" . $usuarios[$indice]['nombre'] . "</div>            
            <div class=\"col\">" . $incE1[$i]['autor'] . "</div>            
            <div class=\"col\">" . date('d-m-yy', strtotime($incE1[$i]['f_creacion'])) . "</div>
            <div class=\"col\">" . date('H:i', strtotime($incE1[$i]['f_creacion'])) . "</div>
            <div class=\"col\"><span " . ${$incE1[$i]['estado']} . "></span></div>
            ";
                    echo "
            <div class=\"col\">
            
            <input type=\"hidden\" name=\":id_rem\" value=\"" . $incE1[$i]['id_usu'] . "\">
            <input type=\"radio\" name=\":id_inc\" value=\"" . $incE1[$i]['id_inc'] . "\" id=\":id_inc$i\">
            <label for=\":id_inc$i\">Elegir</label>
            </div>
            </div>";
                }
                ?>
            </div>
            <?php if (isset($m_asig_inc)) {
                echo "<span class=\"mensaje\">$m_asig_inc</span>";
            } ?>
            <h3>Elegir gestor para incidencia: </h3>
            <div class="t_gest">
                <div class="thead">

                    <div class="col">nombre</div>
                    <div class="col">apellidos</div>
                    <div class="col">movil</div>                    
                    <div class="col"></div>
                </div>
                <div class="tbody">

                    <?php

                    for ($i = 0; $i < count($usuarios); $i++) {
                        if (strcmp($usuarios[$i]['tipo'],'em') !== 0) {
                            echo "<div class=\"row\">";
                            echo "<div class=\"col\">" . $usuarios[$i]['nombre'] . "</div>";
                            echo "<div class=\"col\">" . $usuarios[$i]['apellidos'] . "</div>";
                            echo "<div class=\"col\">" . $usuarios[$i]['movil'] . "</div>";
                            
                            echo "<div class=\"col\"><input type=\"radio\" name=\":gestor\" value=\"" .
                                $usuarios[$i]['id_usu'] . "\" id=\":id_usu$i\"><label for=\":id_usu$i\">Elegir</label></div>";
                            echo "</div>";
                            
                        }
                        
                    }
                    ?>
                </div>
            </div>
        </form>
        <button type="submit" name="asignar_inc" form="form_asignar" value="on">ASIGNAR</button>
    <?php else : ?>
        <div>
            <p>No hay Incidencias creadas</p>
        </div>
    <?php endif; ?>
    <hr>
    <h3>Informacion de gestores:</h3>
    <div class="info_gest">
                <div class="thead">

                    <div class="col">nombre</div>
                    <div class="col">apellidos</div>
                    <div class="col">movil</div>
                    <div class="col">asignadas</div>
                </div>
                <div class="tbody">

                    <?php

                    for ($i = 0; $i < count($gestores); $i++) {
                        
                            echo "<div class=\"row\">";
                            echo "<div class=\"col\">" . $gestores[$i]['nombre'] . "</div>";
                            echo "<div class=\"col\">" . $gestores[$i]['apellidos'] . "</div>";
                            echo "<div class=\"col\">" . $gestores[$i]['movil'] . "</div>";
                            echo "<div class=\"col\">" . $gestores[$i]['asignadas'] . "</div>";
                            echo "</div>";
                            
                        
                        
                    }
                    ?>
                </div>
            </div>
</div>
<div id="d_inc">
    <h3>Presiona el boton para Borrar incidencias Resueltas: </h3><button type="submit" id="delete_inc">Borrar</button>
</div>
