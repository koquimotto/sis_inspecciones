<div>
    <h1>REPORTE DETALLADO DE INSPECCION</h1>
    <p>Codigo de inspeccion: {{ $inspeccion->codigo_formateado ?: ('#' . $inspeccion->id) }}</p>
    <p>Numero de detalle: {{ $detalle->inespeccion_numero ?: '-' }}</p>
    <p>Fecha de inspeccion: {{ $detalle->inspeccion_fecha ? \Illuminate\Support\Carbon::parse($detalle->inspeccion_fecha)->format('d/m/Y H:i') : '-' }}</p>
    <p>Empresa: {{ $empresa?->razon_social ?: 'No registrada' }}</p>
    <p>Equipo: {{ $inspeccion->empresaEquipo?->descripcion ?: ($equipo?->descripcion ?: 'No registrado') }}</p>
    <p>Serie: {{ $inspeccion->empresaEquipo?->serie_codigo ?: '-' }}</p>
    <p>Estado del detalle: {{ \Illuminate\Support\Str::title(str_replace('_', ' ', (string) $detalle->inspeccion_estado)) }}</p>
    <p>Observaciones generales: {{ $detalle->inspeccion_observaciones ?: 'Sin observaciones' }}</p>
</div>

