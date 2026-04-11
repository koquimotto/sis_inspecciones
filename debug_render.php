<?php
chdir(__DIR__);
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$html = view('pdf.certificado-inspeccion', [
    'inspeccion' => (object)['id' => 1, 'codigo_formateado' => 'X-1'],
    'detalle' => (object)['inspeccion_estado' => 'aprobado'],
    'empresa' => (object)['razon_social' => 'EMPRESA TEST', 'ruc' => '123'],
    'equipo' => (object)['descripcion' => 'VOLQUETE'],
    'empresaEquipo' => (object)['serie_codigo' => 'ABC'],
    'observedParametersCount' => 0,
    'selectedFilesCount' => 0,
    'imagePages' => [],
    'pdfPages' => [],
    'nonImageAttachments' => [],
])->render();

file_put_contents('storage/app/cert_view_debug.html', $html);
echo "ok\n";
