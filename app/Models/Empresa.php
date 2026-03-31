<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'empresas';

    protected $fillable = [
        'tipo',
        'unidad_minera_id',
        'ruc',
        'razon_social',
        'nombre_comercial',
        'email',
        'telefono',
        'pais_id',
        'region_id',
        'ciudad',
        'direccion',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'unidad_minera_id' => 'integer',
        'pais_id' => 'integer',
        'region_id' => 'integer',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function unidadMinera(): BelongsTo
    {
        return $this->belongsTo(self::class, 'unidad_minera_id');
    }

    public function empresasHijas(): HasMany
    {
        return $this->hasMany(self::class, 'unidad_minera_id');
    }

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'empresa_id');
    }

    public function contactos(): HasMany
    {
        return $this->hasMany(EmpresaContacto::class, 'empresa_id');
    }

    public function contactoPrincipal(): HasOne
    {
        return $this->hasOne(EmpresaContacto::class, 'empresa_id')->where('estado', true);
    }

    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(Servicio::class, 'empresa_servicios', 'empresa_id', 'servicio_id')
            ->using(EmpresaServicio::class);
    }

    public function empresaEquipos(): HasMany
    {
        return $this->hasMany(EmpresaEquipo::class, 'empresa_id');
    }

    public function inspecciones(): HasManyThrough
    {
        return $this->hasManyThrough(
            Inspeccion::class,
            EmpresaEquipo::class,
            'empresa_id',
            'empresa_equipo_id',
            'id',
            'id'
        );
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
