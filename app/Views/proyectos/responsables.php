<script>
$(document).ready(function(){
    lista_informado();
    lista_consultado();
});
function lista_informado(){
    var url="<?php echo base_url()?>login/lista_informado";
    var id_tarea=$("#id").val();
    $.post(url,
        {id_tarea:id_tarea},
        function(data){
            $("#lista_informado").html(data);
     }); 
}
function lista_consultado(){
    var url="<?php echo base_url()?>login/lista_consultado";
    var id_tarea=$("#id").val();
    $.post(url,
        {id_tarea:id_tarea},
        function(data){
            $("#lista_cosultado").html(data);
     }); 
}
function agrega_consultor(){
    var url="<?php echo base_url()?>login/agrega_consultor";
    var id_tarea=$("#id").val();
    $.post(url,
        {id_tarea:id_tarea,usuario:$("#consultado").val()},
        function(data){
            $("#consultado").val("");
            lista_consultado();
     }); 
}
function agrega_informado(){
    var url="<?php echo base_url()?>login/agrega_informado";
    var id_tarea=$("#id").val();
    $.post(url,
        {id_tarea:id_tarea,usuario:$("#informado").val()},
        function(data){
            $("#informado").val("");
            lista_informado();
     }); 
}
function elimina_informador(id){
    var url="<?php echo base_url()?>login/elimina_informador";
    $.post(url,
        {id:id},
        function(data){
            lista_informado();
     }); 
}
function elimina_consultado(id){
    var url="<?php echo base_url()?>login/elimina_consultado";
    $.post(url,
        {id:id},
        function(data){
            lista_consultado();
     }); 
}
</script>
<div class="card">
    <div class="card-content">
        <div class="row">
            <div class="col-sm-6">
                <h3>Consultado</h3>
                <select id="consultado" name="consultado" class="form-control">
                    <option value=""></option>
                    <?php
                     foreach ($usuarios->getResult() as $key) {
                        ?>
                        <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                        <?php
                     }
                    ?>
                </select>
                <button class="btn btn-primary btn-xs" onclick="agrega_consultor()">Agregar</button>
            </div>
            <div class="col-sm-6">
                <h3>Informado</h3>
                <select id="informado" name="informado" class="form-control">
                    <option value=""></option>
                    <?php
                     foreach ($usuarios->getResult() as $key) {
                        ?>
                        <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                        <?php
                     }
                    ?>
                </select>
                <button class="btn btn-primary btn-xs" onclick="agrega_informado()">Agregar</button>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-sm-6" id="lista_cosultado">
                
            </div>
            <div class="col-sm-6" id="lista_informado">
                
            </div>
        </div>

    </div>
</div>
<input type="text" id="id" value="<?php echo $folio?>" name="id" style="visibility: hidden;">