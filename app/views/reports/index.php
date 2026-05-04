<?php ob_start(); ?>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Cierre de caja</h2>
        <p class="text-sm text-gray-500 dark:text-yt-muted mt-0.5 font-medium transition-colors duration-300">
            Reporte del día <?= date('d/m/Y', strtotime($fecha)) ?>
        </p>
    </div>
    <form method="GET" action="/reportes/cierreCaja" class="flex flex-wrap items-center gap-2">
        <input type="date" name="fecha" value="<?= $fecha ?>"
            class="border border-gray-300 dark:border-yt-border bg-white dark:bg-yt-elevated text-gray-700 dark:text-yt-text text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300">
            Ver
        </button>
        <a href="/reportes/backup" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Backup BD
        </a>
    </form>
</div>

<!-- Cards resumen -->
<div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-4 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #1D9E75">
        <p class="text-sm text-gray-700 dark:text-yt-text font-semibold">Total ventas</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1">$<?= number_format($resumen['monto_total'], 0, ',', '.') ?></p>
        <p class="text-xs text-green-600 mt-2 font-semibold"><?= $resumen['total_ventas'] ?> ventas completadas</p>
    </div>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-4 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #378ADD">
        <p class="text-sm text-gray-700 dark:text-yt-text font-semibold">Impuestos</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1">$<?= number_format($resumen['impuestos'], 0, ',', '.') ?></p>
        <p class="text-xs text-gray-500 dark:text-yt-muted mt-2 font-semibold">del total facturado</p>
    </div>
    <div class="col-span-2 sm:col-span-1 bg-gray-200 dark:bg-yt-surface rounded-b-xl p-4 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #E24B4A">
        <p class="text-sm text-gray-700 dark:text-yt-text font-semibold">Ventas canceladas</p>
        <p class="text-xl sm:text-2xl font-semibold text-red-500 mt-1">$<?= number_format($canceladas['monto'], 0, ',', '.') ?></p>
        <p class="text-xs text-red-500 mt-2 font-semibold"><?= $canceladas['total'] ?> canceladas</p>
    </div>
</div>

<!-- Desglose + Resumen financiero -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">

    <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-300 dark:border-yt-border">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-yt-text">Desglose por método de pago</h2>
        </div>
        <?php if (empty($metodos)): ?>
            <p class="px-6 py-8 text-center text-sm text-gray-400">No hay ventas este día</p>
        <?php else: ?>
            <table class="w-full text-sm">
                <thead class="bg-gray-200 dark:bg-yt-elevated">
                    <tr>
                        <th class="text-left px-4 sm:px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Método</th>
                        <th class="text-left px-4 sm:px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Cant.</th>
                        <th class="text-left px-4 sm:px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-yt-border">
                    <?php foreach ($metodos as $metodo): ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                        <td class="px-4 sm:px-6 py-3 font-medium text-gray-700 dark:text-gray-300"><?= ucfirst($metodo['metodo_pago']) ?></td>
                        <td class="px-4 sm:px-6 py-3 text-gray-600 dark:text-gray-400"><?= $metodo['cantidad'] ?></td>
                        <td class="px-4 sm:px-6 py-3 font-semibold text-gray-700 dark:text-gray-100">$<?= number_format($metodo['monto'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-300 dark:border-yt-border">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-yt-text">Resumen financiero</h2>
        </div>
        <div class="p-4 sm:p-6 flex flex-col gap-4">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-yt-muted font-medium">Subtotal vendido</span>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-100">$<?= number_format($resumen['subtotal'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-yt-muted font-medium">Impuestos</span>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-100">$<?= number_format($resumen['impuestos'], 0, ',', '.') ?></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500 dark:text-yt-muted font-medium">Canceladas</span>
                <span class="text-sm font-semibold text-red-500">-$<?= number_format($canceladas['monto'], 0, ',', '.') ?></span>
            </div>
            <div class="border-t border-gray-300 dark:border-yt-border pt-4 flex justify-between items-center">
                <?php $neto = $resumen['monto_total'] - $canceladas['monto']; ?>
                <span class="text-sm font-bold text-gray-700 dark:text-yt-text">Total neto</span>
                <span class="text-xl font-bold <?= $neto >= 0 ? 'text-green-500' : 'text-red-500' ?>">
                    $<?= number_format(abs($neto), 0, ',', '.') ?>
                </span>
            </div>
        </div>
    </div>

</div>

<!-- Detalle ventas desktop -->
<div class="hidden sm:block bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
    <div class="px-6 py-4 border-b border-gray-300 dark:border-yt-border">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-yt-text">Detalle de ventas del día</h2>
    </div>
    <?php if (empty($ventas)): ?>
        <p class="px-6 py-8 text-center text-sm text-gray-400">No hay ventas registradas este día</p>
    <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-200 dark:bg-yt-elevated">
                <tr>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">#</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Cliente</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Vendedor</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Método</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Total</th>
                    <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 dark:divide-yt-border">
                <?php foreach ($ventas as $venta): ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                    <td class="px-6 py-3 text-gray-500 dark:text-gray-400">#<?= $venta['id'] ?></td>
                    <td class="px-6 py-3 text-gray-700 dark:text-gray-300 font-medium"><?= $venta['cliente'] ?? 'Mostrador' ?></td>
                    <td class="px-6 py-3 text-gray-600 dark:text-gray-400"><?= $venta['vendedor'] ?? '—' ?></td>
                    <td class="px-6 py-3 text-gray-600 dark:text-gray-400"><?= ucfirst($venta['metodo_pago']) ?></td>
                    <td class="px-6 py-3 font-semibold text-gray-700 dark:text-gray-100">$<?= number_format($venta['total'], 0, ',', '.') ?></td>
                    <td class="px-6 py-3">
                        <?php if ($venta['estado'] === 'completada'): ?>
                            <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Completada</span>
                        <?php else: ?>
                            <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Cancelada</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Detalle ventas móvil -->
<div class="sm:hidden">
    <h2 class="text-sm font-semibold text-gray-700 dark:text-yt-text mb-3">Detalle de ventas del día</h2>
    <?php if (empty($ventas)): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-6 text-center text-sm text-gray-400 transition-colors duration-300">
            No hay ventas registradas este día
        </div>
    <?php else: ?>
        <div class="space-y-3">
        <?php foreach ($ventas as $venta): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 shadow-sm transition-colors duration-300">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <span class="text-xs text-gray-400">#<?= $venta['id'] ?></span>
                    <p class="font-semibold text-gray-700 dark:text-yt-text"><?= $venta['cliente'] ?? 'Mostrador' ?></p>
                    <p class="text-xs text-gray-500 dark:text-yt-muted"><?= $venta['vendedor'] ?? '—' ?></p>
                </div>
                <?php if ($venta['estado'] === 'completada'): ?>
                    <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Completada</span>
                <?php else: ?>
                    <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Cancelada</span>
                <?php endif; ?>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs text-gray-500 dark:text-yt-muted">
                <div><span class="font-medium text-gray-600 dark:text-gray-400">Método:</span> <?= ucfirst($venta['metodo_pago']) ?></div>
                <div><span class="font-semibold text-gray-700 dark:text-yt-text text-sm">$<?= number_format($venta['total'], 0, ',', '.') ?></span></div>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>