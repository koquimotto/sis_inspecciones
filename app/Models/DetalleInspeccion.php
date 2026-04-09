<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleInspeccion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'detalle_inspeccion';

    protected $fillable = [
        'inspeccion_id',
        'inespeccion_numero',
        'inspeccion_estado',
        'inspeccion_fecha',
        'correcion_vigencia_fecha',
        'severidad',
        'inspeccion_observaciones',
        'pdf_ruta',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'inspeccion_id' => 'integer',
        'inespeccion_numero' => 'integer',
        'inspeccion_fecha' => 'datetime',
        'correcion_vigencia_fecha' => 'date',
        'pdf_ruta' => 'string',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function inspeccion(): BelongsTo
    {
        return $this->belongsTo(Inspeccion::class, 'inspeccion_id');
    }

    public function certificados(): HasMany
    {
        return $this->hasMany(Certificado::class, 'detalle_inspeccion_id');
    }

    public function cuestionarioRespuestas(): HasMany
    {
        return $this->hasMany(CuestionarioRespuesta::class, 'detalle_inspeccion_id');
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
