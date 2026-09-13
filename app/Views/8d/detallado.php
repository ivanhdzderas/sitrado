<script>
	function terminar(tipo, folio){
	
		    var url="<?php echo base_url()?>login/terminar_8d/";
			$.post(url,{tipo:tipo,folio:folio},
                function (data){
                	location.reload();  
            });
		
	}
	function limpiar(tipo, folio){
	
		    var url="<?php echo base_url()?>login/limpiar_8d/";
			$.post(url,{tipo:tipo,folio:folio},
                function (data){
                	location.reload();  
            });
		
	}
	function ver_archivo_8d(folio, tipo){
		window.open("<?php echo base_url()?>login/ver_archivo_8d/"+folio+"/"+tipo);
	}
    function atras(){
        window.location="<?php echo base_url()?>8d";
    }
</script>
<div class="col-md-12">
     <button type="button" class="btn btn-outline-secondary btn-sm mb-2" onclick="atras(); return false;">Regresar</button>
     <div class="card" style="padding: 10px">
     	<table>
     		<tr>
     			<td width="50%">
     				<b>Tipo de analisis:</b> <?php echo $general[0]->tipo ?><br/>
			     	<b>Problema Detectado:</b> <?php echo $general[0]->problema_detectado ?><br />
			     	<b>Descripcion del problema:</b><?php echo $general[0]->descripcion_problema ?><br />
			     	<b>Objetivo del analisis:</b><?php echo $general[0]->objetivo ?>
     			</td>
     			<td valign="top">
     				<b>Equipo de trabajo</b>
     				<ul>
     					<?php 
     					foreach ($equipo->getResult() as $key) {
     						?>
     						<li><?php echo $key->nombre?></li>
     						<?php
     					}
     					?>
     				</ul>
     				
     			</td>
     		</tr>
     	</table>
     </div>
 </div>
 <div class="col-md-12">
     <div class="card" >
     	<div class="card-content">
            <h4 class="card-title">Solucion temporal</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-primary">
                        <th>Solucion</th>
                        <th>Reponsable</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Costo</th>
                        <th></th>
                    </thead>
                    <tbody>
                    	<?php 
                       
                    	foreach ($temporales as $key) {
                    		?>
                    		<tr>
                    			<td>

                    				<?php 
                    				if (login_model()->buscar_archivo_8d($key->id_solucion,'temporal')->getNumRows()==0){

                    				}else{
                    					?>
                    					<button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="ver_archivo_8d('<?php echo $key->id_solucion?>','temporal')">Archivo</button>
                    					<?php
                    				}
                    				?>
                    				<?php echo $key->solucion?></td>
                    			<td><?php echo $key->nombre?></td>
                    			<td><?php echo $key->fecha?></td>
                    			<td><?php echo $key->f_fin?></td>
                    			<td class="text-primary"><?php echo $key->money?></td>
                    			<td>
                    				<?php
                                    if ($key->activo=="SI"){

                                    
                                    ?>
                    				<button type="button" class="btn btn-sm btn-outline-success me-1" title="Terminar Actividad" onclick="terminar('t','<?php echo $key->id_solucion?>')">Terminar</button>
                                    <?php
                                    }
                                    ?>
                    				<button type="button" class="btn btn-sm btn-outline-danger me-1" title="Limpiar Actividad" onclick="limpiar('t','<?php echo $key->id_solucion?>')">Limpiar</button>
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
</div>

<div class="col-md-12">
     <div class="card" >
     	<div class="card-content">
            <h4 class="card-title">Solucion permanente</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-primary">
                        <th>Solucion</th>
                        <th>Reponsable</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Costo</th>
                        <th></th>
                    </thead>
                    <tbody>
                    	<?php 

                    	foreach ($permanente->getResult() as $key) {
                    		?>
                    		<tr>
                    			<td>
                    				<?php 
                    				if (login_model()->buscar_archivo_8d($key->id_permanente,'permanente')->getNumRows()==0){

                    				}else{
                    					?>
                    					<button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="ver_archivo_8d('<?php echo $key->id_permanente?>','permanente')">Archivo</button>
                    					<?php
                    				}
                    				?>
                    				<?php echo $key->solucion?></td>
                    			<td><?php echo $key->nombre?></td>
                    			<td><?php echo $key->fecha?></td>
                    			<td><?php echo $key->f_fin?></td>
                    			<td class="text-primary"><?php echo $key->money?></td>
                    			<td>
                    				<?php
                                    if ($key->activo=="SI"){

                                    
                                    ?>
                    				<button type="button" class="btn btn-sm btn-outline-success me-1" title="Terminar Actividad" onclick="terminar('p','<?php echo $key->id_permanente?>')">Terminar</button>
                                    <?php
                                        }
                                    ?>
                    				<button type="button" class="btn btn-sm btn-outline-danger me-1" title="Limpiar Actividad" onclick="limpiar('p','<?php echo $key->id_permanente?>')">Limpiar</button>
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
</div>

<div class="col-md-12">
     <div class="card" >
     	<div class="card-content">
            <h4 class="card-title">Acciones Preventivas</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead class="text-primary">
                        <th>Solucion</th>
                        <th>Reponsable</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Costo</th>
                        <th></th>
                    </thead>
                    <tbody>
                    	<?php 
                    	foreach ($preventivo as $key) {
                    		?>
                    		<tr>
                    			<td>
                    				<?php 
                    				if (login_model()->buscar_archivo_8d($key->id_preventivo,'preventivo')->getNumRows()==0){

                    				}else{
                    					?>
                    					<button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="ver_archivo_8d('<?php echo $key->id_preventivo?>','preventivo')">Archivo</button>
                    					<?php
                    				}
                    				?>
                    				<?php echo $key->solucion?></td>
                    			<td><?php echo $key->nombre?></td>
                    			<td><?php echo $key->fecha?></td>
                    			<td><?php echo $key->f_fin?></td>
                    			<td class="text-primary"><?php echo $key->money?></td>
                    			<td>
                    				<?php
                                    if ($key->activo=="SI"){

                                    
                                    ?>
                    				<button type="button" class="btn btn-sm btn-outline-success me-1" title="Terminar Actividad" onclick="terminar('e','<?php echo $key->id_preventivo?>')">Terminar</button>
                                    <?php
                                        }
                                    ?>
                    				<button type="button" class="btn btn-sm btn-outline-danger me-1" title="Limpiar Actividad" onclick="limpiar('e','<?php echo $key->id_preventivo?>')">Limpiar</button>
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
</div>