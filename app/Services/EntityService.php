<?php

namespace App\Services;

use App\Facades\Module;
use App\Models\Ability;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\Creature;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\CanFixTree;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Facades\CampaignLocalization;
use Illuminate\Support\Str;

class EntityService
{
    use CampaignAware;
    use PurifiableTrait;

    /** @var array List of entity types */
    protected array $entities = [];

    /** @var bool|array */
    protected bool|array $cachedNewEntityTypes = false;

    /** @var bool|array */
    protected bool|array $cachedTags = false;

    /**
     * EntityService constructor.
     */
    public function __construct()
    {
        $this->entities = [
            'abilities' => 'App\Models\Ability',
            'characters' => 'App\Models\Character',
            'calendars' => 'App\Models\Calendar',
            'conversations' => 'App\Models\Conversation',
            'creatures' => 'App\Models\Creature',
            'events' => 'App\Models\Event',
            'families' => 'App\Models\Family',
            'items' => 'App\Models\Item',
            'journals' => 'App\Models\Journal',
            'locations' => 'App\Models\Location',
            'maps' => 'App\Models\Map',
            'notes' => 'App\Models\Note',
            'organisations' => 'App\Models\Organisation',
            'quests' => 'App\Models\Quest',
            'races' => 'App\Models\Race',
            'tags' => 'App\Models\Tag',
            'timelines' => 'App\Models\Timeline',
            'attribute_templates' => 'App\Models\AttributeTemplate',
            'dice_rolls' => 'App\Models\DiceRoll',
            'menu_links' => 'App\Models\MenuLink',
            'relations' => 'App\Models\Relation',
        ];
    }

    /**
     * Get the entities
     * @param array $excluded
     * @return array
     */
    public function entities(array $excluded = []): array
    {
        if (empty($excluded)) {
            return $this->entities;
        }

        $entities = [];
        foreach ($this->entities as $name => $class) {
            if (!in_array($name, $excluded)) {
                $entities[$name] = $class;
            }
        }
        return $entities;
    }

    /**
     * @param string $entity
     * @return string
     */
    public function singular(string $entity): string
    {
        $singular = rtrim($entity, 's');
        if ($entity == 'families') {
            $singular = 'family';
        } elseif ($entity == 'abilities') {
            $singular = 'ability';
        }
        return $singular;
    }


    /**
     * @param string $name
     * @param string $target
     * @return MiscModel
     * @throws \Exception
     */
    public function create($name, $target)
    {
        // Create new model
        if (!isset($this->entities[$target])) {
            throw new \Exception("Unknown entity type '{$target}' for creating entity");
        }

        /**
         * @var MiscModel $new
         */
        $new = new $this->entities[$target]();
        $new->name = $name;
        $new->is_private = Auth::user()->isAdmin() ? CampaignLocalization::getCampaign()->entity_visibility : false;
        $new->save();
        return $new;
    }

    /**
     * Get an entity object string based on the entity type
     * @param string $entity
     * @return string|bool
     */
    public function getClass(string $entity)
    {
        return Arr::get($this->entities, $entity, false);
    }

    /**
     * Get a list of enabled entities of a campaign
     * @param Campaign $campaign
     * @param array $except
     * @return array
     */
    public function getEnabledEntities(Campaign $campaign, $except = [])
    {
        $entityTypes = [];
        foreach ($this->entities() as $element => $class) {
            if (in_array($element, $except)) {
                continue;
            }
            if ($campaign->enabled($element)) {
                $entityTypes[] = $this->singular($element);
            }
        }
        return $entityTypes;
    }

    /**
     * @param array $except
     * @return array
     */
    public function getEnabledEntitiesSorted(bool $singular = true, $except = []): array
    {
        $entityTypes = [];
        foreach ($this->entities() as $element => $class) {
            if (in_array($element, $except)) {
                continue;
            }
            if ($this->campaign->enabled($element)) {
                /** @var MiscModel|mixed $misc */
                $misc = new $class();
                if ($singular) {
                    $entityTypes[$this->singular($element)] = Module::singular($misc->entityTypeId(), __('entities.' . $this->singular($element)));
                } else {
                    $entityTypes[$this->singular($element)] = Module::plural($misc->entityTypeId(), __('entities.' . $element));
                }
            }
        }

        $collator = new \Collator(app()->getLocale());
        $collator->asort($entityTypes);

        return $entityTypes;
    }

    /**
     * @param array $except
     * @return array
     */
    public function getEnabledEntitiesID(array $except = []): array
    {
        $types = $this->getEnabledEntities($this->campaign, $except);
        $ids = [];
        foreach ($types as $type) {
            $ids[] = config('entities.ids.' . $type);
        }

        return $ids;
    }

    /**
     * @return array
     */
    public function newEntityTypes(): array
    {
        if ($this->cachedNewEntityTypes !== false) {
            return $this->cachedNewEntityTypes;
        }

        if (!auth()->check()) {
            return $this->cachedNewEntityTypes = [];
        }

        // Save and keep the current campaign before updating the entity
        $campaign = CampaignLocalization::getCampaign();

        $newTypes = [
            'character' => Character::class,
            'location' => Location::class,
            'creature' => Creature::class,
            'race' => Race::class,
            'item' => Item::class,
            'note' => Note::class,
            'family' => Family::class,
            'organisation' => Organisation::class,
            'event' => Event::class,
            'journal' => Journal::class,
            'ability' => Ability::class,
            'quest' => Quest::class,
            'tag' => Tag::class,
        ];
        $entities = [];
        foreach ($newTypes as $type => $class) {
            if ($campaign->enabled(Str::plural($type)) && auth()->user()->can('create', $class)) {
                $entities[$type] = $class;
            }
        }

        return $this->cachedNewEntityTypes = $entities;
    }

    /**
     * @return array
     */
    public function getAutoApplyTags(): array
    {
        if ($this->cachedTags !== false) {
            return $this->cachedTags;
        }
        $allTags = [];
        $tags = \App\Models\Tag::autoApplied()->with('entity')->get();
        foreach ($tags as $tag) {
            if ($tag->entity !== null) {
                array_push($allTags, $tag->id);
            }
        }

        return $this->cachedTags = $allTags;
    }

    /**
     * @param MiscModel $model
     * @param string $name
     * @return MiscModel
     */
    public function makeNewMentionEntity(MiscModel $model, string $name)
    {
        $campaign = CampaignLocalization::getCampaign();
        $defaultPrivate = false;
        if (auth()->user()->isAdmin() && $campaign->entity_visibility) {
            $defaultPrivate = true;
        }
        // Force tags to be readable and removable from strip_tags
        $name = Str::replace(['&lt;', '&gt;'], ['<', '>'], $name);
        $model->name = $this->purify(trim(strip_tags($name)));
        $model->slug = Str::slug($model->name, '');
        $model->is_private = $defaultPrivate;
        $model->campaign_id = $campaign->id;

        // If the modal is a tree, it needs to be placed in its own bounds
        if (method_exists($model, 'makeRoot')) {
            // @phpstan-ignore-next-line
            $model->recalculateTreeBounds();
        }

        $model->saveQuietly();
        $model->createEntity();
        if (!$model->entity->isTag()) {
            $allTags = $this->getAutoApplyTags();
            $model->entity->tags()->attach($allTags);
        }
        return $model;
    }
}
