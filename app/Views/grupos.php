    <script>
         $("#guardar_grupo").click(function(){
         var url = "<?php echo base_url()?>login/agrega_grupo"; // El script a dónde se realizará la petición.
            $.ajax({
                   type: "POST",
                   url: url,
                   data: $("#form").serialize(), // Adjuntar los campos del formulario enviado.
                   success: function(data)
                   {
                        alertify.success("Grupo guardado con exito"); 
                        $('#form')[0].reset(); // Mostrar la respuestas del script PHP.
                        var url = "<?php echo site_url('login/vista_estructura')?>";
                        $.ajax({
                          url : url,
                          type: "POST",
                          data: {id:'<?php echo $numero?>'},
                          success: function(data)
                          {
                          $("#empresas_body").html(data);
                          }
                        });


                        $('#modal_form').modal('show');
                        $('#ModalVisor').modal('hide');
                   }
                 });

            return false; // Evitar ejecutar el submit del formulario.
         });
    </script>
    <form id="form" method="post">
    <?php 
    $agrega=array('name'=>'nombre_grupo','placeholder'=>'Nombre Grupo', 'class'=>'form-control', 'required'=>'required');
    $empresa=array('name'=>'empresa_grupo','style'=>'visibility:hidden', 'value'=>$numero );
    ?>


     <?php echo form_input($agrega)  ?>
     <button id="guardar_grupo" onclick="">Guardar</button>
     <?php echo form_input($empresa) ?>
     
    <?php echo form_close()?>
   
    