<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = [
        'tipo_id',
        'categoria_id',
        'marca_id',
        'modelo_id',
        'serie',
        'placa_id',
        'anio',
        'observaciones',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'tipo_id'      => 'integer',
        'categoria_id' => 'integer',
        'marca_id'     => 'integer',
        'modelo_id'    => 'integer',
        'placa_id'     => 'integer',
        'anio'         => 'integer',  // viene como year()
        'estado'       => 'integer',
        'user_id'      => 'integer',
    ];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class, 'equipo_id');
    }

    // Muchos a muchos: equipos <-> empresas
    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'equipo_empresa', 'equipo_id', 'empresa_id')
            ->withPivot(['id', 'estado', 'user_id'])
            ->withTimestamps();
    }

    // Muchos a muchos: equipos <-> servicios
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'equipo_servicio', 'equipo_id', 'servicio_id')
            ->withPivot(['id', 'estado', 'user_id'])
            ->withTimestamps();
    }
}
