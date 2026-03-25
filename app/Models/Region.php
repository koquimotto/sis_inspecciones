<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regiones';

    protected $fillable = [
        'pais_id',
        'region',
        'codigo',
        'estado',
    ];

    protected $casts = [
        'pais_id' => 'integer',
        'estado'  => 'integer',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'region_id');
    }
}
