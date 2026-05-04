<?php

session_start();


define('ROOT', dirname(__DIR__));


require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/core/Database.php';
require_once ROOT . '/core/Model.php';
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/core/App.php';
require_once ROOT . '/app/models/UserModel.php';
require_once ROOT . '/app/controllers/AuthController.php';
require_once ROOT . '/app/controllers/DashboardController.php';
require_once ROOT . '/app/models/ProductModel.php';
require_once ROOT . '/app/controllers/ProductController.php';
require_once ROOT . '/app/models/CategoryModel.php';
require_once ROOT . '/app/controllers/CategoryController.php';
require_once ROOT . '/app/models/SupplierModel.php';
require_once ROOT . '/app/controllers/SupplierController.php';
require_once ROOT . '/app/models/ClientModel.php';
require_once ROOT . '/app/controllers/ClientController.php';
require_once ROOT . '/app/controllers/UserController.php';
require_once ROOT . '/app/models/PurchaseModel.php';
require_once ROOT . '/app/controllers/PurchaseController.php';
require_once ROOT . '/app/models/SaleModel.php';
require_once ROOT . '/app/controllers/SaleController.php';
require_once ROOT . '/app/models/DashboardModel.php';
require_once ROOT . '/core/Permission.php';
require_once ROOT . '/app/controllers/ProfileController.php';
require_once ROOT . '/app/controllers/ExportController.php';


$app = new App();