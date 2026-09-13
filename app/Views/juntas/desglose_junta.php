<style>
.archiva-modal .modal-content {
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 18px 50px rgba(15, 35, 55, 0.22);
    overflow: hidden;
}
.archiva-modal .modal-header {
    background: linear-gradient(135deg, #0b5cab 0%, #1473c7 55%, #1f8a8a 100%);
    color: #fff;
    border-bottom: 0;
    padding: 1rem 1.25rem;
}
.archiva-modal .modal-title {
    font-family: var(--archiva-display, Georgia, serif);
    font-size: 1.15rem;
    font-weight: 700;
}
.archiva-modal .btn-close {
    filter: invert(1) grayscale(1) brightness(2);
}
.archiva-modal .modal-body {
    background: #f7f9fc;
    padding: 1.25rem;
}
.archiva-modal .modal-footer {
    background: #fff;
    border-top: 1px solid #e5ebf2;
}
.archiva-modal .modal-dialog {
    max-width: 720px;
}
</style>

 <script>
 function showDesgloseModal(modalId) {
     var el = document.getElementById(modalId);
     if (!el || !window.bootstrap || !bootstrap.Modal) {
         console.error('Bootstrap Modal no disponible');
         return;
     }
     if (el.parentElement !== document.body) {
         document.body.appendChild(el);
     }
     bootstrap.Modal.getOrCreateInstance(el).show();
 }

 function visor_archivo(tema){
     showDesgloseModal('modal_visor_archivo');
     var url="<?php echo base_url()?>visor";
   
      $.post(url,
            {id_tema:tema},
            function(data){
                $("#visor_adjunto").html(data);
             }); 
       
 }


function agrega_nota(tema){
  $('#ModalVisor').fadeOut();
  swal({
      title: 'Agregar Notas',
      type: 'info',
      html: '<div class="form-group">' +
                '<input id="notas" type="text" class="form-control" />' +
            '</div>',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false
  }).then(function(result) {
      var url="<?php echo base_url()?>login/guardar_notas";
      $.post(url,
              {nota:$('#notas').val(), tema:tema},
              function(data){
                  $('#ModalVisor').fadeIn();
               }); 
  }, function (dismiss) {
      if (dismiss === 'cancel') {
          $('#ModalVisor').fadeIn();
      }
  })
}
function modificar(tema, junta){
   showDesgloseModal('ModalVisor');
   url="<?php echo base_url()?>modificar_actividad";
              $.post(url,{tema:tema,junta:junta},
                     function (data){
                            $("#visorjunta").html(data);     
                })
}
function limpiar(tema){
url="<?php echo base_url()?>limpiar_archivo";
             $.post(url,{tema:tema},
        function (data){
                
                location.reload(); 
        })
}
function eliminar(tema){
 url="<?php echo base_url()?>elmina_actividad";
            $.post(url,{tema:tema},
                function (data){
            location.reload(); 
             
        })
}
function terminar(tema){
  url="<?php echo base_url()?>terminar_tema";
             $.post(url,{tema:tema},
        function (data){
                
                location.reload(); 
        })


}
function ver_notas2(tema){
    var url="<?php echo base_url()?>login/lista_notas";
            $.post(url,
                {tema:tema},
                function(data){
                    swal({
                      title: 'Notas',
                      type: 'info',
                      html:data,
                      showCloseButton: true,
                      showCancelButton: false,
                    })
                }); 
}
function notas(tema){
  showDesgloseModal('ModalVisor');
  $("#modal_title2").html("Notas");
  var url="<?php echo base_url()?>login/lista_notas";
            $.post(url,
                {tema:tema},
                function(data){
                    $("#visorjunta").html(data);    
                }); 
}
function agrega_participantes(junta){
      var url="<?php echo base_url()?>agrega_participante";
    $("#modal_title").html("Agregar Participantes");
    showDesgloseModal('Especial_modal');
    
     $.post(url,
            {junta:junta},
            function(data){
                $("#Especial_body").html(data);
             }); 
}

function pdf(id){
  var url="<?php echo base_url()?>login/pdf_junta/"+id;
  window.open(url);
}
function atras(){
  window.location.href="<?php echo base_url()?>juntas";
}
function redir(junta){
    var url="<?php echo base_url()?>asigna_temas";
    $("#modal_title").html("Asignar Actividades a Participantes");
    showDesgloseModal('Especial_modal');
    $.post(url,
        {junta:junta},
            function(data){
                $("#Especial_body").html(data);
             });
    
}
 </script>



<?php
$creador="";
$activo="";
$impro="";
foreach ($junta->getResult() as $key) {
    $creador=$key->creador;
    $activo=$key->activo;
    $impro=$key->impartidor;
}
?>
<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div class="d-flex flex-wrap gap-2">
           <?php
    if ($creador==session()->get('logged_in')['iduser']){
        if ($activo=="SI"){
        ?>
            <button type="button" class="btn btn-archiva btn-sm" onclick="redir('<?= esc($id_junta, 'js') ?>')">Asignar actividades</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="agrega_participantes('<?= esc($id_junta, 'js') ?>')">Agregar participantes</button>
        <?php
        }
    }
        ?>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="pdf('<?= esc($id_junta, 'js') ?>')">Generar PDF</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="atras(); return false;">Regresar a minutas</button>
        </div>

        <div class="flex-grow-1" style="min-width: 280px; max-width: 520px;">
            <div class="border rounded p-3 bg-white">
                <h4 class="panel-title text-center mb-3">Informacion de Minuta</h4>
                <div class="row">
                    <div class="col-md-6">
                    <?php
                    foreach ($junta->getResult() as $key) {
                        echo "<b>Tema:  ".esc($key->tema)."</b><br/>";
                        echo "<b>lugar:  ".esc($key->lugar)."</b><br />";
                        echo "<b>Fecha y Hora:  ".esc($key->fecha)."</b><br/>";
                        echo "<b>Duracion ".esc($key->duracion);
                        if ($key->duracion=="1"){
                            echo " Hora</b><br />";
                        }else{
                            echo " Horas</b><br />";
                        }
                    }
                    foreach ($impartidor->getResult() as $key) {
                        echo "<b>Moderador:  ".esc($key->nombre)."</b>";
                    }
                    ?>
                    </div>
                    <div class="col-md-6">
                        <b>Participantes<br /></b>
                        <ul class="mb-0">
                        <?php
                            $parti=login_model()->participantes_junta($id_junta);
                            foreach ($parti as $key) {
                            ?>
                                <li><?= esc($key->nombre) ?></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tema</th>
                    <th>Fecha Compromiso</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($det_junta->getResult() as $key) {
                ?>
                    <tr>
                        <td><?= esc($key->nombre) ?></td>
                        <td>
                            <?php 
                            $query=login_model()->buscar_archivo($key->id_tema);
                            $cuantos=$query->getNumRows();
                            if ($cuantos>0){
                            ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="visor_archivo('<?= esc($key->id_tema, 'js') ?>')">Archivo</button>
                            <?php
                            }
                            ?>
                            <?= esc($key->tema) ?>
                        </td>
                        <td><?= esc($key->fecha_compromiso) ?></td>
                        <td class="text-nowrap">
                        <?php 
                            if ($activo=="SI"){
                                if ($key->terminado=="NO"){
                                    if ($creador==session()->get('logged_in')['iduser'] or $impro==session()->get('logged_in')['iduser'] ){

                                        ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1" title="Terminar Actividad" onclick="terminar('<?= esc($key->id_tema, 'js') ?>')">Terminar</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger me-1" title="Eliminar Actividad" onclick="eliminar('<?= esc($key->id_tema, 'js') ?>')">Eliminar</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-1" title="Limpiar Actividad" onclick="limpiar('<?= esc($key->id_tema, 'js') ?>')">Limpiar</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary me-1" title="Notas" onclick="notas('<?= esc($key->id_tema, 'js') ?>')">Notas</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Modificar" onclick="modificar('<?= esc($key->id_tema, 'js') ?>','<?= esc($id_junta, 'js') ?>')">Modificar</button>
                                        <?php
                                        }else{
                                            echo "Abierto";
                                        }
                                    }else{
                                        echo "TERMINADOS";
                                        ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary ms-1" onclick="ver_notas2('<?= esc($key->id_tema, 'js') ?>')">Ver Notas</button>
                                        <?php
                                    }
                                }else{
                                    echo "Inactiva";
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

<!-- modal_visor_archivo -->
<div class="modal fade archiva-modal" id="modal_visor_archivo" tabindex="-1" aria-labelledby="modal_visor_archivo_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_visor_archivo_title">Visor de Archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="visor_adjunto">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!--  modal_visor_archivo -->


<div class="modal fade archiva-modal" id="Especial_modal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Detalle de la junta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="Especial_body" name="Especial_body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- Classic ModalVisor -->
<div class="modal fade archiva-modal" id="ModalVisor" tabindex="-1" aria-labelledby="modal_title2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title2">Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="visorjunta" name="visorjunta">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
