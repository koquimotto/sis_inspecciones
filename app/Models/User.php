<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'persona_id',
        'empresa_id',
        'user_id',
        'name',
        'email',
        'username',
        'password',
        'estado',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'persona_id' => 'integer',
        'empresa_id' => 'integer',
        'user_id' => 'integer',
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
        'estado' => 'integer',
        'password' => 'hashed',
    ];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(self::class, 'user_id');
    }

    public function creados(): HasMany
    {
        return $this->hasMany(self::class, 'user_id');
    }
}
