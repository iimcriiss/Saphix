<?php

class ProductController extends Controller {

    private $productModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('productos.ver');
    $this->productModel = new ProductModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $productos = $buscar
            ? $this->productModel->search($buscar)
            : $this->productModel->getAll();

        $this->view('products/index', [
            'title'      => 'Productos',
            'activeMenu' => 'productos',
            'userName'   => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'productos'  => $productos,
            'buscar'     => $buscar
        ]);
    }

    public function create() {
        Permission::require('productos.crear');
        $categorias  = $this->productModel->getCategorias();
        $proveedores = $this->productModel->getProveedores();

        $this->view('products/create', [
            'title'      => 'Nuevo producto',
            'activeMenu' => 'productos',
            'userName'   => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'categorias'  => $categorias,
            'proveedores' => $proveedores
        ]);
    }

    public function store() {
        Permission::require('productos.crear');
    if (!$this->isPost()) {
        $this->redirect('/productos');
    }

        $imagen_url = '';

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $extension  = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombre     = uniqid('producto_') . '.' . $extension;
            $destino    = __DIR__ . '/../../public/img/productos/' . $nombre;

            if (!is_dir(__DIR__ . '/../../public/img/productos/')) {
                mkdir(__DIR__ . '/../../public/img/productos/', 0755, true);
            }

            move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
            $imagen_url = '/img/productos/' . $nombre;
        }

        $data = [
            ':nombre'       => $this->sanitize($_POST['nombre']),
            ':descripcion'  => $this->sanitize($_POST['descripcion']),
            ':precio'       => $_POST['precio'],
            ':stock'        => $_POST['stock'],
            ':imagen_url'   => $imagen_url,
            ':estado'       => isset($_POST['estado']) ? 1 : 0,
            ':categoria_id' => $_POST['categoria_id'] ?: null,
            ':proveedor_id' => $_POST['proveedor_id'] ?: null
        ];

        $this->productModel->create($data);
        $this->redirect('/productos');
    }

    public function edit($id)
    {
        Permission::require('productos.editar');
        $producto    = $this->productModel->findById($id);
        $categorias  = $this->productModel->getCategorias();
        $proveedores = $this->productModel->getProveedores();

        $this->view('products/edit', [
            'title'      => 'Editar producto',
            'activeMenu' => 'productos',
            'userName'   => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'producto'    => $producto,
            'categorias'  => $categorias,
            'proveedores' => $proveedores
        ]);
    }

    public function update($id) {
        Permission::require('productos.editar');
    if (!$this->isPost()) {
        $this->redirect('/productos');
    }

    $producto   = $this->productModel->findById($id);
    $imagen_url = $producto['imagen_url'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombre    = uniqid('producto_') . '.' . $extension;
        $destino   = __DIR__ . '/../../public/img/productos/' . $nombre;

        if (!is_dir(__DIR__ . '/../../public/img/productos/')) {
            mkdir(__DIR__ . '/../../public/img/productos/', 0755, true);
        }

        move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
        $imagen_url = '/img/productos/' . $nombre;
    }

    $data = [
        ':nombre'       => $this->sanitize($_POST['nombre']),
        ':descripcion'  => $this->sanitize($_POST['descripcion']),
        ':precio'       => $_POST['precio'],
        ':stock'        => $_POST['stock'],
        ':imagen_url'   => $imagen_url,
        ':estado'       => isset($_POST['estado']) ? 1 : 0,
        ':categoria_id' => $_POST['categoria_id'] ?: null,
        ':proveedor_id' => $_POST['proveedor_id'] ?: null
    ];

    $this->productModel->update($id, $data);
    $this->redirect('/productos');
    }

    public function delete($id) {
        Permission::require('productos.eliminar');
        $this->productModel->delete($id);
        $this->redirect('/productos');
    }
}