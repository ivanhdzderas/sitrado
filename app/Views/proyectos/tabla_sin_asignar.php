
<div class="card">                       
    <h4 class="card-title">Tareas Asignadas</h4>
    <div class="card-content">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tarea</th>
                        <th>Realiza</th>
                        <th>Responsable de Validar</th>
                        <th>Fecha inicio</th>
                        <th>Fecha Fin</th>
                        <th class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($sin_asignar as $tareas) {
                           ?>
                           <tr>
                                <td><?php echo $tareas->nombre?></td>
                                <td><?php echo $tareas->persona?></td>
                                <td>
                                    <?php
                                    $query=login_model()->carga_datos_usuario($tareas->responsable)->getResult();
                                    foreach ($query as $key ) {
                                        echo $key->nombre;
                                    }
                                    ?>
                                </td>
                                <td><?php echo $tareas->f_inicio?></td>
                                <td><?php echo $tareas->f_fin?></td>
                                <td class="td-actions text-right">
                                    <select id="accion<?php echo $tareas->id_subproyecto?>" name="accion" class="form-control">
                                        <option value=""></option>
                                        <option value="elimina">Eliminar</option>
                                        <option value="responsabilidad">Responsabilidades</option>
                                    </select>
                                    <button class="btn btn-primary btn-xs"  onclick="aplica('<?php echo $tareas->id_subproyecto?>')">Ejecutar</button>
                                    
                                </td>
                            </tr>
                           <?php
                        }
                    ?>                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function aplica (id){
        var valor=$("#accion"+id).val();
        if (valor=="elimina"){
            var url="<?php echo base_url()?>login/borrar_subproyecto";
             $.post(url,{subproyecto:id},
            function(data){
                
                var url="<?php echo base_url()?>tareas_sin_asignar";
                $.post(url,
                    {proyecto:id},
                function (data){
                    $("#list_tareas").html(data);
                });

            }); 
        }else if(valor=="responsabilidad"){
            var url="<?php echo base_url()?>login/responsables";
             $.post(url,{id_tarea:id},
            function(data){
                $("#visorjunta").html(data);
            }); 
        }   
    }
</script>