<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'paises';

    protected $fillable = [
        'pais',
        'codigo',
        'flag',
        'iso3',
        'iso_num',
    ];

    protected $casts = [
        'estado' => 'integer',
    ];

    public function regiones()
    {
        return $this->hasMany(Region::class, 'pais_id');
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'pais_id');
    }
}
