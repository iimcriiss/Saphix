<?php ob_start(); ?>

<div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-3">

    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #378ADD">
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Productos activos</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1 transition-colors duration-300"><?= $totalProductos ?></p>
        <p class="text-xs text-gray-500 dark:text-yt-muted mt-2 font-semibold transition-colors duration-300">en inventario</p>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #639922">
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Ventas hoy</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1 transition-colors duration-300">$<?= number_format($montoHoy, 0, ',', '.') ?></p>
        <p class="text-xs text-green-600 mt-2 font-semibold transition-colors duration-300"><?= $ventasHoy ?> ventas completadas</p>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #7F77DD">
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Ventas esta semana</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1 transition-colors duration-300">$<?= number_format($montoSemana, 0, ',', '.') ?></p>
        <p class="text-xs text-green-600 mt-2 font-semibold transition-colors duration-300"><?= $ventasSemana ?> ventas completadas</p>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #E24B4A">
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Stock bajo</p>
        <p class="text-xl sm:text-2xl font-semibold mt-1 <?= $stockBajo > 0 ? 'text-red-500' : 'text-gray-700 dark:text-yt-text' ?> transition-colors duration-300"><?= $stockBajo ?></p>
        <p class="text-xs mt-2 font-semibold <?= $stockBajo > 0 ? 'text-red-500' : 'dark:text-yt-muted' ?> transition-colors duration-300">productos con stock ≤ 5</p>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #1D9E75">
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Ventas del mes</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1 transition-colors duration-300">$<?= number_format($montoMes, 0, ',', '.') ?></p>
        <p class="text-xs text-green-600 mt-2 font-semibold transition-colors duration-300"><?= $ventasMes ?> ventas este mes</p>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid #BA7517">
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Clientes registrados</p>
        <p class="text-xl sm:text-2xl font-semibold text-gray-700 dark:text-gray-100 mt-1 transition-colors duration-300"><?= $totalClientes ?></p>
        <p class="text-xs text-gray-500 dark:text-yt-muted mt-2 font-semibold transition-colors duration-300">en el sistema</p>
    </div>

    <div class="col-span-2 sm:col-span-3 bg-gray-200 dark:bg-yt-surface rounded-b-xl p-3 border border-gray-300 dark:border-yt-border shadow-md transition-colors duration-300" style="border-top: 3px solid <?= ($montoMes - $comprasMes) >= 0 ? '#639922' : '#E24B4A' ?>">
        <?php $balance = $montoMes - $comprasMes; ?>
        <p class="text-xs text-gray-700 dark:text-yt-text font-semibold transition-colors duration-300">Balance del mes</p>
        <p class="text-xl sm:text-2xl font-semibold mt-1 <?= $balance >= 0 ? 'text-green-500' : 'text-red-500' ?> transition-colors duration-300">
            $<?= number_format(abs($balance), 0, ',', '.') ?>
        </p>
        <p class="text-xs mt-2 font-semibold <?= $balance >= 0 ? 'text-green-500' : 'text-red-500' ?> transition-colors duration-300">
            <?= $balance >= 0 ? 'Ganancia' : 'Pérdida' ?> este mes
        </p>
    </div>

</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

    <div class="bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-4 py-2.5 border-b border-gray-300 dark:border-yt-border transition-colors duration-300">
            <h2 class="text-sm font-medium text-gray-700 dark:text-yt-text transition-colors duration-300">Últimas ventas</h2>
        </div>
        <?php if (empty($ultimasVentas)): ?>
            <p class="px-4 py-6 text-center text-sm text-gray-400 transition-colors duration-300">No hay ventas registradas</p>
        <?php else: ?>
            <table class="w-full text-sm transition-colors duration-300">
                <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
                    <tr>
                        <th class="text-left px-4 py-2 text-xs text-gray-500 dark:text-yt-text font-semibold transition-colors duration-300">Cliente</th>
                        <th class="text-left px-4 py-2 text-xs text-gray-500 dark:text-yt-text font-semibold transition-colors duration-300">Total</th>
                        <th class="text-left px-4 py-2 text-xs text-gray-500 dark:text-yt-text font-semibold transition-colors duration-300">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
                    <?php foreach ($ultimasVentas as $venta): ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                            <td class="px-4 py-2.5 text-gray-700 dark:text-gray-300 transition-colors duration-300"><?= $venta['cliente'] ?? 'Mostrador' ?></td>
                            <td class="px-4 py-2.5 font-medium text-gray-700 dark:text-gray-100 transition-colors duration-300">$<?= number_format($venta['total'], 0, ',', '.') ?></td>
                            <td class="px-4 py-2.5">
                                <?php if ($venta['estado'] === 'completada'): ?>
                                    <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-1.5 py-0.5 rounded-full font-medium transition-colors duration-300">Completada</span>
                                <?php else: ?>
                                    <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-1.5 py-0.5 rounded-full font-medium transition-colors duration-300">Cancelada</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
        <div class="px-4 py-2.5 border-b border-gray-300 dark:border-yt-border transition-colors duration-300">
            <h2 class="text-sm font-medium text-gray-700 dark:text-yt-text transition-colors duration-300">Productos con stock bajo</h2>
        </div>
        <?php if (empty($productosStockBajo)): ?>
            <p class="px-4 py-6 text-center text-sm text-green-500 font-medium transition-colors duration-300">Todo el inventario está bien ✓</p>
        <?php else: ?>
            <table class="w-full text-sm transition-colors duration-300">
                <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
                    <tr>
                        <th class="text-left px-4 py-2 text-xs text-gray-500 dark:text-yt-text font-semibold transition-colors duration-300">Producto</th>
                        <th class="text-left px-4 py-2 text-xs text-gray-500 dark:text-yt-text font-semibold transition-colors duration-300">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
                    <?php foreach ($productosStockBajo as $producto): ?>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                            <td class="px-4 py-2.5 text-gray-700 dark:text-gray-300 transition-colors duration-300"><?= $producto['nombre'] ?></td>
                            <td class="px-4 py-2.5">
                                <?php if ($producto['stock'] == 0): ?>
                                    <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-1.5 py-0.5 rounded-full font-medium transition-colors duration-300">Sin stock</span>
                                <?php else: ?>
                                    <span class="bg-amber-200 text-amber-700 dark:bg-amber-800 border border-amber-400 dark:text-amber-300 text-xs px-1.5 py-0.5 rounded-full font-medium transition-colors duration-300"><?= $producto['stock'] ?> unidades</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>