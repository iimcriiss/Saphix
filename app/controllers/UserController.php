<?php

class UserController extends Controller {

    private $userModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('usuarios.ver');
    $this->userModel = new UserModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $usuarios = $buscar
            ? $this->userModel->search($buscar)
            : $this->userModel->getAll();

        $this->view('users/index', [
            'title'        => 'Usuarios',
            'activeMenu'   => 'usuarios',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'usuarios'     => $usuarios,
            'buscar'       => $buscar
        ]);
    }

    public function create() {
        Permission::require('usuarios.crear');
        $roles = $this->userModel->getRoles();

        $this->view('users/create', [
            'title'        => 'Nuevo usuario',
            'activeMenu'   => 'usuarios',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'roles'        => $roles
        ]);
    }

    public function store() {
        Permission::require('usuarios.crear');
        if (!$this->isPost()) {
            $this->redirect('/usuarios');
        }

        $data = [
            ':nombre'   => $this->sanitize($_POST['nombre']),
            ':email'    => $this->sanitize($_POST['email']),
            ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':rol_id'   => $_POST['rol_id'],
            ':estado'   => isset($_POST['estado']) ? 1 : 0
        ];

        $newId = $this->userModel->create($data);

        // Guardar permisos
        $modulos  = ['productos', 'categorias', 'ventas', 'clientes', 'proveedores', 'compras', 'usuarios'];
        $acciones = ['ver', 'crear', 'editar', 'eliminar'];
        $permisos = [];

        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                if (isset($_POST[$modulo . '_' . $accion])) {
                    $permisos[] = $modulo . '.' . $accion;
                }
            }
        }

        if (isset($_POST['ventas_cancelar'])) {
            $permisos[] = 'ventas.cancelar';
        }

        $permisosStr = empty($permisos) ? null : implode(',', $permisos);
        $this->userModel->updatePermisos($newId, $permisosStr);

        $this->notifModel->crear(
            'usuario',
            'Nuevo usuario registrado: ' . $this->sanitize($_POST['nombre']),
            '/usuarios'
        );

        $this->redirect('/usuarios');
    }

    public function edit($id)
    {
        if ($_SESSION['user_role'] !== 'Admin' && $id != $_SESSION['user_id']) {
        $this->redirect('/dashboard');
    }
        $usuario = $this->userModel->findById($id);
        $roles   = $this->userModel->getRoles();
        $rol     = $this->userModel->getRolById($usuario['rol_id']);

        $this->view('users/edit', [
            'title'        => 'Editar usuario',
            'activeMenu'   => 'usuarios',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'usuario'      => $usuario,
            'roles'        => $roles,
            'rol'          => $rol
        ]);
    }

    public function update($id)
    {
        if (!$this->isPost()) {
            $this->redirect('/usuarios');
        }

        $data = [
            ':nombre' => $this->sanitize($_POST['nombre']),
            ':email'  => $this->sanitize($_POST['email']),
            ':rol_id' => $_POST['rol_id'],
            ':estado' => isset($_POST['estado']) ? 1 : 0
        ];

        $this->userModel->update($id, $data);

        if (!empty($_POST['password'])) {
            $this->userModel->updatePassword($id, $_POST['password']);
        }

        // Guardar permisos
        $modulos  = ['productos', 'categorias', 'ventas', 'clientes', 'proveedores', 'compras', 'usuarios'];
        $acciones = ['ver', 'crear', 'editar', 'eliminar'];
        $permisos = [];

        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                if (isset($_POST[$modulo . '_' . $accion])) {
                    $permisos[] = $modulo . '.' . $accion;
                }
            }
        }

        if (isset($_POST['ventas_cancelar'])) {
            $permisos[] = 'ventas.cancelar';
        }

        $permisosStr = empty($permisos) ? null : implode(',', $permisos);
        $this->userModel->updatePermisos($id, $permisosStr);

        $this->redirect('/usuarios');
    }

    public function delete($id) {
        Permission::require('usuarios.eliminar');
        if ($id == $_SESSION['user_id']) {
            $this->redirect('/usuarios');
        }
        $this->userModel->delete($id);
        $this->redirect('/usuarios');
    }

    public function permisos($id) {
    Permission::require('usuarios.ver');
    $usuario = $this->userModel->findById($id);
    $rol     = $this->userModel->getRolById($usuario['rol_id']);

    $this->view('users/permisos', [
        'title'        => 'Permisos de ' . $usuario['nombre'],
        'activeMenu'   => 'usuarios',
        'userName'     => $_SESSION['user_name'],
        'userRole'     => $_SESSION['user_role'],
        'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
        'usuario'      => $usuario,
        'rol'          => $rol
    ]);
}

public function savePermisos($id) {
    Permission::require('usuarios.ver');

    $modulos = ['productos', 'categorias', 'ventas', 'clientes', 'proveedores', 'compras', 'usuarios'];
    $acciones = ['ver', 'crear', 'editar', 'eliminar'];
    $especiales = ['ventas.cancelar'];

    $permisos = [];

    foreach ($modulos as $modulo) {
        foreach ($acciones as $accion) {
            $key = $modulo . '_' . $accion;
            if (isset($_POST[$key])) {
                $permisos[] = $modulo . '.' . $accion;
            }
        }
    }

    foreach ($especiales as $especial) {
        $key = str_replace('.', '_', $especial);
        if (isset($_POST[$key])) {
            $permisos[] = $especial;
        }
    }

    $permisosStr = empty($permisos) ? null : implode(',', $permisos);
    $this->userModel->updatePermisos($id, $permisosStr);
    $this->redirect('/usuarios/permisos/' . $id);
    }
}