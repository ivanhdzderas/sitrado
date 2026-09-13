<script>
function guardar(tema,junta){
	var url="<?php echo base_url()?>guardar_reagendar";
	var fecha=$("#nueva_fecha").val();
	$.post(url,{tema:tema,fecha:fecha},
                function (data){
                
                var url="<?php echo base_url()?>detallado_temas";
   
                $.post(url,
                        {junta:junta},
                        function(data){
                            $("#visorjunta").html(data);
                         }); 
        })
}
</script>
<label class="label-control">Nueva Fecha</label>
<input type="date" class="form-control datetimepicker" name="nueva_fecha"  id="nueva_fecha" />

<button class="btn btn-warning" onclick="guardar('<?php echo $id_actividad?>','<?php echo $junta?>')">Guardar</button>