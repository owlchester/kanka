<?php

namespace App\Models\Scopes;

use App\Models\EntityAsset;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 * @method static self|Builder type(int $type)
 * @method static self|Builder filtered(bool $typeboosted)
 * @method static self|Builder alias()
 * @method static self|Builder file()
 * @method static self|Builder link()
 */
trait EntityAssetScopes
{
    public function scopeType(Builder $query, int $type)
    {
        $query->where('type_id', $type);
    }
    public function scopeFiltered(Builder $query, bool $boosted = false)
    {
        $types = [
            EntityAsset::TYPE_FILE
        ];
        if ($boosted) {
            $types[] = EntityAsset::TYPE_LINK;
            $types[] = EntityAsset::TYPE_ALIAS;
        }
        $query->whereIn('type_id', $types);
    }

    public function scopeFile(Builder $query)
    {
        $query->type(EntityAsset::TYPE_FILE);
    }
    public function scopeLink(Builder $query)
    {
        $query->type(EntityAsset::TYPE_LINK);
    }
    public function scopeAlias(Builder $query)
    {
        $query->type(EntityAsset::TYPE_ALIAS);
    }
}
