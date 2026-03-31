<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaEquipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'empresa_equipos';

    protected $fillable = [
        'empresa_id',
        'equipo_id',
        'servicio_id',
        'descripcion',
        'serie_tipo',
        'serie_codigo',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'empresa_id' => 'integer',
        'equipo_id' => 'integer',
        'servicio_id' => 'integer',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function inspecciones(): HasMany
    {
        return $this->hasMany(Inspeccion::class, 'empresa_equipo_id');
    }

    public function historico(): HasMany
    {
        return $this->hasMany(EmpresaEquipoHistorico::class, 'empresa_equipo_id');
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
