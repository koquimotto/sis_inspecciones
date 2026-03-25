<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleInspeccion extends Model
{
    use HasFactory;

    protected $table = 'detalle_inspeccion';

    protected $fillable = [
        'observacion_id',
        'revision_id',
        'detalle',
        'severidad',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'observacion_id' => 'integer',
        'revision_id'    => 'integer',
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
