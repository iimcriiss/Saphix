<?php

class UserModel extends Model {
    protected $table = 'usuarios';

    public function getAll() {
        $stmt = $this->db->query("
            SELECT u.*, r.nombre AS rol
            FROM usuarios u
            LEFT JOIN roles r ON u.rol_id = r.id
            ORDER BY u.id DESC
        ");
        return $stmt->fetchAll();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table}
            WHERE email = :email AND estado = 1 LIMIT 1
        ");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO usuarios (nombre, email, password, rol_id, estado)
            VALUES (:nombre, :email, :password, :rol_id, :estado)
        ");
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function update($id, $data) {
        $data[':id'] = $id;
        $stmt = $this->db->prepare("
            UPDATE usuarios
            SET nombre = :nombre,
                email  = :email,
                rol_id = :rol_id,
                estado = :estado
            WHERE id = :id
        ");
        return $stmt->execute($data);
    }

    public function updatePassword($id, $password) {
        $stmt = $this->db->prepare("
            UPDATE usuarios SET password = :password WHERE id = :id
        ");
        return $stmt->execute([
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':id'       => $id
        ]);
    }

    public function getRoles() {
        $stmt = $this->db->query("SELECT id, nombre FROM roles");
        return $stmt->fetchAll();
    }

    public function getRolById($rol_id) {
    $stmt = $this->db->prepare("SELECT * FROM roles WHERE id = :id");
    $stmt->execute([':id' => $rol_id]);
    return $stmt->fetch();
    }

    public function updatePermisos($id, $permisos) {
    $stmt = $this->db->prepare("
        UPDATE usuarios SET permisos = :permisos WHERE id = :id
    ");
    return $stmt->execute([
        ':permisos' => $permisos,
        ':id'       => $id
    ]);
    }

    public function search($q)
    {
        $stmt = $this->db->prepare("
        SELECT u.*, r.nombre AS rol
        FROM usuarios u
        LEFT JOIN roles r ON u.rol_id = r.id
        WHERE u.nombre LIKE :q OR u.email LIKE :q
        ORDER BY u.id DESC
    ");
        $stmt->execute([':q' => '%' . $q . '%']);
        return $stmt->fetchAll();
    }
}