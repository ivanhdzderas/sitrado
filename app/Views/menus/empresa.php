	<div class="col-md-4" id="empresas">
                    <div class="card card-chart">
                           <div class="card-header card-header-icon" data-background-color="green">
                            <i class="material-icons">&#xE5D2;</i>
                        </div>
                        <div class="card-content">
                           
                            <h4 class="card-title">Seleccione empresa</h4>
                            

<p class="category">
<table><tr><td>


<select id="empresa" style=" width: 150px;" class="form-control" onchange="window.location='<?php echo base_url("menus/")?>'+this.value">
<option value=""></option>
<?php

foreach ($data->getResult() as $empresa){
	?>
	<option value="<?php echo $empresa->id?>"><?php echo $empresa->nombre?></option>
	<?php
};
?>
</select>
</td><td>

</td></tr></table>

</p>

                        </div>
                        <div class="card-footer">
                            
                        </div>
                    </div>
                </div>
<?php

$mensaje=session()->get('mensaje_menu');
$tipo=session()->get('tipo');

switch($tipo){
  case 'ok':
    ?>
    <script>
    alertify.success("<?php echo $mensaje?>"); 
    </script>

    <?php
     session()->unset_userdata('mensaje_menu');
      session()->unset_userdata('tipo');
  break;
  case 'error':
   ?>
    <script>
    alertify.error("<?php echo $mensaje?>"); 
    </script>

    <?php
     session()->unset_userdata('mensaje_menu');
      session()->unset_userdata('tipo');
  break;

};


?>
