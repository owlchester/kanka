<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostLayout
 * @package App\Models
 *
 * @property integer $id
 * @property integer $entity_type_id
 * @property string $code
 * @property array $config
 * @property EntityType|null $entityType
 *
 */
class PostLayout extends Model
{
    protected $fillable = [
        'code',
        'entity_type_id',
        'config',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entityType()
    {
        return $this->belongsTo('App\Models\EntityType', 'entity_type_id', 'id');
    }

    /**
     * @return Builder
     */
    public function scopeEntity(Builder $query, int $type)
    {
        return $query->whereNull('entity_type_id')->orWhere('entity_type_id', $type);
    }

    /**
     */
    public function name(): string
    {
        if (in_array($this->code, ['abilities', 'attributes', 'assets', 'inventory'])) {
            return __('crud.tabs.' . $this->code);
        } elseif ($this->code === 'entry') {
            return __('crud.fields.' . $this->code);
        }
        return __('post_layouts.' . $this->code);
    }
}
