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
</style>
<script>
function showArchivaModal(id, title, titleSelector) {
    var el = document.getElementById(id);
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    if (title && titleSelector) {
        $(titleSelector).text(title);
    }
    bootstrap.Modal.getOrCreateInstance(el).show();
}
function hideArchivaModal(id) {
    var el = document.getElementById(id);
    if (el && window.bootstrap && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(el).hide();
    }
}
</script>
<script>
    function atras(){
  window.location.href="<?php echo base_url()?>proyectos";
}
function ver_archivo_proyecto(sub_proyecto){
    var url="<?php echo base_url()?>login/ver_archivo_proyecto/"+sub_proyecto;
    window.open(url);

}
function modificar(numero){
    showArchivaModal('myModal', 'Modificar proyecto', '#modal_title');
    var url="<?php echo base_url()?>login/modifica_proyecto";
    $.post(url,{proyecto:numero},
                function (data){
                  $("#body_modal").html(data);  
            });
}
function terminar(subproyecto){
     url="<?php echo base_url()?>login/terminar_subproyecto";
            $.post(url,{subproyecto:subproyecto},
                function (data){
                    location.reload();
            });
}
function eliminar(subproyecto){
     var url="<?php echo base_url()?>login/borrar_subproyecto";
            $.post(url,
                {subproyecto:subproyecto},
                function(data){
                    location.reload();
                });
}
function limpiar(subproyecto){
    var url="<?php echo base_url()?>login/limpiar_archivo_proyecto"
                $.post(url,
                {subproyecto:subproyecto},
                function(data){
                    location.reload();
                }); 
}
function notas(subproyecto){
showArchivaModal('ModalVisor', 'Notas', '#modal_title2');
var url="<?php echo base_url()?>login/lista_notas2";
            $.post(url,
                {subproyecto:subproyecto},
                function(data){
                    $("#visorjunta").html(data); 
                }); 
}
function agrega_nota(){
    hideArchivaModal('ModalVisor');
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
                    var url="<?php echo base_url()?>login/guardar_notas2";
                    $.post(url,
                            {nota:$('#notas').val(), subproyecto:subproyecto},
                            function(data){
                                showArchivaModal('ModalVisor');
                             }); 
                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        showArchivaModal('ModalVisor');
                    }
                })
}
function modificar2(subproyecto, proyecto){
     showArchivaModal('ModalVisor', 'Modificar actividad', '#modal_title2');
     url="<?php echo base_url()?>login/modificar_subproyecto";
             $.post(url,{subproyecto:subproyecto},
                function (data){
                    $("#visorjunta").html(data);

            });
}
function archivo(subproyecto, proyecto){
    showArchivaModal('ModalVisor', 'Subir archivo', '#modal_title2');
    url="<?php echo base_url()?>login/det_proyecto";
                 $.post(url,{id_subproyecto:subproyecto, id_proyecto:proyecto},
                    function (data){
                        $("#visorjunta").html(data);

                });
}
function reagendar(subproyecto, proyecto){


            swal({
              title: '¿Deseas solicitar autorizacion de cambio de fecha de la actividad?',
              type: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Si',
              cancelButtonText:'No'
            }).then(function () {
                     hideArchivaModal('myModal');
                    swal({
                      title: 'Agrege nota',
                      input: 'textarea',
                      showCancelButton: true,
                      confirmButtonText: 'Submit',
                      showLoaderOnConfirm: true,
                      allowOutsideClick: false
                    }).then((result) => {

                      $.post(url,
                        {proyecto:proyecto, subproyecto:subproyecto, notas:result},
                        function(data){
                            swal(
                                'Solicitud generada exitosamente'
                              );
                            showArchivaModal('myModal');
                        });
                    })

                    
                
            })
}

