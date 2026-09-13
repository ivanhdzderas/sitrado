<div class="col-md-12">
    <div class="card card-plain">
        <h4 class="card-title">Equipo de Trabajo</h4>
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Nombre</th>
                    <th>Departamento</th>
                    <th>Puesto</th>
                    <th></th>
                </thead>
                <tbody>
                   <?php
                   foreach ($equipo->getResult() as $key) {
                       ?>
                        <tr>
                            <td><?php echo $key->nombre?></td>
                            <td><?php echo $key->departamento?></td>
                            <td><?php echo $key->puesto?></td>
                            <td>
                                <button type="button" onclick="elimina('<?php echo $key->id_equipo?>')" class="btn btn-sm btn-outline-danger">
                                    Eliminar
                                </button>
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