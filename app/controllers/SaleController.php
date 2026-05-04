<?php

class SaleController extends Controller {

    private $saleModel;
    private $clientModel;
    private $productModel;

    public function __construct() {
    parent::__construct();
    if (!isset($_SESSION['user_id'])) {
        $this->redirect('/login');
    }
    Permission::require('ventas.ver');
    $this->saleModel    = new SaleModel();
    $this->clientModel  = new ClientModel();
    $this->productModel = new ProductModel();
    }

    public function index()
    {
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $ventas = $buscar
            ? $this->saleModel->search($buscar)
            : $this->saleModel->getAll();

        $this->view('sales/index', [
            'title'        => 'Ventas',
            'activeMenu'   => 'ventas',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'ventas'       => $ventas,
            'buscar'       => $buscar
        ]);
    }

    public function create() {
        Permission::require('ventas.crear');
        $clientes  = $this->clientModel->getAll();
        $productos = $this->productModel->getAll();

        $this->view('sales/create', [
            'title'        => 'Nueva venta',
            'activeMenu'   => 'ventas',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'clientes'     => $clientes,
            'productos'    => $productos
        ]);
    }

    public function store() {
    Permission::require('ventas.crear');
    if (!$this->isPost()) {
        $this->redirect('/ventas');
    }

    $productos    = $_POST['producto_id'];
    $cantidades   = $_POST['cantidad'];
    $precios      = $_POST['precio_unitario'];
    $impuesto_pct = isset($_POST['impuesto']) ? (float)$_POST['impuesto'] : 0;

    $subtotal = 0;
    foreach ($productos as $i => $producto_id) {
        if (!empty($producto_id)) {
            $subtotal += $cantidades[$i] * $precios[$i];
        }
    }

    $impuestos = $subtotal * ($impuesto_pct / 100);
    $total     = $subtotal + $impuestos;

    $venta_id = $this->saleModel->create([
        ':cliente_id'  => $_POST['cliente_id'] ?: null,
        ':usuario_id'  => $_SESSION['user_id'],
        ':fecha'       => date('Y-m-d H:i:s'),
        ':metodo_pago' => $this->sanitize($_POST['metodo_pago']),
        ':estado'      => 'completada',
        ':subtotal'    => $subtotal,
        ':impuestos'   => $impuestos,
        ':total'       => $total
    ]);

    foreach ($productos as $i => $producto_id) {
        if (!empty($producto_id)) {
            $this->saleModel->addDetalle([
                ':venta_id'        => $venta_id,
                ':producto_id'     => $producto_id,
                ':cantidad'        => $cantidades[$i],
                ':precio_unitario' => $precios[$i]
            ]);
            $this->saleModel->updateStock($producto_id, $cantidades[$i]);

            // Verificar stock bajo después de la venta
            $producto = $this->productModel->findById($producto_id);
            if ($producto['stock'] <= 5) {
                $this->notifModel->crear(
                    'stock',
                    'Stock bajo: ' . $producto['nombre'] . ' tiene ' . $producto['stock'] . ' unidades',
                    '/productos'
                );
            }
        }
    }

        $this->notifModel->crear(
            'venta',
            'Nueva venta #' . $venta_id . ' registrada por ' . $_SESSION['user_name'] . ' por $' . number_format($total, 0, ',', '.'),
            '/ventas/show/' . $venta_id
        );

    $this->redirect('/ventas?success=1');
    }

    public function show($id) {
        $venta   = $this->saleModel->getById($id);
        $detalle = $this->saleModel->getDetalle($id);

        $this->view('sales/show', [
            'title'        => 'Detalle de venta',
            'activeMenu'   => 'ventas',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'venta'        => $venta,
            'detalle'      => $detalle
        ]);
    }

    public function cancelar($id) {
    Permission::require('ventas.cancelar');
    $this->saleModel->cancelar($id);

    $this->notifModel->crear(
        'venta',
        'Venta #' . $id . ' fue cancelada por ' . $_SESSION['user_name'],
        '/ventas/show/' . $id
    );

    $this->redirect('/ventas?cancelled=1');
    }
}