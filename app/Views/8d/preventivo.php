<div class="col-md-12 tabla_soluciones">
    <div class="card card-plain">
        <h4 class="card-title">Soluciones Preventivas</h4>
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
                   foreach ($preventivo as $key) {
                       ?>
                        <tr>
                            <td><?php echo $key->solucion?></td>
                            <td><?php echo $key->nombre?></td>
                            <td><?php echo $key->fecha?></td>
                            <td><?php echo $key->f_fin?></td>
                            <td><?php echo $key->money?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="elimina_preventivo('<?php echo $key->id_preventivo?>')">Eliminar</button>
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