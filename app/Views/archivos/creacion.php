<div class="form-group">
    <label class="control-label">Tipo de Documento</label>
    <select id="tipo_doc" name="tip_doc" class="form-control">
    	<option value=""></option>
    	<?php
      if (session()->get('logged_in')['tipo']=="admin"){
        ?>
          <option value="m">Mision</option>
          <option value="v">Vision</option>
          <option value="o">Objetivos</option>
          <option value="v">Valores</option>
          <option value="po">Politicas</option>
          <option value="d">Directrices</option>
          <option value="p">Procedimientos</option>
          <option value="f">Formatos</option>
          <option value="i">Instructivos</option>
          <option value="av">Ayudas Visuales</option>
          <option value="mp">Mapa de Procesos</option>
          <option value="ip">Interrelacion de Procesos</option>
          <option value="t">Tutoriales</option>
          <option value="vi">Videos</option>
          <option value="or">Organigramas</option>
        <?php
      }else{}
    	switch(session()->get('logged_in')['nivel']){
    		case "CEO":
    			?>
  	    		<option value="m">Mision</option>
            <option value="v">Vision</option>
            <option value="o">Objetivos</option>
            <option value="v">Valores</option>
            <option value="po">Politicas</option>
            <option value="d">Directrices</option>
            <option value="p">Procedimientos</option>
            <option value="f">Formatos</option>
            <option value="i">Instructivos</option>
            <option value="av">Ayudas Visuales</option>
            <option value="mp">Mapa de Procesos</option>
            <option value="ip">Interrelacion de Procesos</option>
            <option value="t">Tutoriales</option>
            <option value="vi">Videos</option>
            <option value="or">Organigramas</option>
	    		<?php
    		break;
        case "Director Sr.":
          ?>
            <option value="m">Mision</option>
            <option value="v">Vision</option>
            <option value="o">Objetivos</option>
            <option value="v">Valores</option>
            <option value="d">Directrices</option>
            <option value="p">Procedimientos</option>
            <option value="f">Formatos</option>
            <option value="i">Instructivos</option>
            <option value="av">Ayudas Visuales</option>
            <option value="mp">Mapa de Procesos</option>
            <option value="t">Tutoriales</option>
            <option value="vi">Videos</option>

          <?php
        break;
    		case "Gerente Sr.":
    			?>
  	    		<option value="m">Mision</option>
            <option value="v">Vision</option>
            <option value="o">Objetivos</option>
            <option value="v">Valores</option>
            <option value="p">Procedimientos</option>
            <option value="f">Formatos</option>
            <option value="i">Instructivos</option>
            <option value="av">Ayudas Visuales</option>
            <option value="t">Tutoriales</option>
            <option value="vi">Videos</option>
	    		<?php
    		break;
        case "Director":
          ?>
          <option value="m">Mision</option>
          <option value="v">Vision</option>
          <option value="o">Objetivos</option>
          <option value="v">Valores</option>
          <option value="p">Procedimientos</option>
          <option value="f">Formatos</option>
          <option value="i">Instructivos</option>
          <option value="av">Ayudas Visuales</option>
          <option value="mp">Mapa de Procesos</option>
          <option value="t">Tutoriales</option>
          <option value="vi">Videos</option>
          <?php
        break;
        case "Gerente":
          ?>
          <option value="m">Mision</option>
          <option value="v">Vision</option>
          <option value="o">Objetivos</option>
          <option value="v">Valores</option>
          <option value="p">Procedimientos</option>
          <option value="f">Formatos</option>
          <option value="i">Instructivos</option>
          <option value="av">Ayudas Visuales</option>
          <option value="mp">Mapa de Procesos</option>
          <option value="t">Tutoriales</option>
          <option value="vi">Videos</option>
          <?php
        break;
        case "Staff":
          ?>
          <option value="m">Mision</option>
          <option value="v">Vision</option>
          <option value="o">Objetivos</option>
          <option value="v">Valores</option>
          <option value="d">Directrices</option>
          <option value="p">Procedimientos</option>
          <option value="f">Formatos</option>
          <option value="i">Instructivos</option>
          <option value="av">Ayudas Visuales</option>
          <option value="mp">Mapa de Procesos</option>
          <option value="ip">Interrelacion de Procesos</option>
          <option value="t">Tutoriales</option>
          <option value="vi">Videos</option>
          <?php
        break;
    		case "Jefe":
          ?>
          <option value="m">Mision</option>
          <option value="v">Vision</option>
          <option value="o">Objetivos</option>
          <option value="v">Valores</option>
          <option value="f">Formatos</option>
          <option value="i">Instructivos</option>
          <option value="av">Ayudas Visuales</option>
          <option value="t">Tutoriales</option>
          <option value="vi">Videos</option>
          <?php
        break;
    	}
    	
    	?>
    </select>
    
</div>
<div class="form-group">
    <label class="control-label">Nombre del documento</label>
    <input type="text" class="form-control" id="nombre" name="nombre">
</div>
<div class="form-group">
    <label class="control-label">Descripcion</label>
    <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
</div>
<button type="submit" id="btn_enviar" class="btn btn-fill btn-rose">Enviar</button>
<script>
	$("#btn_enviar").click(function(){
 	var url = "<?php echo base_url()?>login/guardar_solicitud_documento/creacion"; // El script a dónde se realizará la petición.
 	//alert($("#formulario").serialize());
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               swal(
				  'Solicitud enviada con exito'
				)
               setTimeout("location.reload();", 2000);
               //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
</script>