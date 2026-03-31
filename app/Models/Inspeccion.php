<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspeccion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'inspecciones';

    protected $fillable = [
        'anio',
        'correlativo',
        'codigo',
        'tipo_inspeccion_id',
        'empresa_equipo_id',
        'fecha_ingreso',
        'fecha_salida',
        'estado_inspeccion',
        'observaciones',
        'certificado_generado',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'anio' => 'integer',
        'correlativo' => 'integer',
        'tipo_inspeccion_id' => 'integer',
        'empresa_equipo_id' => 'integer',
        'fecha_ingreso' => 'date',
        'fecha_salida' => 'date',
        'certificado_generado' => 'boolean',
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function tipoInspeccion(): BelongsTo
    {
        return $this->belongsTo(TipoInspeccion::class, 'tipo_inspeccion_id');
    }

    public function empresaEquipo(): BelongsTo
    {
        return $this->belongsTo(EmpresaEquipo::class, 'empresa_equipo_id');
    }

    public function detalleInspecciones(): HasMany
    {
        return $this->hasMany(DetalleInspeccion::class, 'inspeccion_id');
    }

    public function ultimoDetalle(): HasOne
    {
        return $this->hasOne(DetalleInspeccion::class, 'inspeccion_id')->latestOfMany('id');
    }

    public function certificados(): HasMany
    {
        return $this->hasMany(Certificado::class, 'inspeccion_id');
    }

    public function archivosEquipo(): HasMany
    {
        return $this->hasMany(InspeccionArchivoEquipo::class, 'inspeccion_id');
    }

    public function creadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function actualizadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function eliminadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected function empresa(): Attribute
    {
        return Attribute::get(fn () => $this->empresaEquipo?->empresa);
    }

    protected function servicio(): Attribute
    {
        return Attribute::get(fn () => $this->empresaEquipo?->servicio);
    }

    protected function equipo(): Attribute
    {
        return Attribute::get(fn () => $this->empresaEquipo?->equipo);
    }

    protected function codigoFormateado(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (filled($this->codigo)) {
                return $this->codigo;
            }

            if (!$this->anio || !$this->correlativo) {
                return null;
            }

            return sprintf('%02d-%04d', $this->anio % 100, $this->correlativo);
        });
    }
}
