<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/categorias" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Editar categoría</h2>
</div>

<div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-6 max-w-xl transition-colors duration-300">
    <form method="POST" action="/categorias/update/<?= $categoria['id'] ?>">

        <div class="flex flex-col gap-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Nombre</label>
                <input type="text" name="nombre" required
                    value="<?= $categoria['nombre'] ?>"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300"">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Descripción</label>
                <textarea name="descripcion" rows="3"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300""><?= $categoria['descripcion'] ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Categoría padre</label>
                <select name="categoria_padre_id"
                    class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300"">
                    <option value="">Sin categoría padre</option>
                    <?php foreach ($padres as $padre): ?>
                        <?php if ($padre['id'] !== $categoria['id']): ?>
                            <option value="<?= $padre['id'] ?>" <?= $categoria['categoria_padre_id'] == $padre['id'] ? 'selected' : '' ?>>
                                <?= $padre['nombre'] ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 transition-colors duration-300">Opcional — si esta categoría pertenece a otra</p>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="estado" id="estado"
                    <?= $categoria['estado'] ? 'checked' : '' ?>
                    class="w-4 h-4 accent-indigo-600">
                <label for="estado" class="text-sm text-gray-700 dark:text-gray-300 transition-colors duration-300">Categoría activa</label>
            </div>

        </div>

        <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-yt-border transition-colors duration-300">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors duration-300">
                Actualizar categoría
            </button>
            <a href="/categorias" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-300">
                Cancelar
            </a>
        </div>

    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>