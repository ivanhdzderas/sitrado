<script>

</script>
<div class="col-md-12">
    <div class="card">
        <form id="form_business" class="form-horizontal">
            
            <div class="card-content">
                <h3>Levantamiento de Business Case</h3>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Solicitante</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select id="usuario" name="usuario" class="form-control">
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
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Analisis de los hechos</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" id="hechos" name="hechos" class="form-control" value>
                            <span class="help-block">A block of help text that breaks onto a new line.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Defincion de la ventaja</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" id="define_ventaja" name="define_ventaja" class="form-control" value>
                            <span class="help-block">A block of help text that breaks onto a new line.</span>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <label class="col-sm-2 label-on-left">Alternativas</label>                                   

                    <div class="col-sm-5">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" id="alternativa" name="alternativa" class="form-control" value>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-primary btn-xs" id="agregar_alternativa">Agregar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-10" id="alter">
                       <!-- tabla-->
                       
                       <!-- fin tabla -->
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-primary" id="guardar_business" >Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $().ready(function() {

        tabla_alternativas();
    });
    $("#guardar_business").click(function(){
     var url = "<?php echo base_url()?>login/guardar_business"; // El script a dónde se realizará la petición.
        $.ajax({
               type: "POST",
               url: url,
               data: $("#form_business").serialize(), // Adjuntar los campos del formulario enviado.
               success: function(data)
               {
                   location.reload();
               }
             });

        return false; // Evitar ejecutar el submit del formulario.
     });

 

    $("#agregar_alternativa").click(function(){
     var url = "<?php echo base_url()?>login/agregar_alternativa"; // El script a dónde se realizará la petición.
        $.ajax({
               type: "POST",
               url: url,
               data: {alternativa:$("#alternativa").val()}, // Adjuntar los campos del formulario enviado.
               success: function(data)
               {
                    $("#alternativa").val("");
                   //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
                   tabla_alternativas();
               }
             });

        return false; // Evitar ejecutar el submit del formulario.
     });

    function tabla_alternativas(){
        var url="<?php echo base_url()?>login/tabla_alternativas";
        $.post(url,
            {folio:"0"},
            function(data){
                $("#alter").html(data);
             });
        
    }
    function elimina(id){
        var url="<?php echo base_url()?>login/elimina_alternativa";
        $.post(url,
            {id:id},
            function(data){
                tabla_alternativas();
             });
    }
</script>