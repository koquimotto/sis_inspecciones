<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCertificado extends Model
{
    use HasFactory;

    protected $table = 'tipo_certificado';

    protected $fillable = [
        'tipo_certificado',
        'estado',
    ];

    protected $casts = [
        'estado' => 'integer',
    ];

    public function certificados()
    {
        return $this->hasMany(Certificado::class, 'tipo_certificado_id');
    }
}
