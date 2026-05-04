<?php

class PurchaseModel extends Model {
    protected $table = 'compras';

    public function getAll() {
        $stmt = $this->db->query("
            SELECT c.*, p.nombre AS proveedor
            FROM compras c
            LEFT JOIN proveedores p ON c.proveedor_id = p.id
            ORDER BY c.fecha DESC
        ");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT c.*, p.nombre AS proveedor
            FROM compras c
            LEFT JOIN proveedores p ON c.proveedor_id = p.id
            WHERE c.id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getDetalle($compra_id) {
        $stmt = $this->db->prepare("
            SELECT dc.*, pr.nombre AS producto
            FROM detalle_compras dc
            LEFT JOIN productos pr ON dc.producto_id = pr.id
            WHERE dc.compra_id = :compra_id
        ");
        $stmt->execute([':compra_id' => $compra_id]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO compras (proveedor_id, fecha, total)
            VALUES (:proveedor_id, :fecha, :total)
        ");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function addDetalle($data) {
        $stmt = $this->db->prepare("
            INSERT INTO detalle_compras (compra_id, producto_id, cantidad, costo_unitario)
            VALUES (:compra_id, :producto_id, :cantidad, :costo_unitario)
        ");
        return $stmt->execute($data);
    }

    public function updateStock($producto_id, $cantidad) {
        $stmt = $this->db->prepare("
            UPDATE productos
            SET stock = stock + :cantidad
            WHERE id = :id
        ");
        return $stmt->execute([
            ':cantidad' => $cantidad,
            ':id'       => $producto_id
        ]);
    }

    public function search($q)
    {
        $stmt = $this->db->prepare("
        SELECT c.*, p.nombre AS proveedor
        FROM compras c
        LEFT JOIN proveedores p ON c.proveedor_id = p.id
        WHERE p.nombre LIKE :q
        OR c.fecha LIKE :q
        ORDER BY c.fecha DESC
    ");
        $stmt->execute([':q' => '%' . $q . '%']);
        return $stmt->fetchAll();
    }
}