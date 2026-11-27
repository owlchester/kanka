<?php

namespace App\Models\Scopes;

use App\Enums\EntityAssetType;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static self|Builder type(int $type)
 * @method static self|Builder filtered(bool $premium)
 * @method static self|Builder alias()
 * @method static self|Builder file()
 * @method static self|Builder link()
 * @method static self|Builder withoutAliases()
 * @method static self|Builder withoutHiddenImages()
 */
trait EntityAssetScopes
{
    public function scopeType(Builder $query, EntityAssetType|int $type): Builder
    {
        return $query->where('type_id', $type instanceof EntityAssetType ? $type->value : $type);
    }

    public function scopeFiltered(Builder $query, bool $premium = false): Builder
    {
        $types = [
            EntityAssetType::file,
        ];
        if ($premium) {
            $types[] = EntityAssetType::link;
            $types[] = EntityAssetType::alias;
        }

        return $query->whereIn('type_id', $types);
    }

    public function scopeFile(Builder $query)
    {
        // @phpstan-ignore-next-line
        return $query->type(EntityAssetType::file);
    }

    public function scopeLink(Builder $query): Builder
    {
        // @phpstan-ignore-next-line
        return $query->type(EntityAssetType::link);
    }

    public function scopeAlias(Builder $query)
    {
        // @phpstan-ignore-next-line
        return $query->type(EntityAssetType::alias);
    }

    public function scopeWithoutAliases(Builder $query)
    {
        // @phpstan-ignore-next-line
        return $query->whereNot('type_id', EntityAssetType::alias);
    }

    public function scopeWithoutHiddenImages(Builder $query): Builder
    {
        $column = $query->qualifyColumn('image_uuid');

        return $query->where(function (Builder $query) use ($column): void {
            $query->whereNull($column)
                ->orWhere($column, '')
                ->orWhereHas('image');
        });
    }
}
