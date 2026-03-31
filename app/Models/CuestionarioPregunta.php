<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuestionarioPregunta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cuestionario_preguntas';

    protected $fillable = [
        'cuestionario_categoria_id',
        'cuestionario_sub_categoria_id',
        'equipo_tipo_ids',
        'equipo_categoria_ids',
        'equipo_marca_ids',
        'equipo_modelo_ids',
        'pregunta_numero_orden',
        'pregunta_visualizacion',
        'pregunta_enunciado',
        'ingeso_preguntar',
        'ingreso_respuesta_tipo',
        'ingreso_respuesta_valores',
        'salida_preguntar',
        'salida_respuesta_tipo',
        'salida_respuesta_valores',
        'permitir_observaciones',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'cuestionario_categoria_id' => 'integer',
        'cuestionario_sub_categoria_id' => 'integer',
        'ingeso_preguntar' => 'boolean',
        'salida_preguntar' => 'boolean',
        'permitir_observaciones' => 'boolean',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CuestionarioCategoria::class, 'cuestionario_categoria_id');
    }

    public function subCategoria(): BelongsTo
    {
        return $this->belongsTo(CuestionarioSubCategoria::class, 'cuestionario_sub_categoria_id');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(CuestionarioRespuesta::class, 'cuestionario_pregunta_id');
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
