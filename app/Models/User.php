<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'persona_id',
        'empresa_id',
        'name',
        'email',
        'username',
        'password',
        'estado',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rolesActivos()
    {
        return $this->roles()->wherePivot('estado', 1)->where('roles.estado', 1);
    }

    public function hasRole(string $rolNombre): bool
    {
        return $this->rolesActivos()->where('roles.nombre', $rolNombre)->exists();
    }

    public function roleNames(): array
    {
        return $this->rolesActivos()->pluck('roles.nombre')->unique()->values()->toArray();
    }

    public function saludarConRol(): string
    {
        $roles = $this->roleNames();
        $rolTexto = count($roles) ? implode(', ', $roles) : 'sin rol';
        return "Hola, {$this->name} 👋 (Rol: {$rolTexto})";
    }

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    // usuario creador / superior (según tu tabla users.user_id)
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creados()
    {
        return $this->hasMany(User::class, 'user_id');
    }

}
