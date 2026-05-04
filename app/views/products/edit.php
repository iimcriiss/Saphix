<?php ob_start(); ?>

<!-- Encabezado -->
<div class="flex items-center gap-3 mb-6">
    <a href="/productos" class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors hover:bg-gray-100 dark:hover:bg-white/10" style="color:var(--text-muted)">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h2 class="saphix-page-title">Editar producto</h2>
        <p class="saphix-page-subtitle"><?= $producto['nombre'] ?></p>
    </div>
</div>

<div class="saphix-card p-6">
    <form method="POST" action="/productos/update/<?= $producto['id'] ?>" enctype="multipart/form-data">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

            <!-- Nombre -->
            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Nombre</label>
                <input type="text" name="nombre" required value="<?= $producto['nombre'] ?>" class="saphix-input">
            </div>

            <!-- Precio -->
            <div>
                <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Precio</label>
                <input type="number" name="precio" required min="0" step="0.01" value="<?= $producto['precio'] ?>" class="saphix-input">
            </div>

            <!-- Descripción -->
            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Descripción</label>
                <textarea name="descripcion" rows="3" class="saphix-input resize-none"><?= $producto['descripcion'] ?></textarea>
            </div>

            <!-- Stock + Categoría + Proveedor -->
            <div class="flex flex-col gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Stock</label>
                    <input type="number" name="stock" required min="0" value="<?= $producto['stock'] ?>" class="saphix-input">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Categoría</label>
                    <select name="categoria_id" class="saphix-input">
                        <option value="">Sin categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>" <?= $producto['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>>
                                <?= $categoria['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Proveedor</label>
                    <select name="proveedor_id" class="saphix-input">
                        <option value="">Sin proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                            <option value="<?= $proveedor['id'] ?>" <?= $producto['proveedor_id'] == $proveedor['id'] ? 'selected' : '' ?>>
                                <?= $proveedor['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Imagen -->
            <div class="col-span-1 sm:col-span-2">
                <label class="block text-sm font-medium mb-1.5" style="color:var(--text-primary)">Imagen del producto</label>
                <div class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-colors hover:border-indigo-400"
                     style="border-color:var(--divider);"
                     onclick="document.getElementById('imagen').click()">
                    <?php if ($producto['imagen_url']): ?>
                        <img id="preview" src="<?= $producto['imagen_url'] ?>" alt="" class="mx-auto mb-3 h-32 object-contain rounded-lg">
                        <svg id="upload-icon" class="w-10 h-10 mx-auto mb-2 hidden" style="color:var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    <?php else: ?>
                        <img id="preview" src="" alt="" class="hidden mx-auto mb-3 h-32 object-contain rounded-lg">
                        <svg id="upload-icon" class="w-10 h-10 mx-auto mb-2" style="color:var(--text-muted)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    <?php endif; ?>
                    <p id="upload-text" class="text-sm" style="color:var(--text-muted)">
                        <?= $producto['imagen_url'] ? 'Haz clic para cambiar la imagen' : 'Haz clic para subir una imagen' ?>
                    </p>
                    <p class="text-xs mt-1" style="color:var(--text-muted)">PNG, JPG, WEBP hasta 2MB</p>
                    <input type="file" id="imagen" name="imagen" accept="image/*" class="hidden" onchange="previewImage(this)">
                </div>
            </div>

            <!-- Estado -->
            <div class="flex items-center gap-3 sm:col-span-3">
                <input type="checkbox" name="estado" id="estado" <?= $producto['estado'] ? 'checked' : '' ?> class="w-4 h-4 accent-indigo-600 rounded">
                <label for="estado" class="text-sm font-medium" style="color:var(--text-primary)">Producto activo</label>
            </div>

        </div>

        <!-- Botones -->
        <div class="flex items-center gap-3 mt-6 pt-5" >
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Actualizar producto
            </button>
            <a href="/productos" class="btn-secondary">Cancelar</a>
        </div>

    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const icon    = document.getElementById('upload-icon');
    const text    = document.getElementById('upload-text');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            icon.classList.add('hidden');
            text.textContent = input.files[0].name;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>