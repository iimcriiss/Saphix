<?php ob_start(); ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Usuarios</h2>
        <p class="text-sm text-gray-500 dark:text-yt-muted mt-0.5 font-medium transition-colors duration-300">Gestiona los usuarios del sistema</p>
    </div>
    <div class="flex items-center gap-4">
        <div class="relative">
            <a onclick="toggleExport(this)" class="flex items-center gap-2 text-indigo-500 hover:text-indigo-700 text-sm font-medium cursor-pointer transition-colors duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span class="hidden sm:inline">Exportar datos</span>
            </a>
            <div id="export-menu" class="hidden absolute right-0 mt-1 w-48 bg-white dark:bg-yt-surface rounded-lg shadow-lg border border-gray-300 dark:border-yt-border z-50 overflow-hidden transition-colors duration-300">
                <a href="/exportar/usuarios/xlsx" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M10 3v18M14 3v18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                    Excel (.xlsx)
                </a>
                <a href="/exportar/usuarios/csv" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    CSV (.csv)
                </a>
                <a href="/exportar/usuarios/pdf" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-neutral-900 transition-colors duration-300">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF (.pdf)
                </a>
            </div>
        </div>
        <?php if (Permission::can('usuarios.crear')): ?>
            <a href="/usuarios/create" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-300 whitespace-nowrap">
                + Nuevo usuario
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Tabla desktop -->
<div class="hidden md:block bg-white dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border shadow-md overflow-hidden transition-colors duration-300">
    <table class="w-full text-sm transition-colors duration-300">
        <thead class="bg-gray-200 dark:bg-yt-elevated transition-colors duration-300">
            <tr>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Usuario</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Email</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Rol</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Estado</th>
                <th class="text-left px-6 py-3 text-xs text-gray-500 dark:text-gray-400 font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-300 dark:divide-yt-border transition-colors duration-300">
            <?php if (empty($usuarios)): ?>
                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">No hay usuarios registrados</td></tr>
            <?php else: ?>
                <?php foreach ($usuarios as $usuario): ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700/30 transition-colors duration-300">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                <?= strtoupper(substr($usuario['nombre'], 0, 2)) ?>
                            </div>
                            <span class="font-medium text-gray-700 dark:text-gray-100"><?= $usuario['nombre'] ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= $usuario['email'] ?></td>
                    <td class="px-6 py-4">
                        <span class="bg-indigo-200 dark:bg-indigo-800 text-indigo-600 border border-indigo-400 dark:text-indigo-300 text-xs px-2 py-1 rounded-full font-medium"><?= $usuario['rol'] ?? '—' ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if ($usuario['estado']): ?>
                            <span class="bg-green-200 dark:bg-green-800 text-green-700 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Activo</span>
                        <?php else: ?>
                            <span class="bg-red-200 dark:bg-red-800 text-red-700 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Inactivo</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <a href="/usuarios/edit/<?= $usuario['id'] ?>" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold transition-colors duration-300">Editar</a>
                        <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                            <a href="/usuarios/delete/<?= $usuario['id'] ?>" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors duration-300" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Tarjetas móvil -->
<div class="md:hidden space-y-3">
    <?php if (empty($usuarios)): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-6 text-center text-gray-400 dark:text-gray-500 transition-colors duration-300">
            No hay usuarios registrados
        </div>
    <?php else: ?>
        <?php foreach ($usuarios as $usuario): ?>
        <div class="bg-ytlight-surface dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 shadow-sm transition-colors duration-300">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        <?= strtoupper(substr($usuario['nombre'], 0, 2)) ?>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 dark:text-yt-text"><?= $usuario['nombre'] ?></p>
                        <p class="text-xs text-gray-500 dark:text-yt-muted"><?= $usuario['email'] ?></p>
                    </div>
                </div>
                <?php if ($usuario['estado']): ?>
                    <span class="bg-green-200 text-green-700 dark:bg-green-800 border border-green-400 dark:text-green-300 text-xs px-2 py-1 rounded-full font-medium">Activo</span>
                <?php else: ?>
                    <span class="bg-red-200 text-red-700 dark:bg-red-800 border border-red-400 dark:text-red-300 text-xs px-2 py-1 rounded-full font-medium">Inactivo</span>
                <?php endif; ?>
            </div>
            <div class="text-xs text-gray-500 dark:text-yt-muted mb-3">
                <span class="font-medium text-gray-600 dark:text-gray-400">Rol:</span>
                <span class="bg-indigo-200 dark:bg-indigo-800 text-indigo-600 border border-indigo-400 dark:text-indigo-300 text-xs px-2 py-0.5 rounded-full font-medium ml-1"><?= $usuario['rol'] ?? '—' ?></span>
            </div>
            <div class="flex items-center gap-3 pt-3 border-t border-gray-200 dark:border-yt-border">
                <a href="/usuarios/edit/<?= $usuario['id'] ?>" class="text-indigo-500 hover:text-indigo-700 text-xs font-bold transition-colors duration-300">Editar</a>
                <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                    <a href="/usuarios/delete/<?= $usuario['id'] ?>" class="text-red-400 hover:text-red-600 text-xs font-bold transition-colors duration-300" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</a>
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