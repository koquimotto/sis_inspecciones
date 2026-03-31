<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'equipos';

    protected $fillable = [
        'tipo_id',
        'categoria_id',
        'marca_id',
        'modelo_id',
        'descripcion',
        'anio',
        'observaciones',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'tipo_id' => 'integer',
        'categoria_id' => 'integer',
        'marca_id' => 'integer',
        'modelo_id' => 'integer',
        'anio' => 'integer',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function modelo(): BelongsTo
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }

    public function empresaEquipos(): HasMany
    {
        return $this->hasMany(EmpresaEquipo::class, 'equipo_id');
    }

    public function inspecciones(): HasManyThrough
    {
        return $this->hasManyThrough(
            Inspeccion::class,
            EmpresaEquipo::class,
            'equipo_id',
            'empresa_equipo_id',
            'id',
            'id'
        );
    }

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class, 'empresa_equipos', 'equipo_id', 'empresa_id')
            ->withPivot(['id', 'servicio_id', 'descripcion', 'serie_tipo', 'serie_codigo', 'estado'])
            ->withTimestamps();
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'empresa_equipos', 'equipo_id', 'servicio_id')
            ->withPivot(['id', 'empresa_id', 'descripcion', 'serie_tipo', 'serie_codigo', 'estado'])
            ->withTimestamps();
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
