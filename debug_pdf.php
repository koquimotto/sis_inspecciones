<?php
chdir(__DIR__);
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.certificado-inspeccion', [
    'inspeccion' => (object)['id' => 1, 'codigo_formateado' => '26-0001-XX-069'],
    'detalle' => (object)['inspeccion_estado' => 'aprobado'],
    'empresa' => (object)['razon_social' => 'EMPRESA DEMO S.A.C.', 'ruc' => '20123456789'],
    'equipo' => (object)['descripcion' => 'Equipo de elevacion DEMO'],
    'empresaEquipo' => (object)['serie_codigo' => 'AB C-123'],
    'observedParametersCount' => 0,
    'selectedFilesCount' => 0,
    'imagePages' => [],
    'pdfPages' => [],
    'nonImageAttachments' => [],
])->setPaper('a4', 'portrait');
file_put_contents('storage/app/debug-cert-new.pdf', $pdf->output());
echo "ok\n";
