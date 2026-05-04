<?php

require_once __DIR__ . '/../models/NotificacionModel.php';

class NotificacionController extends Controller {

    private $model;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->model = new NotificacionModel();
    }

    public function marcarLeida($id) {
        $this->model->marcarLeida($id);
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/dashboard');
    }

    public function marcarTodas() {
        $this->model->marcarTodasLeidas();
        $this->redirect($_SERVER['HTTP_REFERER'] ?? '/dashboard');
    }
}