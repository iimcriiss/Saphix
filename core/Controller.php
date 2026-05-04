<?php

class Controller {

    protected $notifModel;

    public function __construct() {
        require_once __DIR__ . '/../app/models/NotificacionModel.php';
        $this->notifModel = new NotificacionModel();
    }

    protected function view($view, $data = [])
    {
        // Evitar caché en páginas protegidas
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        $data['notificaciones']      = $this->notifModel->getNoLeidas();
        $data['totalNotificaciones'] = $this->notifModel->contarNoLeidas();

        extract($data);
        require_once __DIR__ . '/../app/views/' . $view . '.php';
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}