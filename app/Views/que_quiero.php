<div class="archiva-panel">
    <h2 class="panel-title mb-1">Asistente</h2>
    <p class="text-secondary mb-4">Indica el tipo de aspecto detectado y envía tu mensaje.</p>

    <form id="nuevo_reporte">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="archiva-tile w-100 border rounded-3 p-3 d-block" style="min-height:auto;cursor:pointer">
                    <input type="radio" class="form-check-input me-2" name="jobb" value="Positivo" required>
                    <span class="fw-semibold">Aspectos positivos</span>
                </label>
            </div>
            <div class="col-md-6">
                <label class="archiva-tile w-100 border rounded-3 p-3 d-block" style="min-height:auto;cursor:pointer">
                    <input type="radio" class="form-check-input me-2" name="jobb" value="Negativo" required>
                    <span class="fw-semibold">Aspectos negativos</span>
                </label>
            </div>
            <div class="col-12">
                <label class="form-label" for="mensaje">Mensaje</label>
                <textarea name="mensaje" id="mensaje" class="form-control" rows="4" required></textarea>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-archiva" id="buton_sol">Enviar</button>
            </div>
        </div>
    </form>
</div>

<input type="hidden" id="tipo" name="tipo" value="">

<script>
$(function () {
    $("#buton_sol").on("click", function () {
        var tipo = $('input:radio[name=jobb]:checked').val();
        var tema = $('#mensaje').val();
        if (!tipo || !tema) {
            Swal.fire({ icon: 'warning', title: 'Completa el formulario' });
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?= site_url('login/pedir_proyecto') ?>",
            data: { tema: tema, tipo: tipo },
            success: function () {
                Swal.fire({ icon: 'success', title: 'Solicitud enviada' });
            }
        });
        return false;
    });
});
</script>
