<style>
.tabla_soluciones{ font-size: 10px; }
</style>
<div class="archiva-stepper" id="wizardProfile">
    <form id="nuevo_reporte">
        <h2 class="archiva-stepper-title">Nuevo reporte 8D</h2>
        <div class="archiva-stepper-summary">
            <span id="muestreo_problema"></span>
            <span id="muestreo_causa_raiz"></span>
        </div>

        <ul class="archiva-steps" id="archivaSteps">
            <li class="active" data-step="about"><button type="button">Datos generales</button></li>
            <li data-step="problema"><button type="button">Descripción del problema</button></li>
            <li data-step="equipo"><button type="button">Equipo de trabajo</button></li>
            <li data-step="temporal"><button type="button">Solución temporal</button></li>
            <li data-step="cauza"><button type="button">Causa raíz</button></li>
            <li data-step="permanente"><button type="button">Solución permanente</button></li>
            <li data-step="recurrencia"><button type="button">Prevención recurrencia</button></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="about">
                                            <div class="row">
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Tipo
                                                            </h4>
                                                            <select id="tipo" name="tipo" required="required" class="form-control">
                                                                <option value=""></option>
                                                                <option value="auditoria">Hallazgo de Auditoria</option>
                                                                <option value="cliente">Reclamo de Cliente</option>
                                                                <option value="mejora">Accion de Mejora</option>
                                                                <option value="problema">Problema</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Solicitante
                                                            </h4>
                                                            <select id="solicitante" name="solicitante" required="required" class="  form-control">
                                                                <option value=""></option>
                                                                <?php
                                                                foreach ($personal->getResult() as $key) {
                                                                    ?>
                                                                    <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Lider
                                                            </h4>
                                                            <select id="lider" name="lider" required="required" class="  form-control">
                                                                <option value=""></option>
                                                                <?php
                                                                foreach ($personal->getResult() as $key) {
                                                                    ?>
                                                                    <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Objetivo del Analisis
                                                            </h4>
                                                            <input type="text" id="objetivo" name="objetivo" required="required" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Presupuesto Inicial
                                                            </h4>
                                                            <input type="text" id="presupuesto_estimado" name="presupuesto_estimado" required="required" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="problema">
                                            <div class="row">
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Problema Detectado
                                                            </h4>
                                                            <input type="text" id="problema_det" name="problema_det" class="form-control" required="required" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-lg-offset-1">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Describe el problema
                                                            </h4>
                                                            <textarea id="problema_des" name="problema_des" class="form-control" required="required" ></textarea>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="equipo">
                                            <div class="row">
                                                <div class="col-lg-10 col-lg-offset-1">
                                                   
                                                        <div class="input-group">
                                                            <span class="input-group-addon">  
                                                            </span>
                                                            <div class="form-group  ">
                                                                </h4 class="titu">Equipo de Trabajo
                                                                </h4>
                                                                <select id="pre_equipo" name="pre_equipo" class="form-control">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($personal->getResult() as $key) {
                                                                        ?>
                                                                        <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-xs" id="agrega_equipo" >Agregar</button>
                                                    
                                                </div>
                                                <div class="col-lg-10 col-lg-offset-1" id="tabla_equipo">
                                                        
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="tab-pane" id="temporal">
                                            
                                                <div class="row">
                                                    <div class="col-lg-5 col-lg-offset-1">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">  
                                                            </span>
                                                            <div class="form-group  ">
                                                                </h4 class="titu">Solucion
                                                                </h4>
                                                                <input type="text" id="solucion1" name="solucion1" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">  
                                                            </span>
                                                            <div class="form-group  ">
                                                                </h4 class="titu">Responsable
                                                                </h4>
                                                                <select id="responsable1" name="responsable1" class="form-control">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($personal->getResult() as $key) {
                                                                        ?>
                                                                            <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-lg-offset-1">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">  
                                                            </span>
                                                            <div class="form-group  ">
                                                                </h4 class="titu">Fecha Inicion
                                                                </h4>
                                                                <input type="date"  id="f_inicio1" name="f_inicio1" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-5 ">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">  
                                                            </span>
                                                            <div class="form-group  ">
                                                                </h4 class="titu">Fecha Fin
                                                                </h4>
                                                                <input type="date" id="f_fin1" name="f_fin1" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-5 col-lg-offset-1">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">  
                                                            </span>
                                                            <div class="form-group  ">
                                                                </h4 class="titu">Presupuesto Requerido
                                                                </h4>

                                                                <input type="number" id="costo1" name="costo1" step="any" class="form-control">
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary btn-xs" id="agrega_temporales" >Agregar</button>
                                                    </div>                                            
                                                    <div class="col-lg-10 col-lg-offset-1" id="soluciones_temporales">
                                                            
                                                    </div>
                                                </div>
                                            
                                        </div>


                                        <div class="tab-pane" id="cauza">
                                            <h3>1.-Posibles Causas</h3>
                                            <div class="row">
                                                <!--<div class="col-lg-11">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group">
                                                            </h4 class="titu">Materia Prima
                                                            </h4>
                                                            <input type="text" id="materia" name="materia" required="required">
                                                        </div>
                                                    </div>
                                                </div>-->

                                                <div class="col-lg-11">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group">
                                                            </h4 class="titu">Procesos
                                                            </h4>
                                                            <input type="text" class="form-control" id="metodos" name="metodos" required="required" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group">
                                                            </h4 class="titu">Recurso Humano
                                                            </h4>
                                                            <input type="text" class="form-control" id="mano" name="mano" required="required" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group">
                                                            </h4 class="titu">Infraestructura
                                                            </h4>
                                                            <input type="text" class="form-control" id="maquinaria" name="maquinaria" required="required" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group">
                                                            </h4 class="titu">Sistemas
                                                            </h4>
                                                            <input type="text" class="form-control" id="ambiente" name="ambiente" required="required" >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-11">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group">
                                                            <h3>2.-Causa Raiz</h3>
                                                            </h4>
                                                            <input type="text" id="cauza_raiz" name="cauza_raiz" required="required" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="permanente">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Solucion
                                                            </h4>
                                                            <input type="text" id="solucion2" name="solucion2" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Responsable
                                                            </h4>
                                                            <select id="responsable2" name="responsable2" class="form-control">
                                                                <option value=""></option>
                                                                    <?php
                                                                    foreach ($personal->getResult() as $key) {
                                                                        ?>
                                                                            <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Fecha Inicio
                                                            </h4>
                                                            <input type="date" id="f_inicio2" name="f_inicio2" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Fecha Fin
                                                            </h4>
                                                            <input type="date"  id="f_fin2" name="f_fin2" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                </div>


                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Presupuesto Requerido
                                                            </h4>
                                                            <input type="number"  id="costo2" name="costo2" step="any" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-xs" id="agrega_permanentes" >Agregar</button>
                                                </div>
                                                
                                                <div class="col-lg-11" id="solucion_permanente">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="recurrencia">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Solucion
                                                            </h4>
                                                            <input type="text" id="solucion3" name="solucion3" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Responsable
                                                            </h4>
                                                            <select id="responsable3" name="responsable3" class="form-control">
                                                                <option value=""></option>
                                                                    <?php
                                                                    foreach ($personal->getResult() as $key) {
                                                                        ?>
                                                                            <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Fecha Inicio
                                                            </h4>
                                                            <input type="date" id="f_inicio3" name="f_inicio3" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Fecha Fin
                                                            </h4>
                                                            <input type="date" id="f_fin3" name="f_fin3" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="col-lg-5">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">  
                                                        </span>
                                                        <div class="form-group  ">
                                                            </h4 class="titu">Presupuesto Requerido
                                                            </h4>
                                                            <input type="number" step="any" id="costo3" name="costo3" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary btn-xs" id="agrega_recurrentes" >Agregar</button>
                                                </div>
                                                <div class="col-lg-11" id="solucion_preventivos">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        <div class="archiva-stepper-footer">
            <input type="button" class="btn btn-outline-secondary btn-previous" name="previous" value="Atrás">
            <div class="d-flex gap-2">
                <input type="button" class="btn btn-archiva btn-next" name="next" value="Siguiente">
                <input type="button" class="btn btn-archiva btn-finish" name="finish" value="Guardar">
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
function initArchivaStepper() {
    var $root = $('#wizardProfile');
    var $steps = $('#archivaSteps li');
    var $panes = $root.find('.tab-pane');
    var index = 0;

    function goTo(i) {
        if (i < 0 || i >= $steps.length) return;
        index = i;
        $steps.removeClass('active done');
        $steps.each(function (n) {
            if (n < index) $(this).addClass('done');
            if (n === index) $(this).addClass('active');
        });
        $panes.removeClass('active');
        var stepId = $steps.eq(index).data('step');
        $('#' + stepId).addClass('active');
        $root.find('.btn-previous').toggle(index > 0);
        $root.find('.btn-next').toggle(index < $steps.length - 1);
        $root.find('.btn-finish').toggle(index === $steps.length - 1);
    }

    $steps.find('button').on('click', function () {
        goTo($(this).closest('li').index());
    });
    $root.find('.btn-next').on('click', function () {
        var texto = "<b>Descripción del problema: </b>" + ($("#problema_des").val() || "");
        $("#muestreo_problema").html(texto);
        var valor = " <b>Causa raíz: </b>" + ($("#cauza_raiz").val() || "");
        $("#muestreo_causa_raiz").html(valor);
        goTo(index + 1);
    });
    $root.find('.btn-previous').on('click', function () {
        goTo(index - 1);
    });
    goTo(0);
}

$(function () {
    initArchivaStepper();
    lista_equipo();
    lista_temporales();
    lista_permanente();
    lista_preventivos();
});
    function lista_preventivos(){
        var url="<?php echo base_url()?>login/solucion_preventivos";
         $.post(url,
            function(data){
                $("#solucion_preventivos").html(data);
             });
    }
    function lista_permanente(){
        var url="<?php echo base_url()?>login/solucion_permanente";
         $.post(url,
            function(data){
                $("#solucion_permanente").html(data);
             }); 
    }
    function lista_temporales(){
        var url="<?php echo base_url()?>login/temporales";
         $.post(url,
            
            function(data){
                $("#soluciones_temporales").html(data);
             }); 
    }
    function lista_equipo(){
        var url="<?php echo base_url()?>login/lista_equipo_trabajo";
         $.post(url,
            
            function(data){
                $("#tabla_equipo").html(data);
             }); 
    }
    function elimina_temporal(id){
        var url="<?php echo base_url()?>login/elimina_temporal";
        $.post(url,
            {id:id},
            function(data){
                lista_temporales();
             }); 
    }
    function elimina_preventivo(id){
        var url="<?php echo base_url()?>login/elimina_preventivo";
        $.post(url,
            {id:id},
            function(data){
                lista_preventivos();
             }); 
    }
    function elimina_permanente(id){
        var url="<?php echo base_url()?>login/elimina_permanente";
        $.post(url,
            {id:id},
            function(data){
                lista_permanente();
             }); 
    }
    $("#agrega_recurrentes").click(function(){
        var url = "<?php echo base_url()?>login/agrega_preventivo"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {solucion:$("#solucion3").val(),responsable:$("#responsable3").val(),f_inicio:$("#f_inicio3").val(), f_fin:$("#f_fin3").val(), costo:$("#costo3").val()} ,// Adjuntar los campos del formulario enviado.
           success: function(data)
           {    
                $("#solucion3").val("");
                $("#responsable3").val("");
                $("#f_inicio3").val("");
                $("#f_fin3").val("");
                $("#costo3").val("");
                //$("#solucion_temporal")[0].reset()
                lista_preventivos(); // Mostrar la respuestas del script PHP.
           }
         });
        return false;
    })
    $("#agrega_permanentes").click(function(){
        var url = "<?php echo base_url()?>login/agrega_permanente"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {solucion:$("#solucion2").val(),responsable:$("#responsable2").val(),f_inicio:$("#f_inicio2").val(), f_fin:$("#f_fin2").val(), costo:$("#costo2").val()} ,// Adjuntar los campos del formulario enviado.
           success: function(data)
           {    
                $("#solucion2").val("");
                $("#responsable2").val("");
                $("#f_inicio2").val("");
                $("#f_fin2").val("");
                $("#costo2").val("");
                //$("#solucion_temporal")[0].reset()
                lista_permanente(); // Mostrar la respuestas del script PHP.
           }
         });
        return false;
    })
    $("#agrega_temporales").click(function(){

        var url = "<?php echo base_url()?>login/agrega_temporal"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {solucion:$("#solucion1").val(),responsable:$("#responsable1").val(),f_inicio:$("#f_inicio1").val(), f_fin:$("#f_fin1").val(), monto:$("#costo1").val()} ,// Adjuntar los campos del formulario enviado.
           success: function(data)
           {    
                $("#solucion1").val("");
                $("#responsable1").val("");
                $("#f_inicio1").val("");
                $("#f_fin1").val("");
                $("#costo1").val("");
                
                //$("#solucion_temporal")[0].reset()
                lista_temporales(); // Mostrar la respuestas del script PHP.
           }
         });
        return false;
    })
    $("#agrega_equipo").click(function(){
        var url = "<?php echo base_url()?>login/agrega_equipo"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {equipo:$("#pre_equipo").val()} ,// Adjuntar los campos del formulario enviado.
           success: function(data)
           {
                $("#pre_equipo").val("");   
               lista_equipo(); // Mostrar la respuestas del script PHP.
           }
         });

        return false; // Evitar ejecutar el submit del formulario.
    })

    function elimina(id){
        var url="<?php echo base_url()?>login/elimina_equipo";
         $.post(url,
            {equipo:id},
            function(data){
                lista_equipo();
             }); 
    }
    $("input[name = 'finish']").click(function(){
        var url="<?php echo base_url()?>login/guarda_analisis";
        $.ajax({
           type: "POST",
           url: url,
           data: $("#nuevo_reporte").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
                window.location="<?php echo base_url()?>8d";
           }
         });
        return false;
    })

 

</script>