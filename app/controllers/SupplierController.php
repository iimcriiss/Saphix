<?php

class SupplierController extends Controller {

    private $supplierModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('proveedores.ver');
    $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $proveedores = $buscar
            ? $this->supplierModel->search($buscar)
            : $this->supplierModel->getAll();

        $this->view('suppliers/index', [
            'title'        => 'Proveedores',
            'activeMenu'   => 'proveedores',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'proveedores'  => $proveedores,
            'buscar'       => $buscar
        ]);
    }

    public function create() {
        Permission::require('proveedores.crear');
        $this->view('suppliers/create', [
            'title'        => 'Nuevo proveedor',
            'activeMenu'   => 'proveedores',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
        ]);
    }

    public function store() {
        Permission::require('proveedores.crear');
        if (!$this->isPost()) {
            $this->redirect('/proveedores');
        }

        $data = [
            ':nombre'    => $this->sanitize($_POST['nombre']),
            ':contacto'  => $this->sanitize($_POST['contacto']),
            ':telefono'  => $this->sanitize($_POST['telefono']),
            ':email'     => $this->sanitize($_POST['email']),
            ':direccion' => $this->sanitize($_POST['direccion']),
            ':estado'    => isset($_POST['estado']) ? 1 : 0
        ];

        $this->supplierModel->create($data);
        $this->redirect('/proveedores');
    }

    public function edit($id) {
        Permission::require('proveedores.editar');
        $proveedor = $this->supplierModel->findById($id);

        $this->view('suppliers/edit', [
            'title'        => 'Editar proveedor',
            'activeMenu'   => 'proveedores',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'proveedor'    => $proveedor
        ]);
    }

    public function update($id) {
        Permission::require('proveedores.editar');
        if (!$this->isPost()) {
            $this->redirect('/proveedores');
        }

        $data = [
            ':nombre'    => $this->sanitize($_POST['nombre']),
            ':contacto'  => $this->sanitize($_POST['contacto']),
            ':telefono'  => $this->sanitize($_POST['telefono']),
            ':email'     => $this->sanitize($_POST['email']),
            ':direccion' => $this->sanitize($_POST['direccion']),
            ':estado'    => isset($_POST['estado']) ? 1 : 0
        ];

        $this->supplierModel->update($id, $data);
        $this->redirect('/proveedores');
    }

    public function delete($id) {
        Permission::require('proveedores.eliminar');
        $this->supplierModel->delete($id);
        $this->redirect('/proveedores');
    }
}