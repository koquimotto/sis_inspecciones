<div>
    <h1>CERTIFICADO DE INSPECCION</h1>
    <p>Codigo: {{ $inspeccion->codigo_formateado ?: ('#' . $inspeccion->id) }}</p>
    <p>Fecha de emision: {{ now()->format('d/m/Y H:i') }}</p>
    <p>Empresa: {{ $empresa?->razon_social ?: 'No registrada' }}</p>
    <p>RUC: {{ $empresa?->ruc ?: '-' }}</p>
    <p>Equipo: {{ $empresaEquipo?->descripcion ?: ($equipo?->descripcion ?: 'No registrado') }}</p>
    <p>Serie: {{ $empresaEquipo?->serie_codigo ?: '-' }}</p>
    <p>Servicio: {{ $inspeccion->servicio?->descripcion ?: '-' }}</p>
    <p>Estado de inspeccion: {{ \Illuminate\Support\Str::title(str_replace('_', ' ', (string) $detalle->inspeccion_estado)) }}</p>
    <p>Parametros observados: {{ $observedParametersCount }}</p>
    <p>Archivos visibles en certificado: {{ $selectedFilesCount }}</p>
</div>

