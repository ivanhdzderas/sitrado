<script>
$(document).ready(function () {
    if ($.fn.DataTable && ! $.fn.DataTable.isDataTable('#datatables')) {
        $('#datatables').DataTable({
            pagingType: 'simple_numbers',
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
            }
        });
    }
});
</script>

<?php
$titulos = [
    'POL' => 'Políticas',
    'D'   => 'Directrices',
    'P'   => 'Procedimientos',
    'I'   => 'Instructivos',
    'MP'  => 'Mapa de Procesos',
    'F'   => 'Formatos',
    'T'   => 'Tutoriales',
    'OR'  => 'Organigramas',
    'IP'  => 'Interrelación de Procesos',
];
$titulo = $titulos[$tipo ?? ''] ?? 'Documentos';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <a href="<?= site_url('inicio') ?>" class="btn btn-sm btn-outline-secondary">← Inicio</a>
    </div>
</div>

<div class="archiva-panel">
    <h2 class="panel-title">Documentos · <?= esc($titulo) ?></h2>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Documento</th>
                    <th>Departamento</th>
                    <th class="text-end">Ver</th>
                    <th class="text-end">Descargar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documentos)): ?>
                    <tr>
                        <td colspan="5" class="text-secondary">No hay documentos disponibles para este tipo.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($documentos as $key): ?>
                        <tr>
                            <td><span class="badge text-bg-light border"><?= esc($key->tipo) ?></span></td>
                            <td>
                                <a href="<?= site_url('leer/' . $key->id) ?>" target="_blank" class="link-dark text-decoration-none fw-semibold">
                                    <?= esc($key->nombre) ?>
                                </a>
                            </td>
                            <td><?= esc($key->departamento) ?></td>
                            <td class="text-end">
                                <a class="archiva-action" href="<?= site_url('leer/' . $key->id) ?>" target="_blank" title="Ver">Ver</a>
                            </td>
                            <td class="text-end">
                                <?php if (($key->descarga ?? '') === 'SI'): ?>
                                    <a class="archiva-action archiva-action-wide" href="<?= site_url('descargar/' . $key->id) ?>" target="_blank" title="Descargar">Bajar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
