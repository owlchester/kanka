<?php

namespace App\Models;

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
 * @property integer $created_by
 * @property boolean $is_private
 * @property string $visibility
 */
class EntityFile extends Model
{
    use VisibilityTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'name',
        'created_by',
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
    use VisibleTrait;

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

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
