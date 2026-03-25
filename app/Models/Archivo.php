<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'archivos';

    protected $fillable = [
        'observacion_id',
        'ruta',
        'tipo_archivo',
        'archivo',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'observacion_id' => 'integer',
        'estado'         => 'integer',
        'user_id'        => 'integer',
    ];

    public function observacion()
    {
        return $this->belongsTo(Observacion::class, 'observacion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
