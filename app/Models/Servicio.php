<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'empresa_id',
        'servicio',
        'ubicacion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'empresa_id'   => 'integer',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'estado'       => 'integer',
        'user_id'      => 'integer',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class, 'servicio_id');
    }

    // Muchos a muchos: servicios <-> equipos
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_servicio', 'servicio_id', 'equipo_id')
            ->withPivot(['id', 'estado', 'user_id'])
            ->withTimestamps();
    }
}
