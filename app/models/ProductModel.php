<?php

class ProductModel extends Model {
    protected $table = 'productos';

    public function getAll() {
        $stmt = $this->db->query("
            SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO productos (nombre, descripcion, precio, stock, imagen_url, estado, categoria_id, proveedor_id)
            VALUES (:nombre, :descripcion, :precio, :stock, :imagen_url, :estado, :categoria_id, :proveedor_id)
        ");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[':id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE productos
            SET nombre = :nombre,
                descripcion = :descripcion,
                precio = :precio,
                stock = :stock,
                imagen_url = :imagen_url,
                estado = :estado,
                categoria_id = :categoria_id,
                proveedor_id = :proveedor_id
            WHERE id = :id
        ");
        return $stmt->execute($data);
    }

    public function getCategorias() {
        $stmt = $this->db->query("SELECT id, nombre FROM categorias WHERE estado = 1");
        return $stmt->fetchAll();
    }

    public function getProveedores() {
        $stmt = $this->db->query("SELECT id, nombre FROM proveedores WHERE estado = 1");
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM productos WHERE id = :id
    ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function search($q)
    {
        $stmt = $this->db->prepare("
        SELECT p.*, c.nombre AS categoria, pr.nombre AS proveedor
        FROM productos p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
        WHERE p.nombre LIKE :q OR p.descripcion LIKE :q
        ORDER BY p.created_at DESC
    ");
        $stmt->execute([':q' => '%' . $q . '%']);
        return $stmt->fetchAll();
    }
}
