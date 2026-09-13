<script>
		function validar(){
			var tiene=$("#tipo").val();
			var url="<?php echo base_url()?>login/";
			if (tiene=="N"){
				url=url+"creacion";
			}else{
				url=url+"otro";
			}

			$.post(url,
                   
                    function(data){
                   $("#respuesta").html(data);
                     });


		}
</script>
<div class="col-md-6 col-md-offset-3">
    <div class="card">
        <div class="card-content">
            <h4 class="card-title"><center>Solicitud Documental</center></h4>
            <form id="formulario">
                <div class="form-group">
                    <label class="control-label">Tipo de Solicitud</label>
                    <select id="tipo" onchange="validar()" name="tipo" class="form-control" >
                    	<option value=""></option>
                    	<!--<option value="N">Creacion</option>-->
                    	<option value="M">Modificacion</option>
                    	<option value="C">Cancelacion</option>
                    </select>
                </div>
                <div id="respuesta"></div>
                	
                
            </form>
        </div>
    </div>
</div>