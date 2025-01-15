<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\EntityCache;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\Concerns\Acl;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\EntityLogs;
use App\Models\Concerns\EntityType;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasMentions;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\SortableTrait;
use App\Models\Concerns\Templatable;
use App\Models\Relations\EntityRelations;
use App\Models\Scopes\EntityScopes;
use App\Traits\HasTooltip;
use Carbon\Carbon;
use Collator;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Entity
 * @package App\Models
 *
 * @property int $id
 * @property int $entity_id
 * @property string $name
 * @property ?string $type
 * @property ?string $entry
 * @property int $type_id
 * @property int $created_by
 * @property int $updated_by
 * @property int $deleted_by
 * @property bool|int $is_private
 * @property bool|int $is_attributes_private
 * @property string $tooltip
 * @property string $header_image
 * @property ?string $image_uuid
 * @property ?string $header_uuid
 * @property ?string $marketplace_uuid
 * @property ?int $focus_x
 * @property ?int $focus_y
 * @property ?string $image_path
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 */
class Entity extends Model
{
    use Acl;
    use Blameable;
    use EntityLogs;
    use EntityRelations;
    use EntityScopes;
    use EntityType;
    use HasCampaign;
    use HasEntry;
    use HasMentions;
    use HasTooltip;
    use LastSync;
    use Paginatable;
    use Searchable;
    use SoftDeletes;
    use SortableTrait;
    use Templatable;

    protected $fillable = [
        'campaign_id',
        'entity_id',
        'name',
        'type_id',
        'is_private',
        'is_attributes_private',
        'header_image',
        'image_uuid',
        'header_uuid',
        'is_template',
        'type',
        'entry',
    ];

    /** @var array Searchable fields */
    protected array $searchableColumns = [
        'name',
    ];

    /** @var string[] Fields that can be used to order by */
    protected array $sortable = [
        'name',
        'type_id',
        'deleted_at',
    ];

    /**
     * Array of our custom model events declared under model property $observables
     * @var array
     */
    protected $observables = [
        'crudSaved',
    ];

    protected string $cachedPluralName;

    /** The entity type string */
    protected string $cachedType;

    /**
     * Get the child entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|MiscModel
     */
    public function child()
    {
        if ($this->isAttributeTemplate()) {
            return $this->attributeTemplate();
        } elseif ($this->isDiceRoll()) {
            return $this->diceRoll();
        }
        return $this->{$this->entityType->code}();
    }

    /**
     * Child attribute
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|MiscModel
     */
    public function getChildAttribute()
    {
        // When in console mode (queue), don't cache results as the queue won't re-validate them
        return app()->runningInConsole() ? $this->child()->first() : EntityCache::child($this);
    }

    /**
     * @return Entity
     */
    public function reloadChild()
    {
        if ($this->isAttributeTemplate()) {
            return $this->load('attributeTemplate');
        } elseif ($this->isDiceRoll()) {
            return $this->load('diceRoll');
        }
        return $this->load($this->type());
    }

    /**
     * Fire an event to the observer to know that the entity was saved from the crud
     */
    public function crudSaved()
    {
        $this->fireModelEvent('crudSaved', false);
    }

    /**
     * Preview of the entity with mapped mentions. For map markers
     */
    public function mappedPreview(): string
    {
        if ($this->isMissingChild()) {
            return '';
        }
        $campaign = CampaignLocalization::getCampaign();
        if ($campaign->boosted()) {
            $boostedTooltip = strip_tags($this->tooltip);
            if (!empty(mb_trim($boostedTooltip))) {
                $text = Mentions::mapEntity($this);
                return (string)strip_tags($text);
            }
        }
        if ($this->entityType->isSpecial()) {
            if (!$this->hasEntry()) {
                return '';
            }
            return Str::limit(strip_tags($this->parsedEntry()), 500);
        }
        if (!$this->child->hasEntry()) {
            return '';
        }
        // @phpstan-ignore-next-line
        return Str::limit(strip_tags($this->child->parsedEntry()), 500);
    }


