<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Paginatable;
use App\Traits\OrderableTrait;
use App\Traits\VisibilityTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $name
 * @property string $path
 * @property string $type
 * @property integer $size
 * @property boolean $is_private
 * @property string $visibility
 */
class EntityFile extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'name',
        'is_private',
        'visibility',
    ];

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'files/';

    /**
     * Traits
     */
    use VisibleTrait, VisibilityTrait, Blameable;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }
}
