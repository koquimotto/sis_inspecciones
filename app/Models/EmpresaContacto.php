<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaContacto extends Model
{
    use HasFactory;

    protected $table = 'empresa_contacto';

    protected $fillable = [
        'persona_id',
        'empresa_id',
        'email',
        'telefono',
        'estado',
        'user_id',
    ];

    protected $casts = [
        'persona_id' => 'integer',
        'empresa_id' => 'integer',
        'estado'     => 'integer',
        'user_id'    => 'integer',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
