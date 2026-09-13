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
<div class="archiva-form">
    <?=form_open_multipart('do_upload');?>
        <div class="mb-3">
            <label class="form-label">Seleccione Empresa</label>
            <select id="empresa" name="empresa" onchange="carga_menus()" class="form-control">
				<option value=""></option>
				<?php
					foreach ($empresas->getResult() as $key) {
						?>
							<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
						<?php
					}
				?>
			</select>
        </div>
        <div class="mb-3">
            <label class="form-label">Seleccione Menu</label>
            <select id="menu" name="menu" onchange="carga_submenu()" class="form-control" disabled="">
			</select>
        </div>
        <div class="mb-3">
            <label class="form-label">Seleccione SubMenu</label>
            <select id="submenu" name="submenu" class="form-control" disabled="">
			</select>
        </div>
        <div class="mb-3">
            <label class="form-label">Seleccione descarga</label>
            <select name="descarga" class="form-control" required='required'>
				      <option value=""></option>
			        <option value="SI">SI DESCARGAR</option>
				      <option value="NO">NO DESCARGAR</option>
		        </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre del Archivo</label>
            <input type="text" id="re_nombre" name="re_nombre" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Folio documento</label>
          <input type="text" id="folio_doc" name="folio_doc" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo de Documento</label>
            <select id="tipo" name="tipo" class="form-control">
              <option value=""></option>
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
              <option value="T">Tutoriales</option>
              <option value="OR">Organigramas</option>
              <option value="IP">Interrelacion de Procesos</option>
            </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Departamento</label>
          <select id="departamento" name="departamento" class="form-control">
            <option value=""></option>
            <?php
            foreach ($departamento as $key) {
              ?>
              <option value="<?php echo $key->departamento?>"><?php echo $key->departamento?></option>
              <?php
            }
            ?>
          </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ver Todos</label>
            <select name="todos" class="form-control" required='required'>
              <option value=""></option>
              <option value="SI">SI</option>
              <option value="NO">NO</option>
            </select>
        </div>
        <div class="mb-3">
            
                <label class="form-label">Responsables</label>
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
      <div class="mb-3">
                <label class="form-label">Validaciones</label>
                <select id="secondlist" class="select" name="vali[]" multiple="multiple">
                </select>
                <input type="button" value="Quitar item de la lista" 
     onclick="DeleteSecondListItem();" />    
              </div>


        <div class="mb-3">
            <label class="form-label">Suba un archivo zip, rar, pdf, docx o txt</label><br />
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-outline-secondary">
                        Buscar&hellip; <input type="file" name="userfile" size="20" style="display: none;" required='required' />
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
        </div>

         <div class="mb-3">
                <label class="form-label">Revision</label>
                <input type="text" id="revision" name="revision" class="form-control">
              </div>


        <div class="form-group label-floating" id="permisos_grupales">
            
        </div>
        <button type="submit" class="btn btn-archiva">Subir archivo</button>
    <?=form_close()?>
</div>

<script>
$(function() {

  // We can attach the `fileselect` event to all file inputs on the page
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});



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
</script>