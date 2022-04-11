<?php

namespace App\Models;

use App\Facades\Attributes;
use App\Facades\Mentions;
use App\Models\Concerns\Paginatable;
use App\Models\Scopes\Starred;
use App\Traits\OrderableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Str;

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
    const TYPE_SECTION = 'section';
    const TYPE_RANDOM = 'random';
    const TYPE_NUMBER = 'number';
    const TYPE_LIST = 'list';

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

    protected $numberRange = '`\[range:(-?[0-9]+),(-?[0-9]+)\]`i';
    protected $numberMax = null;
    protected $numberMin = null;

    protected $listRegexp = '`\[range:(.*)\]`i';
    protected $listRange = null;

    protected $mappedName = false;

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
     * @return string
     */
    public function mappedValue(): string
    {
        if ($this->type == self::TYPE_SECTION) {
            return $this->name;
        }
        return Mentions::mapAttribute($this);
    }

    /**
     * @return string
     */
    public function mappedName(): string
    {
        if ($this->mappedName !== false) {
            return $this->mappedName;
        }

        return (string) $this->mappedName = Attributes::map($this, 'name');
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return empty($this->type);
    }

    /**
     * @return bool
     */
    public function isBlock(): bool
    {
        return $this->type == self::TYPE_BLOCK;
    }

    /**
     * @return bool
     */
    public function isCheckbox(): bool
    {
        return $this->type == self::TYPE_CHECKBOX;
    }

    /**
     * @return bool
     */
    public function isText(): bool
    {
        return $this->type == self::TYPE_TEXT;
    }
    /**
     * @return bool
     */
    public function isSection(): bool
    {
        return $this->type == self::TYPE_SECTION;
    }

    /**
     * @return bool
     */
    public function isNumber(): bool
    {
        return $this->type == self::TYPE_NUMBER;
    }

    /**
     * @return bool
     */
    public function isList(): bool
    {
        return $this->type == self::TYPE_LIST;
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

    /**
     * @return string
     */
    public function name(): string
    {
        $name = preg_replace('`\[icon:(.*?)\]`si', '<i class="$1"></i>', $this->name);
        $name = preg_replace($this->listRegexp, '', $name);

        return (string) $name;

    }

    /**
     * Set the value of the attribute. Validates if there are constraints
     * @param $value
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        // Check if there is a constraint
        if (!$this->validConstraints()) {
            return $this;
        }

        if ($this->isNumber()) {
            $this->value = min($this->numberMax, max($this->numberMin, $value));
        } elseif (!empty($this->listRange)) {
            if (!in_array($this->value, $this->listRange())) {
                $this->value = null;
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function numberMax()
    {
        $this->calculateConstraints();
        return $this->numberMax;
    }

    /**
     * @return int
     */
    public function numberMin()
    {
        $this->calculateConstraints();
        return $this->numberMin;
    }

    /**
     * @return bool
     */
    public function validConstraints(): bool
    {
        $this->calculateConstraints();
        if ($this->isNumber()) {
            return $this->numberMax !== false && $this->numberMin !== false;
        }
        return $this->listRange !== false;
    }

    /**
     * @return $this
     */
    protected function calculateConstraints(): self
    {
        if ($this->isNumber()) {
            return $this->calculateNumberConstraints();
        } elseif ($this->isDefault()) {
            return $this->calculateListConstraints();
        }

        return $this;
    }

    /**
     * Define the min/max range of a number, if set
     * @return $this
     */
    protected function calculateNumberConstraints(): self
    {
        if (!$this->numberMax === null) {
            return $this;
        }

        $this->numberMax = false;
        $this->numberMin = false;

        //dump('checking ' . $this->name . '(' . $this->mappedName() . ')');

        if (!Str::contains($this->mappedName(), '[range:')) {
            return $this;
        }

        //dump('check regexp');
        preg_match($this->numberRange, $this->mappedName(), $constraints);
        if (count($constraints) !== 3) {
            //dd('no range');
            return $this;
        }

        $this->numberMin = $constraints[1];
        $this->numberMax = $constraints[2];

        //dump($this->numberMin);
        //dd($this->numberMax);

        return $this;
    }

    protected function calculateListConstraints(): self
    {
        if (!$this->listRange === null) {
            return $this;
        }

        $this->listRange = false;

        if (!Str::contains($this->mappedName(), '[range:')) {
            //dd('nope a');
            return $this;
        }

        preg_match($this->listRegexp, $this->mappedName(), $constraints);
        if (count($constraints) !== 2) {
            //dd('nope b');
            return $this;
        }
        $this->listRange = explode(',', $constraints[1]);
        //dump($constraints);
        //dd($this->listRange);

        return $this;
    }

    /**
     * @return array|null
     */
    public function listRange(): array
    {
        return $this->listRange;
    }
}
