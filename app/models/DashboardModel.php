<?php

class DashboardModel extends Model {
    protected $table = 'productos';

    public function getTotalProductos() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM productos WHERE estado = 1");
        return $stmt->fetch()['total'];
    }

    public function getStockBajo($limite = 5) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM productos WHERE stock <= :limite AND estado = 1");
        $stmt->execute([':limite' => $limite]);
        return $stmt->fetch()['total'];
    }

    public function getVentasHoy() {
        $stmt = $this->db->query("
            SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as monto
            FROM ventas
            WHERE DATE(fecha) = CURDATE() AND estado = 'completada'
        ");
        return $stmt->fetch();
    }

    public function getVentasSemana() {
    $stmt = $this->db->query("
        SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as monto
        FROM ventas
        WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        AND estado = 'completada'
    ");
    return $stmt->fetch();
    }

    public function getVentasMes() {
        $stmt = $this->db->query("
            SELECT COUNT(*) as total, COALESCE(SUM(total), 0) as monto
            FROM ventas
            WHERE MONTH(fecha) = MONTH(CURDATE())
            AND YEAR(fecha) = YEAR(CURDATE())
            AND estado = 'completada'
        ");
        return $stmt->fetch();
    }

    public function getTotalClientes() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM clientes");
        return $stmt->fetch()['total'];
    }

    public function getComprasMes() {
        $stmt = $this->db->query("
            SELECT COALESCE(SUM(total), 0) as monto
            FROM compras
            WHERE MONTH(fecha) = MONTH(CURDATE())
            AND YEAR(fecha) = YEAR(CURDATE())
        ");
        return $stmt->fetch()['monto'];
    }

    public function getUltimasVentas($limite = 5)
    {
        $stmt = $this->db->prepare("
        SELECT v.*, c.nombre AS cliente, u.nombre AS usuario
        FROM ventas v
        LEFT JOIN clientes c ON v.cliente_id = c.id
        LEFT JOIN usuarios u ON v.usuario_id = u.id
        WHERE DATE(v.fecha) = CURDATE()
        ORDER BY v.fecha DESC
        LIMIT :limite
    ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProductosStockBajo($limite = 5) {
        $stmt = $this->db->prepare("
            SELECT nombre, stock FROM productos
            WHERE stock <= :limite AND estado = 1
            ORDER BY stock ASC
        ");
        $stmt->execute([':limite' => $limite]);
        return $stmt->fetchAll();
    }
}