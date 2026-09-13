<style>
.tabla_soluciones{
    font-size: 10px;
}
.titu{
    font-size: 10px;
}
</style>

            <div class="content">
                <div class="container-fluid">
                    <div class="col-sm-8 col-sm-offset-2">                        
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="purple" id="wizardProfile">
                                <form id="nuevo_reporte">
                                    <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">
                                            Reporte 8D
                                        </h3>
                                        <h5><label id="muestreo_problema"></h4>,<label id="muestreo_causa_raiz"></h4></h5>
                                        
                                    </div>
                                    <div class="wizard-navigation">
                                        <ul>
                                            <li>
                                                <a href="#about" data-toggle="tab">Datos Generales</a>
                                            </li>
                                            <li>
                                                <a href="#problema" data-toggle="tab">Descripcion del problema</a>
                                            </li>
                                            <li>
                                                <a href="#equipo" data-toggle="tab">Equipo de Trabajo</a>
                                            </li>
                                            <li>
                                                <a href="#temporal" data-toggle="tab">Solucion Temporal</a>
                                            </li>
                                            <li>
                                                <a href="#cauza" data-toggle="tab">Deteccion de Cauza raiz</a>
                                            </li>
                                            <li>
                                                <a href="#permanente" data-toggle="tab">Solucion Permanente</a>
                                            </li>
                                            <li>
                                                <a href="#recurrencia" data-toggle="tab">Prevencion Recurrencia</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="about">
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
                                                                <?php
                                                                if ($general[0]->tipo=="auditoria"){
                                                                    ?>
                                                                    <option selected="selected" value="auditoria">Hallazgo de Auditoria</option>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <option value="auditoria">Hallazgo de Auditoria</option>
                                                                    <?php
                                                                }

                                                                if ($general[0]->tipo=="cliente"){
                                                                    ?>
                                                                    <option selected="selected" value="cliente">Reclamo de Cliente</option>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <option value="cliente">Reclamo de Cliente</option>
                                                                    <?php
                                                                }

                                                                if ($general[0]->tipo=="mejora"){
                                                                    ?>
                                                                    <option selected="selected" value="mejora">Accion de Mejora</option>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <option value="mejora">Accion de Mejora</option>
                                                                    <?php
                                                                }

                                                                if ($general[0]->tipo=="problema"){
                                                                    ?>
                                                                    <option selected="selected" value="problema">Problema</option>
                                                                    <?php
                                                                }else{
                                                                    ?>
                                                                    <option value="problema">Problema</option>
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
                                                            </h4 class="titu">Solicitante
                                                            </h4>
                                                            <select id="solicitante" name="solicitante" required="required" class="form-control">
                                                                <option value=""></option>
                                                                <?php
                                                                $seleccion="";
                                                                foreach ($personal->getResult() as $key) {
                                                                    if ($key->id==$general[0]->solicitante){
                                                                        $seleccion="selected='selected'";
                                                                    }else{
                                                                        $seleccion="";
                                                                    }
                                                                    ?>
                                                                    <option  <?php echo $seleccion?> value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
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
                                                            <select id="lider" name="lider" required="required" class="form-control">
                                                                <option value=""></option>
                                                                <?php
                                                                $seleccion="";
                                                                foreach ($personal->getResult() as $key) {
                                                                    if ($key->id==$general[0]->lider){
                                                                        $seleccion="selected='selected'";
                                                                    }else{
                                                                        $seleccion="";
                                                                    }
                                                                    ?>
                                                                    ?>
                                                                    <option <?php echo $seleccion?> value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
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
                                                            <input type="text" id="objetivo" value="<?php echo $general[0]->objetivo?>" name="objetivo" required="required" class="form-control">
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
                                                            <input type="text" value="<?php echo $general[0]->presupuesto?>" id="presupuesto_estimado" name="presupuesto_estimado" required="required" class="form-control">
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
                                                            <input type="text" value="<?php echo $general[0]->problema_detectado?>" id="problema_det" name="problema_det" class="form-control" required="required" >
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
                                                            <textarea id="problema_des" name="problema_des" class="form-control" required="required" ><?php echo $general[0]->descripcion_problema?></textarea>
                                                            
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
                                                            <input type="text" value="<?php echo $general[0]->metodos?>" class="form-control" id="metodos" name="metodos" required="required" >
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
                                                            <input type="text" value="<?php echo $general[0]->mano_de_obra?>" class="form-control" id="mano" name="mano" required="required" >
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
                                                            <input type="text" value="<?php echo $general[0]->maquinaria?>" class="form-control" id="maquinaria" name="maquinaria" required="required" >
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
                                                            <input type="text" value="<?php echo $general[0]->medio_ambiente?>" class="form-control" id="ambiente" name="ambiente" required="required" >
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
                                                            <input type="text" value="<?php echo $general[0]->causa_raiz?>" id="cauza_raiz" name="cauza_raiz" required="required" class="form-control">
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
                                    <div class="wizard-footer">
                                        <div class="pull-right">
                                            <input type='button' class='btn btn-next btn-fill btn-primary btn-wd' name='next' value='Siguiente' />
                                            <input type='button' class='btn btn-finish btn-fill btn-primary btn-wd' name='finish' value='Guardar' />
                                        </div>
                                        <div class="pull-left">
                                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Atras' />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <script type="text/javascript">
    $().ready(function() {
        demo.initMaterialWizard();
        lista_equipo();
        lista_temporales();
        lista_permanente();
        lista_preventivos(); 
    });
    function lista_preventivos(){
        var url="<?php echo base_url()?>login/solucion_preventivos2";
         $.post(url,
            {id:'<?php echo $id_8d?>'},
            function(data){
                $("#solucion_preventivos").html(data);
             });
    }
    function lista_permanente(){
        var url="<?php echo base_url()?>login/solucion_permanente2";
         $.post(url,
            {id:'<?php echo $id_8d?>'},
            function(data){
                $("#solucion_permanente").html(data);
             }); 
    }
    function lista_temporales(){
        var url="<?php echo base_url()?>login/temporales2";
         $.post(url,
            {id:"<?php echo $id_8d?>"},
            function(data){
                $("#soluciones_temporales").html(data);
             }); 
    }
    function lista_equipo(){
        var url="<?php echo base_url()?>login/lista_equipo_trabajo_2";
         $.post(url,
            {id:"<?php echo $id_8d?>"},
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
        var url = "<?php echo base_url()?>login/agrega_preventivo2"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {solucion:$("#solucion3").val(),responsable:$("#responsable3").val(),f_inicio:$("#f_inicio3").val(), f_fin:$("#f_fin3").val(), costo:$("#costo3").val(),id:'<?php echo $id_8d?>'} ,// Adjuntar los campos del formulario enviado.
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
        var url = "<?php echo base_url()?>login/agrega_permanente2"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {solucion:$("#solucion2").val(),responsable:$("#responsable2").val(),f_inicio:$("#f_inicio2").val(), f_fin:$("#f_fin2").val(), costo:$("#costo2").val(),id:'<?php echo $id_8d?>'} ,// Adjuntar los campos del formulario enviado.
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

        var url = "<?php echo base_url()?>login/agrega_temporal2"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {solucion:$("#solucion1").val(),responsable:$("#responsable1").val(),f_inicio:$("#f_inicio1").val(), f_fin:$("#f_fin1").val(), monto:$("#costo1").val(),id:"<?php echo $id_8d?>"} ,// Adjuntar los campos del formulario enviado.
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
        var url = "<?php echo base_url()?>login/agrega_equipo2"; // El script a dónde se realizará la petición.
        $.ajax({
           type: "POST",
           url: url,
           data: {equipo:$("#pre_equipo").val(),id:"<?php echo $id_8d?>"} ,// Adjuntar los campos del formulario enviado.
           success: function(data)
           {
                $("#pre_equipo").val("");   
               lista_equipo(); // Mostrar la respuestas del script PHP.
           }
         });

        return false; // Evitar ejecutar el submit del formulario.
    })

    $("input[name = 'next']").click(function(){
        var texto="<b>Descripcion del problema: </b>"+$("#problema_des").val();
       $("#muestreo_problema").html(texto);
        var valor="<b>Causa Raiz: </b>"+$("#cauza_raiz").val();
        
       $("#muestreo_causa_raiz").html(valor);
    })
    
    function elimina2(id){
        var url="<?php echo base_url()?>login/elimina_equipo";
         $.post(url,
            {equipo:id},
            function(data){
                lista_equipo();
             }); 
    }

    $("input[name = 'finish']").click(function(){
        var url="<?php echo base_url()?>login/guarda_analisis2";
        $.ajax({
           type: "POST",
           url: url,
           data: $("#nuevo_reporte").serialize()+"&id=<?php echo $id_8d?>", // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
                window.location="<?php echo base_url()?>8d";
           }
         });
        return false;
    })
</script>