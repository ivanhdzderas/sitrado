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
function showEventosModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Evento');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function agrega_evento() {
    showEventosModal('Nuevo evento');
    var url = "<?php echo base_url()?>login/nuevo_evento";
    $.post(url, function (data) {
        $("#modal_body").html(data);
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Eventos</h2>
        <?php if (session()->get('logged_in')['nivel'] == "staff" or session()->get('logged_in')['tipo'] == "admin") { ?>
            <button type="button" class="btn btn-archiva btn-sm" onclick="agrega_evento()">Nuevo evento</button>
        <?php } ?>
    </div>

    <div id="calendar"></div>
</div>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Evento</h5>
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

<script>
$(document).ready(function () {
    var initialLocaleCode = 'es';
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth'
        },
        defaultDate: '<?php echo date('Y-m-d')?>',
        locale: initialLocaleCode,
        navLinks: true,
        selectable: true,
        selectHelper: true,
        eventClick: function (calEvent, jsEvent, view) {
            var url = "<?php echo base_url()?>login/ver_evento";
            $.post(url,
                { id: calEvent._id },
                function (data) {
                    swal("Descripcion del evento", data);
                });
        },
        editable: false,
        eventLimit: true,
        events: [
            <?php foreach ($eventos as $key): ?>
            {
                id: '<?php echo $key->id_evento?>',
                title: '<?php echo $key->titulo?>',
                start: '<?php echo $key->fecha_inicio?>',
                end: '<?php echo $key->fecha_fin?>',
                <?php
                switch ($key->tipo) {
                    case 'Beneficio':
                        ?>
                        color: '#ffff00'
                        <?php
                        break;
                    case 'Asueto':
                        ?>
                        color: '#92d050'
                        <?php
                        break;
                    case 'Medio':
                        ?>
                        color: '#ff0066'
                        <?php
                        break;
                    case 'Interno':
                        ?>
                        color: '#ffc000'
                        <?php
                        break;
                    case 'Capacitacion':
                        ?>
                        color: '#00b050'
                        <?php
                        break;
                }
                ?>
            },
            <?php endforeach; ?>
        ]
    });
});
</script>
