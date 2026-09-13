

				<div class="col-md-4" id="empresas">
                    <div class="card card-chart">
                           <div class="card-header card-header-icon" data-background-color="green">
                            <i class="material-icons">&#xE2C8;</i>
                        </div>
                        <div class="card-content">
                           
                            <h4 class="card-title">Seleccione empresa</h4>
                            

<p class="category">
<select id="empresa" name="empresa" class="form-control" onchange="window.location='<?php echo base_url("documentos/")?>'+this.value">
    <option value=""></option>
    <?php
    foreach ($empresas->getResult() as $empresa) {
        ?>
            <option value="<?php echo $empresa->id?>"><?php echo $empresa->nombre?></option>
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