    /**
     * @return string
     */
    public function url(string $action = 'show', array $options = [])
    {
        $campaign = CampaignLocalization::getCampaign();
        try {
            if ($action == 'index') {
                return route($this->entityType->code . '.index', [$campaign, $this->entityType]);
            } elseif ($action === 'show') {
                return route('entities.show', [$campaign, $this] + $options);
            } elseif ($action === 'edit') {
                return route('entities.edit', [$campaign, $this] + $options);
            }
            $routeOptions = array_merge([$campaign, $this->entity_id], $options);
            return route($this->entityType->code . '.' . $action, $routeOptions);
        } catch (Exception $e) {
            return route('dashboard', $campaign);
        }
    }

    /**
     * Get the entity's type id
     */
    public function typeId()
    {
        return $this->type_id;
    }

    /**
     */
    public function isType(array|int $types): bool
    {
        if (!is_array($types)) {
            $types = [$types];
        }

        return in_array($this->type_id, $types);
    }

    public function cleanCache(): self
    {
        unset($this->cachedType, $this->cachedPluralName);

        return $this;
    }

    /**
     * Get the image (or default image) of an entity
     * @param int $width = 200
     */
    public function thumbnail(int $width = 400, int $height = null, $field = 'header_image'): string
    {
        if (empty($this->$field)) {
            return '';
        }

        return Img::resetCrop()->crop($width, $height ?? $width)->url($this->$field);
    }

    /**
     * If an entity has entity files
     */
    public function hasFiles(): bool
    {
        return $this->type_id != config('entities.ids.bookmark');
    }

    /**
     * Touch a model (update the timestamps) without any observers/events
     */
    public function touchSilently()
    {
        return static::withoutEvents(function () {
            // Still log who edited the entity
            $this->updated_by = auth()->user()->id;
            return $this->touch();
        });
    }

    /**
     */
    public function hasHeaderImage(): bool
    {
        if (!empty($this->header_image)) {
            return true;
        }

        return !empty($this->header_uuid) && !empty($this->header);
    }

    /**
     * Determine if an entity has an image that can be shown. This can be either uploaded
     * directly on them, or from the gallery
     */
    public function hasImage(bool $boosted = false): bool
    {
        return !empty($this->image_path) || !empty($this->image);
    }

    /**
     */
    public function hasLinks(): bool
    {
        return $this->links()->count() > 0;
    }

    /**
     * Get the entity background header image
     */
    public function getHeaderUrl(): string|null
    {
        if (!empty($this->header_image)) {
            return $this->thumbnail(1200, 400, 'header_image');
        }

        if (empty($this->header)) {
            return null;
        }

        return $this->header->getUrl(1200, 400);
    }

    /**
     * Determine if an entity has pinned elements to display
     */
    public function hasPins(): bool
    {
        if ($this->pinnedRelations->isNotEmpty()) {
            return true;
        }
        if ($this->starredAttributes()->isNotEmpty()) {
            return true;
        }
        return (bool) ($this->pinnedFiles->isNotEmpty());
    }

    /**
     * @return array|string[]
     */
    public function postPositionOptions(?int $position = null): array
    {
        $options = $position ? [
            null => __('posts.position.dont_change'),
        ] : [];

        $layers = $this->posts->sortBy('position');
        $hasFirst = false;
        foreach ($layers as $layer) {
            if (!$hasFirst) {
                $hasFirst = true;
                $options[$layer->position < 0 ? $layer->position - 1 : 1] = __('posts.position.first');
            }
            $key = $layer->position > 0 ? $layer->position + 1 : $layer->position;
            $lang = __('maps/layers.placeholders.position_list', ['name' => $layer->name]);
            if (app()->isLocal()) {
                $lang .= ' (' . $key . ')';
            }
            $options[$key] = $lang;
        }

        // Didn't have a first option added, add one now
        if (!$hasFirst) {
            $options[1] = __('posts.position.first');
        }

        //If is the last position remove last+1 position from the options array
        /*if ($position == array_key_last($options) - 1 && count($options) > 1) {
            array_pop($options);
        }*/
        return $options;
    }

