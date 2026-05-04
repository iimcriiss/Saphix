<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Dompdf\Dompdf;
use Dompdf\Options;

class ExportController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    public function export($modulo, $formato) {
        $datos  = $this->getDatos($modulo);
        $campos = $this->getCampos($modulo);
        $titulo = $this->getTitulo($modulo);

        switch ($formato) {
            case 'xlsx': $this->exportExcel($datos, $campos, $titulo); break;
            case 'csv':  $this->exportCsv($datos, $campos, $titulo);   break;
            case 'pdf':  $this->exportPdf($datos, $campos, $titulo);   break;
            default:     $this->redirect('/dashboard');
        }
    }

    private function getDatos($modulo) {
        switch ($modulo) {
            case 'productos':
                Permission::require('productos.ver');
                $model = new ProductModel();
                return $model->getAll();
            case 'categorias':
                Permission::require('categorias.ver');
                $model = new CategoryModel();
                return $model->getAll();
            case 'clientes':
                Permission::require('clientes.ver');
                $model = new ClientModel();
                return $model->getAll();
            case 'proveedores':
                Permission::require('proveedores.ver');
                $model = new SupplierModel();
                return $model->getAll();
            case 'ventas':
                Permission::require('ventas.ver');
                $model = new SaleModel();
                return $model->getAll();
            case 'compras':
                Permission::require('compras.ver');
                $model = new PurchaseModel();
                return $model->getAll();
            case 'usuarios':
                Permission::require('usuarios.ver');
                $model = new UserModel();
                return $model->getAll();
            default:
                return [];
        }
    }

    private function getCampos($modulo) {
        $campos = [
            'productos'   => ['ID' => 'id', 'Nombre' => 'nombre', 'Categoría' => 'categoria', 'Proveedor' => 'proveedor', 'Precio' => 'precio', 'Stock' => 'stock', 'Estado' => 'estado'],
            'categorias'  => ['ID' => 'id', 'Nombre' => 'nombre', 'Descripción' => 'descripcion', 'Categoría padre' => 'categoria_padre', 'Estado' => 'estado'],
            'clientes'    => ['ID' => 'id', 'Nombre' => 'nombre', 'Email' => 'email', 'Teléfono' => 'telefono', 'Dirección' => 'direccion'],
            'proveedores' => ['ID' => 'id', 'Nombre' => 'nombre', 'Contacto' => 'contacto', 'Teléfono' => 'telefono', 'Email' => 'email', 'Dirección' => 'direccion', 'Estado' => 'estado'],
            'ventas'      => ['ID' => 'id', 'Cliente' => 'cliente', 'Vendedor' => 'usuario', 'Fecha' => 'fecha', 'Total' => 'total', 'Estado' => 'estado'],
            'compras'     => ['ID' => 'id', 'Proveedor' => 'proveedor', 'Fecha' => 'fecha', 'Total' => 'total'],
            'usuarios'    => ['ID' => 'id', 'Nombre' => 'nombre', 'Email' => 'email', 'Estado' => 'estado'],
        ];
        return $campos[$modulo] ?? [];
    }

    private function getTitulo($modulo) {
        $titulos = [
            'productos'   => 'Productos',
            'categorias'  => 'Categorías',
            'clientes'    => 'Clientes',
            'proveedores' => 'Proveedores',
            'ventas'      => 'Ventas',
            'compras'     => 'Compras',
            'usuarios'    => 'Usuarios',
        ];
        return $titulos[$modulo] ?? $modulo;
    }

    private function exportExcel($datos, $campos, $titulo) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($titulo);

        $colIndex = 1;
        foreach ($campos as $header => $key) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->setCellValue($colLetter . '1', $header);
            $sheet->getStyle($colLetter . '1')->getFont()->setBold(true);
            $sheet->getStyle($colLetter . '1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF3730A3');
            $sheet->getStyle($colLetter . '1')->getFont()->getColor()->setARGB('FFFFFFFF');
            $colIndex++;
        }

        $rowIndex = 2;
        foreach ($datos as $fila) {
            $colIndex = 1;
            foreach ($campos as $header => $key) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                $valor = $fila[$key] ?? '';
                if ($key === 'estado' && is_numeric($valor)) {
                    $valor = $valor ? 'Activo' : 'Inactivo';
                }
                $sheet->setCellValue($colLetter . $rowIndex, $valor);
                $colIndex++;
            }
            $rowIndex++;
        }

        for ($i = 1; $i <= count($campos); $i++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $titulo . '_' . date('Y-m-d') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function exportCsv($datos, $campos, $titulo) {
        error_reporting(0);
        ob_end_clean();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment;filename="' . $titulo . '_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, array_keys($campos));

        foreach ($datos as $fila) {
            $row = [];
            foreach ($campos as $header => $key) {
                $valor = $fila[$key] ?? '';
                if ($key === 'estado' && is_numeric($valor)) {
                    $valor = $valor ? 'Activo' : 'Inactivo';
                }
                $row[] = $valor;
            }
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    private function exportPdf($datos, $campos, $titulo) {
        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 11px; }
            h2 { color: #3730a3; margin-bottom: 6px; }
            table { width: 100%; border-collapse: collapse; }
            th { background: #3730a3; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
            td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; font-size: 10px; }
            tr:nth-child(even) td { background: #f9fafb; }
            .fecha { font-size: 9px; color: #6b7280; margin-bottom: 8px; }
        </style>
        <h2>' . $titulo . '</h2>
        <p class="fecha">Exportado el ' . date('d/m/Y H:i') . '</p>
        <table><thead><tr>';

        foreach ($campos as $header => $key) {
            $html .= '<th>' . $header . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($datos as $fila) {
            $html .= '<tr>';
            foreach ($campos as $header => $key) {
                $valor = $fila[$key] ?? '—';
                if ($key === 'estado' && is_numeric($valor)) {
                    $valor = $valor ? 'Activo' : 'Inactivo';
                }
                $html .= '<td>' . htmlspecialchars((string)$valor) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream($titulo . '_' . date('Y-m-d') . '.pdf', ['Attachment' => true]);
        exit;
    }
}