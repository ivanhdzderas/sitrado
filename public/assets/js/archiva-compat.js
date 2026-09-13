/**
 * Compatibilidad Bootstrap 3/4 → 5 para modales y SweetAlert legado.
 * No cambia la lógica de negocio; solo hace visibles/usables los modales antiguos.
 */
(function (window, $) {
  'use strict';

  if (!window.bootstrap || !$) {
    return;
  }

  function resolveEl(target) {
    if (!target) return null;
    if (typeof target === 'string') {
      return document.querySelector(target);
    }
    if (target.jquery) {
      return target[0] || null;
    }
    return target.nodeType ? target : null;
  }

  function showModal(target) {
    var el = resolveEl(target);
    if (!el) return null;
    // Evita que transform/overflow del shell recorte el modal
    if (el.parentElement !== document.body) {
      document.body.appendChild(el);
    }
    return bootstrap.Modal.getOrCreateInstance(el).show();
  }

  function hideModal(target) {
    var el = resolveEl(target);
    if (!el) return;
    var inst = bootstrap.Modal.getInstance(el);
    if (inst) inst.hide();
  }

  // API jQuery .modal('show'|'hide'|'toggle')
  if (!$.fn.modal || !$.fn.modal._archivaShim) {
    $.fn.modal = function (action, _related) {
      return this.each(function () {
        var inst = bootstrap.Modal.getOrCreateInstance(this);
        if (action === 'show') inst.show();
        else if (action === 'hide') inst.hide();
        else if (action === 'toggle') inst.toggle();
        else if (action === 'dispose') inst.dispose();
      });
    };
    $.fn.modal._archivaShim = true;
  }

  // data-toggle="modal" data-target="#..."
  $(document).on('click.archivaModal', '[data-toggle="modal"]', function (e) {
    var $btn = $(this);
    var target = $btn.attr('data-target') || $btn.attr('href');
    if (!target || target.charAt(0) !== '#') return;
    e.preventDefault();
    showModal(target);
  });

  // data-dismiss="modal"
  $(document).on('click.archivaModalDismiss', '[data-dismiss="modal"]', function (e) {
    e.preventDefault();
    var modal = $(this).closest('.modal')[0];
    hideModal(modal);
  });

  // SweetAlert2: permitir swal({...}) y swal('texto')
  // En el legado, .then(fn) solo debía correr al confirmar.
  if (window.Swal) {
    window.swal = function (opts, maybeText, maybeType) {
      var promise;
      if (typeof opts === 'string') {
        if (typeof maybeText === 'string' && typeof maybeType === 'string') {
          promise = Swal.fire({ title: opts, text: maybeText, icon: maybeType });
        } else if (typeof maybeText === 'string') {
          promise = Swal.fire({ title: opts, text: maybeText });
        } else {
          promise = Swal.fire({ title: opts });
        }
      } else if (opts && typeof opts === 'object') {
        var mapped = Object.assign({}, opts);
        if (mapped.type && !mapped.icon) {
          mapped.icon = mapped.type;
          delete mapped.type;
        }
        promise = Swal.fire(mapped);
      } else {
        promise = Swal.fire(opts);
      }

      var originalThen = promise.then.bind(promise);
      promise.then = function (onFulfilled, onRejected) {
        return originalThen(function (result) {
          if (result && (result.isConfirmed || result.value === true)) {
            return typeof onFulfilled === 'function' ? onFulfilled(result) : result;
          }
          return result;
        }, onRejected);
      };
      return promise;
    };
  }

  // Saca los modales del shell para que no los recorte overflow/transform
  $(function () {
    $('.modal').each(function () {
      if (this.parentElement !== document.body) {
        document.body.appendChild(this);
      }
    });
  });

  window.archivaShowModal = showModal;
  window.archivaHideModal = hideModal;
})(window, window.jQuery);
