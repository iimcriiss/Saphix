<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/usuarios" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-100 transition-colors duration-300">Nuevo usuario</h2>
</div>

<div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-6 w-full sm:max-w-xl transition-colors duration-300">
    <form method="POST" action="/usuarios/store">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Nombre</label>
                <input type="text" name="nombre" required placeholder="Nombre completo"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
            </div>

            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Email</label>
                <input type="email" name="email" required placeholder="correo@ejemplo.com"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Contraseña</label>
                <input type="password" name="password" required placeholder="Mínimo 8 caracteres"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Rol</label>
                <select name="rol_id" required class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                    <option value="" disabled selected>Seleccionar rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-span-1 sm:col-span-2 flex items-center gap-3">
                <input type="checkbox" name="estado" id="estado" checked class="w-4 h-4 accent-indigo-600">
                <label for="estado" class="text-sm text-gray-700 dark:text-gray-300 transition-colors duration-300">Usuario activo</label>
            </div>

        </div>

        <?php
        $modulos = [
            'productos'   => 'Productos',
            'categorias'  => 'Categorías',
            'ventas'      => 'Ventas',
            'clientes'    => 'Clientes',
            'proveedores' => 'Proveedores',
            'compras'     => 'Compras',
        ];
        $acciones = ['ver', 'crear', 'editar', 'eliminar'];
        ?>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-3 transition-colors duration-300">
                Permisos <span class="text-xs text-gray-400 font-normal ml-1">— sobreescribe los del rol</span>
            </label>
            <div class="overflow-x-auto">
                <div class="bg-gray-50 dark:bg-neutral-900 rounded-lg overflow-hidden border border-gray-300 dark:border-yt-border transition-colors duration-300 min-w-max">
                    <table class="w-full text-sm transition-colors duration-300">
                        <thead>
                            <tr class="border-b border-gray-300 dark:border-yt-border">
                                <th class="text-left px-4 py-2.5 text-xs text-gray-500 dark:text-yt-muted font-medium">Módulo</th>
                                <?php foreach ($acciones as $accion): ?>
                                    <th class="text-center px-3 py-2.5 text-xs text-gray-500 dark:text-yt-muted font-medium capitalize"><?= ucfirst($accion) ?></th>
                                <?php endforeach; ?>
                                <th class="text-center px-3 py-2.5 text-xs text-gray-500 dark:text-yt-muted font-medium">Cancelar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 dark:divide-yt-border">
                            <?php foreach ($modulos as $key => $nombre): ?>
                            <tr>
                                <td class="px-4 py-2.5 font-medium text-gray-700 dark:text-yt-text"><?= $nombre ?></td>
                                <?php foreach ($acciones as $accion): ?>
                                    <?php if ($key === 'compras' && in_array($accion, ['editar', 'eliminar'])) continue; ?>
                                    <td class="px-3 py-2.5 text-center">
                                        <input type="checkbox" name="<?= $key . '_' . $accion ?>" class="w-4 h-4 accent-indigo-600">
                                    </td>
                                <?php endforeach; ?>
                                <td class="px-3 py-2.5 text-center">
                                    <?php if ($key === 'ventas'): ?>
                                        <input type="checkbox" name="ventas_cancelar" class="w-4 h-4 accent-indigo-600">
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-yt-border transition-colors duration-300">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors duration-300">Guardar usuario</button>
            <a href="/usuarios" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-300">Cancelar</a>
        </div>

    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>