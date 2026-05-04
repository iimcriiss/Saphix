<?php ob_start(); ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Productos</h2>
        <p class="text-sm text-gray-500 dark:text-yt-muted mt-0.5 font-medium transition-colors duration-300">Gestiona tus productos</p>
    </div>
    <!-- Botón exportar -->
    <div class="flex items-center gap-4">
        <div class="relative">
            <a onclick="toggleExport(this)" class="flex items-center gap-2 text-indigo-500 hover:text-indigo-700 text-sm font-medium cursor-pointer transition-colors duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span class="hidden sm:inline">Exportar datos</span>
            </a>
            <div id="export-menu" class="hidden absolute right-0 mt-1 w-48 bg-white dark:bg-yt-surface rounded-lg shadow-lg border border-gray-300 dark:border-yt-border z-50 overflow-hidden transition-colors duration-300">
                <a href="/exportar/productos/xlsx" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 3v18M14 3v18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                    Excel (.xlsx)
                </a>
                <a href="/exportar/productos/csv" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    CSV (.csv)
                </a>
                <a href="/exportar/productos/pdf" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF (.pdf)
                </a>
            </div>
        </div>

        <!-- Botón nueva venta -->
        <?php if (Permission::can('product.crear')): ?>
            <a href="/product/create" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300">
                + Nuevo Producto
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="hidden md:block bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
    <table class="w-full text-sm transition-colors duration-300">
        <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
            <tr>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Producto</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Categoría</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Proveedor</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Precio</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Stock</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Estado</th>
                <th class="text-left px-6 py-3 text-md text-gray-500 dark:text-gray-400 font-semibold transition-colors duration-300">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500 transition-colors duration-300">
                        No hay productos registrados
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($productos as $producto): ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-700 dark:text-gray-100 transition-colors duration-300"><?= $producto['nombre'] ?></p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 transition-colors duration-300"><?= $producto['descripcion'] ?></p>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 transition-colors duration-300">
                            <?= $producto['categoria'] ?? '—' ?>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 transition-colors duration-300">
                            <?= $producto['proveedor'] ?? '—' ?>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-100 font-medium transition-colors duration-300">
                            $<?= number_format($producto['precio'], 0, ',', '.') ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="<?= $producto['stock'] <= 5 ? 'text-red-500 font-semibold' : 'text-gray-700 dark:text-gray-300' ?> transition-colors duration-300">
                                <?= $producto['stock'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($producto['estado']): ?>
                                <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium transition-colors duration-300">Activo</span>
                            <?php else: ?>
                                <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full  font-medium transition-colors duration-300">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <?php if (Permission::can('productos.editar')): ?>
                                <a href="/productos/edit/<?= $producto['id'] ?>" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold transition-colors duration-300">Editar</a>
                            <?php endif; ?>
                            <?php if (Permission::can('productos.eliminar')): ?>
                                <a href="/productos/delete/<?= $producto['id'] ?>" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors duration-300" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
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
    <?php if (empty($productos)): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-6 text-center text-gray-400 dark:text-gray-500 transition-colors duration-300">
            No hay productos registrados
        </div>
    <?php else: ?>
        <?php foreach ($productos as $producto): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 shadow-sm transition-colors duration-300">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="font-semibold text-gray-700 dark:text-yt-text"><?= $producto['nombre'] ?></p>
                    <p class="text-xs text-gray-500 dark:text-yt-muted"><?= $producto['categoria'] ?? '—' ?></p>
                </div>
                <?php if ($producto['estado']): ?>
                    <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Activo</span>
                <?php else: ?>
                    <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Inactivo</span>
                <?php endif; ?>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs text-gray-500 dark:text-yt-muted mb-3">
                <div><span class="font-medium text-gray-600 dark:text-gray-400">Precio:</span> $<?= number_format($producto['precio'], 0, ',', '.') ?></div>
                <div><span class="font-medium text-gray-600 dark:text-gray-400">Stock:</span> <?= $producto['stock'] ?> unidades</div>
                <div class="col-span-2"><span class="font-medium text-gray-600 dark:text-gray-400">Proveedor:</span> <?= $producto['proveedor'] ?? '—' ?></div>
            </div>
            <div class="flex items-center gap-3 pt-3 border-t border-gray-200 dark:border-yt-border">
                <?php if (Permission::can('productos.editar')): ?>
                    <a href="/productos/edit/<?= $producto['id'] ?>" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold transition-colors duration-300">Editar</a>
                <?php endif; ?>
                <?php if (Permission::can('productos.eliminar')): ?>
                    <a href="/productos/delete/<?= $producto['id'] ?>" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors duration-300" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
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