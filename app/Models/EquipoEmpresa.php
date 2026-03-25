<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoEmpresa extends Model
{
    use HasFactory;

    protected $table = 'equipo_empresa';

    protected $fillable = [
        'empresa_id',
        'equipo_id',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'empresa_id' => 'integer',
        'equipo_id'  => 'integer',
        'estado'     => 'integer',
        'user_id'    => 'integer',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
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
