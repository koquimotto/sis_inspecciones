<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuestionarioRespuesta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cuestionario_respuestas';

    protected $fillable = [
        'detalle_inspeccion_id',
        'cuestionario_categoria_id',
        'cuestionario_sub_categoria_id',
        'cuestionario_pregunta_id',
        'cuestionario_pregunta_personalizada',
        'ingreso_respuesta',
        'salida_respuesta',
        'observaciones',
        'estado_respuesta',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'detalle_inspeccion_id' => 'integer',
        'cuestionario_categoria_id' => 'integer',
        'cuestionario_sub_categoria_id' => 'integer',
        'cuestionario_pregunta_id' => 'integer',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function detalleInspeccion(): BelongsTo
    {
        return $this->belongsTo(DetalleInspeccion::class, 'detalle_inspeccion_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CuestionarioCategoria::class, 'cuestionario_categoria_id');
    }

    public function subCategoria(): BelongsTo
    {
        return $this->belongsTo(CuestionarioSubCategoria::class, 'cuestionario_sub_categoria_id');
    }

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(CuestionarioPregunta::class, 'cuestionario_pregunta_id');
    }

    public function observacionesAdjuntas(): HasMany
    {
        return $this->hasMany(CuestionarioRespuestaObservacion::class, 'cuestionario_respuesta_id')
            ->where('estado', 1);
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
