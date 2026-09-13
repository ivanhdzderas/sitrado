<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

.select {
     width: 200px;
     height: 200px;
   }

</style>
<script>
	function AddToSecondList(){
     var fl = document.getElementById('firstlist');
     var sl = document.getElementById('secondlist');    
     for (i = 0; i < fl.options.length; i++){
       if(fl.options[i].selected){
         sl.add(fl.options[i],null);
       }
     }
     return false;
   }
   
   function DeleteSecondListItem(){
     var fl = document.getElementById('firstlist');
     var sl = document.getElementById('secondlist');    
     for (i = 0; i < sl.options.length; i++){
       if(sl.options[i].selected){
         fl.add(sl.options[i],null);
         // O... 
         // sl.remove(sl.options[i]);
       }
     }
     return false;
   }
$("#guardar").click(function(){
 var url = "<?php echo base_url()?>login/modifica_documento"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#modifica_documento").serialize()+"&id=<?php echo $id?>", // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
           		  $('#myModal').modal('toggle');
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
</script>
<div class="card-content">
    <form id="modifica_documento">
        <div class="form-group label-floating">
            <label class="control-label">Seleccione Empresa</label>
            <select id="empresa" name="empresa" onchange="carga_menus()" class="form-control">
        <option value=""></option>
        <?php
          foreach ($empresas->getResult() as $key) {
            if($empresa==$key->id){
               ?>
              <option selected="selected" value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
            <?php
            } else{
               ?>
              <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
            <?php
            }
           
          }
        ?>
      </select>
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Seleccione Menu</label>
            <select id="menu" name="menu" onchange="carga_submenu()" class="form-control" >
             <option value=""></option>
              <?php
              foreach ($menu->getResult() as $key) {
                if ($key->id==$todo[0]->menu){
                  ?>
                  <option selected="selected" value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                <?php
                }else{
                  ?>
                  <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                <?php
                }
                
                }
              ?> 
      </select>
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Seleccione SubMenu</label>
            <select id="submenu" name="submenu" class="form-control" >
              <option value=""></option>
              <?php
              foreach ($submenus->getResult() as $key) {
                if ($key->id==$todo[0]->submenu){
                  ?>
                  <option selected="selected" value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                <?php
                }else{
                  ?>
                  <option  value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                <?php
                }
                
                }
              ?>
      </select>
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Seleccione descarga</label>
            <select name="descarga" class="form-control" required='required'>
              <option value=""></option>
              <?php
              if ($todo[0]->descarga=="SI"){
                ?>
                <option selected="selected" value="SI">SI DESCARGAR</option>
                <?php
              }else{
                ?>
                <option selected="selected" value="NO">NO DESCARGAR</option>
                <?php
              }
              ?>
              
              
            </select>
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Nombre del Archivo</label>
            <?php 
            $texto=explode (".",$todo[0]->nombre);
            ?>
            <input type="text" id="re_nombre" value="<?php echo $texto[0]?>" name="re_nombre" class="form-control">
        </div>
        <div class="form-group label-floating">
          <label class="control-label">Folio documento</label>
          <input type="text" id="folio_doc" value="<?php echo $todo[0]->folio?>"  name="folio_doc" class="form-control">
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Tipo de Documento</label>
            <select id="tipo" name="tipo" class="form-control">
              <option value=""></option>
              <?php 
              switch ($todo[0]->tipo) {
                case 'POL':
                  ?>
                  <option selected="selected" value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                
                case 'D':
                  ?>
                  <option value="POL">Politicas</option>
                  <option selected="selected" value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'P':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option  selected="selected" value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'I':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option selected="selected" value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'F':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option selected="selected" value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'M':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option selected="selected" value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'V':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option selected="selected" value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'O':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option selected="selected" value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'VAL':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option selected="selected" value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'AY':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option selected="selected" value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'MP':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option selected="selected" value="MP">Mapa de Proceso</option>
                  <option value="T">Tutoriales</option>
                  <?php
                  break;
                case 'T':
                  ?>
                  <option value="POL">Politicas</option>
                  <option value="D">Directriz</option>
                  <option value="P">Procedimientos</option>
                  <option value="I">Instructivo</option>
                  <option value="F">Formatos</option>
                  <option value="M">Mision</option>
                  <option value="V">Vision</option>
                  <option value="O">Objetivos</option>
                  <option value="VAL">Valores</option>
                  <option value="AY">Ayuda Visual</option>
                  <option value="MP">Mapa de Proceso</option>
                  <option selected="selected" value="T">Tutoriales</option>
                  <?php
                  break;

              }
              ?>
              
            </select>
        </div>
        <div class="form-group label-floating">
          <label class="control-label">Departamento</label>
          <select id="departamento" name="departamento" class="form-control">
            <option value=""></option>
            <?php
            foreach ($departamento as $key) {
              if ($key->departamento==$todo[0]->departamento){
                      ?>
              <option selected="selected" value="<?php echo $key->departamento?>"><?php echo $key->departamento?></option>
              <?php
              }else{
                ?>
              <option value="<?php echo $key->departamento?>"><?php echo $key->departamento?></option>
              <?php
              }
              
            }
            ?>
          </select>
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Ver Todos</label>
            <select name="todos" class="form-control" required='required'>
              <option value=""></option>
              <?php
              if ($key->todos=="SI"){
                ?>
                <option value="SI" selected="selected">SI</option>
                <option value="NO">NO</option>
                <?php
              }else{
                ?>
                 <option value="SI" >SI</option>
                <option value="NO" selected="selected">NO</option>
                <?php
              }
              ?>
              
            </select>
        </div>
        <div class="form-group label-floating">
            
                <label class="control-label">Responsables</label>
                <select id="firstlist" class="select"  multiple="multiple">
                  <?php 
                  foreach ($responsables as $key) {
                    ?>
                      <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                    <?php
                  }
                  ?>
                </select> 
                <input type="button" value="Añadir" 
     onclick="AddToSecondList();" />
   </div>
      <div class="form-group label-floating">
                <label class="control-label">Validaciones</label>
                <select id="secondlist" class="select" name="vali[]" multiple="multiple">
                </select>
                <input type="button" value="Quitar item de la lista" 
     onclick="DeleteSecondListItem();" />    
              </div>

              <div class="form-group label-floating">
                <label class="control-label">Revision</label>
                <input type="text" value="<?php echo $todo[0]->rev?>" id="revision" name="revision" class="form-control">
              </div>
       
        <div class="form-group label-floating" id="permisos_grupales">
            <label class="control-label">Seleccione Cual sub-grupo puede ver este archivo</label>
            <?php
            foreach ($permisos2->getResult() as $key) {
              ?>

              <div class="checkbox">
                <label>
                  <?php 
                  if ($permisos->getNumRows()==0){
                    ?>
                      <input type="checkbox" name="permisos[]" value="<?php echo $key->id?>"  ><span class="checkbox-material"><span class="check"></span></span> <?php echo $key->nomber?> / <?php echo $key->nombre?>
                  </label>
                      <?php
                  }else{
                    if ($permisos->getResult()[0]->id_subgrupo==$key->id){
                        ?>
                      <input checked="checked" type="checkbox" name="permisos[]" value="<?php echo $key->id?>"  ><span class="checkbox-material"><span class="check"></span></span> <?php echo $key->nomber?> / <?php echo $key->nombre?>
                  </label>
                      <?php
                    }else{
                      ?>
                      <input type="checkbox" name="permisos[]" value="<?php echo $key->id?>"  ><span class="checkbox-material"><span class="check"></span></span> <?php echo $key->nomber?> / <?php echo $key->nombre?>
                  </label>
                      <?php
                    }
                  }
                  
                  ?>
                  
              </div>
              
              <?php
            }
            ?>

        </div>
        <button class="btn btn-info" id="guardar">Guardar</button>
    <?=form_close()?>
</div>