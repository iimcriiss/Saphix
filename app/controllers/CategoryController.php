<?php

class CategoryController extends Controller {

    private $categoryModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('categorias.ver');
    $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $categorias = $buscar
            ? $this->categoryModel->search($buscar)
            : $this->categoryModel->getAll();

        $this->view('categories/index', [
            'title'        => 'Categorías',
            'activeMenu'   => 'categorias',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'categorias'   => $categorias,
            'buscar'       => $buscar
        ]);
    }

    public function create() {
        Permission::require('categorias.crear');
        $padres = $this->categoryModel->getAllActivas();

        $this->view('categories/create', [
            'title'        => 'Nueva categoría',
            'activeMenu'   => 'categorias',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'padres'       => $padres
        ]);
    }

    public function store() {
        Permission::require('categorias.crear');
        if (!$this->isPost()) {
            $this->redirect('/categorias');
        }

        $data = [
            ':nombre'             => $this->sanitize($_POST['nombre']),
            ':descripcion'        => $this->sanitize($_POST['descripcion']),
            ':categoria_padre_id' => $_POST['categoria_padre_id'] ?: null,
            ':estado'             => isset($_POST['estado']) ? 1 : 0
        ];

        $this->categoryModel->create($data);
        $this->redirect('/categorias');
    }

    public function edit($id) {
        Permission::require('categorias.editar');
        $categoria = $this->categoryModel->findById($id);
        $padres    = $this->categoryModel->getAllActivas();

        $this->view('categories/edit', [
            'title'        => 'Editar categoría',
            'activeMenu'   => 'categorias',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'categoria'    => $categoria,
            'padres'       => $padres
        ]);
    }

    public function update($id) {
        Permission::require('categorias.editar');
        if (!$this->isPost()) {
            $this->redirect('/categorias');
        }

        $data = [
            ':nombre'             => $this->sanitize($_POST['nombre']),
            ':descripcion'        => $this->sanitize($_POST['descripcion']),
            ':categoria_padre_id' => $_POST['categoria_padre_id'] ?: null,
            ':estado'             => isset($_POST['estado']) ? 1 : 0
        ];

        $this->categoryModel->update($id, $data);
        $this->redirect('/categorias');
    }

    public function delete($id) {
        Permission::require('categorias.eliminar');
        $this->categoryModel->delete($id);
        $this->redirect('/categorias');
    }
}