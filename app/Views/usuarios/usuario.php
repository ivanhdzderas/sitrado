<div class="col-md-8">
    <div class="card">
        <div class="card-header" data-background-color="purpule">
            <h4 class="title"><font color="#FFFFFF">Editar Perfil</font></h4>
        </div>
        <div class="card-content">
            <h4 class="card-title">Datos usuario</h4>
            <p class="category">
            <?php  echo form_open('login/modifica_usuario'); ?>
            <?php
                foreach($datos->getResult() as $usuario){
            ?>

            <div class="row">
            <div class="col-md-5">
                <div class="form-group label-floating">
                    <label class="control-label">Nombre</label>
                    <input type="text" name="nombre" value="<?php echo $usuario->nombre?>" class="form-control" >
               </div>
            </div>
            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Usuario</label>
                    <input type="text" name="usuario" value="<?php echo $usuario->usuario?>" class="form-control" >
               </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Contraseña</label>
                    <input type="text" name="pass" value="<?php echo $usuario->pass?>" class="form-control" >
                </div>
            </div>
            <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control"  name="tipo">
                        <?php
                            $tipo=$usuario->tipo;
                            switch ($tipo) {
                                case 'admin':
                                   ?>
                                <option value="admin" selected="selected">ADMIN</option>
                               
                                <option value="empr">EMPRESA</option>
                                <?php
                                break;

                                
                                case 'empr':
                                ?>
                                <option value="admin" >ADMIN</option>
                               
                                <option value="empr" selected="selected">EMPRESA</option>
                                <?php
                                break;
                            }
                           

                        ?>
                       

                    </select>
                   
               </div>
            </div>

             <div class="col-md-5">
                 <div class="form-group label-floating">
                    <label class="control-label">Acceso a crear Minutas</label>
                    <select id="minutas" name="minutas" class="form-control" required="required"  name="tipo">
                                <option value=""></option>
                                <?php 
                                    if ($usuario->juntas=="SI"){
                                        ?>
                                <option value="SI" selected>SI</option>
                                <option value="NO">NO</option>
                                        <?PHP
                                    }else{
                                        ?>
                                        <option value="SI" >SI</option>
                                        <option value="NO" selected>NO</option>
                                        <?php
                                    }

                                ?>
                                
                    </select>
                </div>
            </div>


<input type="text"  style="visibility: hidden;"  id="id" name="id" value="<?php echo $usuario->id?>">
                <?php
                }
                ?>
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


