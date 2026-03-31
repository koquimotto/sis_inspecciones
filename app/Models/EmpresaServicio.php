<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaServicio extends Pivot
{
    protected $table = 'empresa_servicios';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'empresa_id',
        'servicio_id',
    ];

    protected $casts = [
        'empresa_id' => 'integer',
        'servicio_id' => 'integer',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
