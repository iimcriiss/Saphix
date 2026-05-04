<?php ob_start(); ?>

<?php if (isset($_GET['success'])): ?>
    <div id="toast-success" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-green-600 border-green-700 border text-white text-sm font-medium px-6 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Venta realizada con éxito
    </div>
    <script>
        setTimeout(() => { const t = document.getElementById('toast-success'); t.style.opacity='0'; setTimeout(()=>t.remove(),300); }, 1500);
        history.replaceState({}, '', '/ventas');
    </script>
<?php endif; ?>

<?php if (isset($_GET['cancelled'])): ?>
    <div id="toast-cancelled" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-red-600 border-red-700 border text-white text-sm font-medium px-6 py-3 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        Venta cancelada
    </div>
    <script>
        setTimeout(() => { const t = document.getElementById('toast-cancelled'); t.style.opacity='0'; setTimeout(()=>t.remove(),300); }, 1500);
        history.replaceState({}, '', '/ventas');
    </script>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Ventas</h2>
        <p class="text-sm text-gray-500 dark:text-yt-muted mt-0.5 font-medium transition-colors duration-300">Historial de ventas</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <a onclick="toggleExport(this)" class="flex items-center gap-2 text-indigo-500 hover:text-indigo-700 text-sm font-medium cursor-pointer transition-colors duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span class="hidden sm:inline">Exportar datos</span>
            </a>
            <div id="export-menu" class="hidden absolute right-0 mt-1 w-48 bg-white dark:bg-yt-surface rounded-lg shadow-lg border border-gray-300 dark:border-yt-border z-50 overflow-hidden transition-colors duration-300">
                <a href="/exportar/ventas/xlsx" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 3v18M14 3v18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                    Excel (.xlsx)
                </a>
                <a href="/exportar/ventas/csv" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    CSV (.csv)
                </a>
                <a href="/exportar/ventas/pdf" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF (.pdf)
                </a>
            </div>
        </div>
        <?php if (Permission::can('ventas.crear')): ?>
            <a href="/ventas/create" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300 whitespace-nowrap">
                + Nueva venta
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Vista tabla (md+) -->
<div class="hidden md:block bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
    <table class="w-full text-sm">
        <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
            <tr>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">#</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Cliente</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Vendedor</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Fecha</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Método pago</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Total</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Estado</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
            <?php if (empty($ventas)): ?>
                <tr><td colspan="8" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">No hay ventas registradas</td></tr>
            <?php else: ?>
                <?php foreach ($ventas as $venta): ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">#<?= $venta['id'] ?></td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium"><?= $venta['cliente'] ?? 'Mostrador' ?></td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= $venta['usuario'] ?? '—' ?></td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?></td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= ucfirst($venta['metodo_pago']) ?></td>
                    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-100">$<?= number_format($venta['total'], 0, ',', '.') ?></td>
                    <td class="px-6 py-4">
                        <?php if ($venta['estado'] === 'completada'): ?>
                            <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Completada</span>
                        <?php else: ?>
                            <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Cancelada</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <a href="/ventas/show/<?= $venta['id'] ?>" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold transition-colors duration-300">Ver</a>
                        <?php if ($venta['estado'] === 'completada' && Permission::can('ventas.cancelar')): ?>
                            <a href="/ventas/cancelar/<?= $venta['id'] ?>" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors duration-300" onclick="return confirm('¿Cancelar esta venta?')">Cancelar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Vista tarjetas (móvil) -->
<div class="md:hidden space-y-3">
    <?php if (empty($ventas)): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-6 text-center text-gray-400 dark:text-gray-500 transition-colors duration-300">
            No hay ventas registradas
        </div>
    <?php else: ?>
        <?php foreach ($ventas as $venta): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 shadow-sm transition-colors duration-300">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-xs text-gray-400 dark:text-gray-500">#<?= $venta['id'] ?></span>
                    <p class="font-semibold text-gray-700 dark:text-yt-text"><?= $venta['cliente'] ?? 'Mostrador' ?></p>
                    <p class="text-xs text-gray-500 dark:text-yt-muted"><?= $venta['usuario'] ?? '—' ?></p>
                </div>
                <?php if ($venta['estado'] === 'completada'): ?>
                    <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Completada</span>
                <?php else: ?>
                    <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Cancelada</span>
                <?php endif; ?>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs text-gray-500 dark:text-yt-muted mb-3">
                <div><span class="font-medium text-gray-600 dark:text-gray-400">Fecha:</span> <?= date('d/m/Y H:i', strtotime($venta['fecha'])) ?></div>
                <div><span class="font-medium text-gray-600 dark:text-gray-400">Método:</span> <?= ucfirst($venta['metodo_pago']) ?></div>
                <div class="col-span-2"><span class="font-semibold text-gray-700 dark:text-yt-text text-sm">Total: $<?= number_format($venta['total'], 0, ',', '.') ?></span></div>
            </div>
            <div class="flex items-center gap-3 pt-3 border-t border-gray-200 dark:border-yt-border">
                <a href="/ventas/show/<?= $venta['id'] ?>" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold transition-colors duration-300">Ver detalle</a>
                <?php if ($venta['estado'] === 'completada' && Permission::can('ventas.cancelar')): ?>
                    <a href="/ventas/cancelar/<?= $venta['id'] ?>" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors duration-300" onclick="return confirm('¿Cancelar esta venta?')">Cancelar</a>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function toggleExport(btn) {
        const menu = document.getElementById('export-menu');
        menu.classList.toggle('hidden');
        document.addEventListener('click', function close(e) {
            if (!btn.parentElement.contains(e.target)) {
                menu.classList.add('hidden');
                document.removeEventListener('click', close);
            }
        });
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>