<?php

class SearchController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        parent::__construct();
    }

    public function index() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (strlen($q) < 2) {
            echo json_encode([]);
            exit();
        }

        $db = (new Database())->getConnection();
        $resultados = [];

        // Productos
        if (Permission::can('productos.ver')) {
            $stmt = $db->prepare("SELECT id, nombre, precio FROM productos WHERE nombre LIKE :q AND estado = 1 LIMIT 5");
            $stmt->execute([':q' => '%' . $q . '%']);
            $rows = $stmt->fetchAll();
            if ($rows) $resultados['Productos'] = array_map(fn($r) => [
                'texto' => $r['nombre'],
                'sub'   => '$' . number_format($r['precio'], 0, ',', '.'),
                'url' => '/productos?buscar=' . urlencode($r['nombre'])
            ], $rows);
        }

        // Clientes
        if (Permission::can('clientes.ver')) {
            $stmt = $db->prepare("SELECT id, nombre, email FROM clientes WHERE nombre LIKE :q LIMIT 5");
            $stmt->execute([':q' => '%' . $q . '%']);
            $rows = $stmt->fetchAll();
            if ($rows) $resultados['Clientes'] = array_map(fn($r) => [
                'texto' => $r['nombre'],
                'sub'   => $r['email'],
                'url' => '/clientes?buscar=' . urlencode($r['nombre'])
            ], $rows);
        }

        // Proveedores
        if (Permission::can('proveedores.ver')) {
            $stmt = $db->prepare("SELECT id, nombre FROM proveedores WHERE nombre LIKE :q LIMIT 5");
            $stmt->execute([':q' => '%' . $q . '%']);
            $rows = $stmt->fetchAll();
            if ($rows) $resultados['Proveedores'] = array_map(fn($r) => [
                'texto' => $r['nombre'],
                'sub'   => '',
                'url'   => '/proveedores?buscar=' . urlencode($r['nombre'])
            ], $rows);
        }

        // Usuarios
        if (Permission::can('usuarios.ver')) {
            $stmt = $db->prepare("SELECT id, nombre, email FROM usuarios WHERE nombre LIKE :q LIMIT 5");
            $stmt->execute([':q' => '%' . $q . '%']);
            $rows = $stmt->fetchAll();
            if ($rows) $resultados['Usuarios'] = array_map(fn($r) => [
                'texto' => $r['nombre'],
                'sub'   => $r['email'],
                'url'   => '/usuarios?buscar=' . urlencode($r['nombre'])
            ], $rows);
        }

        // Ventas
        if (Permission::can('ventas.ver')) {
            $stmt = $db->prepare("
        SELECT v.id, c.nombre AS cliente, v.total, v.estado
        FROM ventas v
        LEFT JOIN clientes c ON v.cliente_id = c.id
        WHERE c.nombre LIKE :q OR v.estado LIKE :q
        LIMIT 5
    ");
            $stmt->execute([':q' => '%' . $q . '%']);
            $rows = $stmt->fetchAll();
            if ($rows) $resultados['Ventas'] = array_map(fn($r) => [
                'texto' => 'Venta #' . $r['id'] . ' — ' . ($r['cliente'] ?? 'Mostrador'),
                'sub'   => '$' . number_format($r['total'], 0, ',', '.') . ' · ' . $r['estado'],
                'url'   => '/ventas?buscar=' . urlencode($r['cliente'] ?? '')
            ], $rows);
        }

        // Compras
        if (Permission::can('compras.ver')) {
            $stmt = $db->prepare("
        SELECT c.id, p.nombre AS proveedor, c.total
        FROM compras c
        LEFT JOIN proveedores p ON c.proveedor_id = p.id
        WHERE p.nombre LIKE :q
        LIMIT 5
    ");
            $stmt->execute([':q' => '%' . $q . '%']);
            $rows = $stmt->fetchAll();
            if ($rows) $resultados['Compras'] = array_map(fn($r) => [
                'texto' => 'Compra #' . $r['id'] . ' — ' . $r['proveedor'],
                'sub'   => '$' . number_format($r['total'], 0, ',', '.'),
                'url'   => '/compras?buscar=' . urlencode($r['proveedor'] ?? '')
            ], $rows);
        }

        header('Content-Type: application/json');
        echo json_encode($resultados);
        exit();
        
    } 
    
}