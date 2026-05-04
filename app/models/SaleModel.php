<?php

class SaleModel extends Model {
    protected $table = 'ventas';

    public function getAll() {
        $stmt = $this->db->query("
            SELECT v.*, c.nombre AS cliente, u.nombre AS usuario
            FROM ventas v
            LEFT JOIN clientes c ON v.cliente_id = c.id
            LEFT JOIN usuarios u ON v.usuario_id = u.id
            ORDER BY v.fecha DESC
        ");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT v.*, c.nombre AS cliente, u.nombre AS usuario
            FROM ventas v
            LEFT JOIN clientes c ON v.cliente_id = c.id
            LEFT JOIN usuarios u ON v.usuario_id = u.id
            WHERE v.id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getDetalle($venta_id) {
        $stmt = $this->db->prepare("
            SELECT dv.*, p.nombre AS producto
            FROM detalle_ventas dv
            LEFT JOIN productos p ON dv.producto_id = p.id
            WHERE dv.venta_id = :venta_id
        ");
        $stmt->execute([':venta_id' => $venta_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO ventas (cliente_id, usuario_id, fecha, metodo_pago, estado, subtotal, impuestos, total)
            VALUES (:cliente_id, :usuario_id, :fecha, :metodo_pago, :estado, :subtotal, :impuestos, :total)
        ");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function addDetalle($data) {
        $stmt = $this->db->prepare("
            INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario)
            VALUES (:venta_id, :producto_id, :cantidad, :precio_unitario)
        ");
        return $stmt->execute($data);
    }

    public function updateStock($producto_id, $cantidad) {
        $stmt = $this->db->prepare("
            UPDATE productos
            SET stock = stock - :cantidad
            WHERE id = :id
        ");
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id'       => $producto_id
        ]);
    }

    public function cancelar($id) {
        $stmt = $this->db->prepare("
            UPDATE ventas
            SET estado = 'cancelada', cancelada_at = NOW()
            WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }

    public function search($q)
    {
        $stmt = $this->db->prepare("
        SELECT v.*, c.nombre AS cliente, u.nombre AS usuario
        FROM ventas v
        LEFT JOIN clientes c ON v.cliente_id = c.id
        LEFT JOIN usuarios u ON v.usuario_id = u.id
        WHERE c.nombre LIKE :q 
        OR u.nombre LIKE :q
        OR v.estado LIKE :q
        OR v.metodo_pago LIKE :q
        ORDER BY v.fecha DESC
    ");
        $stmt->execute([':q' => '%' . $q . '%']);
        return $stmt->fetchAll();
    }
}