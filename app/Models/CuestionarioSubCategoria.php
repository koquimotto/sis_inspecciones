<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuestionarioSubCategoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cuestionario_sub_categorias';

    protected $fillable = [
        'descripcion',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function preguntas(): HasMany
    {
        return $this->hasMany(CuestionarioPregunta::class, 'cuestionario_sub_categoria_id');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(CuestionarioRespuesta::class, 'cuestionario_sub_categoria_id');
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
}
