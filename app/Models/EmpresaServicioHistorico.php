<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaServicioHistorico extends Model
{
    use HasFactory;

    protected $table = 'empresa_servicios_historico';

    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'servicio_id',
        'accion',
        'estado',
        'created_at',
        'created_by',
    ];

    protected $casts = [
        'empresa_id' => 'integer',
        'servicio_id' => 'integer',
        'estado' => 'boolean',
        'created_at' => 'datetime',
        'created_by' => 'integer',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
