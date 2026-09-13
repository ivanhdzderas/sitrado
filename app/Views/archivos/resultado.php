<div class="card">
    <div class="card-content text-center">
        <?php
        if ($encontrado->getNumRows()==0){
            ?>
            <code>Sin Resultado</code>
            <?php
        }else{
            ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="text-primary">
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Fecha de Ingreso</th>
                            <th>Estatus</th>
                            <th></th>
                        </thead>
                        <tbody>
                           
                            <?php
                            foreach ($encontrado->getResult() as $key) {
                                ?>
                                    <tr>
                                        <td><?php echo $key->nombre?></td>
                                        <td><?php echo $key->departamento?></td>
                                        <td><?php echo $key->fecha?></td>
                                        <td><?php 
                                        switch($key->estatus){
                                            case "P":
                                                echo "Pendiente";
                                            break;
                                            case "A":
                                                echo "Aprobado";
                                            break;
                                            case "R":
                                                echo "Rechazado";
                                            break;
                                        }
                                        ?></td>
                                        <td><?php
                                            if ($key->estatus=="R"){
                                                ?>
                                                <button class="btn btn-primary btn-xs" onclick="ver_notas('<?php echo $key->id?>')">Ver Notas</button>
                                                <?php
                                            }
                                        ?></td>
                                    </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    function ver_notas(id){
    var url="<?php echo base_url()?>login/notas_doc";
      $.post(url,
                    {id:id},
                    function(data){
                      swal(data);
                     });
    }
</script>