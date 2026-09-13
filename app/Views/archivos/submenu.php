

				<div class="col-md-4" id="empresas">
                    <div class="card card-chart">
                           <div class="card-header card-header-icon" data-background-color="purple">
                            <i class="material-icons">&#xE2C8;</i>
                        </div>
                        <div class="card-content">
                           
                            <h4 class="card-title">Seleccione menu</h4>
                            

<p class="category">
<select id="empresa" name="empresa" class="form-control" onchange="window.location='<?php echo base_url("documentos/".$numero."/")?>'+this.value"> 
    <option value=""></option>
    <?php
    foreach ($permisos->getResult() as $permiso) {
        ?>
            <option value="<?php echo $permiso->id?>"><?php echo $permiso->nombre?></option>
        <?php
    }
    ?>
</select>
</p>

                        </div>
                        <div class="card-footer">
                            
                        </div>
                    </div>
                </div>
