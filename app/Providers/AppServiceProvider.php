<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Cache de columnas por tabla/columna para no consultar Schema en cada evento.
     *
     * @var array<string, bool>
     */
    private static array $auditColumnCache = [];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::creating(function (Model $model): void {
            $actorId = $this->resolveActorId();
            if (!$actorId) {
                return;
            }

            if ($this->modelHasColumn($model, 'created_by') && !$model->getAttribute('created_by')) {
                $model->setAttribute('created_by', $actorId);
            }

            if ($this->modelHasColumn($model, 'updated_by') && !$model->getAttribute('updated_by')) {
                $model->setAttribute('updated_by', $actorId);
            }
        });

        Model::updating(function (Model $model): void {
            $actorId = $this->resolveActorId();
            if (!$actorId) {
                return;
            }

            if ($this->modelHasColumn($model, 'updated_by')) {
                $model->setAttribute('updated_by', $actorId);
            }
        });

        Model::deleting(function (Model $model): void {
            $actorId = $this->resolveActorId();
            if (!$actorId) {
                return;
            }

            $shouldPersist = false;
            if ($this->modelHasColumn($model, 'deleted_by')) {
                $model->setAttribute('deleted_by', $actorId);
                $shouldPersist = true;
            }

            if ($this->modelHasColumn($model, 'updated_by')) {
                $model->setAttribute('updated_by', $actorId);
                $shouldPersist = true;
            }

            if ($shouldPersist && method_exists($model, 'saveQuietly')) {
                $model->saveQuietly();
            }
        });
    }

    private function resolveActorId(): ?int
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $id = $user->getAuthIdentifier();
        if ($id === null) {
            $id = $user->getAttribute($user->getKeyName());
        }
        if ($id === null) {
            $id = $user->getAttribute('id');
        }
        if ($id === null) {
            $id = $user->getAttribute('user_id');
        }

        return $id !== null ? (int) $id : null;
    }

    private function modelHasColumn(Model $model, string $column): bool
    {
        $connectionName = (string) ($model->getConnectionName() ?? config('database.default'));
        $table = (string) $model->getTable();
        $cacheKey = $connectionName . ':' . $table . ':' . $column;

        if (array_key_exists($cacheKey, self::$auditColumnCache)) {
            return self::$auditColumnCache[$cacheKey];
        }

        try {
            $hasColumn = $model->getConnection()->getSchemaBuilder()->hasColumn($table, $column);
        } catch (\Throwable $e) {
            $hasColumn = false;
        }

        self::$auditColumnCache[$cacheKey] = $hasColumn;

        return $hasColumn;
    }
}
