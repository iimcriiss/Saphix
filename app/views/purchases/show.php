<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/compras" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Detalle de compra #<?= $compra['id'] ?></h2>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-5 mb-6">
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1 transition-colors duration-300">Proveedor</p>
        <p class="font-medium text-gray-700 dark:text-yt-text transition-colors duration-300"><?= $compra['proveedor'] ?? '—' ?></p>
    </div>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1 transition-colors duration-300">Fecha</p>
        <p class="font-medium text-gray-700 dark:text-yt-text transition-colors duration-300"><?= date('d/m/Y H:i', strtotime($compra['fecha'])) ?></p>
    </div>
    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-5 transition-colors duration-300">
        <p class="text-xs text-gray-500 dark:text-yt-muted mb-1 transition-colors duration-300">Total</p>
        <p class="font-semibold text-xl text-gray-700 dark:text-yt-text transition-colors duration-300">$<?= number_format($compra['total'], 0, ',', '.') ?></p>
    </div>
</div>

<div class="hidden md:block bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border overflow-hidden transition-colors duration-300">
    <div class="px-6 py-4 border-b border-gray-300 dark:border-yt-border transition-colors duration-300">
        <h3 class="text-sm font-medium text-gray-700 dark:text-yt-text transition-colors duration-300">Productos comprados</h3>
    </div>
    <table class="w-full text-sm transition-colors duration-300">
        <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
            <tr>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-yt-muted font-semibold transition-colors duration-300">Producto</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-yt-muted font-semibold transition-colors duration-300">Cantidad</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-yt-muted font-semibold transition-colors duration-300">Costo unitario</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-yt-muted font-semibold transition-colors duration-300">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
            <?php foreach ($detalle as $item): ?>
            <tr>
                <td class="px-6 py-4 font-medium text-gray-700 dark:text-yt-text transition-colors duration-300"><?= $item['producto'] ?></td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 transition-colors duration-300"><?= $item['cantidad'] ?></td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300 transition-colors duration-300">$<?= number_format($item['costo_unitario'], 0, ',', '.') ?></td>
                <td class="px-6 py-4 font-medium text-gray-700 dark:text-yt-text transition-colors duration-300">$<?= number_format($item['cantidad'] * $item['costo_unitario'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Vista tarjetas (móvil) -->
<div class="md:hidden space-y-3 mt-3">
    <h3 class="text-sm font-medium text-gray-700 dark:text-yt-text mb-2">Productos comprados</h3>
    <?php foreach ($detalle as $item): ?>
    <div class="bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 transition-colors duration-300">
        <p class="font-semibold text-gray-700 dark:text-yt-text mb-2"><?= $item['producto'] ?></p>
        <div class="grid grid-cols-3 gap-2 text-xs text-gray-500 dark:text-yt-muted">
            <div><span class="block font-medium text-gray-600 dark:text-gray-400">Cantidad</span><?= $item['cantidad'] ?></div>
            <div><span class="block font-medium text-gray-600 dark:text-gray-400">Costo</span>$<?= number_format($item['costo_unitario'], 0, ',', '.') ?></div>
            <div><span class="block font-medium text-gray-600 dark:text-gray-400">Subtotal</span>$<?= number_format($item['cantidad'] * $item['costo_unitario'], 0, ',', '.') ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>