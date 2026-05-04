<?php

class DashboardController extends Controller {

    private $dashboardModel;

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        
        $this->dashboardModel = new DashboardModel();
    }

    public function index() {
        $ventasHoy    = $this->dashboardModel->getVentasHoy();
        $ventasMes    = $this->dashboardModel->getVentasMes();
        $ventasSemana = $this->dashboardModel->getVentasSemana();

        $this->view('dashboard/index', [
            'title'               => 'Dashboard',
            'activeMenu'          => 'dashboard',
            'userName'            => $_SESSION['user_name'],
            'userRole'            => $_SESSION['user_role'],
            'userInitials'        => strtoupper(substr($_SESSION['user_name'], 0, 2)),
            'totalProductos'      => $this->dashboardModel->getTotalProductos(),
            'stockBajo'           => $this->dashboardModel->getStockBajo(),
            'totalClientes'       => $this->dashboardModel->getTotalClientes(),
            'comprasMes'          => $this->dashboardModel->getComprasMes(),
            'ventasHoy'           => $ventasHoy['total'],
            'montoHoy'            => $ventasHoy['monto'],
            'ventasMes'           => $ventasMes['total'],
            'montoMes'            => $ventasMes['monto'],
            'ultimasVentas'       => $this->dashboardModel->getUltimasVentas(),
            'productosStockBajo'  => $this->dashboardModel->getProductosStockBajo(),
            'ventasSemana'  => $ventasSemana['total'],
            'montoSemana'   => $ventasSemana['monto'],
            
        ]);
    }
}