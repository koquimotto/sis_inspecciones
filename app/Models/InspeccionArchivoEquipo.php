<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeccionArchivoEquipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inspeccion_archivos_equipo';

    protected $fillable = [
        'inspeccion_id',
        'archivo_descripcion',
        'archivo_autogenerado',
        'archivo_tipo',
        'archivo_ruta',
        'archivo_origen',
        'mostrar_certificado',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'inspeccion_id' => 'integer',
        'archivo_autogenerado' => 'boolean',
        'mostrar_certificado' => 'boolean',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function inspeccion(): BelongsTo
    {
        return $this->belongsTo(Inspeccion::class, 'inspeccion_id');
    }

    public function observaciones(): HasMany
    {
        return $this->hasMany(CuestionarioRespuestaObservacion::class, 'inspeccion_archivo_equipo_id');
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
