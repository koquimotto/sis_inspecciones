<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    use HasFactory;

    protected $table = 'certificados';

    protected $fillable = [
        'tipo_certificado_id',
        'inspeccion_id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'estado',
        'pdf_ruta',
    ];

    protected $casts = [
        'tipo_certificado_id' => 'integer',
        'inspeccion_id'        => 'integer',
        'fecha_emision'        => 'date',
        'fecha_vencimiento'    => 'date',
    ];

    public function tipoCertificado()
    {
        return $this->belongsTo(TipoCertificado::class, 'tipo_certificado_id');
    }

    public function inspeccion()
    {
        return $this->belongsTo(Inspeccion::class, 'inspeccion_id');
    }
}
