<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    use HasFactory;

    protected $table = 'inspecciones';

    protected $fillable = [
        'codigo',
        'tipo_inspeccion_id',
        'fecha_ingreso',
        'fecha_salida',
        'empresa_id',
        'servicio_id',
        'equipo_id',
        'user_id',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'tipo_inspeccion_id' => 'integer',
        'fecha_ingreso'      => 'date',
        'fecha_salida'       => 'date',
        'empresa_id'         => 'integer',
        'servicio_id'        => 'integer',
        'equipo_id'          => 'integer',
        'user_id'            => 'integer',
    ];

    public function tipoInspeccion()
    {
        return $this->belongsTo(TipoInspeccion::class, 'tipo_inspeccion_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'inspeccion_id');
    }

    public function antecedentes()
    {
        return $this->hasMany(AntecedenteEquipo::class, 'inspeccion_id');
    }
}
