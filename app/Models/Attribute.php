<?php

namespace App\Models;

use App\Facades\Attributes;
use App\Facades\Mentions;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Privatable;
use App\Models\Scopes\Pinnable;
use App\Traits\OrderableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

/**
 * Class Attribute
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_id
 * @property string $name
 * @property string|null $value
 * @property int $type_id
 * @property int|null $origin_attribute_id
 * @property int $default_order
 * @property int|bool $is_private
 * @property int|bool $is_hidden
 * @property int|bool $is_pinned
 * @property string|null $api_key
 * @property Entity|null $entity
 */
class Attribute extends Model
{
    use HasFactory;
    use OrderableTrait;
    use Paginatable;
    use Pinnable;
    use Privatable;
    use Searchable;

    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_SECTION = 'section';
    public const TYPE_RANDOM = 'random';
    public const TYPE_NUMBER = 'number';
    public const TYPE_LIST = 'list';
    public const TYPE_TEXT = 'text';

    public const TYPE_STANDARD_ID = 1;
    public const TYPE_TEXT_ID = 2;
    public const TYPE_CHECKBOX_ID = 3;
    public const TYPE_SECTION_ID = 4;
    public const TYPE_RANDOM_ID = 5;
    public const TYPE_NUMBER_ID = 6;
    public const TYPE_LIST_ID = 7;

    protected $fillable = [
        'entity_id',
        'name',
        'value',
        'is_private',
        'default_order',
        'type_id',
        'origin_attribute_id',
        'api_key',
        'is_pinned',
        'is_hidden',
    ];

    /**
     * Trigger for filtering based on the order request.
     */
    protected string $orderTrigger = 'attributes/';

    /**
     * Searchable fields
     */
    protected array $searchableColumns = [
        'name'
    ];

    protected string $numberRange = '`\[range:(-?[0-9]+),(-?[0-9]+)\]`i';
    protected mixed $numberMax = null;
    protected mixed $numberMin = null;

    protected string $listRegexp = '`\[range:(.+)\]`i';
    protected mixed $listRange = null;

    protected $mappedName = false;

    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function origin()
    {
        return $this->belongsTo('App\Models\Attribute', 'origin_attribute_id', 'id');
    }

    /**
     * Get an entity's value parsed of mentions
     */
    public function mappedValue(): string
    {
        if ($this->type_id == self::TYPE_SECTION_ID) {
            return $this->name;
        }
        return Mentions::mapAttribute($this);
    }

    /**
     * Get an entity's name parsed of mentions
     */
    public function mappedName(): string
    {
        if ($this->mappedName !== false) {
            return $this->mappedName;
        }

        return (string) $this->mappedName = Attributes::map($this);
    }

    public function exposedName(bool $slug = true): string
    {
        $name = str_replace(' ', '', $this->name);
        if (Str::contains($name, '[range:')) {
            $name = Str::before($name, '[range:');
        }
        return $slug ? Str::slug($name) : $name;
    }

    /**
     * Determine if an attribute is of the standard input field type
     */
    public function isDefault(): bool
    {
        return $this->type_id === self::TYPE_STANDARD_ID;
    }

    /**
     * Determine if an attribute is of the "checkbox" type
     */
    public function isCheckbox(): bool
    {
        return $this->type_id === self::TYPE_CHECKBOX_ID;
    }

    /**
     * Determine if an attribute is of the "text" type
     */
    public function isText(): bool
    {
        return $this->type_id === self::TYPE_TEXT_ID;
    }

    /**
     * Determine if an attribute is of the "section" type
     */
    public function isSection(): bool
    {
        return $this->type_id === self::TYPE_SECTION_ID;
    }

    /**
     * Determine if an attribute is of the "number" type
     */
    public function isNumber(): bool
    {
        return $this->type_id === self::TYPE_NUMBER_ID;
    }

    /**
     * Determine if an attribute is of the "list" type
     */
    public function isList(): bool
    {
        return $this->type_id === self::TYPE_LIST_ID;
    }

    /**
     * Determine if an attribute is of the "random" type
     */
    public function isRandom(): bool
    {
        return $this->type_id === self::TYPE_RANDOM_ID;
    }

    /**
     * Copy an attribute to another target
     * @return bool
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;
        return $new->save();
    }

    /**
     */
    public function scopeOrdered(Builder $query, string $order = 'asc'): Builder
    {
        return $query->orderBy('default_order', $order);
    }

    /**
     */
    public function scopeHidden(Builder $query, bool $hidden = false): Builder
    {
        return $query->where(['is_hidden' => $hidden]);
    }

    /**
     */
    public function name(): string
    {
        $name = preg_replace('`\[icon:(.*?)\]`si', '<i class="$1"></i>', $this->name);
        $name = preg_replace($this->listRegexp, '', $name);

        return Mentions::mapAttribute($this, $name);
    }

    /**
     * Set the value of the attribute. Validates if there are constraints
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
     * Generate the attribute's mention syntax
     */
    public function mentionName(): string
    {
        return '{attribute:' . $this->id . '}';
    }

    /**
     * Determine if an attribute's value is inside its numeric constraints (for ranged attributes)
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
     * Determine an attribute's constraints (for ranged and listed attributes)
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
        if ($this->numberMax !== null) {
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
            return $this;
        }

        $this->numberMin = $constraints[1];
        $this->numberMax = $constraints[2];

        //dump($this->numberMin);
        //dd($this->numberMax);

        return $this;
    }

    /**
     * Generate a list of values possible for an attribute
     * @return $this
     */
    protected function calculateListConstraints(): self
    {
        if ($this->listRange !== null) {
            return $this;
        }

        $this->listRange = false;

        if (!Str::contains($this->mappedName(), '[range:')) {
            //dd('Missing range syntax');
            return $this;
        }

        preg_match($this->listRegexp, $this->mappedName(), $constraints);
        if (count($constraints) !== 2) {
            return $this;
        }
        $this->listRange = explode(',', $constraints[1]);

        //dump($constraints);
        //dd($this->listRange);

        return $this;
    }

    /**
     */
    public function listRange(): array
    {
        if (!is_array($this->listRange)) {
            return [];
        }
        return $this->listRange;
    }

    /**
     */
    public function listRangeText(): string
    {
        return implode(', ', $this->listRange);
    }

    public function exportFields(): array
    {
        return [
            'id',
            'type_id',
            'name',
            'value',
            'is_private',
            'default_order',
            'is_pinned',
            'is_hidden',
        ];
    }

    /**
     * Get the value used to index the model.
     *
     */
    public function getScoutKey()
    {
        return $this->getTable() . '_' . $this->id;
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'entities';
    }

    protected function makeAllSearchableUsing($query)
    {
        return $query
            ->select([$this->getTable() . '.*', 'entities.id as entity_id'])
            ->leftJoin('entities', $this->getTable() . '.entity_id', '=', 'entities.id')
            ->has('entity')
            ->with('entity');
    }

    public function toSearchableArray()
    {
        return [
            'campaign_id' => $this->entity->campaign_id,
            'entity_id' => $this->entity_id,
            'name' => $this->name,
            'type'  => 'attribute',
            'entry'  => strip_tags($this->value),
        ];
    }
}
