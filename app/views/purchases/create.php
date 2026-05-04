<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/compras" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Nueva compra</h2>
</div>

<form method="POST" action="/compras/store">

    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-6 mb-5 transition-colors duration-300">
        <h3 class="text-sm font-medium text-gray-700 dark:text-yt-muted mb-4 transition-colors duration-300">Información general</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Proveedor</label>
                <select name="proveedor_id" required class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                    <option value="" disabled selected>Seleccionar proveedor</option>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <option value="<?= $proveedor['id'] ?>"><?= $proveedor['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Fecha</label>
                <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
            </div>
        </div>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-6 mb-5 transition-colors duration-300">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-700 dark:text-yt-text transition-colors duration-300">Productos</h3>
            <button type="button" onclick="agregarFila()" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors duration-300">+ Agregar producto</button>
        </div>

        <div class="hidden sm:block">
            <table class="w-full text-sm transition-colors duration-300">
                <thead>
                    <tr class="border-b border-gray-300 dark:border-yt-border">
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium">Producto</th>
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium w-32">Cantidad</th>
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium w-40">Costo unitario</th>
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium w-36">Subtotal</th>
                        <th class="w-10"></th>
                    </tr>
                </thead>
                <tbody id="tabla-productos">
                    <tr class="fila-producto">
                        <td class="py-2 pr-3">
                            <select name="producto_id[]" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" onchange="calcularTotal()">
                                <option value="">Seleccionar producto</option>
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="py-2 pr-3"><input type="number" name="cantidad[]" min="1" value="1" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()"></td>
                        <td class="py-2 pr-3"><input type="number" name="costo_unitario[]" min="0" value="0" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()"></td>
                        <td class="py-2 pr-3"><span class="subtotal text-gray-700 dark:text-gray-300 font-medium">$0</span></td>
                        <td class="py-2"><button type="button" onclick="eliminarFila(this)" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="sm:hidden space-y-3" id="tabla-productos-mobile">
            <div class="fila-producto bg-white dark:bg-yt-elevated rounded-lg border border-gray-300 dark:border-yt-border p-3 space-y-2 transition-colors duration-300">
                <select name="producto_id[]" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" onchange="calcularTotal()">
                    <option value="">Seleccionar producto</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?= $producto['id'] ?>"><?= $producto['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-500 dark:text-yt-muted mb-1 block">Cantidad</label>
                        <input type="number" name="cantidad[]" min="1" value="1" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-yt-muted mb-1 block">Costo unitario</label>
                        <input type="number" name="costo_unitario[]" min="0" value="0" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500 dark:text-yt-muted">Subtotal: <span class="subtotal font-semibold text-gray-700 dark:text-gray-300">$0</span></span>
                    <button type="button" onclick="eliminarFila(this)" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 pt-4 border-t border-gray-100 dark:border-yt-border transition-colors duration-300">
            <div class="text-right">
                <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                <p id="total-compra" class="text-2xl font-semibold text-gray-700 dark:text-gray-100">$0</p>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors duration-300">Registrar compra</button>
        <a href="/compras" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-300">Cancelar</a>
    </div>

</form>

<script>
    function calcularTotal() {
        let total = 0;
        document.querySelectorAll('.fila-producto').forEach(fila => {
            const cantidad = parseFloat(fila.querySelector('[name="cantidad[]"]').value) || 0;
            const costo    = parseFloat(fila.querySelector('[name="costo_unitario[]"]').value) || 0;
            const subtotal = cantidad * costo;
            fila.querySelector('.subtotal').textContent = '$' + subtotal.toLocaleString('es-CO');
            total += subtotal;
        });
        document.getElementById('total-compra').textContent = '$' + total.toLocaleString('es-CO');
    }

    function agregarFila() {
        const isMobile = window.innerWidth < 640;
        const container = isMobile
            ? document.getElementById('tabla-productos-mobile')
            : document.getElementById('tabla-productos');
        const template = container.querySelector('.fila-producto');
        const nueva = template.cloneNode(true);
        nueva.querySelector('[name="cantidad[]"]').value = 1;
        nueva.querySelector('[name="costo_unitario[]"]').value = 0;
        nueva.querySelector('.subtotal').textContent = '$0';
        nueva.querySelector('select').value = '';
        nueva.querySelectorAll('input').forEach(i => i.addEventListener('input', calcularTotal));
        nueva.querySelectorAll('select').forEach(s => s.addEventListener('change', calcularTotal));
        container.appendChild(nueva);
    }

    function eliminarFila(btn) {
        const isMobile = window.innerWidth < 640;
        const container = isMobile
            ? document.getElementById('tabla-productos-mobile')
            : document.getElementById('tabla-productos');
        const filas = container.querySelectorAll('.fila-producto');
        if (filas.length > 1) {
            btn.closest('.fila-producto').remove();
            calcularTotal();
        }
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>