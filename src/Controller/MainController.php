<?php
namespace App\Controller;

use App\Model\EmployeeModel;
use App\Model\SalesModel;
use App\Service\FinanceService;
use App\Service\UnitConverterService;
use Intervention\Image\ImageManager; // v3
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class MainController
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    private function render(string $view, array $params = []): void
    {
        extract($params);
        $appName = $this->config['app_name'] ?? 'App';
        require __DIR__ . '/../View/layout.php';
    }

    public function home(): void
    {
        $this->render('home', []);
    }

    public function processEmployees(): void
    {
        $json = $_POST['employees_json'] ?? '';
        $employees = json_decode($json, true) ?: [];

        $model = new EmployeeModel($employees);
        $avgByDept = $model->averageSalaryByDepartment();
        $topDept = $model->departmentWithHighestAverage();
        $aboveAvg = $model->employeesAboveDepartmentAverage();

        $this->render('results', [
            'title' => 'Resultados Empleados',
            'sections' => [
                ['Promedios por departamento', $avgByDept],
                ['Depto con mayor salario promedio', $topDept],
                ['Empleados sobre el promedio de su depto', $aboveAvg],
            ]
        ]);
    }

    public function processSales(): void
    {
        $json = $_POST['sales_json'] ?? '';
        $ventas = json_decode($json, true) ?: [];

        $model = new SalesModel($ventas);
        $totalVentas = $model->totalSalesCount();
        $topCliente = $model->topSpender();
        $productoMasVendido = $model->topProductByQuantity();

        $this->render('results', [
            'title' => 'Resultados Ventas',
            'sections' => [
                ['Total de ventas (conteo)', $totalVentas],
                ['Cliente que más gastó', $topCliente],
                ['Producto más vendido', $productoMasVendido],
            ]
        ]);
    }

    public function mathTools(): void
    {
        $finance = new FinanceService();
        $units = new UnitConverterService();

        $ci = null; $net = null; $conv = null;

        if (isset($_POST['ci_principal'])) {
            $ci = $finance->compoundInterest(
                (float)$_POST['ci_principal'],
                (float)$_POST['ci_rate'],
                (int)$_POST['ci_years'],
                (int)($_POST['ci_n'] ?? 12)
            );
        }
        if (isset($_POST['col_gross'])) {
            $net = $finance->netSalaryColombia((float)$_POST['col_gross']);
        }
        if (isset($_POST['conv_type'])) {
            $conv = match ($_POST['conv_type']) {
                'c2f' => $units->celsiusToFahrenheit((float)$_POST['conv_value']),
                'kmh2ms' => $units->kmhToMs((float)$_POST['conv_value']),
                default => null,
            };
        }

        $this->render('results', [
            'title' => 'Herramientas Matemáticas',
            'sections' => array_filter([
                ['Interés compuesto', $ci],
                ['Salario neto (CO) — simplificado', $net],
                ['Conversión', $conv],
            ], fn($s) => $s[1] !== null)
        ]);
    }

    public function processImage(): void
    {
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $this->render('results', ['title' => 'Imagen', 'sections' => [['Error', 'No se recibió archivo válido.']]]);
            return;
        }
        // Asegura carpeta
        $uploadDir = $this->config['upload_dir'];
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

        // Nombres
        $tmp  = $_FILES['photo']['tmp_name'];
        $name = basename($_FILES['photo']['name']);
        $san  = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $name);
        $file = uniqid('img_') . '_' . $san;

        // Ruta FÍSICA donde guardar
        $destFs = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file;

        // Intervention Image v3 (GD)
        $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
        $manager->read($tmp)
            ->scale(450, 450, function ($c) { $c->keepAspectRatio(); $c->preventUpsizing(); })
            ->toJpeg(80)
            ->save($destFs);

        // URL PÚBLICA (siempre con /, no con backslashes)
        $publicUrl = '/assets/uploads/' . $file;

        $this->render('results', [
            'title' => 'Imagen procesada',
            'sections' => [[
                'Archivo',
                '<img src="' . htmlspecialchars($publicUrl, ENT_QUOTES) . '" class="img-fluid rounded" alt="Imagen procesada" />'
            ]]
        ]);
    }

    public function sendTestMail(): void
    {
        $dsn = $this->config['smtp']['dsn'];
        $transport = Transport::fromDsn($dsn);
        $mailer = new Mailer($transport);

        $to = $_POST['to'] ?? 'test@example.com';
        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($to)
            ->subject('Prueba Symfony Mailer')
            ->html('<p>Este es un email de prueba enviado desde la app.</p>');

        try {
            $mailer->send($email);
            $msg = 'Correo enviado a ' . htmlspecialchars($to);
        } catch (\Throwable $e) {
            $msg = 'Error enviando correo: ' . $e->getMessage();
        }
        $this->render('results', ['title' => 'Mailer', 'sections' => [['Estado', $msg]]]);
    }
}

