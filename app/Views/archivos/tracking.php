<div class="card">
    <div class="card-content text-center">
        <div class="table-responsive">
            <table class="table">
                <thead class="text-primary">
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Estatus</th>
                    
                </thead>
                <tbody>
                	<?php
                	foreach ($track->getResult() as $key) {
                		?>
                		<tr>
                			<td><?php echo $key->nombre?></td>
                			<td><?php echo $key->tipo?></td>
                			<td><?php
                			switch ($key->estatus) {
                				case 'P':
                					echo "Pendiente";
                					break;
                				
                				case 'A':
                					echo "Aprobado";
                					break;
                                case 'R':
                                    echo "Rechazada";
                                    ?>
                                        <button class="btn btn-primary btn-xs" onclick="ver_notas('<?php echo $id?>')">Ver Notas</button>
                                    <?php
                                    break;
                			}
                			?></td>
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
    function ver_notas(id){
    var url="<?php echo base_url()?>login/notas_doc";
      $.post(url,
                    {id:id},
                    function(data){
                      swal(data);
                     });
    }
</script>