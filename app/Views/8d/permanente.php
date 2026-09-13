
<script>

function solicitar_proyecto(titulo){
    swal({
      title: '¿Deseas solicitar un Proyecto de '+titulo+'?',
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then(function () {
        var url="<?php echo base_url()?>login/pedir_proyecto";
         $.post(url,
                {tema:titulo, tipo:"Proyecto"},
                function(data){
                    swal('La Solicitud fue Enviada');
                }
            );
    });

     return false;
    
    
}
</script>

<div class="col-md-12 tabla_soluciones">
    <div class="card card-plain">
        <h4 class="card-title">Soluciones Permanentes</h4>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Solucion</th>
                    <th>Responsable</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Presupuesto Requerido</th>
                    <th></th>
                </thead>
                <tbody>
                   <?php
                   foreach ($permanente->getResult() as $key) {
                       ?>
                        <tr>
                            <td><?php echo $key->solucion?></td>
                            <td><?php echo $key->nombre?></td>
                            <td><?php echo $key->fecha?></td>
                            <td><?php echo $key->f_fin?></td>
                            <td><?php echo $key->money?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="elimina_permanente('<?php echo $key->id_permanente?>')">Eliminar</button>
                                <button class="btn btn-primary btn-xs" type="button"  onclick="solicitar_proyecto('<?php echo $key->solucion?>')" >Solicitar Proyecto</button>

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