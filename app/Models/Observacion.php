<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'observaciones';

    protected $fillable = [
        'codigo',
        'observacion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'integer',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleInspeccion::class, 'observacion_id');
    }

    public function antecedentes()
    {
        return $this->hasMany(AntecedenteEquipo::class, 'observacion_id');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'observacion_id');
    }
}
