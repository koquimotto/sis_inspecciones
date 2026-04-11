<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Certificado de Inspección</title>
    </head>
    @php
        $membretePath = public_path('img/plantilla.png');
        $membreteDataUri = null;
        if (is_file($membretePath)) {
            $membreteRaw = @file_get_contents($membretePath);
            if ($membreteRaw !== false) {
                $membreteDataUri = 'data:image/png;base64,' . base64_encode($membreteRaw);
            }
        }
        $rawImagePages = $imagePages ?? [];
        $flatImageItems = [];
        foreach ((array) $rawImagePages as $item) {
            if (is_array($item) && array_key_exists('src', $item)) {
                $flatImageItems[] = $item;
                continue;
            }

            if (is_array($item)) {
                foreach ($item as $nestedItem) {
                    if (is_array($nestedItem) && array_key_exists('src', $nestedItem)) {
                        $flatImageItems[] = $nestedItem;
                    }
                }
            }
        }
        $imagePages = array_chunk($flatImageItems, 24);
        $pdfPages = $pdfPages ?? [];
        $nonImageAttachments = $nonImageAttachments ?? [];
        $penultimateObservationItems = $penultimateObservationItems ?? [];
        $hasPenultimateObservationSection = (bool) ($hasPenultimateObservationSection ?? !empty($penultimateObservationItems));
        $tailPagesCount = ($hasPenultimateObservationSection ? 1 : 0) + count($imagePages) + count($pdfPages) + (!empty($nonImageAttachments) ? 1 : 0);
        $certificateNumber = trim((string) ($certificateNumber ?? ''));
        $certificateEmissionDate = trim((string) ($certificateEmissionDate ?? ''));
        $certificateExpiryDate = trim((string) ($certificateExpiryDate ?? ''));
        $identifierType = strtoupper(trim((string) ($empresaEquipo?->serie_tipo ?: 'PLACA')));
        $identifierCode = trim((string) ($empresaEquipo?->serie_codigo ?: ''));
        $identifierLabel = $identifierType === 'SERIE' ? 'SERIE' : ($identifierType . ' DE RODAJE');
        $emissionDateLabel = $certificateEmissionDate !== ''
            ? \Illuminate\Support\Carbon::parse($certificateEmissionDate)->format('d-m-Y')
            : now()->format('d-m-Y');
        $expiryDateLabel = $certificateExpiryDate !== ''
            ? \Illuminate\Support\Carbon::parse($certificateExpiryDate)->format('d-m-Y')
            : now()->addYear()->format('d-m-Y');
    @endphp

    <style>
        @page {
            margin-top: 110mm;
            margin-bottom: 10mm;
            margin-left: 18mm;
            margin-right: 18mm;
        }

        body {}
        header {
            position: fixed;
            top: -110mm;
            left: -18mm;
            right: 0;
            z-index: 10;
            width: 210mm;
            height: 297mm;

        }
        .sheets {
            /* background: red; */
            z-index: 20;

            margin: 0;
            color: #111;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            letter-spacing: normal;
            word-spacing: normal;

            position: relative;
        }
        .sheet-break { page-break-after: always; }
        .layer {
            position: relative;
            z-index: 1;
            box-sizing: border-box;
            /* page-break-inside: avoid; */
        }
        .first-layer {
            position: absolute;
            top: 168mm;
            left: 18mm;
            right: 18mm;
            bottom: 10mm;
            height: auto;
            padding: 0;
        }
        .section-title {
            margin: 0 0 3mm 0;
            font-size: 10.5pt;
            font-weight: 700;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2.5mm;
        }
        .data-table td {
            padding: 0.8mm 0;
            vertical-align: top;
            font-size: 9.6pt;
        }
        .label-col { width: 42%; }
        .sep-col { width: 4%; text-align: center; }
        .value-col { width: 54%; }
        .antecedente {
            margin-top: 0.8mm;
            line-height: 1.2;
            font-size: 9.8pt;
            text-align: justify;
        }
        .first-footer {
            margin-top: 3.2mm;
        }
        .center-note {
            margin-top: 0;
            text-align: center;
            font-size: 9.8pt;
        }
        .sign-block {
            margin-top: 2.5mm;
            text-align: center;
            font-size: 8.8pt;
        }
        .sign-line {
            width: 90mm;
            margin: 0 auto 2mm auto;
            border-top: 1px solid #222;
        }
        .gallery-layer {
            box-sizing: border-box;
            padding: 86mm 10mm 10mm 10mm;
            overflow: visible;
            page-break-inside: avoid;
        }
        .gallery {
            font-size: 0;
            line-height: 0;
            margin: 0 -0.6mm;
        }
        .tile {
            float: left;
            box-sizing: border-box;
            padding: 0.6mm;
            page-break-inside: avoid;
        }
        .gallery::after {
            content: "";
            display: block;
            clear: both;
            height: 0;
            line-height: 0;
        }
        .gallery-img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 0.4mm solid #fff;
            box-sizing: border-box;
        }
        .pdf-sheet-layer {
            box-sizing: border-box;
            margin: 56mm 10mm 10mm 10mm;
        }
        .pdf-first-page {
            width: 100%;
            height: 186mm;
            object-fit: contain;
            background: #fff;
            border: 0.4mm solid #fff;
            box-sizing: border-box;
        }
        .non-image-list {
            margin-top: 4mm;
            font-size: 9.5pt;
        }
        .observation-layer {
            padding: 86mm 12mm 18mm 12mm;
        }
        .observation-box {
            border: 0.25mm solid #666;
            padding: 3.5mm 4.5mm;
        }
        .observation-box-title {
            margin: 0 0 2.5mm 0;
            font-family: "Times New Roman", serif;
            font-size: 12.5pt;
            font-weight: 700;
        }
        .observation-list {
            margin: 0;
            padding-left: 6mm;
            font-size: 11pt;
            line-height: 1.28;
        }
        .observation-list li {
            margin-bottom: 1.5mm;
        }
        .observation-status {
            font-size: 9.5pt;
            font-style: italic;
            color: #048f0b;
        }
        .photo-layer {
            padding: 86mm 8mm 10mm 8mm;
        }
        .photo-title {
            margin: 0 0 2.5mm 0;
            font-size: 10.5pt;
            font-weight: 700;
        }
        .photo-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 1.8mm 2.2mm;
            table-layout: fixed;
        }
        .photo-cell {
            vertical-align: top;
            padding: 0;
        }
        .photo-card {
            border: 0.2mm solid #cfd7df;
            padding: 1.1mm;
            box-sizing: border-box;
            background: #fff;
        }
        .photo-frame {
            width: 100%;
            overflow: hidden;
            border: 0.2mm solid #e7edf2;
            box-sizing: border-box;
            background: #f8fbfd;
        }
        .photo-img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-caption {
            margin-top: 1.1mm;
            font-size: 7.8pt;
            line-height: 1.15;
            text-transform: uppercase;
            color: #2b3a46;
        }

    </style>
    <body>
        <header>
            <img src="{{ public_path('img/plantilla.png') }}" style="width: 100%;">
        </header>
        <div class="sheets">
            <div class="">
                <h3 class="section-title">1. DATOS GENERALES</h3>
                <table class="data-table" style="margin-left: 12mm">
                    <tr><td class="label-col">CLIENTE</td><td class="sep-col">:</td><td class="value-col">{{ $empresa?->razon_social ?: 'NO REGISTRADA' }}</td></tr>
                    <tr><td class="label-col">RUC</td><td class="sep-col">:</td><td class="value-col">{{ $empresa?->ruc ?: '-' }}</td></tr>
                    <tr><td class="label-col">EQUIPO</td><td class="sep-col">:</td><td class="value-col">{{ $equipo?->descripcion ?: 'NO REGISTRADO' }}</td></tr>
                    <tr><td class="label-col">MARCA</td><td class="sep-col">:</td><td class="value-col">{{ data_get($equipo, 'marca.marca', '-') }}</td></tr>
                    <tr><td class="label-col">MODELO</td><td class="sep-col">:</td><td class="value-col">{{ data_get($equipo, 'modelo.modelo') ?: data_get($equipo, 'modelo.modelos', '-') }}</td></tr>
                    @if ($certificateNumber !== '')
                        <tr><td class="label-col">NRO CERTIFICADO</td><td class="sep-col">:</td><td class="value-col">{{ $certificateNumber }}</td></tr>
                    @endif
                    <tr><td class="label-col">{{ $identifierLabel }}</td><td class="sep-col">:</td><td class="value-col">{{ $identifierCode !== '' ? $identifierCode : '-' }}</td></tr>
                    <tr><td class="label-col">SERIE</td><td class="sep-col">:</td><td class="value-col">{{ $empresaEquipo?->serie_codigo ?: '-' }}</td></tr>
                    <tr><td class="label-col">FECHA DE EMISION</td><td class="sep-col">:</td><td class="value-col">{{ $emissionDateLabel }}</td></tr>
                    <tr><td class="label-col">FECHA DE CADUCIDAD</td><td class="sep-col">:</td><td class="value-col">{{ $expiryDateLabel }}</td></tr>
                </table>
                <br>
                <br>

                <h3 class="section-title">2. ANTECEDENTE</h3>
                <div class="antecedente">
                    Se certifica que el equipo inspeccionado se encuentra en estado
                    <strong><u>{{ $observedParametersCount > 0 ? 'OPERATIVO CON OBSERVACIONES' : 'OPERATIVO Y EN BUENAS CONDICIONES TECNICAS' }}</u></strong>,
                    conforme a los criterios aplicables de la inspeccion.
                </div>

                <div class="first-footer">
                    <div class="center-note">
                        Por lo tanto, emitimos el certificado para los fines que crean conveniente.
                    </div>

                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="sign-block">
                        <div class="sign-line"></div>
                        TITULAR / RESPONSABLE DE INSPECCION
                    </div>
                </div>
            </div>


            @if ($hasPenultimateObservationSection)
                <div class="sheet-break"></div>
                <div>
                    <div class="observation-box">
                        <div>
                            <h3 class="observation-box-title">OBSERVACIONES:</h3>
                            <ul class="observation-list">
                                @foreach ($penultimateObservationItems as $item)
                                    <li>
                                        {{ $item['descripcion'] }}
                                        <span class="observation-status">({{ $item['estado'] }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif


            @if (!empty($imagePages))
                @foreach ($imagePages as $pageIndex => $pageImages)
                    <div class="sheet-break"></div>

                    @php
                        $photosInPage = count($pageImages);
                        $columns = 3;
                        if ($photosInPage <= 6) {
                            $photoHeight = '48mm';
                        } elseif ($photosInPage <= 12) {
                            $photoHeight = '40mm';
                        } elseif ($photosInPage <= 18) {
                            $photoHeight = '33mm';
                        } else {
                            $photoHeight = '28mm';
                        }
                        $rows = array_chunk($pageImages, $columns);
                    @endphp

                    <div >
                        <h3 class="photo-title">
                            REGISTRO FOTOGRAFICO
                            @if (count($imagePages) > 1)
                                - PAGINA {{ $pageIndex + 1 }} DE {{ count($imagePages) }}
                            @endif
                        </h3>

                        <table class="photo-grid">
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach ($row as $imageItem)
                                        <td class="photo-cell">
                                            <div class="photo-card">
                                                <div class="photo-frame" style="height: {{ $photoHeight }};">
                                                    <img src="{{ $imageItem['src'] }}" alt="Adjunto" class="photo-img">
                                                </div>
                                                <div class="photo-caption">{{ $imageItem['title'] ?? 'EVIDENCIA' }}</div>
                                            </div>
                                        </td>
                                    @endforeach

                                    @for ($i = count($row); $i < $columns; $i++)
                                        <td class="photo-cell"></td>
                                    @endfor
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endforeach
            @endif


            @foreach ($pdfPages as $pdfIndex => $item)
                @php
                    $isLastPdfPage = $pdfIndex === (count($pdfPages) - 1);
                @endphp
                <div class="sheet-break"></div>
                <div>
                    <div class="layer pdf-sheet-layer">
                        <img src="{{ $item['src'] }}" alt="Primera hoja PDF" class="pdf-first-page">
                    </div>
                </div>
            @endforeach

            @if (!empty($nonImageAttachments))
                <div class="sheet-break"></div>
                <div>
                    <div class="layer gallery-layer">
                        <h3 class="section-title">ANEXOS NO VISUALIZABLES COMO IMAGEN</h3>
                        <ul class="non-image-list">
                            @foreach ($nonImageAttachments as $item)
                                <li>{{ $item['title'] }} ({{ $item['type'] ?: 'ARCHIVO' }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>

    </body>
</html>