    public function export(): array
    {
        $fields = [
            'id',
            'entity_id',
            'type_id',
            'name',
            'is_private',
            'tooltip',
            'is_template',
            'is_attributes_private',
            'focus_x',
            'focus_y',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'image_path',
            'image_uuid',
            'header_image',
            'header_uuid',
            'marketplace_uuid',
        ];
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $this->$field;
        }

        // Entity relations
        $relations = [
            'entityTags', 'relationships', 'posts', 'abilities', 'events', 'entityAttributes', 'assets', 'mentions', 'inventories'
        ];
        foreach ($relations as $relation) {
            foreach ($this->$relation as $model) {
                if ($relation === 'abilities' && empty($model->ability)) {
                    continue;
                }
                if ($relation === 'inventories' && empty($model->item)) {
                    continue;
                }
                //here
                if (method_exists($model, 'exportFields')) {
                    $export = [];
                    foreach ($model->exportFields() as $field) {
                        $export[$field] = $model->$field;
                    }
                    $data[$relation][] = $export;
                } elseif (method_exists($model, 'export')) {
                    $data[$relation][] = $model->export();
                } else {
                    $data[$relation][] = $model->toArray();
                }
            }
        }
        return $data;
    }

    /**
     * List of inventory items, group by alphabetical position
     */
    public function orderedInventory(): Collection
    {
        $inventory = [];
        $items = $this->inventories()->with(['image', 'item', 'item.entity', 'item.entity.image'])->get();
        foreach ($items as $item) {
            if ($item->item_id && (empty($item->item) || empty($item->item->entity))) {
                continue;
            }
            $position = $item->position ?: __('entities/inventories.default_position');
            $inventory[$position][] = $item;
        }

        // We want the inventory ordered by position, then by item name
        $collator = new Collator(app()->getLocale());
        $positions = array_keys($inventory);
        $collator->asort($positions);

        $ordered = [];
        foreach ($positions as $position) {
            $items = new Collection($inventory[$position]);
            $ordered[$position] = $items->sortBy(function ($model) {
                /** @var Inventory $model */
                return $model->itemName();
            });
        }

        return new Collection($ordered);
    }

    public function hasChild(): bool
    {
        return !$this->entityType->isSpecial();
    }

    public function isMissingChild(): bool
    {
        return !$this->entityType->isSpecial() && empty($this->child);
    }

    /**
     * Generate the entity's body css classes
     */
    public function bodyClasses(): string
    {
        $classes = [
            'kanka-entity-' . $this->id,
            'kanka-entity-' . $this->entityType->code,
        ];

        if (!$this->entityType->isSpecial() && !empty($this->child->type)) {
            $classes[] = 'kanka-type-' . Str::slug($this->child->type);
        }

        foreach ($this->tagsWithEntity(true) as $tag) {
            $classes[] = 'kanka-tag-' . $tag->id;
            $classes[] = 'kanka-tag-' . $tag->slug;

            if ($tag->tag_id) {
                $classes[] = 'kanka-tag-' . $tag->tag_id;
            }
        }

        // Specific entity flags
        // @phpstan-ignore-next-line
        if ($this->isCharacter() && $this->child->is_dead) {
            $classes[] = 'character-dead';
            // @phpstan-ignore-next-line
        } elseif ($this->isQuest() && $this->child->is_completed) {
            $classes[] = 'quest-completed';
        }

        if ($this->is_private) {
            $classes[] = 'kanka-entity-private';
        }

        if ($this->hasHeaderImage()) {
            $classes[] = 'entity-with-banner';
        }

        return (string) implode(' ', $classes);
    }

    /**
     * Determine if the model has an entry text field
     */
    public function hasEntry(): bool
    {
        // If all that's in the entry is two \n, then there is no real content
        return mb_strlen($this->entry) > 2;
    }
}
