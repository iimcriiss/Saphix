<?php

class CategoryModel extends Model {
    protected $table = 'categorias';

    public function getAll() {
        $stmt = $this->db->query("
            SELECT c.*, p.nombre AS categoria_padre
            FROM categorias c
            LEFT JOIN categorias p ON c.categoria_padre_id = p.id
            ORDER BY c.id DESC
        ");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO categorias (nombre, descripcion, categoria_padre_id, estado)
            VALUES (:nombre, :descripcion, :categoria_padre_id, :estado)
        ");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[':id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE categorias
            SET nombre = :nombre,
                descripcion = :descripcion,
                categoria_padre_id = :categoria_padre_id,
                estado = :estado
            WHERE id = :id
        ");
        return $stmt->execute($data);
    }

    public function getAllActivas() {
        $stmt = $this->db->query("SELECT id, nombre FROM categorias WHERE estado = 1");
        return $stmt->fetchAll();
    }

    public function search($q)
    {
        $stmt = $this->db->prepare("
        SELECT c.*, p.nombre AS categoria_padre
        FROM categorias c
        LEFT JOIN categorias p ON c.categoria_padre_id = p.id
        WHERE c.nombre LIKE :q OR c.descripcion LIKE :q
        ORDER BY c.id DESC
    ");
        $stmt->execute([':q' => '%' . $q . '%']);
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM categorias WHERE id = :id
    ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}