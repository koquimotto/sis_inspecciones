<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoInspeccion extends Model
{
    use HasFactory;

    protected $table = 'tipo_inspeccion';

    protected $fillable = [
        'tipo_inspeccion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'integer',
    ];

    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class, 'tipo_inspeccion_id');
    }
}
