<?php

namespace App\Services;

use App\Facades\Module;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Creature;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\TimelineEra;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\CanFixTree;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use Illuminate\Support\Str;

class EntityService
{
    use CampaignAware;
    use PurifiableTrait;
    use CanFixTree;

    /** @var array List of entity types */
    protected array $entities = [];

    /** @var bool If the process is copying an entity (this should be moved outside of this class) */
    protected bool $copied = false;

    /** @var bool|array */
    protected bool|array $cachedNewEntityTypes = false;

    /** @var bool|array */
    protected bool|array $cachedTags = false;


    protected Campaign $targetCampaign;

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
     * @return bool
     */
    public function copied(): bool
    {
        return $this->copied;
    }

    public function targetCampaign(): Campaign
    {
        return $this->targetCampaign;
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
     * Move an entity to another type or campaign
     *
     * @param Entity $entity
     * @param array $request
     * @return bool
     */
    public function move(Entity $entity, array $request): bool
    {
        return $this->moveCampaign(
            $entity,
            $request['campaign'],
            Arr::get($request, 'copy', false)
        );
    }

    /**
     * Move an entity to another campaign
     * @param Entity $entity
     * @param int $campaignId
     * @param bool $copy
     * @return bool
     * @throws TranslatableException
     */
    protected function moveCampaign(Entity $entity, int $campaignId, bool $copy): bool
    {
        // First we make sure we have access to the new campaign.
        /** @var Campaign|null $campaign */
        $campaign = auth()->user()->campaigns()->where('campaign_id', $campaignId)->first();
        if (empty($campaign)) {
            throw new TranslatableException('entities/move.errors.unknown_campaign');
        }

        // Check that the new campaign is different than the current one.
        if ($campaign->id == $entity->campaign_id) {
            throw new TranslatableException('entities/move.errors.same_campaign');
        }

        // Can the user create an entity of that type on the new campaign?
        if (!auth()->user()->can('create', [get_class($entity->child), null, $campaign])) {
            throw new TranslatableException('entities/move.errors.permission');
        }

        // Trying to move (not copy) but can't update the original entity
        if (!$copy && !auth()->user()->can('update', $entity->child)) {
            throw new TranslatableException('entities/move.errors.permission_update');
        }

        if ($copy) {
            $this->copied = true;
            return $this->copyToCampaign($entity, $campaign);
        }

        // Save and keep the current campaign before updating the entity
        $currentCampaign = CampaignLocalization::getCampaign();

        $success = false;
        DB::beginTransaction();
        try {
            // Made it so far, we can move the entity's campaign_id. We first need to remove all the
            // relations and, since they won't make sense on the new campaign.
            $entity->relationships()->delete();
            $entity->targetRelationships()->delete();
            $entity->events()->delete();
            $entity->imageMentions()->delete();

            // Get the child of the entity (the actual Location, Character etc) and remove the permissions, since they
            // won't make sense on the new campaign either.
            /* @var MiscModel $child */
            $child = $entity->child;
            $entity->permissions()->delete();

            // Detach is a custom function on a child to remove itself from where it is parent to other entities.
            $child->detach();

            // Update Entity first, as there are no hooks on the Entity model.
            CampaignLocalization::forceCampaign($campaign);
            $this->targetCampaign = $campaign;
            $entity->campaign_id = $campaign->id;
            $entity->saveQuietly();

            $this->fixTree($child);
            // Update child second. We do this otherwise we'll have an old entity and a new one
            $child->campaign_id = $campaign->id;
            if (empty($child->slug)) {
                $child->slug = Str::slug($child->name, '');
            }
            $child->saveQuietly();

            DB::commit();
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
        }

        // Switch back to the original campaign
        CampaignLocalization::forceCampaign($currentCampaign);

        return $success;
    }

    /**
     * @param Entity $entity
     * @param Campaign $newCampaign
     * @return bool
     */
    protected function copyToCampaign(Entity $entity, Campaign $newCampaign): bool
    {
        // Save and keep the current campaign before updating the entity
        $originalCampaign = CampaignLocalization::getCampaign();

        // Update Entity first, as there are no hooks on the Entity model.
        CampaignLocalization::forceCampaign($newCampaign);
        $this->targetCampaign = $newCampaign;
        $success = false;

        DB::beginTransaction();
        try {
            $newModel = $entity->child->replicate(['campaign_id']);
            $newModel->campaign_id = $newCampaign->id;
            // Remove any foreign keys that wouldn't make any sense in the new campaign
            foreach ($newModel->getAttributes() as $attribute) {
                if (str_contains($attribute, '_id')) {
                    $newModel->$attribute = null;
                }
            }

            // Copy the image to avoid issues when deleting/replacing one image
            if (!empty($entity->child->image)) {
                $uniqid = uniqid();
                $newPath = str_replace('.', $uniqid . '.', $entity->child->image);
                $newModel->image = $newPath;
                if (!Storage::exists($newPath)) {
                    Storage::copy($entity->child->image, $newPath);
                }
            }

            $this->fixTree($newModel);

            // The model is ready to be saved.
            $newModel->saveQuietly();
            $newModel->createEntity();

            // Copy entity notes over
            foreach ($entity->posts as $note) {
                /** @var EntityNote $newNote */
                $newNote = $note->replicate(['entity_id', 'created_by', 'updated_by']);
                $newNote->entity_id = $newModel->entity->id;
                $newNote->created_by = auth()->user()->id;
                $newNote->saveQuietly();
            }

            // Attributes please
            foreach ($entity->attributes as $attribute) {
                /** @var Attribute $newAttribute */
                $newAttribute = $attribute->replicate(['entity_id']);
                $newAttribute->entity_id = $newModel->entity->id;
                $newAttribute->saveQuietly();
            }

            // Characters: copy traits
            if ($entity->child instanceof Character) {
                /** @var CharacterTrait $trait */
                foreach ($entity->child->characterTraits as $trait) {
                    $newTrait = $trait->replicate(['character_id']);
                    $newTrait->character_id = $newModel->id;
                    $newTrait->saveQuietly();
                }
            }

            // Timeline: copy eras
            if ($entity->child instanceof Timeline) {
                foreach ($entity->child->eras as $era) {
                    /** @var TimelineEra $newEra **/
                    $newEra = $era->replicate(['timeline_id']);
                    $newEra->timeline_id = $newModel->id;
                    $newEra->saveQuietly();
                }
            }

            if (request()->has('copy_related_elements') && request()->filled('copy_related_elements')) {
                $entity->child->copyRelatedToTarget($newModel);
            }

            DB::commit();
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
        }

        // Switch back to the original campaign
        CampaignLocalization::forceCampaign($originalCampaign);

        return $success;
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
