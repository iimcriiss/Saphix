<?php ob_start(); ?>

<div class="flex items-center gap-3 mb-6">
    <a href="/ventas" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <h2 class="text-lg font-bold text-gray-700 dark:text-yt-text transition-colors duration-300">Nueva venta</h2>
</div>

<form method="POST" action="/ventas/store">

    <?php if (isset($_SESSION['stock_error'])): ?>
        <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-1">Stock insuficiente para registrar la venta:</p>
                    <ul class="space-y-0.5">
                        <?php foreach ($_SESSION['stock_error'] as $err): ?>
                            <li class="text-sm text-red-600 dark:text-red-300">• <?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['stock_error']); ?>
    <?php endif; ?>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-6 mb-5 transition-colors duration-300">
        <h3 class="text-sm font-medium text-gray-700 dark:text-yt-muted mb-4 transition-colors duration-300">Información general</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Cliente</label>
                <select name="cliente_id" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                    <option value="">Venta al mostrador</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Método de pago</label>
                <select name="metodo_pago" required class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="nequi">Nequi</option>
                    <option value="daviplata">Daviplata</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-yt-text mb-1 transition-colors duration-300">Impuesto (%)</label>
                <select name="impuesto" onchange="calcularTotal()" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                    <option value="0">Sin impuesto (0%)</option>
                    <option value="5">5%</option>
                    <option value="19">IVA (19%)</option>
                </select>
            </div>

        </div>
    </div>

    <div class="bg-gray-200 dark:bg-yt-surface rounded-xl border border-gray-300 dark:border-yt-border p-4 sm:p-6 mb-5 transition-colors duration-300">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-700 dark:text-yt-text transition-colors duration-300">Productos</h3>
            <button type="button" onclick="agregarFila()" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium transition-colors duration-300">+ Agregar producto</button>
        </div>

        <!-- Tabla en desktop -->
        <div class="hidden sm:block">
            <table class="w-full text-sm transition-colors duration-300">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-yt-border transition-colors duration-300">
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium">Producto</th>
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium w-32">Cantidad</th>
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium w-40">Precio unitario</th>
                        <th class="text-left pb-3 text-xs text-gray-500 dark:text-yt-muted font-medium w-36">Subtotal</th>
                        <th class="w-10"></th>
                    </tr>
                </thead>
                <tbody id="tabla-productos">
                    <tr class="fila-producto">
                        <td class="py-2 pr-3">
                            <select name="producto_id[]" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" onchange="autocompletarPrecio(this)">
                                <option value="">Seleccionar producto</option>
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?= $producto['id'] ?>" data-precio="<?= $producto['precio'] ?>" data-stock="<?= $producto['stock'] ?>">
                                        <?= $producto['nombre'] ?> (Stock: <?= $producto['stock'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="py-2 pr-3"><input type="number" name="cantidad[]" min="1" value="1" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()"></td>
                        <td class="py-2 pr-3"><input type="number" name="precio_unitario[]" min="0" value="0" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()"></td>
                        <td class="py-2 pr-3"><span class="subtotal text-gray-700 dark:text-gray-300 font-medium">$0</span></td>
                        <td class="py-2"><button type="button" onclick="eliminarFila(this)" class="text-red-400 hover:text-red-600 transition-colors duration-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg></button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tarjetas en móvil -->
        <div class="sm:hidden space-y-3" id="tabla-productos-mobile">
            <div class="fila-producto bg-white dark:bg-yt-elevated rounded-lg border border-gray-300 dark:border-yt-border p-3 space-y-2 transition-colors duration-300">
                <select name="producto_id[]" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" onchange="autocompletarPrecio(this)">
                    <option value="">Seleccionar producto</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?= $producto['id'] ?>" data-precio="<?= $producto['precio'] ?>" data-stock="<?= $producto['stock'] ?>">
                            <?= $producto['nombre'] ?> (Stock: <?= $producto['stock'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-500 dark:text-yt-muted mb-1 block">Cantidad</label>
                        <input type="number" name="cantidad[]" min="1" value="1" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 dark:text-yt-muted mb-1 block">Precio unitario</label>
                        <input type="number" name="precio_unitario[]" min="0" value="0" class="w-full border border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300" oninput="calcularTotal()">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500 dark:text-yt-muted">Subtotal: <span class="subtotal font-semibold text-gray-700 dark:text-gray-300">$0</span></span>
                    <button type="button" onclick="eliminarFila(this)" class="text-red-400 hover:text-red-600 transition-colors duration-300"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg></button>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 pt-4 border-t border-gray-100 dark:border-yt-border transition-colors duration-300">
            <div class="text-right space-y-1">
                <div class="flex justify-between gap-10 sm:gap-16 text-sm text-gray-500 dark:text-gray-400"><span>Subtotal</span><span id="valor-subtotal">$0</span></div>
                <div class="flex justify-between gap-10 sm:gap-16 text-sm text-gray-500 dark:text-gray-400"><span>Impuestos</span><span id="valor-impuestos">$0</span></div>
                <div class="flex justify-between gap-10 sm:gap-16 text-base font-semibold text-gray-700 dark:text-yt-text pt-1 border-t border-gray-100 dark:border-yt-border"><span>Total</span><span id="total-venta">$0</span></div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" onclick="return validarProductos()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-colors duration-300">Registrar venta</button>
        <a href="/ventas" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-300">Cancelar</a>
    </div>

</form>

<script>
    function autocompletarPrecio(select) {
        const option = select.options[select.selectedIndex];
        const precio = option.dataset.precio || 0;
        const stock = parseInt(option.dataset.stock) || 0;
        const fila = select.closest('.fila-producto');

        fila.querySelector('[name="precio_unitario[]"]').value = precio;

        // Límite máximo en el input de cantidad
        const inputCantidad = fila.querySelector('[name="cantidad[]"]');
        inputCantidad.max = stock;

        // Tag de stock disponible
        let stockTag = fila.querySelector('.stock-tag');
        if (!stockTag) {
            stockTag = document.createElement('p');
            stockTag.className = 'stock-tag text-xs mt-1';
            select.parentNode.appendChild(stockTag);
        }
        if (stock <= 0) {
            stockTag.className = 'stock-tag text-xs mt-1 text-red-500 font-medium';
            stockTag.textContent = 'Sin stock disponible';
        } else if (stock <= 5) {
            stockTag.className = 'stock-tag text-xs mt-1 text-amber-500 font-medium';
            stockTag.textContent = 'Stock bajo: ' + stock + ' unidades';
        } else {
            stockTag.className = 'stock-tag text-xs mt-1 text-green-600 font-medium';
            stockTag.textContent = 'Stock disponible: ' + stock + ' unidades';
        }

        calcularTotal();
    }

    function calcularTotal() {
        let subtotal = 0;
        let hayErrorStock = false;

        document.querySelectorAll('.fila-producto').forEach(fila => {
            const select = fila.querySelector('select[name="producto_id[]"]');
            const option = select?.options[select.selectedIndex];
            const stock = parseInt(option?.dataset.stock) || 0;
            const cantidad = parseFloat(fila.querySelector('[name="cantidad[]"]').value) || 0;
            const precio = parseFloat(fila.querySelector('[name="precio_unitario[]"]').value) || 0;
            const sub = cantidad * precio;

            fila.querySelector('.subtotal').textContent = '$' + sub.toLocaleString('es-CO');
            subtotal += sub;

            // Input en rojo si supera el stock
            const inputCantidad = fila.querySelector('[name="cantidad[]"]');
            if (stock > 0 && cantidad > stock) {
                inputCantidad.classList.add('border-red-500', 'ring-1', 'ring-red-400');
                hayErrorStock = true;
            } else {
                inputCantidad.classList.remove('border-red-500', 'ring-1', 'ring-red-400');
            }
        });

        // Bloquear submit si hay error de stock
        const btnSubmit = document.querySelector('button[type="submit"]');
        if (hayErrorStock) {
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        const impuestoPct = parseFloat(document.querySelector('[name="impuesto"]').value) || 0;
        const impuestos = subtotal * (impuestoPct / 100);
        const total = subtotal + impuestos;
        document.getElementById('valor-subtotal').textContent = '$' + subtotal.toLocaleString('es-CO');
        document.getElementById('valor-impuestos').textContent = '$' + impuestos.toLocaleString('es-CO');
        document.getElementById('total-venta').textContent = '$' + total.toLocaleString('es-CO');
    }

    function agregarFila() {
        const isMobile = window.innerWidth < 640;
        if (isMobile) {
            const container = document.getElementById('tabla-productos-mobile');
            const template = container.querySelector('.fila-producto');
            const nueva = template.cloneNode(true);
            nueva.querySelector('[name="cantidad[]"]').value = 1;
            nueva.querySelector('[name="precio_unitario[]"]').value = 0;
            nueva.querySelector('.subtotal').textContent = '$0';
            nueva.querySelector('select').value = '';
            nueva.querySelectorAll('input').forEach(i => i.addEventListener('input', calcularTotal));
            nueva.querySelector('select').addEventListener('change', function() {
                autocompletarPrecio(this);
            });
            container.appendChild(nueva);
        } else {
            const tbody = document.getElementById('tabla-productos');
            const template = tbody.querySelector('.fila-producto');
            const nueva = template.cloneNode(true);
            nueva.querySelector('[name="cantidad[]"]').value = 1;
            nueva.querySelector('[name="precio_unitario[]"]').value = 0;
            nueva.querySelector('.subtotal').textContent = '$0';
            nueva.querySelector('select').value = '';
            nueva.querySelectorAll('input').forEach(i => i.addEventListener('input', calcularTotal));
            nueva.querySelector('select').addEventListener('change', function() {
                autocompletarPrecio(this);
            });
            tbody.appendChild(nueva);
        }
    }

    function eliminarFila(btn) {
        const isMobile = window.innerWidth < 640;
        const container = isMobile ? document.getElementById('tabla-productos-mobile') : document.getElementById('tabla-productos');
        const filas = container.querySelectorAll('.fila-producto');
        if (filas.length > 1) {
            btn.closest('.fila-producto').remove();
            calcularTotal();
        }
    }

    function validarProductos() {
        const selects = document.querySelectorAll('select[name="producto_id[]"]');
        const alguno = Array.from(selects).some(s => s.value !== '');
        if (!alguno) {
            alert('Debes seleccionar al menos un producto para registrar la venta.');
            return false;
        }
        return true;
    }
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/main.php'; ?>