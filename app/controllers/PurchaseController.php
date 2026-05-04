<?php

class PurchaseController extends Controller {

    private $purchaseModel;
    private $supplierModel;
    private $productModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('compras.ver');
    $this->purchaseModel = new PurchaseModel();
    $this->supplierModel = new SupplierModel();
    $this->productModel  = new ProductModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $compras = $buscar
            ? $this->purchaseModel->search($buscar)
            : $this->purchaseModel->getAll();

        $this->view('purchases/index', [
            'title'        => 'Compras',
            'activeMenu'   => 'compras',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'compras'      => $compras,
            'buscar'       => $buscar
        ]);
    }

    public function create() {
        Permission::require('compras.crear');
        $proveedores = $this->supplierModel->getAll();
        $productos   = $this->productModel->getAll();

        $this->view('purchases/create', [
            'title'        => 'Nueva compra',
            'activeMenu'   => 'compras',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'proveedores'  => $proveedores,
            'productos'    => $productos
        ]);
    }

    public function store() {
        Permission::require('compras.crear');
        if (!$this->isPost()) {
            $this->redirect('/compras');
        }

        $productos   = $_POST['producto_id'];
        $cantidades  = $_POST['cantidad'];
        $costos      = $_POST['costo_unitario'];

        $total = 0;
        foreach ($productos as $i => $producto_id) {
            if (!empty($producto_id)) {
                $total += $cantidades[$i] * $costos[$i];
            }
        }

        $compra_id = $this->purchaseModel->create([
            ':proveedor_id' => $_POST['proveedor_id'],
            ':fecha'        => date('Y-m-d H:i:s'),
            ':total'        => $total
        ]);

        foreach ($productos as $i => $producto_id) {
            if (!empty($producto_id)) {
                $this->purchaseModel->addDetalle([
                    ':compra_id'      => $compra_id,
                    ':producto_id'    => $producto_id,
                    ':cantidad'       => $cantidades[$i],
                    ':costo_unitario' => $costos[$i]
                ]);

                $this->purchaseModel->updateStock($producto_id, $cantidades[$i]);
            }
        }

        $this->redirect('/compras');
    }

    public function show($id) {
        $compra  = $this->purchaseModel->getById($id);
        $detalle = $this->purchaseModel->getDetalle($id);

        $this->view('purchases/show', [
            'title'        => 'Detalle de compra',
            'activeMenu'   => 'compras',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'compra'       => $compra,
            'detalle'      => $detalle
        ]);
    }
}