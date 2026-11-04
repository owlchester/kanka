<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveEntityScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas('entity', fn (Builder $entity) => $entity
            ->withoutGlobalScopes()
            ->whereNull('entities.deleted_at'));
    }
}
