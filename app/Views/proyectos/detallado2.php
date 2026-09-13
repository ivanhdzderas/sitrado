<script>
function ver_archivo_proyecto(sub_proyecto){
    var url="<?php echo base_url()?>login/ver_archivo_proyecto/"+sub_proyecto;
    window.open(url);

}

</script>
<div class="archiva-panel">
    <div class="mb-3">
        <h2 class="panel-title mb-0">Detalle de proyecto</h2>
    </div>
    <table class="table table-borderless align-middle mb-3">
        <tr>
            <td width="50%">
                <?php
                foreach ($nombre_proyecto as $key) {
                    echo "<b>Proyecto: </b>".esc($key->nombre_proyecto)."<br />";
                    echo "<b>Fecha Inicio: </b>".esc($key->f_inicio)."<br />";
                }
                $alfa=login_model()->carga_datos_usuario($key->patrocinador)->getResult();
                foreach ($alfa as $patro) {
                     echo "<b>Patrocinador: </b>".esc($patro->nombre)."<br />";
                }
                ?>
            </td>
            <td>
                <b>Participantes</b><br />
                <ul>
                <?php
                $array=array();
                foreach ($participantes as $key) {
                    array_push($array, $key->persona);
                }
                $parte= array_unique($array);

                foreach ($parte as $key) {
                    ?>
                    <li><?php echo esc($key)?></li>
                    <?php
                }
                ?>
                </ul>
            </td>
        </tr>
    </table>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Realiza</th>
                    <th>Responsable de validar</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($detalles->getNumRows()>0){
                foreach ($detalles->getResult() as $key) {
                    ?>
                    <tr>
                        <td><?php
                        $query=login_model()->buscar_archivos_proyectos($key->id_subproyecto);

                        $cuantos=$query->getNumRows();
                        if ($cuantos==0){

                        }else{
                            ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="ver_archivo_proyecto('<?php echo esc($key->id_subproyecto, 'js') ?>')">Archivo</button>
                            <?php
                        }
                        echo esc($key->tarea)
                        ?></td>
                        <td><?php echo esc($key->nombre)?></td>
                        <td>
                            <?php
                            $query=login_model()->carga_datos_usuario($key->responsable)->getResult();
                            foreach ($query as $alfa) {
                                echo esc($alfa->nombre);
                            }
                            ?>
                        </td>
                        <td><?php echo esc($key->f_inicio)?></td>
                        <td><?php echo esc($key->f_fin)?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