function ver_nota_terminadas(subproyecto){
     var url="<?php echo base_url()?>login/lista_notas2";
            $.post(url,
                {subproyecto:subproyecto},
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
function graficar(proyecto){
    var url="<?php echo base_url()?>login/gantt/"+proyecto;
   
    var form = document.createElement('FORM');
    form.method='POST';
    form.action = url;
    form.target="_blank";

    var input = document.createElement("input");
    input.id="proyecto";
    input.name="proyecto";
    input.type="hidden";
    input.value=proyecto;
    form.appendChild(input);
    document.body.appendChild(form);
    
    form.submit();



    var url="<?php echo base_url()?>login/raci/"+proyecto;
    window.open(url,'_blank');
}
function nuevas_tareas(proyecto){
    showArchivaModal('ModalVisor', 'Asigna tareas', '#modal_title2');
    var url="<?php echo base_url()?>signa_tareas";
    $.post(url,
        {proyecto:proyecto},
        function (data){
            $("#visorjunta").html(data);
        });
    $("#list_tareas").html("<h2>Esperando Servidor</h2>");
    var url="<?php echo base_url()?>tareas_sin_asignar";
        $.post(url,
            {proyecto:proyecto},
        function (data){
            $("#list_tareas").html(data);
        });
 };


</script>
<div class="archiva-panel">
<table>
    <tr>
        <td width="50%" valign="bottom">
            <button type="button" class="btn btn-archiva btn-sm me-2 mb-2" onclick="nuevas_tareas('<?php echo esc($proyecto, 'js') ?>')">Asignar actividades</button>
            <button type="button" class="btn btn-outline-secondary btn-sm me-2 mb-2" onclick="graficar('<?php echo esc($proyecto, 'js') ?>')">Gráficas</button>
            <button type="button" class="btn btn-outline-secondary btn-sm mb-2" onclick="atras(); return false;">Regresar a proyectos</button>
        </td>
        <td>

        
<div class="col-md-12">
     <div class="card" style="padding: 10px">
<table width="100%"  rules="all">
            <tr>
               <td colspan="2"><center><h4><b>Informacion de Proyecto</b></h4></center></td> 
            </tr>
            <tr>
                <td width="50%" style="padding-top: 8px">
                <?php
    ;
                foreach ($nombre_proyecto as $key) {
                    echo "<b>Proyecto: </b>".$key->nombre_proyecto."<br />";
                    echo "<b>Fecha Inicio: </b>".$key->f_inicio."<br />";
             
                }
                $alfa=login_model()->carga_datos_usuario($key->patrocinador)->getResult();
                foreach ($alfa as $patro) {
                     echo "<b>Patrocinador: </b>".$patro->nombre."<br />"; 
                }
                ?>
                
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="modificar('<?php echo esc($key->id_proyecto, 'js') ?>')">Modificar</button>
                </td>
                <td style="padding-top: 8px">
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Participantes</b><br />
                    <ul>
                    <?php
                    $array=array();
                    foreach ($participantes as $key) {
                        array_push($array, $key->persona);
                        
                    }
                    $parte= array_unique($array);

                    foreach ($parte as $key) {
                        ?>
                        <li><?php echo $key?></li>
                        <?php
                    }
                    ?>
                    </ul>
                </td>
            </tr>
        </table>
</div></div>
</td>
    </tr>
</table>
<div class="col-md-12">
     <div class="card">
        
    <div class="card-content table-responsive table-full-width">
        <table class="table table-hover">
            <thead>
                <th>Tarea</th>
                <th>Realiza</th>
                <th>Responsable de validar</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th></th>
            </thead>
            <tbody>
            <?php
            if ($detalles->getNumRows()>0){
                foreach ($detalles->getResult() as $key) {
                    ?>
                    <tr>
                        <td><?php 
                        $query=login_model()->buscar_archivos_proyectos($key->id_subproyecto);
                        
                        $cuantos=$query->getNumRows();
                        if ($cuantos==0){

                        }else{
                            ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="ver_archivo_proyecto('<?php echo esc($key->id_subproyecto, 'js') ?>')">Archivo</button>
                            <?php
                        }
                        echo $key->tarea
                        ?></td>
                        <td><?php echo $key->nombre?></td>
                        <td>
                            <?php
                            $query=login_model()->carga_datos_usuario($key->responsable)->getResult();
                            foreach ($query as $alfa) {
                                echo $alfa->nombre;
                            }
                            ?>
                        </td>
                        <td><?php echo $key->f_inicio?></td>
                        <td><?php echo $key->f_fin?></td>
                        <td>
                            <?php 
                            if ($key->terminado=='NO'){
                            ?>
                            
                             <button type="button" class="btn btn-sm btn-outline-success me-1" onclick="terminar('<?php echo esc($key->id_subproyecto, 'js') ?>')">Terminar</button>

                             <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="eliminar('<?php echo esc($key->id_subproyecto, 'js') ?>')">Eliminar</button>
                            
                             <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="limpiar('<?php echo esc($key->id_subproyecto, 'js') ?>')">Limpiar</button>
                             <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="notas('<?php echo esc($key->id_subproyecto, 'js') ?>')">Notas</button>
                             <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="modificar2('<?php echo esc($key->id_subproyecto, 'js') ?>','<?php echo esc($proyecto, 'js') ?>')">Modificar</button>

                             <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="archivo('<?php echo esc($key->id_subproyecto, 'js') ?>','<?php echo esc($proyecto, 'js') ?>')">Archivo</button>


                             <button type="button" class="btn btn-sm btn-outline-secondary" onclick="reagendar('<?php echo esc($key->id_subproyecto, 'js') ?>','<?php echo esc($proyecto, 'js') ?>')">Reagendar</button>

                          
                            <?php
                            }else{
                                echo "Terminado <br />";
                                ?><button class="btn btn-sm btn-outline-danger me-1" onclick="liberar('<?php echo esc($key->id_subproyecto, 'js') ?>','<?php echo esc($proyecto, 'js') ?>')">Reactivar
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="ver_nota_terminadas('<?php echo esc($key->id_subproyecto, 'js') ?>','<?php echo esc($proyecto, 'js') ?>')">Ver notas
                                    </button>
                                    <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>  
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
<div class="modal fade archiva-modal" id="ModalVisor" tabindex="-1" aria-labelledby="modal_title2" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title2">Notas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="visorjunta"></div>
                <div id="list_tareas"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_modal">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>