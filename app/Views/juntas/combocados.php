<script>
    function borra_participante(participante, junta){
        var url="<?php echo base_url()?>borra_participante";
         $.ajax({
           type: "POST",
           url: url,
           data: {usuario:participante,junta:junta }, // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               carga_participantes();
           }
         });
    }
    function cambiar_asistencia(participante, junta){
      var url="<?php echo base_url()?>login/asistencia_asistente";
      var check="";
      if ($("#check_"+participante).is(':checked')){
        check="SI";
      }else{
        check="NO";
      }
       $.post(url,
            {junta:junta,id:participante, valor:check},
            function(data){
                
             }); 
    }
</script>
<div class="col-md-12">
    <div class="card">
        <h4 class="card-title">Convocados</h4>
        <div class="card-content">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($participantes as $key ) {
                           ?>
                            <tr>
                                <td><?php echo $key->nombre?></td>
                                <td class="td-actions text-right">

                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="borra_participante('<?php echo $key->id?>','<?php echo $junta?>')">Eliminar</button>
                                    <?php
                                    if ($key->asistencia=="SI"){
                                      ?>
                                       <input type="checkbox" onclick="cambiar_asistencia('<?php echo $key->id?>','<?php echo $junta?>')" id="check_<?php echo $key->id?>" checked="checked" value="SI"> Asistio<br>
                                      <?php
                                    }else{
                                      ?>
                                         <input type="checkbox"  onclick="cambiar_asistencia('<?php echo $key->id?>','<?php echo $junta?>')" id="check_<?php echo $key->id?>" value="SI"> Asistio<br>
                                      <?php
                                    }
                                    ?>
                                   
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
</div>