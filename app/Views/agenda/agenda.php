<div class="content">
    <div class="container-fluid">
        <div class="header text-center">
            <h3 class="title">Agenda Personal</h3>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="card card-calendar">
                    <div class="card-content" class="ps-child">
                        <div id='calendar'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        var initialLocaleCode = 'es';
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listMonth'
            },
            defaultDate: '<?php echo   date('Y-m-d')?>',
            locale: initialLocaleCode,
            navLinks: true, 
            selectable: true,
            selectHelper: true,
             eventClick: function(calEvent, jsEvent, view)
            {
                swal({
                  title: '¿Estas seguro?',
                  text: 'Deseas eliminar el evento "'+calEvent.title+'"',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si',
                  cancelButtonText:'No',
                }).then((result) => {
                  if (result==true) {
                    $('#calendar').fullCalendar('removeEvents', calEvent._id);
                    var url="<?php echo base_url()?>login/eliminar_evento";
                     $.post(url,
                        {id:calEvent._id},    
                        function(data){
                         });
                  }
                })
            },
            select: function(start, end) {
                var miFechaActual = new Date(start);
                dia = miFechaActual.getDate() ;
                dia=dia+1;
                if (dia<10){
                    dia="0"+dia;
                }
                mes = parseInt(miFechaActual.getMonth()) + 1; 
                if (mes<10){
                    mes="0"+mes;
                }
                ano = miFechaActual.getFullYear();
                var fecha=ano + '-' + mes + '-' + dia;
                
                //inicio modificacion
                swal({
                  title: 'Titulo del Evento',
                  input: 'text',
                  showCancelButton: true,
                  confirmButtonText: 'Siguiente',
                  showLoaderOnConfirm: true,
                  preConfirm: (email) => {
                    return new Promise((resolve) => {
                      setTimeout(() => {
                        if (email === '') {
                          swal.showValidationError(
                            'Ingrese un titulo.'
                          )
                        }
                        resolve()
                      }, 500)
                    })
                  },
                  allowOutsideClick: false
                }).then((result) => {
                    var title=result;
                    swal({
                        title: 'Desde:',
                        html :'<input type="date" value="'+fecha+'" id="swal-input1" class="swal2-input">',
                        showCancelButton: true,
                        confirmButtonText: 'Siguiente',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        var start=$("#swal-input1").val();
                        swal({
                            title: 'Hasta:',
                            html :'<input type="date"  id="swal-input2" class="swal2-input">',
                            showCancelButton: true,
                            confirmButtonText: 'Guardar',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: false
                        }).then((result) => {
                        var end=$("#swal-input2").val();
                        var miFechaActual2 = new Date(end);
                        dia2 = miFechaActual2.getDate() ;
                        dia2=dia2+2;
                        if (dia2<10){
                            dia2="0"+dia2;
                        }
                        mes2 = parseInt(miFechaActual2.getMonth()) + 1; 
                        ano2 = miFechaActual2.getFullYear();
                        var fecha2=ano2 + '-' + mes2 + '-' + dia2;
                        var eventData;
                        if (title) {
                            eventData = {
                                title: title,
                                start: start,
                                end: fecha2
                            };
                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                        }
                        $('#calendar').fullCalendar('unselect');
                        var url="<?php echo base_url()?>login/agregar_agenda";
                        $.post(url,
                            {titulo:title, inicio:start, fin:fecha2},    
                            function(data){
                            });
                        })
                    });
                });
            },
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: [
                <?php
                foreach ($agenda as $key) {
                   ?>
                    {
                        id: <?php echo $key->id_pendiente?>,
                        title: '<?php echo $key->titulo?>',
                        start: '<?php echo $key->fecha?>',
                        end: '<?php echo $key->f_fin?>'
                    },
                   <?php
               }
                ?>
            ]
        });
    });
</script>
