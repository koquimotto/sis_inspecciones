<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteEquipo extends Model
{
    use HasFactory;

    protected $table = 'antecedente_equipo';

    protected $fillable = [
        'inspeccion_id',
        'observacion_id',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'inspeccion_id'  => 'integer',
        'observacion_id' => 'integer',
        'estado'         => 'integer',
        'user_id'        => 'integer',
    ];

    public function inspeccion()
    {
        return $this->belongsTo(Inspeccion::class, 'inspeccion_id');
    }

    public function observacion()
    {
        return $this->belongsTo(Observacion::class, 'observacion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
