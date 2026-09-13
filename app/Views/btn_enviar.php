<script>
	function guardar_minuta(){
   
    var url = "<?php echo base_url()?>guarda_junta";
    $.ajax({
           type: "POST",
           url: url,
           data: $("#form_minuta").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
                                window.location="<?php echo base_url()?>juntas";
           }
         });
    return false; 
}

   
</script>
<button class="btn btn-success" id="guardar_minuta">Guardar</button>