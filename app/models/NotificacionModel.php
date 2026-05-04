<?php

class NotificacionModel extends Model {
    protected $table = 'notificaciones';

    public function getNoLeidas() {
        $stmt = $this->db->query("
            SELECT * FROM notificaciones
            WHERE leida = 0
            ORDER BY created_at DESC
            LIMIT 10
        ");
        return $stmt->fetchAll();
    }

    public function contarNoLeidas() {
        $stmt = $this->db->query("
            SELECT COUNT(*) as total FROM notificaciones WHERE leida = 0
        ");
        return $stmt->fetch()['total'];
    }

    public function marcarLeida($id) {
        $stmt = $this->db->prepare("
            UPDATE notificaciones SET leida = 1 WHERE id = :id
        ");
        return $stmt->execute([':id' => $id]);
    }

    public function marcarTodasLeidas() {
        $stmt = $this->db->query("
            UPDATE notificaciones SET leida = 1 WHERE leida = 0
        ");
        return $stmt->execute();
    }

    public function crear($tipo, $mensaje, $url = null) {
        $stmt = $this->db->prepare("
            INSERT INTO notificaciones (tipo, mensaje, url)
            VALUES (:tipo, :mensaje, :url)
        ");
        return $stmt->execute([
            ':tipo'    => $tipo,
            ':mensaje' => $mensaje,
            ':url'     => $url
        ]);
    }
}