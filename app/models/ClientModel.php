<?php

class ClientModel extends Model {
    protected $table = 'clientes';

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO clientes (nombre, email, telefono, direccion)
            VALUES (:nombre, :email, :telefono, :direccion)
        ");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[':id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE clientes
            SET nombre    = :nombre,
                email     = :email,
                telefono  = :telefono,
                direccion = :direccion
            WHERE id = :id
        ");
        return $stmt->execute($data);
    }

    public function search($q) {
    $stmt = $this->db->prepare("
        SELECT * FROM clientes 
        WHERE nombre LIKE :q 
        OR email LIKE :q 
        OR telefono LIKE :q
        ORDER BY nombre ASC
    ");
    $stmt->execute([':q' => '%' . $q . '%']);
    return $stmt->fetchAll();
}
}