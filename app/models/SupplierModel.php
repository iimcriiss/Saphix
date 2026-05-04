<?php

class SupplierModel extends Model {
    protected $table = 'proveedores';

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO proveedores (nombre, contacto, telefono, email, direccion, estado)
            VALUES (:nombre, :contacto, :telefono, :email, :direccion, :estado)
        ");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[':id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE proveedores
            SET nombre    = :nombre,
                contacto  = :contacto,
                telefono  = :telefono,
                email     = :email,
                direccion = :direccion,
                estado    = :estado
            WHERE id = :id
        ");
        return $stmt->execute($data);
    }

    public function getAll()
    {
        $stmt = $this->db->query("
        SELECT * FROM proveedores ORDER BY nombre ASC
    ");
        return $stmt->fetchAll();
    }

    public function search($q)
    {
        $stmt = $this->db->prepare("
        SELECT * FROM proveedores
        WHERE nombre LIKE :q OR contacto LIKE :q OR email LIKE :q
        ORDER BY nombre ASC
    ");
        $stmt->execute([':q' => '%' . $q . '%']);
        return $stmt->fetchAll();
    }
}