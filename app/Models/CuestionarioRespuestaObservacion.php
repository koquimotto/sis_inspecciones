<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuestionarioRespuestaObservacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cuestionario_respuestas_observaciones';

    protected $fillable = [
        'cuestionario_respuesta_id',
        'inspeccion_archivo_equipo_id',
        'descripcion',
        'momento',
        'severidad',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'cuestionario_respuesta_id' => 'integer',
        'inspeccion_archivo_equipo_id' => 'integer',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function respuesta(): BelongsTo
    {
        return $this->belongsTo(CuestionarioRespuesta::class, 'cuestionario_respuesta_id');
    }

    public function archivoEquipo(): BelongsTo
    {
        return $this->belongsTo(InspeccionArchivoEquipo::class, 'inspeccion_archivo_equipo_id');
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
