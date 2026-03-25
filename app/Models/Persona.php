<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';

    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'ubigeo',
        'email',
        'telefono',
        'sexo',
        'foto',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'estado' => 'integer',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'persona_id');
    }

    public function contactosEmpresa()
    {
        return $this->hasMany(EmpresaContacto::class, 'persona_id');
    }
    
    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombres} {$this->apellido_paterno} {$this->apellido_materno}");
    }
}
