<div class="col-md-12">
	<button type="button" class="btn btn-archiva btn-sm mb-2" onclick="agrega_nota('<?php echo $subproyecto?>')">Agregar notas</button>
    <div class="card card-plain">
        <div class="card-content table-responsive">
            <table class="table table-hover">
                <thead>
                    <th>Fecha</th>
                    <th>Nota</th>
                </thead>
                <tbody>
                   <?php
					foreach ($lista as $key ) {
						?>
						<tr>
							<td>
								<?php echo $key->fecha?>
							</td>
							<td>
								<?php echo $key->nota?>
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