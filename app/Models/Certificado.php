<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificado extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'certificados';

    protected $fillable = [
        'tipo_certificado_id',
        'inspeccion_id',
        'detalle_inspeccion_id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'pdf_ruta',
        'anulado',
        'motivo_anulacion',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'tipo_certificado_id' => 'integer',
        'inspeccion_id' => 'integer',
        'detalle_inspeccion_id' => 'integer',
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'anulado' => 'boolean',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function tipoCertificado(): BelongsTo
    {
        return $this->belongsTo(TipoCertificado::class, 'tipo_certificado_id');
    }

    public function inspeccion(): BelongsTo
    {
        return $this->belongsTo(Inspeccion::class, 'inspeccion_id');
    }

    public function detalleInspeccion(): BelongsTo
    {
        return $this->belongsTo(DetalleInspeccion::class, 'detalle_inspeccion_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function eliminadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
