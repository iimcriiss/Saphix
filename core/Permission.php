<?php

class Permission {

    public static function check($permiso) {
        if (!isset($_SESSION['user_permisos'])) {
            return false;
        }

        $permisos = $_SESSION['user_permisos'];

        if ($permisos === 'all') {
            return true;
        }

        $lista = array_map('trim', explode(',', $permisos));
        return in_array($permiso, $lista);
    }

    public static function require($permiso) {
        if (!self::check($permiso)) {
            header("Location: /dashboard");
            exit();
        }
    }

    public static function can($permiso) {
        return self::check($permiso);
    }
}