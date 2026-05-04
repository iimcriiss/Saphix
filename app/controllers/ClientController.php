<?php

class ClientController extends Controller {

    private $clientModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('clientes.ver');
    $this->clientModel = new ClientModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $clientes = $buscar
            ? $this->clientModel->search($buscar)
            : $this->clientModel->getAll();

        $this->view('clients/index', [
            'title'        => 'Clientes',
            'activeMenu'   => 'clientes',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'clientes'     => $clientes,
            'buscar'       => $buscar
        ]);
    }

    public function create() {
        Permission::require('clientes.crear');
        $this->view('clients/create', [
            'title'        => 'Nuevo cliente',
            'activeMenu'   => 'clientes',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
        ]);
    }

    public function store() {
        Permission::require('clientes.crear');
        if (!$this->isPost()) {
            $this->redirect('/clientes');
        }

        $data = [
            ':nombre'    => $this->sanitize($_POST['nombre']),
            ':email'     => $this->sanitize($_POST['email']),
            ':telefono'  => $this->sanitize($_POST['telefono']),
            ':direccion' => $this->sanitize($_POST['direccion']),
        ];

        $this->clientModel->create($data);
        $this->redirect('/clientes');
    }

    public function edit($id) {
        Permission::require('clientes.editar');
        $cliente = $this->clientModel->findById($id);

        $this->view('clients/edit', [
            'title'        => 'Editar cliente',
            'activeMenu'   => 'clientes',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'cliente'      => $cliente
        ]);
    }

    public function update($id) {
        Permission::require('clientes.editar');
        if (!$this->isPost()) {
            $this->redirect('/clientes');
        }

        $data = [
            ':nombre'    => $this->sanitize($_POST['nombre']),
            ':email'     => $this->sanitize($_POST['email']),
            ':telefono'  => $this->sanitize($_POST['telefono']),
            ':direccion' => $this->sanitize($_POST['direccion']),
        ];

        $this->clientModel->update($id, $data);
        $this->redirect('/clientes');
    }

    public function delete($id) {
        Permission::require('clientes.eliminar');
        $this->clientModel->delete($id);
        $this->redirect('/clientes');
    }
}