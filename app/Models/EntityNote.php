<?php

namespace App\Models;

use App\Traits\OrderableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property integer $entity_id
 * @property string $name
 * @property string $value
 * @property string $entry
 * @property integer $created_by
 * @property boolean $is_private
 */
class EntityNote extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'name',
        'entry',
        'created_by',
        'is_private',
    ];

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'notes/';

    /**
     * Traits
     */
    use VisibleTrait;
    use OrderableTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
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
