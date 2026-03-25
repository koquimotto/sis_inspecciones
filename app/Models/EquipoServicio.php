<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoServicio extends Model
{
    use HasFactory;

    protected $table = 'equipo_servicio';

    protected $fillable = [
        'servicio_id',
        'equipo_id',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'servicio_id' => 'integer',
        'equipo_id'   => 'integer',
        'estado'      => 'integer',
        'user_id'     => 'integer',
    ];

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
}
