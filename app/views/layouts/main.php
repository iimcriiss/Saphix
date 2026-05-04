<!DOCTYPE html>
<html lang="es" class="<?= isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/img/icono_saphix.png">
    <title><?= isset($title) ? $title . ' — Saphix' : 'Saphix' ?></title>
    <style>
        * {
            transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }
    </style>
    <script>
        // Si no hay sesión activa y se intenta acceder, redirigir al login
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                window.location.reload();
            }
        });
    </script>

</head>

<body class="bg-gray-200 dark:bg-yt-bg font-sans transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">

        <!-- Overlay móvil -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/50 z-30 md:hidden"></div>

        <!-- Sidebar -->
        <aside class="w-60 bg-indigo-950 flex flex-col flex-shrink-0 fixed md:relative h-full z-40 -translate-x-full md:translate-x-0 transition-transform duration-300" id="sidebar">

            <!-- Logo -->
            <div class="px-5 py-5 border-b border-white/10">
                <img src="/img/saphix_logo.svg" alt="Saphix Logo" class="mx-auto mb-3 object-contain w-[220px]">
                <small class="text-indigo-300/70 text-xs block mt-1 tracking-wide">
                    Gestión de inventario y ventas
                </small>
            </div>

            <!-- Navegación -->
            <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-1">

                <p class="text-indigo-400/60 text-xs uppercase tracking-widest px-3 mb-2">Principal</p>

                <a href="/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'dashboard' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                    <svg class="w-4 h-4 flex-shrink-0 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <?php if (Permission::can('ventas.ver')): ?>
                    <a href="/ventas" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'ventas' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Ventas
                    </a>
                <?php endif; ?>

                <?php if (Permission::can('clientes.ver')): ?>
                    <a href="/clientes" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'clientes' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Clientes
                    </a>
                <?php endif; ?>

                <?php if (Permission::can('productos.ver')): ?>
                    <a href="/productos" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'productos' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Productos
                    </a>
                <?php endif; ?>

                <?php if (Permission::can('categorias.ver')): ?>
                    <a href="/categorias" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'categorias' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z" />
                        </svg>
                        Categorías
                    </a>
                <?php endif; ?>

                <p class="text-indigo-400/60 text-xs uppercase tracking-widest px-3 mb-2 mt-5">Gestión</p>

                <?php if ($_SESSION['user_role'] === 'Admin'): ?>
                    <a href="/reportes/cierreCaja" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'reportes' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Reportes
                    </a>
                <?php endif; ?>

                <?php if (Permission::can('proveedores.ver')): ?>
                    <a href="/proveedores" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'proveedores' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        Proveedores
                    </a>
                <?php endif; ?>

                <?php if (Permission::can('compras.ver')): ?>
                    <a href="/compras" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'compras' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Compras
                    </a>
                <?php endif; ?>

                <?php if (Permission::can('usuarios.ver')): ?>
                    <a href="/usuarios" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors duration-300 <?= isset($activeMenu) && $activeMenu === 'usuarios' ? 'bg-indigo-500/20 text-indigo-300 font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Usuarios
                    </a>
                <?php endif; ?>

            </nav>

            <!-- Usuario activo -->
            <div class="px-4 py-4 border-t border-white/10 relative">
                <button onclick="toggleUserMenu()" class="w-full flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 transition-colors duration-300">
                        <?= isset($userInitials) ? $userInitials : 'US' ?>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-white text-sm font-medium truncate transition-colors"><?= isset($userName) ? $userName : 'Usuario' ?></p>
                        <p class="text-indigo-400 text-xs truncate transition-colors"><?= isset($userRole) ? $userRole : 'Rol' ?></p>
                    </div>
                    <svg id="user-arrow" class="w-4 h-4 text-white/30 group-hover:text-white/60 transition-all flex-shrink-0 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="user-menu" class="hidden fixed left-4 w-52 bg-ytlight-elevated dark:bg-yt-surface rounded-xl shadow-lg border border-ytlight-border dark:border-yt-border overflow-hidden z-50 transition-colors duration-300">
                    <div class="px-4 py-3 border-b border-gray-400/40 bg-gray-300/50 dark:bg-yt-elevated dark:border-yt-border transition-colors duration-300">
                        <p class="text-sm font-medium text-ytlight-text dark:text-yt-text transition-colors"><?= isset($userName) ? $userName : 'Usuario' ?></p>
                        <p class="text-xs text-ytlight-muted dark:text-yt-muted transition-colorstransition-colors"><?= isset($userRole) ? $userRole : 'Rol' ?></p>
                    </div>
                    <button onclick="togglePasswordModal()" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-ytlight-text dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors text-left duration-300">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Cambiar contraseña
                    </button>
                    <a href="/logout" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500  hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar sesión
                    </a>
                </div>
            </div>



        </aside>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col overflow-hidden">



            <!-- Topbar -->
            <header class="bg-gray-300/50 dark:bg-yt-surface border-b border-gray-400/40 dark:border-yt-border px-6 h-14 flex items-center justify-between flex-shrink-0 gap-4 transition-colors duration-300">

                <!-- Botón hamburguesa móvil -->
                <button onclick="toggleSidebar()" class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-200 dark:hover:bg-yt-elevated transition-colors duration-300">
                    <svg class="w-5 h-5 text-gray-500 dark:text-yt-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Buscador centrado -->
                <div class="flex-1 flex justify-center">
                    <div class="relative w-full max-w-xs sm:max-w-sm" id="search-wrapper">
                        <div class="flex items-center gap-2 bg-white dark:bg-yt-elevated border border-gray-300 dark:border-yt-border rounded-full px-4 py-2 shadow-md transition-colors duration-300">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" id="search-input" placeholder="Buscar en Saphix..." value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>"
                                class="bg-transparent text-sm text-gray-600 dark:text-yt-text placeholder-gray-400 dark:placeholder-yt-muted outline-none w-full transition-colors duration-300">
                            <kbd class="hidden sm:inline-flex text-xs text-gray-500 dark:text-yt-muted bg-gray-200 dark:bg-yt-surface px-1.5 py-0.5 rounded border border-gray-300 dark:border-yt-border transition-colors duration-300">↵</kbd>
                        </div>

                        <!-- Dropdown resultados -->
                        <div id="search-dropdown" class="hidden absolute top-full mt-2 bg-gray-50 dark:bg-yt-surface border border-gray-300 dark:border-yt-border rounded-xl shadow-lg z-50 overflow-hidden transition-colors duration-300" style="left: 100%; transform: translateX(-95%); width: min(420px, 90vw);">
                            <div id="search-results" class="max-h-80 overflow-y-auto "></div>
                        </div>
                    </div>
                </div>

                <!-- Notificaciones -->
                <div class="relative">
                    <button onclick="toggleNotificaciones()" class="relative w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-200 dark:hover:bg-yt-elevated transition-colors duration-300">
                        <svg class="w-6 h-6 text-gray-500 dark:text-yt-muted transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <?php if ($totalNotificaciones > 0): ?>
                            <span class="absolute top-0.5 right-0.5 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-medium transition-colors duration-300">
                                <?= $totalNotificaciones > 9 ? '9+' : $totalNotificaciones ?>
                            </span>
                        <?php endif; ?>
                    </button>

                    <!-- Dropdown notificaciones -->
                    <div id="notif-menu" class="hidden fixed bg-white dark:bg-yt-surface border border-gray-200 dark:border-yt-border rounded-xl shadow-lg z-50 overflow-hidden transition-colors duration-300" style="width: min(288px, calc(100vw - 16px));">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-yt-border transition-colors">
                            <span class="text-sm font-medium text-gray-800 dark:text-yt-text">Notificaciones</span>
                            <?php if ($totalNotificaciones > 0): ?>
                                <a href="/notificaciones/marcarTodas" class="text-xs text-indigo-500 hover:text-indigo-700 transition-colors duration-300">Marcar todas leídas</a>
                            <?php endif; ?>
                        </div>

                        <?php if (empty($notificaciones)): ?>
                            <p class="px-4 py-6 text-center text-sm text-gray-400 dark:text-yt-muted transition-colors duration-300">Sin notificaciones nuevas</p>
                        <?php else: ?>
                            <ul class="divide-y divide-gray-100 dark:divide-yt-border max-h-64 overflow-y-auto">
                                <?php foreach ($notificaciones as $notif): ?>
                                    <li class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-yt-elevated transition-colors duration-300">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-gray-700 dark:text-yt-text transition-colors"><?= $notif['mensaje'] ?></p>
                                            <p class="text-xs text-gray-400 dark:text-yt-muted mt-0.5 transition-colors"><?= $notif['created_at'] ?></p>
                                        </div>
                                        <a href="/notificaciones/marcarLeida/<?= $notif['id'] ?>"
                                            class="flex-shrink-0 bg-indigo-100 dark:bg-indigo-950 hover:bg-indigo-200 dark:hover:bg-indigo-900 text-indigo-600 dark:text-indigo-400 border border-indigo-300 dark:border-indigo-800 text-xs px-2 py-0.5 rounded-md transition-colors duration-300">
                                            Leído
                                        </a>
                                    </li>

                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

                <!--Selector tema y rol-->
                <div class="flex items-center gap-5">
                    <button onclick="toggleTheme()" class="w-10 h-10 flex items-center justify-center rounded-lg">
                        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1728 1792" class="w-6 h-6" style="display:none" fill="#aaaaaa">
                            <path d="M873 416q-130 0-240.5 64.5t-175 175T393 896t64.5 240.5t175 175T873 1376t240.5-64.5t175-175T1353 896t-64.5-240.5t-175-175T873 416zm853 757q0 6-7 12t-13 8l-293 97v306q0 16-13 26q-14 9-29 4l-292-94l-180 248q-9 12-26 12t-26-12l-180-248l-292 94q-15 5-29-4q-12-8-14-26v-306l-292-97q-16-5-20-20q-5-16 4-29l180-248L24 648q-9-13-4-29q4-15 20-20l292-97V196q2-18 14-26q14-9 29-4l292 94L847 12q9-12 26-12t26 12l180 248l292-94q15-5 29 4q13 10 13 26v306l293 97q6 2 13 8t7 12q4 15-4 29l-181 248l181 248q8 14 4 29zm-277-277q0-157-77-289.5T1162.5 397T873 320t-289.5 77T374 606.5T297 896q0 118 46 225t123 184t183.5 122.5T873 1473q158 0 290.5-77.5t209-210T1449 896z" />
                        </svg>
                        <svg id="icon-moon" fill="none" stroke="#6b7280" viewBox="0 0 24 24" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                    <span class="bg-indigo-200 dark:bg-indigo-800 text-indigo-600 border border-indigo-400 dark:text-indigo-300 text-xs px-2 py-1 rounded-full font-medium">
                        <?= isset($userRole) ? $userRole : 'Admin' ?>
                    </span>
                </div>
            </header>

            <!-- Área de contenido -->
            <main class="flex-1 overflow-y-auto p-3 sm:p-6 bg-ytlight-bg dark:bg-yt-bg transition-colors duration-300">
                <?= $content ?>
            </main>

        </div>
    </div>


    <!-- Modal cambiar contraseña -->
    <div id="password-modal" class="fixed inset-0 bg-black/50 z-50 items-center justify-center min-h-screen flex px-4" style="display:none">
        <div class="bg-ytlight-bg dark:bg-yt-elevated rounded-xl p-6 w-full max-w-sm mx-auto shadow-xl transition-colors duration-300">
            <h3 class="text-base font-semibold text-ytlight-text  dark:text-yt-text mb-1 transition-colors duration-300">Cambiar contraseña</h3>
            <p class="text-xs text-ytlight-muted dark:text-yt-muted mb-4 transition-colors duration-300">Los campos marcados con <span class="text-red-500">*</span> son obligatorios</p>

            <form method="POST" action="/perfil/password" id="password-form">
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ytlight-text dark:text-yt-text mb-1 transition-colors duration-300">
                            Contraseña actual <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_actual" id="pwd_actual" required
                                class="w-full border bg-ytlight-elevated border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                            <button type="button" onclick="togglePwd('pwd_actual', 'eye1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                                <svg id="eye1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ytlight-text dark:text-yt-text mb-1 transition-colors duration-300">
                            Nueva contraseña <span class="text-red-500">*</span>
                            <span class="text-ytlight-muted font-normal text-xs">(mínimo 6 caracteres)</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_nuevo" id="pwd_nuevo" required
                                class="w-full border bg-ytlight-elevated border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                            <button type="button" onclick="togglePwd('pwd_nuevo', 'eye2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                                <svg id="eye2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ytlight-text dark:text-yt-text mb-1 transition-colors duration-300">
                            Confirmar contraseña <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmar" id="pwd_confirmar" required
                                class="w-full border bg-ytlight-elevated border-gray-300 dark:border-yt-border dark:bg-neutral-900 dark:text-yt-muted rounded-lg px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-300">
                            <button type="button" onclick="togglePwd('pwd_confirmar', 'eye3')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-300">
                                <svg id="eye3" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                <?php if (isset($_SESSION['password_error'])): ?>
                    <div class="flex items-center gap-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg px-4 py-3 mt-4 transition-colors duration-300">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-red-600 dark:text-red-400 text-sm font-medium transition-colors duration-300"><?= $_SESSION['password_error'] ?></p>
                    </div>
                    <?php unset($_SESSION['password_error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['password_success'])): ?>
                    <div class="flex items-center gap-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-4 py-3 mt-4 transition-colors duration-300">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-green-600 dark:text-green-400 text-sm font-medium transition-colors duration-300"><?= $_SESSION['password_success'] ?></p>
                    </div>
                    <?php unset($_SESSION['password_success']); ?>
                <?php endif; ?>

                <div class="flex gap-3 mt-5">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors duration-300">
                        Guardar
                    </button>
                    <button type="button" onclick="togglePasswordModal()" class="flex-1 border border-red-200 dark:border-red-800 text-white dark:text-white hover:bg-red-700 dark:hover:bg-red-700 bg-red-600 dark:bg-red-600 text-sm font-medium py-2.5 rounded-lg transition-colors duration-300">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleNotificaciones() {
            const menu = document.getElementById('notif-menu');
            const btn = document.querySelector('[onclick="toggleNotificaciones()"]');

            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                return;
            }

            const btnRect = btn.getBoundingClientRect();
            const menuWidth = Math.min(288, window.innerWidth - 16);

            // Posición vertical: justo debajo del botón
            menu.style.top = (btnRect.bottom + 8) + 'px';

            // Posición horizontal: alineado a la derecha del botón, pero sin salirse
            let left = btnRect.right - menuWidth;
            if (left < 8) left = 8;
            if (left + menuWidth > window.innerWidth - 8) left = window.innerWidth - menuWidth - 8;

            menu.style.left = left + 'px';
            menu.classList.remove('hidden');
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("sidebar-overlay");
            sidebar.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
        }

        document.addEventListener("click", (e) => {
            const menu = document.getElementById('notif-menu');
            if (!menu.contains(e.target) && !e.target.closest('[onclick="toggleNotificaciones()"]')) {
                menu.classList.add('hidden');
            }
        });

        function updateIcon(isDark) {
            document.getElementById('icon-sun').style.display = isDark ? 'block' : 'none';
            document.getElementById('icon-moon').style.display = isDark ? 'none' : 'block';
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            document.documentElement.classList.toggle('dark', !isDark);
            document.cookie = 'theme=' + (!isDark ? 'dark' : 'light') + '; path=/';
            updateIcon(!isDark);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cookie = document.cookie.split(';').find(c => c.trim().startsWith('theme='));
            const isDark = cookie ? cookie.split('=')[1].trim() === 'dark' : false;
            document.documentElement.classList.toggle('dark', isDark);
            updateIcon(isDark);
        });

        function togglePwd(inputId, eyeId) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const eye = document.getElementById(eyeId);
            eye.innerHTML = isPassword ?
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
        }

        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            const arrow = document.getElementById('user-arrow');
            const btn = document.querySelector('[onclick="toggleUserMenu()"]');

            if (!menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                arrow.style.transform = 'rotate(0deg)';
                return;
            }

            menu.classList.remove('hidden');
            const rect = btn.getBoundingClientRect();
            const menuH = menu.offsetHeight;
            menu.style.top = (rect.top - menuH - 8) + 'px';
            menu.style.left = rect.left + 'px';
            menu.style.width = rect.width + 'px';
            arrow.style.transform = 'rotate(180deg)';
        }

        function togglePasswordModal() {
            const modal = document.getElementById('password-modal');
            const isHidden = modal.style.display === 'none' || modal.style.display === '';
            modal.style.display = isHidden ? 'flex' : 'none';
            document.getElementById('user-menu').classList.add('hidden');
        }

        // Mantener modal abierto si viene de cambio de contraseña
        if (window.location.search.includes('pwd=1')) {
            document.getElementById('password-modal').style.display = 'flex';
            // Limpiar URL sin recargar
            history.replaceState({}, '', window.location.pathname);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cookie = document.cookie.split(';').find(c => c.trim().startsWith('theme='));
            const isDark = cookie ? cookie.split('=')[1].trim() === 'dark' : false;
            document.documentElement.classList.toggle('dark', isDark);
            updateIcon(isDark);

            if (window.location.search.includes('pwd=1')) {
                document.getElementById('password-modal').style.display = 'flex';
                history.replaceState({}, '', window.location.pathname);
            }
        });

        const searchInput = document.getElementById('search-input');
        const searchDropdown = document.getElementById('search-dropdown');
        const searchResults = document.getElementById('search-results');

        searchInput.addEventListener('keydown', async (e) => {

            if (e.key === 'Enter') {
                const q = searchInput.value.trim();
                if (q.length === 0) {
                    const path = window.location.pathname;
                    if (path !== '/dashboard') {
                        window.location.href = path;
                    }
                    return;
                }

                const res = await fetch('/buscar?q=' + encodeURIComponent(q));
                const data = await res.json();

                if (Object.keys(data).length === 0) {
                    searchResults.innerHTML = `
                <p class="px-4 py-6 text-center text-sm text-gray-400 dark:text-yt-muted duration-300 transition-colors">
                    No se encontraron resultados para "<strong>${q}</strong>"
                </p>`;
                } else {
                    let html = '';
                    for (const [modulo, items] of Object.entries(data)) {
                        html += `<div class="px-4 py-2 bg-gray-300/50 dark:bg-yt-elevated border-b border-gray-100 dark:border-yt-border transition-colors duration-300">
                    <span class="text-xs font-semibold text-gray-500 dark:text-yt-muted uppercase tracking-wide">${modulo}</span>
                </div>`;
                        items.forEach(item => {
                            html += `<a href="${item.url}" class="flex items-center justify-between px-4 py-2.5 hover:bg-gray-100 dark:hover:bg-yt-elevated transition-colors border-b border-gray-100 dark:border-yt-border duration-300">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-yt-text">${item.texto}</p>
                            ${item.sub ? `<p class="text-xs text-gray-400 dark:text-yt-muted duration-300 transition-colors">${item.sub}</p>` : ''}
                        </div>
                        <span class="text-xs text-indigo-500">Ver →</span>
                    </a>`;
                        });
                    }
                    searchResults.innerHTML = html;s
                }

                searchDropdown.classList.remove('hidden');
            }
        });


        document.addEventListener("click", (e) => {
            if (!document.getElementById('search-wrapper').contains(e.target)) {
                searchDropdown.classList.add('hidden');
            }
        });
    </script>

</body>

</html>