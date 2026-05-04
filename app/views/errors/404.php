<?php ob_start(); ?>

<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
    <p class="text-8xl font-bold text-indigo-200 dark:text-indigo-900 select-none leading-none">404</p>
    <h1 class="text-xl font-semibold text-gray-700 dark:text-yt-text mt-4">Página no encontrada</h1>
    <p class="text-sm text-gray-500 dark:text-yt-muted mt-2 max-w-sm">
        La ruta que intentas acceder no existe o fue eliminada.
    </p>
    <a href="/dashboard" class="mt-6 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors duration-300">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Volver al dashboard
    </a>
</div>

<?php $content = ob_get_clean(); ?>
<?php
// Variables que necesita el layout
$title = 'Página no encontrada';
// Estas variables las necesita main.php — ponlas vacías si no existen
if (!isset($userName)) $userName = $_SESSION['user_name'] ?? 'Usuario';
if (!isset($userRole)) $userRole = $_SESSION['user_role'] ?? '';
if (!isset($userInitials)) $userInitials = strtoupper(substr($userName, 0, 2));
if (!isset($activeMenu)) $activeMenu = '';
if (!isset($notificaciones)) $notificaciones = [];
if (!isset($totalNotificaciones)) $totalNotificaciones = 0;
require_once __DIR__ . '/../layouts/main.php';
?>