    <script>
        $("#guardar_sugrupo").click(function(){
         var url = "<?php echo base_url()?>login/agrega_subgrupo"; // El script a dónde se realizará la petición.
            $.ajax({
                   type: "POST",
                   url: url,
                   data: $("#form").serialize(), // Adjuntar los campos del formulario enviado.
                   success: function(data)
                   {
                       alertify.success("Subgrupo guardado con exito"); 
                        $('#form')[0].reset(); // Mostrar la respuestas del script PHP. // Mostrar la respuestas del script PHP.
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
    $agrega=array('name'=>'nombre_subgrupo','placeholder'=>'Nombre Subgrupo', 'class'=>'form-control', 'required'=>'required');
    ?>
     <h2>Agrega Subgrupo</h2><br />
     <?php echo form_input($agrega)  ?><br/>
     Seleccione Grupo
    <select id="grupo" name="grupo" class="form-control" placeholder='Selecciona Grupo' required="required" >
        <option value=""></option>
       <?php

foreach ($data->getResult() as $empresa){
    ?>
    <option value="<?php echo $empresa->id?>"><?php echo $empresa->nomber?></option>
    <?php
};
?>
    </select>
    <input type="text" name="empresa_grupo" value="<?php echo $numero?>" style="visibility: hidden;" >
     <button id="guardar_sugrupo">Guardar</button>
    <?php echo form_close()?>
   
    