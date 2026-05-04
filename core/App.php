<?php

class App {
    private $controller;
    private $method;
    private $params;

    public function __construct() {
        $url = $this->parseUrl();

        $routes = [
            'login'      => ['controller' => 'AuthController',      'method' => 'login'],
            'logout'     => ['controller' => 'AuthController',      'method' => 'logout'],
            'dashboard'  => ['controller' => 'DashboardController', 'method' => 'index'],
            'productos'  => ['controller' => 'ProductController',   'method' => 'index'],
            'categorias' => ['controller' => 'CategoryController', 'method' => 'index'],
            'proveedores' => ['controller' => 'SupplierController', 'method' => 'index'],
            'clientes' => ['controller' => 'ClientController', 'method' => 'index'],
            'usuarios' => ['controller' => 'UserController', 'method' => 'index'],
            'compras' => ['controller' => 'PurchaseController', 'method' => 'index'],
            'ventas' => ['controller' => 'SaleController', 'method' => 'index'],
            'perfil' => ['controller' => 'ProfileController', 'method' => 'password'],
            'usuarios' => ['controller' => 'UserController', 'method' => 'index'],
            'notificaciones' => ['controller' => 'NotificacionController', 'method' => 'index'],
            'buscar' => ['controller' => 'SearchController', 'method' => 'index'],
            'exportar' => ['controller' => 'ExportController', 'method' => 'export'],
            'reportes' => ['controller' => 'ReportsController', 'method' => 'cierreCaja'],
            'reportes/backup' => ['controller' => 'ReporteController', 'method' => 'backup'],
            'home' => ['controller' => 'HomeController', 'method' => 'index'],
        ];

        $segment = isset($url[0]) ? $url[0] : 'home';

        if (isset($routes[$segment])) {
            $controllerName = $routes[$segment]['controller'];
            // Si la ruta tiene método fijo, usarlo siempre
            if ($segment === 'exportar') {
                $this->method = 'export';
            } else {
                $this->method   = isset($url[1]) ? $url[1] : $routes[$segment]['method'];
            }
        } else {
            $controllerName = ucfirst($segment) . 'Controller';
            $this->method   = isset($url[1]) ? $url[1] : 'index';
        }

        $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = new $controllerName();
        } else {
            http_response_code(404);
            // Cargamos la vista 404 usando el layout normal de Saphix
            $title = 'Página no encontrada';
            // Intentar cargar con sesión activa (layout completo) o sin ella
            if (isset($_SESSION['user_id'])) {
                ob_start();
                require_once __DIR__ . '/../app/views/errors/404.php';
            } else {
                require_once __DIR__ . '/../app/views/errors/404_guest.php';
            }
            exit;
        }

        if (!method_exists($this->controller, $this->method)) {
            http_response_code(404);
            if (isset($_SESSION['user_id'])) {
                ob_start();
                require_once __DIR__ . '/../app/views/errors/404.php';
            } else {
                require_once __DIR__ . '/../app/views/errors/404_guest.php';
            }
            exit;
        }

        if ($segment === 'exportar') {
            $this->params = isset($url[1]) ? array_slice($url, 1) : [];
        } else {
            $this->params = isset($url[2]) ? array_slice($url, 2) : [];
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['home'];
    }
}