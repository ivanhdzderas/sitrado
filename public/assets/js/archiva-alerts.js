/**
 * Alertas / pendientes: actualiza badge y modal sin recargar la página.
 */
(function (window, $) {
  'use strict';

  if (!$) return;

  var cfg = window.ArchivaAlertsConfig || {};

  function modalEl() {
    return document.getElementById('modalpendiente');
  }

  function modalIsOpen() {
    var el = modalEl();
    return !!(el && el.classList.contains('show'));
  }

  function showModal() {
    var el = modalEl();
    if (!el || !window.bootstrap || !bootstrap.Modal) return;
    if (el.parentElement !== document.body) {
      document.body.appendChild(el);
    }
    bootstrap.Modal.getOrCreateInstance(el).show();
  }

  function refreshBadge() {
    if (!cfg.badgeUrl) return;
    $.ajax({
      url: cfg.badgeUrl,
      type: 'POST',
      success: function (data) {
        var $slot = $('#alertas_usuarios');
        if (!$slot.length) return;
        var $incoming = $('<div>').html(data);
        var $newBtn = $incoming.find('.archiva-notify').first();
        var $curBtn = $slot.find('.archiva-notify').first();
        // Actualiza solo el badge si el botón ya existe (evita parpadeo / “refresh” cada 15s)
        if ($curBtn.length && $newBtn.length) {
          var count = $.trim($newBtn.find('.notify-badge').text());
          var n = parseInt(count, 10) || 0;
          $curBtn.find('.notify-badge').text(count);
          $curBtn.find('.notify-badge').toggleClass('muted', n === 0);
          $curBtn.toggleClass('has-items', n > 0);
          $curBtn.prop('disabled', n === 0);
          if (n === 0) {
            $curBtn.attr('title', 'Sin pendientes');
          } else {
            $curBtn.removeAttr('title');
          }
          return;
        }
        $slot.html(data);
      }
    });
  }

  function refreshPanel(done) {
    if (!cfg.panelUrl) return;
    var $body = $('#body_alertas_pendientes');
    if (!$body.length) return;
    $body.html('<p class="text-secondary mb-0">Cargando…</p>');
    $.post(cfg.panelUrl, function (data) {
      $body.html(data);
      if (typeof done === 'function') done();
    });
  }

  /** Refresca campana y, si el modal está abierto, su contenido. */
  function refresh() {
    refreshBadge();
    if (modalIsOpen()) {
      refreshPanel();
    }
  }

  function openPanel() {
    showModal();
    refreshPanel();
  }

  function postThenRefresh(url, data) {
    $.post(url, data || {}, function () {
      refresh();
    });
  }

  // —— Acciones del panel (mismas URLs / lógica, sin location.reload) ——
  window.ver_documento = function (id) {
    window.open((cfg.leerBase || '') + id, '_blank');
  };

  window.ir_proyecto2 = function () {
    window.location = cfg.proyectos2Url;
  };

  window.ir_proyecto = function (proyecto) {
    window.location = cfg.detallaProyectoUrl + '/' + proyecto;
  };

  window.marcar = function (pedimento) {
    postThenRefresh(cfg.yaPedimentoUrl, { id: pedimento });
  };

  window.subir_archivo1 = function (tema) {
    $.post(cfg.pendientesJuntasUrl, { id_tema: tema }, function (data) {
      $('#body_alertas_pendientes').html(data);
    });
  };

  window.subir_archivo2 = function (subproyecto, proyecto) {
    $.post(cfg.detProyectoUrl, { id_proyecto: proyecto, id_subproyecto: subproyecto }, function (data) {
      $('#body_alertas_pendientes').html(data);
    });
  };

  window.subir_archivo3 = function (solucion, tipo) {
    $.post(cfg.archivo8dUrl, { solucion: solucion, tipo: tipo }, function (data) {
      $('#body_alertas_pendientes').html(data);
    });
  };

  window.autorizaciones = function () {
    window.location = cfg.documentosAutorizarUrl;
  };

  window.revisar = function () {
    window.location = cfg.revisarDocUrl;
  };

  window.revisar_doc = function () {
    window.location = cfg.revisaUrl;
  };

  window.solicitudes = function () {
    window.location = cfg.solicitudesUrl;
  };

  window.solucion = function (id, solucion) {
    postThenRefresh(cfg.solucionReagendarUrl, { id: id, solucion: solucion });
  };

  window.atendido = function (id) {
    postThenRefresh(cfg.atenderReagendarUrl, { id: id });
  };

  window.visto = function (id) {
    postThenRefresh(cfg.vistoUrl, { id: id });
  };

  window.visto2 = function (id) {
    postThenRefresh(cfg.visto2Url, { id: id });
  };

  window.terminar_agenda = function (id) {
    postThenRefresh(cfg.terminarAgendaUrl, { id: id });
  };

  window.ver_nota_reagendar = function (id) {
    $.post(cfg.verNotaReagendarUrl, { id: id }, function (data) {
      if (window.swal) swal(data);
      else if (window.Swal) Swal.fire({ html: data });
      else alert(data);
    });
  };

  window.visor_pendiente = openPanel;
  window.alertas = refreshBadge;
  window.refreshAlertas = refresh;

  window.ArchivaAlerts = {
    refreshBadge: refreshBadge,
    refreshPanel: refreshPanel,
    refresh: refresh,
    openPanel: openPanel
  };

  $(function () {
    // Delegación: el botón de avisos se regenera por AJAX
    $(document).on('click', '#alertas_usuarios .archiva-notify:not(:disabled)', function (e) {
      e.preventDefault();
      openPanel();
    });

    refreshBadge();
    // Solo badge en polling; no reinyecta scripts del panel
    if (cfg.pollMs > 0) {
      setInterval(refreshBadge, cfg.pollMs);
    }
  });
})(window, window.jQuery);
