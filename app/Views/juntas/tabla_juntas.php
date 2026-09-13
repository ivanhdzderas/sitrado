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

<script src="<?php echo base_url()?>assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script>
function reactivar(junta){
   swal({
                    title: '¿Deseas reactivar la minuta?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No',
                    confirmButtonClass: "btn btn-success",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then(function() {
                  var url="<?php echo base_url()?>login/reactivar_minuta";
                   $.post(url,
                    {junta:junta},
                    function(data){
                        window.location.href = "<?php echo base_url()?>juntas";
                     }); 
                })

}
function ezBSAlert (options) {
    var deferredObject = $.Deferred();
    var defaults = {
        type: "alert", //alert, prompt,confirm 
        modalSize: 'modal-sm', //modal-sm, modal-lg
        okButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        yesButtonText: 'Si',
        noButtonText: 'No',
        headerText: 'Atencion',
        messageText: 'Message',
        alertType: 'default', //default, primary, success, info, warning, danger
        inputFieldType: 'text', //could ask for number,email,etc
    }
    $.extend(defaults, options);
  
    var _show = function(){
        var headClass = "navbar-default";
        switch (defaults.alertType) {
            case "primary":
                headClass = "alert-primary";
                break;
            case "success":
                headClass = "alert-success";
                break;
            case "info":
                headClass = "alert-primary";
                break;
            case "warning":
                headClass = "alert-warning";
                break;
            case "danger":
                headClass = "alert-danger";
                break;
        }
        $('BODY').append(
            '<div id="ezAlerts" class="modal fade archiva-modal">' +
            '<div class="modal-dialog ' + defaults.modalSize + '">' +
            '<div class="modal-content">' +
            '<div id="ezAlerts-header" class="modal-header ' + headClass + '">' +
            '<h5 id="ezAlerts-title" class="modal-title">Modal title</h5>' +
            '<button id="close-button" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>' +
            '</div>' +
            '<div id="ezAlerts-body" class="modal-body">' +
            '<div id="ezAlerts-message" ></div>' +
            '</div>' +
            '<div id="ezAlerts-footer" class="modal-footer">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );

        $('#ezAlerts-title').text(defaults.headerText);
        $('#ezAlerts-message').html(defaults.messageText);

        var keyb = false, backd = 'static';
        var calbackParam = "";
        switch (defaults.type) {
            case 'alert':
                keyb = true;
                backd = true;
                $('#ezAlerts-footer').html('<button class="btn btn-' + defaults.alertType + '">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
                    calbackParam = true;
                    var inst = bootstrap.Modal.getInstance(document.getElementById('ezAlerts'));
                    if (inst) inst.hide();
                });
                break;
            case 'confirm':
                var btnhtml = '<button id="ezok-btn" class="btn btn-primary">' + defaults.yesButtonText + '</button>';
                if (defaults.noButtonText && defaults.noButtonText.length > 0) {
                    btnhtml += '<button id="ezclose-btn" class="btn btn-secondary">' + defaults.noButtonText + '</button>';
                }
                $('#ezAlerts-footer').html(btnhtml).on('click', 'button', function (e) {
                        if (e.target.id === 'ezok-btn') {
                            calbackParam = true;
                            var inst = bootstrap.Modal.getInstance(document.getElementById('ezAlerts'));
                            if (inst) inst.hide();
                        } else if (e.target.id === 'ezclose-btn') {
                            calbackParam = false;
                            var inst2 = bootstrap.Modal.getInstance(document.getElementById('ezAlerts'));
                            if (inst2) inst2.hide();
                        }
                    });
                break;
            case 'prompt':
                $('#ezAlerts-message').html(defaults.messageText + '<br /><br /><div class="form-group"><input type="' + defaults.inputFieldType + '" class="form-control" id="prompt" /></div>');
                $('#ezAlerts-footer').html('<button class="btn btn-primary">' + defaults.okButtonText + '</button>').on('click', ".btn", function () {
                    calbackParam = $('#prompt').val();
                    var inst = bootstrap.Modal.getInstance(document.getElementById('ezAlerts'));
                    if (inst) inst.hide();
                });
                break;
        }

        var el = document.getElementById('ezAlerts');
        if (el.parentElement !== document.body) {
            document.body.appendChild(el);
        }
        $(el).on('hidden.bs.modal', function () {
            $(el).remove();
            deferredObject.resolve(calbackParam);
        }).on('shown.bs.modal', function () {
            if ($('#prompt').length > 0) {
                $('#prompt').focus();
            }
        });
        bootstrap.Modal.getOrCreateInstance(el, {
            backdrop: backd,
            keyboard: keyb
        }).show();
    }
    
  _show();  
  return deferredObject.promise();    
}





$(document).ready(function(){
  $("#btnAlert").on("click", function(){    
    var prom = ezBSAlert({
      messageText: "hello world",
      alertType: "danger"
    }).done(function (e) {
      $("body").append('<div>Callback from alert</div>');
    });
  });   
  
  $("#btnConfirm").on("click", function(){      
    ezBSAlert({
      type: "confirm",
      messageText: "hello world",
      alertType: "info"
    }).done(function (e) {
      $("body").append('<div>Callback from confirm ' + e + '</div>');
    });
  });   

  $("#btnPrompt").on("click", function(){   
    ezBSAlert({
      type: "prompt",
      messageText: "Enter Something",
      alertType: "primary"
    }).done(function (e) {
      ezBSAlert({
        messageText: "You entered: " + e,
        alertType: "success"
      });
    });
  });   
  
});
function terminar_junta(junta){
ezBSAlert({
      type: "confirm",
      messageText: "¿Desea cerrar la minuta?<br /> todas las actividades de esta minuta seran terminadas",
      alertType: "info"
    }).done(function (e) {
      if(e==true){
        var url="<?php echo base_url()?>terminar_minuta";
         $.post(url,
            {junta:junta},
            function(data){
                window.location.href = "<?php echo base_url()?>juntas";
             }); 
      }
    });

}
function eliminar(junta){
ezBSAlert({
      type: "confirm",
      messageText: "¿Desea eliminar la minuta ?<br /> todas las actividades de esta minuta seran eliminadas",
      alertType: "info"
    }).done(function (e) {
      if(e==true){
        var url="<?php echo base_url()?>eliminar_minuta";
         $.post(url,
            {junta:junta},
            function(data){
                window.location.href = "<?php echo base_url()?>juntas";
             }); 
      }
    });

}
function visor(junta){
    var id_junta=junta;  
    var url="<?php echo base_url()?>login/detallado_temas/"+junta;
    window.location.href=url;
     /* $.post(url,
            {junta:id_junta},
            function(data){
                $("#visorjunta").html(data);
             }); */
       
};
function mostrar_temas(){
        var junta=$("#nombre_junta").val();
        var url="<?php echo base_url()?>asigna_temas";

        
        $.post(url,
            {junta:junta},
            function(data){
                $("#desglose_temas").html(data);
             }); 
       
        };
function redir(junta){
    var url="<?php echo base_url()?>asigna_temas";

    $.post(url,
        {junta:junta},
            function(data){
                $("#Especial_body").html(data);
             });
    
}
function showJuntasModal(modalId, titleId, title) {
    var el = document.getElementById(modalId);
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    if (titleId && title) {
        $('#' + titleId).text(title);
    }
    bootstrap.Modal.getOrCreateInstance(el).show();
}
function nueva_minuta(){
    showJuntasModal('myModal', 'modal_title', 'Nueva minuta');
    var url="<?php echo base_url()?>nueva_minuta";
      $.post(url,
            function(data){
                $("#modal_body").html(data);
             });
}
function agrega_participantes(){
    showJuntasModal('myModal', 'modal_title', 'Participantes');
    var url="<?php echo base_url()?>antes_participante";
    $.post(url,
            function(data){
                $("#modal_body").html(data);
             });
}
function minutas_no_activas(){
    var url="<?php echo base_url()?>juntas/NO";
    window.location=url;
}
function pdf(id){
  var url="<?php echo base_url()?>login/pdf_junta/"+id;
  window.open(url);
}
function reporte_rapido() {
    showJuntasModal('modalReporteMinutas', 'modalReporteMinutasTitle', 'Reporte de minutas');
    $('#modal_reporte_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    $.post("<?= site_url('login/reporte_rapido') ?>", function (data) {
        $('#modal_reporte_body').html(data);
    });
}
function envio_email(id){
  var url="<?php echo base_url()?>login/correo_minutas";
    $.post(url,
            {junta:id},
            function(data){
                swal("Correos enviados");
             });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Minutas</h2>
        <div class="d-flex flex-wrap gap-2">
                <?php
                 $juntas=session()->get('logged_in')['juntas'];
                 $tipo=session()->get('logged_in')['tipo'];
                 if ($juntas=="SI" OR $tipo=="admin"){
                ?>
                <button type="button" class="btn btn-archiva btn-sm" onclick="nueva_minuta()">Nueva minuta</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="minutas_no_activas()">Minutas inactivas</button>
                <?php 
              }
                   $tipo=session()->get('logged_in')['tipo'];
               
                $reportes=session()->get('logged_in')['reportes'];

                if ($tipo=="admin"){

                
                ?>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="reporte_rapido()">Reporte minutas</button>
                <?php
                }
                if ($tipo="empr" and $reportes=="SI"){
                  ?>
                  <button type="button" class="btn btn-outline-secondary btn-sm" onclick="reporte_rapido()">Reporte minutas</button>
                  <?PHP
                }

                ?>
        </div>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-center">Fecha y hora</th>
                    <th class="text-center">Tema</th>
                    <th class="text-center">lugar</th>
                    <th class="text-center">Duracion</th>
                    <th class="text-center">Moderador</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th class="text-center">Fecha y hora</th>
                    <th class="text-center">Tema</th>
                    <th class="text-center">lugar</th>
                    <th class="text-center">Duracion</th>
                    <th class="text-center">Moderador</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                                foreach ($junta->getResult() as $juntas) {
                                    ?>
                                
                                    <tr>
                                        <td class="text-center"><?= esc($juntas->id_junta) ?></td>
                                        <td><?= esc($juntas->fecha) ?></td>
                                        <td><a style="cursor:pointer;" onclick="visor('<?= esc($juntas->id_junta, 'js') ?>')"><?= esc($juntas->tema) ?></a></td>
                                        <td><?= esc($juntas->lugar) ?></td>
                                        <td class="text-end">
                                            <?php
                                            if ($juntas->duracion=="1"){
                                                echo esc($juntas->duracion)." Hora";
                                            }else{
                                                 echo esc($juntas->duracion)." Horas";
                                            }
                                            ?>
                                        </td>
                                        <td class="text-end"><?php
                                            $escalar=login_model()->extre_impartidor($juntas->impartidor);
                                            if ($escalar->getNumRows()==0){
                                                
                                            }else{
                                            foreach ($escalar->getResult() as $key ) {
                                                echo esc($key->nombre);
                                            }
                                        }
                                         ?>
                                             
                                         </td>
                                         <td class="text-center text-nowrap">
                                         <?php
                                         if ($juntas->activo=="SI"){
                                         if ($juntas->asignada=="NO"){
                                            if (($juntas->creador==session()->get('logged_in')['iduser']) or ($juntas->impartidor==session()->get('logged_in')['iduser'])){
                                                ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="terminar_junta('<?= esc($juntas->id_junta, 'js') ?>')">Abierta</button>
                                                <?php
                                            }else{
                                                ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger">Abierta</button>
                                                <?php
                                            }
                                           
                                         }else{
                                            ?>
                                                 <button type="button" class="btn btn-sm btn-outline-secondary">Terminada</button>
                                            <?php
                                         }
                                     }else{
                                        ?>
                                            <button type="button" class="btn btn-sm btn-outline-warning">Inactivo</button>
                                        <?php
                                     }
                                         ?>
                                           
                                         </td>
                                        <td class="text-end text-nowrap">
                                            <?php
                                              if (($juntas->creador==session()->get('logged_in')['iduser']) or ($juntas->impartidor==session()->get('logged_in')['iduser'])){
                                                if ($juntas->activo=="SI"){
                                            ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="eliminar('<?= esc($juntas->id_junta, 'js') ?>')">Eliminar</button>
                                            <?php
                                            }else{
                                              ?>
                                               <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="reactivar('<?= esc($juntas->id_junta, 'js') ?>')">Reactivar</button>
                                              <?php
                                            }
                                          }
                                            ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="pdf('<?= esc($juntas->id_junta, 'js') ?>')">PDF</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="envio_email('<?= esc($juntas->id_junta, 'js') ?>')">Email</button>
                                        </td>
                                    </tr>
                                
                                    <?php
                                };
                                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- inicio modal -->
<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Minuta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- fin modal -->

<div class="modal fade archiva-modal" id="modalReporteMinutas" tabindex="-1" aria-labelledby="modalReporteMinutasTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReporteMinutasTitle">Reporte de minutas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_reporte_body">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
        </div>
    </div>
</div>

<!-- Classic ModalVisor -->
<div class="modal fade archiva-modal" id="ModalVisor" tabindex="-1" aria-labelledby="ModalVisorLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalVisorLabel">Detalle de la junta</h5>
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
<!--  End  ModalVisor -->

<div class="modal fade archiva-modal" id="Especial_modal" tabindex="-1" aria-labelledby="Especial_modal_title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Especial_modal_title">Detalle de la junta</h5>
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

<script type="text/javascript">
$(document).ready(function () {
    if (!$.fn.DataTable) {
        console.error('DataTables no está cargado');
        return;
    }
    if ($.fn.DataTable.isDataTable('#datatables')) {
        return;
    }

    $('#datatables').DataTable({
        pagingType: 'simple_numbers',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
        columnDefs: [{
            targets: [-1],
            orderable: false
        }]
    });
});
</script>
