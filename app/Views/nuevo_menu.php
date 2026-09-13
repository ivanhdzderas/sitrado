<div class="col-md-12">
    <div class="card card-chart">
        <div class="card-header card-header-icon" data-background-color="purple">
            <i class="material-icons">apps</i>
        </div>
        <div class="card-content">
            <h4 class="card-title">Menu</h4>
            <p class="category">
            <button onclick="window.location='#popup4'">Agregar</button>


<div class="modal-wrapper form-group label-floating" id="popup4">
    <div class="popup3-contenedor">
    <?php  echo form_open('login/agrega_menu');  
    $agrega=array('name'=>'Nombre_menu','placeholder'=>'Nombre menu', 'class'=>'form-control', 'required'=>'required');

    ?>
     <h2>Agrega Menu</h2><br />
     <?php echo form_input($agrega)  ?><br/>
     selecciona SubGrupo
     <select name="grupo" id='grupo' class="form-control" required='required'>
        <option value=""></option>
        <?php
        foreach ($grupos->getResult() as $grupo) {
            ?>
            <option value="<?php echo $grupo->id?>"><?php echo $grupo->nomber?></option>
            <?php
        }
        ?>
     </select>
     <input type="text" style="visibility: hidden;" id="empresa" name="empresa" value="<?php echo $numero?>">
     <?php echo form_submit('guarda_empresa','Guardar')?>
    <?php echo form_close()?>
      
       
       <a class="popup3-cerrar" href="#">X</a>
    </div>
</div>

            </p>



 <div class="row">
                                        <div class="col-md-5">
                                            <div class="table-responsive table-sales">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                           
                                                            
                                                            <td class="text-right">
                                                                Menu
                                                            </td>
                                                           
                                                            <td class="text-right">
                                                                SubMenu
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                            <?php
                                                            foreach ($menus->getResult() as $empresa){
                                                                ?>
                                                        <tr>
                                                            
                                                            
                                                            <td class="text-right">
                                                                <?php echo $empresa->grupo?>

                                                            </td>
                                                           
                                                            <td class="text-right">
                                                                <?php echo $empresa->menu?>
                                                            </td>
                                                            <td>
                                                                <a href="../elimina_menu/<?php echo $empresa->idmenu?>/<?php echo $numero?>"><i class="material-icons">&#xE92B;</i> </a>
                                                            </td>
                                                        </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        
                                                      
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

        </div>
        <div class="card-footer">
        </div>
    </div>
</div>

