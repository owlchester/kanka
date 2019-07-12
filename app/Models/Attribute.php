<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use App\Models\Scopes\Starred;
use App\Traits\OrderableTrait;
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
 * @property string $value
 * @property string $type
 * @property integer $origin_attribute_id
 * @property integer $default_order
 * @property boolean $is_private
 * @property boolean $is_star
 * @property string $api_key
 */
class Attribute extends Model
{
    const TYPE_BLOCK = 'block';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_TEXT = 'text';

    /**
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'name',
        'value',
        'is_private',
        'default_order',
        'type',
        'origin_attribute_id',
        'api_key',
        'is_star',
    ];

    /**
     * Trigger for filtering based on the order request.
     * @var string
     */
    protected $orderTrigger = 'attributes/';

    /**
     * Traits
     */
    use VisibleTrait, OrderableTrait, Paginatable, Starred;

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
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function origin()
    {
        return $this->belongsTo('App\Models\Attribute', 'origin_attribute_id', 'id');
    }

    /**
     * @return bool
     */
    public function isBlock()
    {
        return $this->type == self::TYPE_BLOCK;
    }

    /**
     * @return bool
     */
    public function isCheckbox()
    {
        return $this->type == self::TYPE_CHECKBOX;
    }

    /**
     * @return bool
     */
    public function isText()
    {
        return $this->type == self::TYPE_TEXT;
    }

    /**
     * Copy an attribute to another target
     * @param Entity $target
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }

    /**
     * @param $query
     * @param int $star
     * @return mixed
     */
    public function scopeOrdered($query, $order = 'asc')
    {
        return $query->orderBy('default_order', $order);
    }
}
