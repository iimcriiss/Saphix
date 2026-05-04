<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/clientes" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Nuevo cliente</h2>
</div>

<div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-6 max-w-xl sm:max-w-xl w-full transition-colors duration-300">
    <form method="POST" action="/clientes/store">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Nombre</label>
                <input type="text" name="nombre" required
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300"
                    placeholder="Nombre del cliente">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Email</label>
                <input type="email" name="email"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300"
                    placeholder="correo@ejemplo.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Teléfono</label>
                <input type="text" name="telefono"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300"
                    placeholder="Ej: 3001234567">
            </div>

            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Dirección</label>
                <textarea name="direccion" rows="2"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300"
                    placeholder="Dirección del cliente"></textarea>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-yt-border transition-colors duration-300">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors duration-300">
                Guardar cliente
            </button>
            <a href="/clientes" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-300">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>