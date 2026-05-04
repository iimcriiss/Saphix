<?php

class ProfileController extends Controller {

    private $userModel;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->userModel = new UserModel();
    }

    public function password() {
        if (!$this->isPost()) {
            $this->redirect('/dashboard');
        }

        $actual    = $_POST['password_actual'];
        $nuevo     = $_POST['password_nuevo'];
        $confirmar = $_POST['password_confirmar'];
        $referer   = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/dashboard';

        $usuario = $this->userModel->findById($_SESSION['user_id']);

        if (!password_verify($actual, $usuario['password'])) {
            $_SESSION['password_error'] = 'La contraseña actual es incorrecta';
            header('Location: ' . $referer . '?pwd=1');
            exit();
        }

        if ($nuevo !== $confirmar) {
            $_SESSION['password_error'] = 'Las contraseñas nuevas no coinciden';
            header('Location: ' . $referer . '?pwd=1');
            exit();
        }

        if (strlen($nuevo) < 6) {
            $_SESSION['password_error'] = 'La contraseña debe tener al menos 6 caracteres';
            header('Location: ' . $referer . '?pwd=1');
            exit();
        }

        $this->userModel->updatePassword($_SESSION['user_id'], $nuevo);
        $_SESSION['password_success'] = '✓ Contraseña actualizada correctamente';
        header('Location: ' . $referer . '?pwd=1');
        exit();
    }
}