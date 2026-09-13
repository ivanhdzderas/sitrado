</div><!-- /.archiva-content -->
</div><!-- /.archiva-main -->
</div><!-- /.archiva-shell -->

<div class="modal fade" id="modalpendiente" tabindex="-1" aria-labelledby="modalpendienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalpendienteLabel">Pendientes y avisos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body archiva-alerts-body" id="body_alertas_pendientes">
        <p class="text-secondary mb-0">Cargando…</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="<?= base_url('assets/js/archiva-compat.js') ?>"></script>
<script>
window.demo = window.demo || {
  initMaterialWizard: function () {},
  initFormExtendedDatetimepickers: function () {},
  showNotification: function () {}
};
</script>
</body>
</html>
