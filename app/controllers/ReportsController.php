<?php

class ReportsController extends Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    public function cierreCaja() {
        $db = (new Database())->getConnection();
        $fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date('Y-m-d');

        // Total ventas del día
        $stmt = $db->prepare("
            SELECT COUNT(*) as total_ventas, COALESCE(SUM(total), 0) as monto_total,
            COALESCE(SUM(subtotal), 0) as subtotal, COALESCE(SUM(impuestos), 0) as impuestos
            FROM ventas
            WHERE DATE(fecha) = :fecha AND estado = 'completada'
        ");
        $stmt->execute([':fecha' => $fecha]);
        $resumen = $stmt->fetch();

        // Desglose por método de pago
        $stmt = $db->prepare("
            SELECT metodo_pago, COUNT(*) as cantidad, COALESCE(SUM(total), 0) as monto
            FROM ventas
            WHERE DATE(fecha) = :fecha AND estado = 'completada'
            GROUP BY metodo_pago
        ");
        $stmt->execute([':fecha' => $fecha]);
        $metodos = $stmt->fetchAll();

        // Ventas canceladas del día
        $stmt = $db->prepare("
            SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as monto
            FROM ventas
            WHERE DATE(fecha) = :fecha AND estado = 'cancelada'
        ");
        $stmt->execute([':fecha' => $fecha]);
        $canceladas = $stmt->fetch();

        // Detalle de ventas del día
        $stmt = $db->prepare("
            SELECT v.*, c.nombre AS cliente, u.nombre AS vendedor
            FROM ventas v
            LEFT JOIN clientes c ON v.cliente_id = c.id
            LEFT JOIN usuarios u ON v.usuario_id = u.id
            WHERE DATE(v.fecha) = :fecha
            ORDER BY v.fecha DESC
        ");
        $stmt->execute([':fecha' => $fecha]);
        $ventas = $stmt->fetchAll();

        $this->view('reports/index', [
            'title'        => 'Cierre de caja',
            'activeMenu'   => 'reports',
            'userName'     => $_SESSION['user_name'],
            'userRole'     => $_SESSION['user_role'],
            'userInitials' => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'resumen'      => $resumen,
            'metodos'      => $metodos,
            'canceladas'   => $canceladas,
            'ventas'       => $ventas,
            'fecha'        => $fecha
        ]);}

    public function backup()
    {
        $host     = 'localhost';
        $db       = 'saphix';
        $user     = 'root';
        $pass     = '';
        $fecha    = date('Y-m-d_H-i-s');
        $archivo  = "backup_saphix_{$fecha}.sql";
        $ruta     = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $archivo;

        $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin\\mysqldump.exe';
        $comando = "\"{$mysqldump}\" --host={$host} --user={$user} --password={$pass} {$db} > \"{$ruta}\"";
        exec($comando, $output, $resultado);

        if ($resultado !== 0 || !file_exists($ruta)) {
            die('Error al generar el backup. Verifica que mysqldump esté disponible.');
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $archivo . '"');
        header('Content-Length: ' . filesize($ruta));
        readfile($ruta);
        unlink($ruta);
        exit();

    }
}