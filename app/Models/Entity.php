<?php

namespace App\Models;

use App\Facades\CampaignLocalization;
use App\Facades\EntityCache;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\Concerns\Acl;
use App\Models\Concerns\EntityLogs;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Picture;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\SortableTrait;
use App\Models\Relations\EntityRelations;
use App\Models\Scopes\EntityScopes;
use App\Traits\CampaignTrait;
use App\Traits\TooltipTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * Class Entity
 * @package App\Models
 *
 * @property integer $id
 * @property integer $entity_id
 * @property integer $campaign_id
 * @property string $name
 * @property string $type
 * @property integer $type_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property boolean $is_private
 * @property boolean $is_attributes_private
 * @property string $tooltip
 * @property string $header_image
 * @property string|null $image_uuid
 * @property string|null $header_uuid
 * @property boolean $is_template
 * @property string|null $marketplace_uuid
 * @property integer|null $focus_x
 * @property integer|null $focus_y
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Entity extends Model
{
    /**
     * Traits
     */
    use CampaignTrait,
        EntityRelations,
        BlameableTrait,
        EntityScopes,
        Searchable,
        TooltipTrait,
        Picture,
        SoftDeletes,
        EntityLogs,
        Paginatable,
        LastSync,
        SortableTrait,
        Acl;

    /** @var string[]  */
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
    ];

    /** @var array Searchable fields */
    protected array $searchableColumns = [
        'name',
    ];

    /** @var string[] Fields that can be used to order by */
    protected $sortable = [
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

    /**
     * True if the user granted themselves permission to read/write when creating the entity
     * @var bool
     */
    public $permissionGrantSelf = false;

    /** @var bool|string */
    protected $cachedPluralName = false;

    /** @var bool|string the entity type string */
    protected $cachedType = false;

    /**
     * Get the child entity
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|MiscModel
     */
    public function child()
    {
        if ($this->type_id == config('entities.ids.attribute_template')) {
            return $this->attributeTemplate();
        } elseif ($this->type_id == config('entities.ids.dice_roll')) {
            return $this->diceRoll();
        }
        return $this->{$this->type()}();
    }

    /**
     * Child attribute
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|MiscModel
     */
    public function getChildAttribute()
    {
        return EntityCache::child($this);
    }

    /**
     * @return Entity
     */
    public function reloadChild()
    {
        if ($this->type_id == config('entities.ids.attribute_template')) {
            return $this->load('attributeTemplate');
        } elseif ($this->type_id == config('entities.ids.dice_roll')) {
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
     * Create a short name for the interface
     * @return mixed|string
     */
    public function shortName()
    {
        if (strlen($this->name) > 30) {
            return '<span title="' . e($this->name) . '">' . substr(e($this->name), 0, 28) . '...</span>';
        }
        return $this->name;
    }



    /**
     * Preview of the entity with mapped mentions. For map markers
     * @return string
     */
    public function mappedPreview(): string
    {
        if (empty($this->child)) {
            return '';
        }
        $campaign = CampaignLocalization::getCampaign();
        if ($campaign->boosted()) {
            $boostedTooltip = strip_tags($this->tooltip);
            if (!empty(trim($boostedTooltip))) {
                $text = Mentions::mapEntity($this);
                return (string)strip_tags($text);
            }
        }
        $text = Str::limit($this->child->entry(), 500);
        return (string)strip_tags($text);
    }


    /**
     * @param string $action
     * @return string
     */
    public function url(string $action = 'show', array $options = [])
    {
        try {
            if ($action == 'index') {
                return route($this->pluralType() . '.index');
            }
            $routeOptions = array_merge([$this->entity_id], $options);
            return route($this->pluralType() . '.' . $action, $routeOptions);
        } catch (\Exception $e) {
            return route('dashboard');
        }
    }

    /**
     * Get the plural name of the entity for routes
     * @return string
     */
    public function pluralType(): string
    {
        if ($this->cachedPluralName !== false) {
            return $this->cachedPluralName;
        }
        return $this->cachedPluralName = Str::plural($this->type());
    }

    /**
     * Get the entity's type id
     * @return \Illuminate\Config\Repository|mixed
     */
    public function typeId()
    {
        return $this->type_id;
    }

    public function entityType(): string
    {
        return __('entities.' . $this->type());
    }

    /**
     * @param array|int $types
     * @return bool
     */
    public function isType($types): bool
    {
        if (!is_array($types)) {
            $types[] = $types;
        }

        return in_array($this->type_id, $types);
    }

    /**
     * @return string
     */
    public function type(): string
    {
        if ($this->cachedType !== false) {
            return $this->cachedType;
        }
        $type = array_search($this->type_id, config('entities.ids'));
        return $this->cachedType = $type;
    }

    public function cleanCache(): self
    {
        $this->cachedType = false;
        $this->cachedPluralName = false;
        return $this;
    }

    /**
     * Get the image (or default image) of an entity
     * @param int $width = 200
     * @param int $height = null (null takes width)
     * @return string
     */
    public function getImageUrl(int $width = 400, $height = null, $field = 'header_image'): string
    {
        if (empty($this->$field)) {
            return '';
        }

        return Img::resetCrop()->crop($width, $height ?? $width)->url($this->$field);
    }

    /**
     * If an entity has entity files
     * @return bool
     */
    public function hasFiles(): bool
    {
        return $this->type_id != config('entities.ids.menu_link');
    }

    /**
     * Touch a model (update the timestamps) without any observers/events
     * @return mixed
     */
    public function touchSilently()
    {
        return static::withoutEvents(function () {
            // Still logg who edited the entity
            $this->updated_by = auth()->user()->id;
            return $this->touch();
        });
    }

    /**
     * Entity assets: files and links
     * @return array
     */
    /*public function assets(): Collection
    {
        $assets = $this->files;
        $campaign = CampaignLocalization::getCampaign();
        $links = $campaign->boosted() ? $this->links : [];
        $aliases = $campaign->boosted() ? $this->aliases : [];
        $assets = $assets->merge($aliases);
        $assets = $assets->merge($links);
        //$assets
        return $assets->sort(function ($a, $b) {
            return strcmp($a->name, $b->name);
        });
    }*/

    /**
     * @param bool $superboosted
     * @return bool
     */
    public function hasHeaderImage(bool $superboosted = false): bool
    {
        if (!empty($this->header_image)) {
            return true;
        }

        if ($superboosted && !empty($this->header_uuid) && !empty($this->header)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if an entity has an image that can be shown
     * @return bool
     */
    public function hasImage(bool $boosted = false): bool
    {
        // Most basic setup, the child has an image
        if (!empty($this->child->image)) {
            return true;
        }
        // Otherwise, might have a gallery image, which needs a boosted campaign
        return $boosted && $this->image;
    }

    /**
     * Get the entity's image url (local or gallery)
     * @param $boosted
     * @return string
     */
    public function getEntityImageUrl($boosted = false, int $width = 200, int $height = 200): string
    {
        if ($boosted && $this->image) {
            return Img::crop($width, $height)->url($this->image->path);
        }
        return $this->child->getImageUrl($width, $height);
    }

    /**
     * @return bool
     */
    public function hasLinks(): bool
    {
        return $this->links()->count() > 0;
    }

    /**
     * @param bool $superboosted
     * @return string
     */
    public function getHeaderUrl(bool $superboosted = false): string
    {
        if (!empty($this->header_image)) {
            return $this->getImageUrl(1200, 400, 'header_image');
        }

        if (!$superboosted) {
            return '';
        }

        if (empty($this->header)) {
            return '';
        }

        return Img::resetCrop()
            ->crop(1200, 400)
            ->url($this->header->path);
    }

    /**
     * @return bool
     */
    public function accessAttributes(): bool
    {
        if (!$this->is_attributes_private) {
            return true;
        }
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Count the number of mentions this entity has. The AclTrait on entities and posts
     * makes sure only visible things get added to the query.
     * @return int
     */
    public function mentionsCount(): int
    {
        return $this->targetMentions()->where(function ($sub) {
            return $sub
                ->where(function ($subEnt) {
                    return $subEnt->entity()
                        ->has('entity');
                })
                ->orWhere(function ($subPost) {
                    return $subPost->entityNote()
                        ->has('entityNote.entity');
                })
                ->orWhere(function ($subCam) {
                    return $subCam->campaign();
                });
        })
            ->count();
    }

    /**
     * Determine if an entity has pinned elements to display
     * @return bool
     */
    public function hasPins(): bool
    {
        if ($this->starredRelations->isNotEmpty()) {
            return true;
        }
        if ($this->accessAttributes() && $this->starredAttributes()->isNotEmpty()) {
            return true;
        }
        return false;
    }
}
