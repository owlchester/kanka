<?php

namespace App\Models\Concerns;

use App\Models\Scopes\AclScope;
use Illuminate\Database\Eloquent\Builder;

trait Acl
{
    /**
     * Boot the trait's observers
     */
    public static function bootAcl(): void
    {
        static::addGlobalScope(new AclScope);
    }

    /**
     * Global privacy scope
     */
    public function scopePrivate(Builder $query, bool $private = true): Builder
    {
        return $query->where($this->getTable() . '.is_private', $private);
    }
}
