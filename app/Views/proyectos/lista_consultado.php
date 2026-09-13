    <table class="table table-hover">
        <thead>
            <th>Nombre</th>
            <th></th>
        </thead>
        <tbody>
        	<?php
        	foreach ($consultado as $key) {
        		?>
        		<tr>
        			<td>
        				<?php echo $key->nombre?>
        			</td>
                    <td>
                         <button type="button" class="btn btn-sm btn-outline-danger" onclick="elimina_consultado('<?php echo $key->id_consultor ?>')">Eliminar</button>
                    </td>
        		</tr>
        		<?php
        	}
        	?>
            
        </tbody>
    </table>
