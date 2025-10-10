<?php

namespace App\Models\Scopes;

use App\Enums\EntityAssetType;
use App\Models\EntityAsset;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static self|Builder type(int $type)
 * @method static self|Builder filtered(bool $premium)
 * @method static self|Builder alias()
 * @method static self|Builder file()
 * @method static self|Builder link()
 */
trait EntityAssetScopes
{
    public function scopeType(Builder $query, int $type): Builder
    {
        return $query->where('type_id', $type);
    }

    public function scopeFiltered(Builder $query, bool $premium = false): Builder
    {
        $types = [
            EntityAssetType::FILE->value,
        ];
        if ($premium) {
            $types[] = EntityAssetType::LINK->value;
            $types[] = EntityAssetType::ALIAS->value;
        }

        return $query->whereIn('type_id', $types);
    }

    public function scopeFile(Builder $query)
    {
        // @phpstan-ignore-next-line
        return $query->type(EntityAssetType::FILE->value);
    }

    public function scopeLink(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query->type(EntityAssetType::LINK->value);
    }

    public function scopeAlias(Builder $query)
    {
        // @phpstan-ignore-next-line
        return $query->type(EntityAssetType::ALIAS->value);
    }
}
