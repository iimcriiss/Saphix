<?php

class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->isPost()) {
            $email    = $this->sanitize($_POST['email']);
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $rol = $this->userModel->getRolById($user['rol_id']);

                $_SESSION['user_id']       = $user['id'];
                $_SESSION['user_name']     = $user['nombre'];
                $_SESSION['user_role']     = $rol['nombre'];
                $_SESSION['user_permisos'] = !empty($user['permisos'])
                    ? $user['permisos']
                    : $rol['permisos'];

                $this->redirect('/dashboard');
            } else {
                $error = 'Correo o contraseña incorrectos';
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function logout() {
    session_start();
    session_destroy();
    
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    
    $this->redirect('/login');
    }
}