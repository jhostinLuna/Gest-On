<input type="checkbox" id="resolver_inc" <?php if (strcmp($check, 'resolver_inc') === 0) {
                                                echo 'checked';
                                            } ?>><label for="resolver_inc">Resolver Incidencia</label>
<div class="resolver_inc">
    <p><b>incidencias asignadas: <?php echo count($incRevisar); ?></b></p>
    <h3>Elige una incidecia para completarla:</h3>
    <span><b>Estado: </b></span>
    <span>Pendiente </span><span class="e1"></span>
    <span>Resuelto </span><span class="e2"></span><br>
    <hr>

    <?php if (isset($m_resolver_inc)) {
        echo $m_resolver_inc;
    } ?>
    <form action="index.php" method="POST">
        <div class="thead">

            <div class="col">Asunto</div>

            <div class="col">Equipo</div>
            <div class="col">Ubicación</div>
            <div class="col">Estado</div>
            <div class="col">Prioridad</div>
            <div class="col">Autor</div>
            <div class="col">Fecha</div>


            <div class="col"></div>

        </div>
        <div class="tbody">


            <?php

            for ($i = 0; $i < count($incRevisar); $i++) {
                $indice = array_search($incRevisar[$i]['gestor'], array_column($usuarios, 'id_usu'));
                echo "<div class=\"row\">";

                echo "
            
            <div class=\"col\">" . $incRevisar[$i]['asunto'] . "</div>
            
            <div class=\"col\">" . $incRevisar[$i]['equipo'] . "</div>
            <div class=\"col\">" . $incRevisar[$i]['ubicacion'] . "</div>
            <div class=\"col\"><span " . ${$incRevisar[$i]['estado']} . "></span></div>
            <div class=\"col\">" . $incRevisar[$i]['prioridad'] . "</div>
            
            <div class=\"col\"> <a href=\"index.php?chat=on&:id_dest=".$incRevisar[$i]["id_usu"]."\">".$incRevisar[$i]['autor']."</a> </div>
                    
            
            <div class=\"col\">" . date('d-m-yy', strtotime($incRevisar[$i]['f_creacion'])) . "</div>
            
            
            ";
                echo "
            <div class=\"col\">
            <input type=\"radio\" name=\":id_inc\" value=\"" . $incRevisar[$i]['id_inc'] . "\" id=\"resolver$i\">
            <label for=\"resolver$i\">Elegir</label></div>
            </div>";
            }
            ?>


        </div>
        <input type="submit" name="resolver_inc" value="COMPLETAR">
    </form>
</div>