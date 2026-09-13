<script>
    function genera(){
        var url="<?php echo base_url()?>login/reporte_general/"+$("#tipo_archivo2").val();
        window.open(url, '_blank');
    }
</script>
<div class="col-sm-6 col-lg-6">
    <div class="card">
        <div class="card-content text-center">
            <h4 class="card-title">Reporte Desglosado por Usuario</h4>
            <form id="formulario" target="_blank" method="post" action="<?php echo base_url()?>login/busca_carga_trabajo">
            	<div class="form-group ">
            		<label class="control-label" style="color: #000;font-size: 16px" >Usuario</label>
            		<select id="usuario" name="usuario" class="form-control" required="required">
                	   <option value=""></option>
                    	<?php 
                    	foreach ($usuarios->getResult() as $key) {
                    		?>
                    		<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                    		<?php
                    	}
                    	?>
                    </select>
            	</div>
                <div class="form-group ">
                    <label class="control-label" style="color: #000;font-size: 16px" >Fecha Inicio</label>
                    <input type="date" name="f_inicio" id="f_inicio" class="form-control" required="required">
                </div>
                <div class="form-group ">
                    <label class="control-label" style="color: #000;font-size: 16px" >Fecha Fin</label>
                    <input type="date" name="f_fin" id="f_fin" class="form-control" required="required">
                </div>
            	<button type="submit" class="btn btn-info" id="btn_enviar">Generar</button>
            </form>
        </div>
    </div>
</div>

<div class="col-sm-6 col-lg-6">
    <div class="card">
        <div class="card-content text-center">
            <h4 class="card-title">Reporte de Pendientes General</h4>
            <div class="form-group ">
                <label class="control-label" style="color: #000;font-size: 16px" >Tipo de Archivo</label>
                <select id="tipo_archivo2" name="tipo_archivo2" class="form-control">
                    <option value="pdf" selected="selected">PDF</option>
                    <option value="excel">EXCEL</option>
                </select>
            </div>
            <button type="button" class="btn btn-info" onclick="genera()" id="btn_enviar">Generar</button>
        </div>
    </div>
</div>