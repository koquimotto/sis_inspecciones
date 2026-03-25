<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

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
        'user_id',
    ];

    protected $casts = [
        'unidad_minera_id' => 'integer',
        'pais_id'          => 'integer',
        'region_id'        => 'integer',
        'estado'           => 'integer',
        'user_id'          => 'integer',
    ];

    // Self relation: unidad minera (padre)
    public function unidadMinera()
    {
        return $this->belongsTo(Empresa::class, 'unidad_minera_id');
    }

    // Self relation: servicios (hijos)
    public function servicios()
    {
        return $this->hasMany(Empresa::class, 'unidad_minera_id');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    // Usuario creador/relacionado (según tu migración)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'empresa_id');
    }

    public function contactos()
    {
        return $this->hasMany(EmpresaContacto::class, 'empresa_id');
    }
    
    public function contactoPrincipal()
    {
        return $this->hasOne(EmpresaContacto::class, 'empresa_id')
            ->where('estado', 1);
    }

}
