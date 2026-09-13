<script>
function agrega(tipo){ 
    var url="<?php echo base_url()?>login/"+tipo;
    var empresa=$("#empresa_tipo").val();
      $.post(url,
            {empresa:empresa},
            function(data){
                $("#cuerpo_tipo").html(data);
             }); 
       
};

</script>
<select id="empresa_tipo" nama="empresa_tipo" class="form-control">
	<option value=""></option>
	<?php
	foreach ($empresas->getResult() as $key) {
		?>
			<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
		<?php
	}
	?>
</select>
<button class="btn btn-primary btn-xs" onclick="agrega('<?php echo $tipo?>')" >Mostrar</button>
<div id="cuerpo_tipo">
Esperando respuesta de servidor...
</div>