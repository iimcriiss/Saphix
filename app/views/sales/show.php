<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/ventas" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Detalle de venta #<?= $venta['id'] ?></h2>
</div>

<!-- Cards info: 2 cols en móvil, 4 en desktop -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-5 mb-6">
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1">Cliente</p>
        <p class="font-medium text-gray-700 dark:text-yt-text text-sm transition-colors duration-300"><?= $venta['cliente'] ?? 'Mostrador' ?></p>
    </div>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1">Vendedor</p>
        <p class="font-medium text-gray-700 dark:text-yt-text text-sm transition-colors duration-300"><?= $venta['usuario'] ?? '—' ?></p>
    </div>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1">Método de pago</p>
        <p class="font-medium text-gray-700 dark:text-yt-text text-sm transition-colors duration-300"><?= ucfirst($venta['metodo_pago']) ?></p>
    </div>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1">Estado</p>
        <?php if ($venta['estado'] === 'completada'): ?>
            <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Completada</span>
        <?php else: ?>
            <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Cancelada</span>
        <?php endif; ?>
    </div>
</div>

<!-- Tabla desktop -->
<div class="hidden sm:block bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border overflow-hidden mb-5 transition-colors duration-300">
    <div class="px-6 py-4 border-b border-gray-300 dark:border-yt-border transition-colors duration-300">
        <h3 class="text-sm font-medium text-gray-700 dark:text-yt-text">Productos vendidos</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
            <tr>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-yt-muted font-semibold">Producto</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-yt-muted font-semibold">Cantidad</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-yt-muted font-semibold">Precio unitario</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-yt-muted font-semibold">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
            <?php foreach ($detalle as $item): ?>
            <tr>
                <td class="px-6 py-4 font-medium text-gray-700 dark:text-yt-text"><?= $item['producto'] ?></td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= $item['cantidad'] ?></td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">$<?= number_format($item['precio_unitario'], 0, ',', '.') ?></td>
                <td class="px-6 py-4 font-medium text-gray-700 dark:text-yt-text">$<?= number_format($item['cantidad'] * $item['precio_unitario'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-300 dark:border-yt-border transition-colors duration-300">
        <div class="flex justify-end">
            <div class="text-right space-y-1">
                <div class="flex justify-between gap-16 text-sm text-gray-500 dark:text-yt-muted"><span>Subtotal</span><span>$<?= number_format($venta['subtotal'], 0, ',', '.') ?></span></div>
                <div class="flex justify-between gap-16 text-sm text-gray-500 dark:text-yt-muted"><span>Impuestos</span><span>$<?= number_format($venta['impuestos'], 0, ',', '.') ?></span></div>
                <div class="flex justify-between gap-16 text-base font-semibold text-gray-700 dark:text-yt-text pt-1 border-t border-gray-100 dark:border-yt-border"><span>Total</span><span>$<?= number_format($venta['total'], 0, ',', '.') ?></span></div>
            </div>
        </div>
    </div>
</div>

<!-- Tarjetas móvil -->
<div class="sm:hidden space-y-3 mb-5">
    <h3 class="text-sm font-medium text-gray-700 dark:text-yt-text mb-2">Productos vendidos</h3>
    <?php foreach ($detalle as $item): ?>
    <div class="bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 transition-colors duration-300">
        <p class="font-semibold text-gray-700 dark:text-yt-text mb-2"><?= $item['producto'] ?></p>
        <div class="grid grid-cols-3 gap-2 text-xs text-gray-500 dark:text-yt-muted">
            <div><span class="block font-medium text-gray-600 dark:text-gray-400">Cantidad</span><?= $item['cantidad'] ?></div>
            <div><span class="block font-medium text-gray-600 dark:text-gray-400">Precio</span>$<?= number_format($item['precio_unitario'], 0, ',', '.') ?></div>
            <div><span class="block font-medium text-gray-600 dark:text-gray-400">Subtotal</span>$<?= number_format($item['cantidad'] * $item['precio_unitario'], 0, ',', '.') ?></div>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 transition-colors duration-300">
        <div class="space-y-1">
            <div class="flex justify-between text-sm text-gray-500 dark:text-yt-muted"><span>Subtotal</span><span>$<?= number_format($venta['subtotal'], 0, ',', '.') ?></span></div>
            <div class="flex justify-between text-sm text-gray-500 dark:text-yt-muted"><span>Impuestos</span><span>$<?= number_format($venta['impuestos'], 0, ',', '.') ?></span></div>
            <div class="flex justify-between text-base font-semibold text-gray-700 dark:text-yt-text pt-1 border-t border-gray-200 dark:border-yt-border"><span>Total</span><span>$<?= number_format($venta['total'], 0, ',', '.') ?></span></div>
        </div>
    </div>
</div>

<?php if ($venta['estado'] === 'completada' && Permission::can('ventas.cancelar')): ?>
<a href="/ventas/cancelar/<?= $venta['id'] ?>" class="text-red-400 hover:text-red-600 text-sm font-medium transition-colors duration-300" onclick="return confirm('¿Cancelar esta venta?')">
    Cancelar venta
</a>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>