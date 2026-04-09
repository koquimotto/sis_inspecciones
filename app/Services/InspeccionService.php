<?php

namespace App\Services;

use App\Models\Certificado;
use App\Models\DetalleInspeccion;
use App\Models\Inspeccion;
use App\Models\InspeccionArchivoEquipo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InspeccionService
{
    public function generateDetailReportPdf(Inspeccion $inspeccion, DetalleInspeccion $detalle, ?int $actorId, bool $forceGenerate = true): ?string
    {
        if ((int) $detalle->inspeccion_id !== (int) $inspeccion->id) {
            return null;
        }

        if (!$forceGenerate) {
            return $this->getGeneratedDetailReportPath($inspeccion, $detalle);
        }

        $lines = $this->extractLinesFromRenderedView(
            view('pdf.informe-detallado-inspeccion', [
                'inspeccion' => $inspeccion,
                'detalle' => $detalle,
                'empresa' => $inspeccion->empresa,
                'equipo' => $inspeccion->equipo,
            ])->render()
        );

        $relative = $this->storePdfFromPages(
            $inspeccion,
            (string) $detalle->inespeccion_numero,
            'resumen-inspeccion',
            [[
                'title' => 'REPORTE DETALLADO',
                'lines' => $lines,
                'image' => null,
            ]],
            public_path('img/plantilla.png')
        );

        if (!$relative) {
            return null;
        }

        $detalle->update([
            'pdf_ruta' => $relative,
            'updated_by' => $actorId,
        ]);

        InspeccionArchivoEquipo::query()->create([
            'inspeccion_id' => (int) $inspeccion->id,
            'archivo_descripcion' => $this->sanitizeStorageText(
                'Reporte detallado inspeccion ' . (string) $detalle->inespeccion_numero . ' detalle ' . (int) $detalle->id
            ),
            'archivo_autogenerado' => 1,
            'archivo_tipo' => 'pdf',
            'archivo_ruta' => $relative,
            'archivo_origen' => 'autogenerado',
            'mostrar_certificado' => 0,
            'estado' => 1,
            'created_by' => $actorId,
            'updated_by' => $actorId,
        ]);

        return $relative;
    }

    public function generateInspectionCertificatePdf(
        Inspeccion $inspeccion,
        DetalleInspeccion $detalle,
        int $observedParametersCount
    ): ?string {
        if ((int) $detalle->inspeccion_id !== (int) $inspeccion->id) {
            return null;
        }

        $selectedFiles = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', (int) $inspeccion->id)
            ->where('estado', 1)
            ->where('mostrar_certificado', 1)
            ->orderBy('id')
            ->get();

        $summaryLines = $this->extractLinesFromRenderedView(
            view('pdf.certificado-inspeccion', [
                'inspeccion' => $inspeccion,
                'detalle' => $detalle,
                'empresa' => $inspeccion->empresa,
                'equipo' => $inspeccion->equipo,
                'empresaEquipo' => $inspeccion->empresaEquipo,
                'observedParametersCount' => $observedParametersCount,
                'selectedFilesCount' => $selectedFiles->count(),
            ])->render()
        );

        $pages = [[
            'title' => 'CERTIFICADO DE INSPECCION',
            'lines' => $summaryLines,
            'image' => null,
        ]];

        foreach ($selectedFiles as $file) {
            $absolutePath = public_path((string) $file->archivo_ruta);
            $attachmentImage = $this->prepareJpegForPdf($absolutePath);
            if ($attachmentImage) {
                $pages[] = [
                    'title' => 'ANEXO - ' . (string) ($file->archivo_descripcion ?: ('Archivo #' . $file->id)),
                    'lines' => [
                        'Archivo: ' . (string) ($file->archivo_descripcion ?: ('Adjunto #' . $file->id)),
                        'Tipo: ' . strtoupper((string) ($file->archivo_tipo ?: 'archivo')),
                    ],
                    'image' => $attachmentImage['path'],
                ];
                continue;
            }

            $pages[] = [
                'title' => 'ANEXO - ' . (string) ($file->archivo_descripcion ?: ('Archivo #' . $file->id)),
                'lines' => [
                    'Archivo no visualizable como imagen dentro del PDF.',
                    'Descripcion: ' . (string) ($file->archivo_descripcion ?: '-'),
                    'Ruta: ' . (string) ($file->archivo_ruta ?: '-'),
                ],
                'image' => null,
            ];
        }

        return $this->storePdfFromPages(
            $inspeccion,
            (string) $detalle->inespeccion_numero,
            'certificado',
            $pages,
            public_path('img/plantilla.png')
        );
    }

    public function getGeneratedCertificatePath(Inspeccion $inspeccion): ?string
    {
        $cert = Certificado::query()
            ->where('inspeccion_id', (int) $inspeccion->id)
            ->where('anulado', 0)
            ->latest('id')
            ->first();

        return filled($cert?->pdf_ruta) ? (string) $cert->pdf_ruta : null;
    }

    public function getGeneratedDetailReportPath(Inspeccion $inspeccion, DetalleInspeccion $detalle): ?string
    {
        if ((int) $detalle->inspeccion_id !== (int) $inspeccion->id) {
            return null;
        }

        if (filled($detalle->pdf_ruta)) {
            return (string) $detalle->pdf_ruta;
        }

        $latestReport = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', (int) $inspeccion->id)
            ->where('archivo_origen', 'autogenerado')
            ->where('archivo_descripcion', 'like', 'Reporte detallado%')
            ->latest('id')
            ->first();

        return filled($latestReport?->archivo_ruta) ? (string) $latestReport->archivo_ruta : null;
    }

    private function storePdfFromPages(Inspeccion $inspeccion, string $numeroInspeccion, string $prefix, array $pages, ?string $templatePath = null): ?string
    {
        $folderInfo = $this->resolveTargetFolder($inspeccion, $numeroInspeccion, 'archivos_generados');
        if (!$folderInfo) {
            return null;
        }

        $templateImage = $this->prepareJpegForPdf((string) $templatePath);
        $pdfBinary = $this->buildRichPdfDocument($pages, $templateImage['path'] ?? null);

        $fileName = $this->buildGeneratedPdfFileName($prefix, $numeroInspeccion);
        $absoluteFile = $folderInfo['abs'] . DIRECTORY_SEPARATOR . $fileName;
        File::put($absoluteFile, $pdfBinary);

        if ($templateImage && !empty($templateImage['cleanup'])) {
            File::delete((string) $templateImage['path']);
        }

        foreach ($pages as $page) {
            if (!empty($page['image']) && str_contains((string) $page['image'], 'tmp_pdf_')) {
                File::delete((string) $page['image']);
            }
        }

        return $folderInfo['rel'] . '/' . $fileName;
    }

    private function resolveTargetFolder(Inspeccion $inspeccion, string $codigoInspeccion, string $bucket): ?array
    {
        $empresaEquipo = $inspeccion->empresaEquipo;
        $serieTipo = trim((string) ($empresaEquipo?->serie_tipo ?: 'SERIE'));
        $serieCodigo = trim((string) ($empresaEquipo?->serie_codigo ?: ('EQ-' . $inspeccion->empresa_equipo_id)));
        $codigoInspeccion = trim($codigoInspeccion);
        $bucket = trim($bucket);

        $serieFolder = $this->sanitizePathSegment($serieTipo . '_' . $serieCodigo, 'serie');
        $codigoFolder = $this->sanitizePathSegment($codigoInspeccion, 'inspeccion');
        $bucketFolder = $this->sanitizePathSegment($bucket, 'archivos_generados');

        $targetRelativePath = 'uploads/' . $serieFolder . '/' . $codigoFolder . '/' . $bucketFolder;
        $targetDirectory = public_path($targetRelativePath);
        if (!File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        return ['rel' => $targetRelativePath, 'abs' => $targetDirectory];
    }

    private function buildGeneratedPdfFileName(string $prefix, string $codigoInspeccion): string
    {
        $timestamp = now()->format('Ymd_His');
        $codigo = $this->sanitizeFileToken($codigoInspeccion, 'inspeccion');
        $normalizedPrefix = Str::of(trim($prefix))
            ->lower()
            ->replaceMatches('/[^a-z0-9\-]+/u', '-')
            ->trim('-')
            ->value();

        if ($normalizedPrefix === 'certificado') {
            return "certificado-{$timestamp}-{$codigo}.pdf";
        }

        if ($normalizedPrefix === 'resumen-inspeccion' || $normalizedPrefix === 'reporte-detallado') {
            return "resumen-inspeccion-{$timestamp}-{$codigo}.pdf";
        }

        $fallbackPrefix = $normalizedPrefix !== '' ? $normalizedPrefix : 'documento';
        return "{$fallbackPrefix}-{$timestamp}-{$codigo}.pdf";
    }

    private function sanitizePathSegment(string $value, string $fallback): string
    {
        $segment = Str::of(trim($value))
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9\-_]+/u', '_')
            ->trim('_')
            ->value();

        return $segment !== '' ? $segment : $fallback;
    }

    private function sanitizeFileToken(string $value, string $fallback): string
    {
        $token = Str::of(trim($value))
            ->lower()
            ->replaceMatches('/[^a-z0-9\-_]+/u', '-')
            ->trim('-_')
            ->value();

        return $token !== '' ? $token : $fallback;
    }

    private function prepareJpegForPdf(?string $absolutePath): ?array
    {
        if (!$absolutePath || !File::exists($absolutePath)) {
            return null;
        }

        $imageInfo = @getimagesize($absolutePath);
        if (!$imageInfo || empty($imageInfo['mime'])) {
            return null;
        }

        $mime = strtolower((string) $imageInfo['mime']);
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            return [
                'path' => $absolutePath,
                'cleanup' => false,
            ];
        }

        if (!function_exists('imagecreatefromstring') || !function_exists('imagejpeg')) {
            return null;
        }

        $raw = @file_get_contents($absolutePath);
        if ($raw === false) {
            return null;
        }

        $source = @imagecreatefromstring($raw);
        if (!$source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $canvas = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopy($canvas, $source, 0, 0, 0, 0, $width, $height);

        $tmpPath = storage_path('app/tmp_pdf_' . Str::random(24) . '.jpg');
        @imagejpeg($canvas, $tmpPath, 88);
        imagedestroy($source);
        imagedestroy($canvas);

        if (!File::exists($tmpPath)) {
            return null;
        }

        return [
            'path' => $tmpPath,
            'cleanup' => true,
        ];
    }

    private function extractLinesFromRenderedView(string $html): array
    {
        $normalized = str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>', '</li>', '</h1>', '</h2>', '</h3>'], "\n", $html);
        $text = strip_tags($normalized);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $lines = preg_split('/\r\n|\r|\n/', $text) ?: [];
        $lines = array_values(array_filter(array_map(fn ($line) => trim((string) $line), $lines), fn ($line) => $line !== ''));
        return array_slice($lines, 0, 24);
    }

    private function sanitizeStorageText(string $value): string
    {
        $ascii = Str::ascii(trim($value));
        $ascii = preg_replace('/[^A-Za-z0-9\\s\\-_.]/', '', $ascii) ?? '';
        $ascii = preg_replace('/\\s+/', ' ', $ascii) ?? '';
        return trim($ascii) !== '' ? trim($ascii) : 'archivo';
    }

    private function buildRichPdfDocument(array $pages, ?string $templateImagePath = null): string
    {
        $a4Width = 595;
        $a4Height = 842;

        $objects = [];
        $addObject = function (string $content) use (&$objects): int {
            $objects[] = $content;
            return count($objects);
        };

        $catalogId = $addObject('');
        $pagesId = $addObject('');
        $fontId = $addObject('<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');

        $imageObjectIds = [];
        $imageSizes = [];

        $registerImage = function (?string $path) use (&$imageObjectIds, &$imageSizes, $addObject): ?int {
            if (!$path || !File::exists($path)) {
                return null;
            }
            if (isset($imageObjectIds[$path])) {
                return $imageObjectIds[$path];
            }

            $size = @getimagesize($path);
            if (!$size || empty($size[0]) || empty($size[1])) {
                return null;
            }
            $raw = @file_get_contents($path);
            if ($raw === false) {
                return null;
            }

            $imgObj = sprintf(
                '<< /Type /XObject /Subtype /Image /Width %d /Height %d /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length %d >>' . "\nstream\n",
                (int) $size[0],
                (int) $size[1],
                strlen($raw)
            ) . $raw . "\nendstream";

            $imgId = $addObject($imgObj);
            $imageObjectIds[$path] = $imgId;
            $imageSizes[$path] = [(float) $size[0], (float) $size[1]];

            return $imgId;
        };

        $templateObjId = $registerImage($templateImagePath);
        $pageIds = [];

        foreach ($pages as $page) {
            $xObjectMap = [];
            if ($templateObjId) {
                $xObjectMap['ImTpl'] = $templateObjId;
            }

            $attachmentPath = (string) ($page['image'] ?? '');
            $attachmentObjId = $registerImage($attachmentPath !== '' ? $attachmentPath : null);
            if ($attachmentObjId) {
                $xObjectMap['ImFile'] = $attachmentObjId;
            }

            $stream = '';
            if (isset($xObjectMap['ImTpl'])) {
                $stream .= "q {$a4Width} 0 0 {$a4Height} 0 0 cm /ImTpl Do Q\n";
            }

            $title = $this->escapePdfText((string) ($page['title'] ?? 'DOCUMENTO'));
            $stream .= "BT /F1 15 Tf 42 790 Td ({$title}) Tj ET\n";

            $currentY = 760;
            foreach ((array) ($page['lines'] ?? []) as $line) {
                $text = $this->escapePdfText((string) $line);
                $stream .= "BT /F1 11 Tf 42 {$currentY} Td ({$text}) Tj ET\n";
                $currentY -= 18;
                if ($currentY < 110) {
                    break;
                }
            }

            if (isset($xObjectMap['ImFile']) && isset($imageSizes[$attachmentPath])) {
                [$imgW, $imgH] = $imageSizes[$attachmentPath];
                $maxW = 500.0;
                $maxH = 470.0;
                $scale = min($maxW / max($imgW, 1.0), $maxH / max($imgH, 1.0), 1.0);
                $drawW = $imgW * $scale;
                $drawH = $imgH * $scale;
                $x = ($a4Width - $drawW) / 2;
                $y = 90;
                $stream .= sprintf("q %.3f 0 0 %.3f %.3f %.3f cm /ImFile Do Q\n", $drawW, $drawH, $x, $y);
            }

            $contentId = $addObject('<< /Length ' . strlen($stream) . " >>\nstream\n" . $stream . "endstream");

            $xObjResource = '';
            if (!empty($xObjectMap)) {
                $parts = [];
                foreach ($xObjectMap as $name => $objId) {
                    $parts[] = '/' . $name . ' ' . $objId . ' 0 R';
                }
                $xObjResource = '/XObject << ' . implode(' ', $parts) . ' >>';
            }

            $pageId = $addObject(
                "<< /Type /Page /Parent {$pagesId} 0 R /MediaBox [0 0 {$a4Width} {$a4Height}] /Resources << /Font << /F1 {$fontId} 0 R >> {$xObjResource} >> /Contents {$contentId} 0 R >>"
            );
            $pageIds[] = $pageId;
        }

        $kids = implode(' ', array_map(fn (int $id) => $id . ' 0 R', $pageIds));
        $objects[$pagesId - 1] = '<< /Type /Pages /Kids [' . $kids . '] /Count ' . count($pageIds) . ' >>';
        $objects[$catalogId - 1] = '<< /Type /Catalog /Pages ' . $pagesId . ' 0 R >>';

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $i => $obj) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1) . " 0 obj\n" . $obj . "\nendobj\n";
        }

        $xrefPos = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root {$catalogId} 0 R >>\n";
        $pdf .= "startxref\n{$xrefPos}\n%%EOF";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\\(', '\\)', ' ', ' '],
            trim($text)
        );
    }
}
