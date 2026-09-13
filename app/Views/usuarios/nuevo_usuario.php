<style>
/* Base for label styling */
    [type="checkbox"]:not(:checked),
    [type="checkbox"]:checked {
        position: absolute;
        left: -9999px;
    }
    [type="checkbox"]:not(:checked) + label,
    [type="checkbox"]:checked + label {
        position: relative;
        padding-left: 25px;
        cursor: pointer;
    }

    /* checkbox aspect */
    [type="checkbox"]:not(:checked) + label:before,
    [type="checkbox"]:checked + label:before {
        content: '';
        position: absolute;
        left:0; top: 2px;
        width: 17px; height: 17px;
        border: 1px solid #aaa;
        background: #f8f8f8;
        border-radius: 3px;
        box-shadow: inset 0 1px 3px rgba(0,0,0,.3)
    }
    /* checked mark aspect */
    [type="checkbox"]:not(:checked) + label:after,
    [type="checkbox"]:checked + label:after {
        content: '✔';
        position: absolute;
        top: 0; left: 4px;
        font-size: 14px;
        color: #a23cb6;
        line-height: 1.75;
        -webkit-transition: all .2s;
        -moz-transition: all .2s;
        -ms-transition: all .2s;
        transition: all .2s;
    }
    /* checked mark aspect changes */
    [type="checkbox"]:not(:checked) + label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        -moz-transform: scale(0);
        -ms-transform: scale(0);
        transform: scale(0);
    }
    [type="checkbox"]:checked + label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        transform: scale(1);
    }
    /* disabled checkbox */
    [type="checkbox"]:disabled:not(:checked) + label:before,
    [type="checkbox"]:disabled:checked + label:before {
        box-shadow: none;
        border-color: #bbb;
        background-color: #ddd;
    }
    [type="checkbox"]:disabled:checked + label:after {
        color: #999;
    }
    [type="checkbox"]:disabled + label {
        color: #aaa;
    }
    /* accessibility */
    [type="checkbox"]:checked:focus + label:before,
    [type="checkbox"]:not(:checked):focus + label:before {
        border: 1px dotted blue;
    }
</style>
<script>
    function marcar1(numero){
        
        var nombre='E'+numero;
     
        if (document.getElementById('E'+numero).checked == true){ 
        var texto= '#dive'+numero+' input[type=checkbox]';
       
            $('#dive'+numero+' input[type=checkbox]').prop('checked',true);
        }else{

             $('#dive'+numero+' input[type=checkbox]').prop('checked',false);
        }
    }
     function marcar2(numero){
        
         
        var nombre='G'+numero;
        
        if (document.getElementById('G'+numero).checked == true){ 
        var texto= '#divg'+numero+' input[type=checkbox]';
     
            $('#divg'+numero+' input[type=checkbox]').prop('checked',true);
        }else{

             $('#divg'+numero+' input[type=checkbox]').prop('checked',false);
        }
    }
</script>
<div class="col-md-8">
    <div class="card">
        <div class="card-header" data-background-color="orange">
            <h4 class="title"><font color="#FFFFFF">Nuevo Perfil</font></h4>
        </div>
        <div class="card-content">
            <h4 class="card-title">Datos usuario</h4>
            <p class="category">
            <?php  echo form_open('login/agrega_usuario'); ?>
           
            <div class="row">
            <div class="col-md-5">
                <div class="form-group label-floating">
                    <label class="control-label">Nombre</label>
                    <input type="text" name="nombre"  class="form-control" required="required" >
                </div>
            </div>
            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Usuario</label>
                    <input type="text" name="usuario"  class="form-control" required="required" >
                </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Contraseña</label>
                    <input type="text" name="pass"  class="form-control" required="required" >
                </div>
            </div>
            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control" required="required"  name="tipo">
                                <option value=""></option>
                                <option value="admin">ADMIN</option>
                               
                                <option value="empr">EMPRESA</option>
                    </select>
                </div>
            </div>

            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Acceso a crear Minutas</label>
                    <select id="minutas" name="minutas" class="form-control" required="required"  name="tipo">
                                <option value=""></option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                    </select>
                </div>
            </div>


            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Permisos</label>
                                <?php
                                    $idempresa="";
                                    $grupo="";
                                    $entrado="no";
                                    foreach ($data->getResult() as $empresa){
                                        if ($idempresa!=($empresa->idempresa)){
                                            
                                            $entrado="si";
                                            ?>
                                            <div id="dive<?php echo $empresa->idempresa?>">
                                            <input name="permisos[]" type="checkbox" onclick="marcar1(<?php echo $empresa->idempresa?>)" id="E<?php echo $empresa->idempresa?>" value="E<?php echo $empresa->idempresa?>" /><label for="E<?php echo $empresa->idempresa?>"><?php echo $empresa->nombre?></label><br />
                                            <?php
                                        }
                                        if ($grupo!=$empresa->idgrupo){        
                                            $grupo=$empresa->idgrupo;                                
                                            ?>
                                            <div id="divg<?php echo $empresa->idgrupo?>">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="permisos[]" type="checkbox" onclick="marcar2(<?php echo $empresa->idgrupo?>)" id="G<?php echo $empresa->idgrupo?>" value="G<?php echo $empresa->idgrupo?>" /><label for="G<?php echo $empresa->idgrupo?>"><?php echo $empresa->grupo?></label><br />
                                        <?php
                                        }
                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="permisos[]" type="checkbox" id="S<?php echo $empresa->idsubgrupos?>" value="S<?php echo $empresa->idsubgrupos?>" /><label for="S<?php echo $empresa->idsubgrupos?>"><?php echo $empresa->subgrupo?></label><br />
                                    <?php
                                      if ($grupo!=$empresa->idgrupo){        
                                            $grupo=$empresa->idgrupo; 
                                            ?>
                                            </div>
                                            <?php
                                        }
                                     if ($idempresa!=($empresa->idempresa)){
                                            $idempresa=$empresa->idempresa;
                                            ?>
                                                </div>
                                            <?php
                                        }
                                    }
                                ?>
                </div>
            </div>
                </div>
            </p>
             <button type="submit" class="btn btn-primary pull-right">Guardar Perfil</button>
        </div>
        <?php echo form_close();?>
        <div class="card-footer">
        </div>
    </div>
</div>


