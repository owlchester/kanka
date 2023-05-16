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
use App\Traits\CampaignAware;
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

    /** @var array List of entity types */
    protected array $entities = [];

    /** @var bool If the process is copying an entity (this should be moved outside of this class) */
    protected bool $copied = false;

    /** @var bool|array */
    protected bool|array $cachedNewEntityTypes = false;

    /** @var bool|array */
    protected bool|array $cachedTags = false;

    /** @var array|string[] Popular entity types */
    protected array $popularEntityTypes = [
        'characters',
        'locations',
        'races',
        'items',
        'organisations',
    ];

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
     * Get labelled entities
     *
     * @param bool $singular
     * @param array $ignore
     * @param bool $includeNull
     * @return array
     */
    public function labelledEntities(bool $singular = true, array $ignore = [], bool $includeNull = false): array
    {
        $labels = [];
        if ($includeNull) {
            $labels = ['' => ''];
        }

        foreach ($this->entities() as $entity => $class) {
            if (auth()->check() && auth()->user()->can('create', $class)) {
                /** @var MiscModel|mixed $misc */
                $misc = new $class();
                if ($singular) {
                    $labels[$entity] = Module::singular($misc->entityTypeId(), __('entities.' . $this->singular($entity)));
                } else {
                    $labels[$entity] = Module::plural($misc->entityTypeId(), __('entities.' . $entity));
                }
            }
        }

        // Removed options
        if (!empty($ignore)) {
            foreach ($ignore as $unset) {
                unset($labels[$unset]);
            }
        }

        return $labels;
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
     * @return Entity
     */
    public function move(Entity $entity, array $request): Entity
    {
        return $this->moveCampaign(
            $entity,
            $request['campaign'],
            Arr::get($request, 'copy', false)
        );
    }

    /**
     * Transform an entity into another type
     * @param Entity $entity
     * @param string $entityType
     * @param MiscModel|null $misc
     * @return Entity
     * @throws \Exception
     */
    public function transform(Entity $entity, string $entityType, MiscModel $misc = null): Entity
    {
        return $this->moveType($entity, $entityType, $misc);
    }

    /**
     * Move an entity to another campaign
     * @param Entity $entity
     * @param int $campaignId
     * @param bool $copy
     * @return Entity
     * @throws TranslatableException
     */
    protected function moveCampaign(Entity $entity, int $campaignId, bool $copy): Entity
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

        DB::beginTransaction();
        try {
            // Made it so far, we can move the entity's campaign_id. We first need to remove all the
            // relations and, since they won't make sense on the new campaign.
            $entity->relationships()->delete();
            $entity->targetRelationships()->delete();

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
            $child->campaign_id = $campaign->id; // Technically don't need this since it's in MiscObserver::saving()
            if (empty($child->slug)) {
                $child->slug = Str::slug($child->name, '');
            }
            $child->saveQuietly();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        // Switch back to the original campaign
        CampaignLocalization::forceCampaign($currentCampaign);

        return $entity;
    }

    /**
     * @param Entity $entity
     * @param Campaign $newCampaign
     * @return Entity
     */
    protected function copyToCampaign(Entity $entity, Campaign $newCampaign)
    {
        // Save and keep the current campaign before updating the entity
        $originalCampaign = CampaignLocalization::getCampaign();

        // Update Entity first, as there are no hooks on the Entity model.
        CampaignLocalization::forceCampaign($newCampaign);
        $this->targetCampaign = $newCampaign;

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
        } catch (\Exception $e) {
            DB::rollBack();
        }

        // Switch back to the original campaign
        CampaignLocalization::forceCampaign($originalCampaign);

        return $entity;
    }

    /**
     * @param Entity $entity
     * @param string $target
     * @param MiscModel|null $misc
     * @return Entity
     * @throws \Exception
     */
    protected function moveType(Entity $entity, string $target, MiscModel $misc = null)
    {
        // Create new model
        if (!isset($this->entities[$target])) {
            throw new \Exception("Unknown target '{$target}' for transforming entity");
        }

        /** @var MiscModel $new */
        $new = new $this->entities[$target]();
        /** @var MiscModel $old */
        $old = $misc;
        if (empty($misc)) {
            $old = $entity->child;
        }

        // Move attributes
        $oldAttributes = $old->getAttributes();
        unset($oldAttributes['id']);

        $fillable = $new->getFillable();
        foreach ($oldAttributes as $attribute => $value) {
            if (in_array($attribute, $fillable)) {
                $new->{$attribute} = $value;
            }
        }

        // Special import for location parent_location_id
        /** @var Location $old */
        /** @var Item $new */
        if (in_array('location_id', $fillable) && empty($new->location_id) && !empty($old->parent_location_id)) {
            $new->location_id = $old->getParentId();
        }
        /** @var Item $old */
        /** @var Location $new */
        if (in_array('parent_location_id', $fillable) && empty($new->parent_location_id) && !empty($old->location_id)) {
            $new->setParentId($old->location_id);
        }

        /** @var Race|Creature $old */
        /** @var Creature|Race $new */
        $raceID = config('entities.ids.race');
        $creatureID = config('entities.ids.creature');

        if (in_array($old->entityTypeId(), [$raceID, $creatureID]) && !in_array($new->entityTypeId(), [$raceID, $creatureID])) {
            if (in_array('location_id', $fillable)) {
                $new->location_id = $old->locations()->first()->id;
            } elseif (in_array('parent_location_id', $fillable)) {
                // Todo: fix crash when location is empty
                $new->setParentId($old->locations()->first()->id);
            }
        }

        // Copy file
        if (!empty($new->image)) {
            $newPath = str_replace($old->getTable(), $new->getTable(), $old->image);
            $new->image = $newPath;
            if (!Storage::exists($newPath)) {
                Storage::copy($old->image, $newPath);
            }
        }

        $this->fixTree($new);

        // Finally, we can save. Should be all good.
        $new->campaign_id = $old->campaign_id;
        $new->saveQuietly();

        // If switching from an organisation to a family, we need to move the members?
        /** @var Organisation|Family $old */
        /** @var Family|Organisation $new */
        if (
            $old->entityTypeId() == config('entities.ids.organisation') &&
            $new->entityTypeId() == config('entities.ids.family')
        ) {
            foreach ($old->members as $member) {
                $member->delete();
                $new->members()->attach($member->character_id);
            }
        } elseif (
            $old->entityTypeId() == config('entities.ids.family') &&
            $new->entityTypeId() == config('entities.ids.organisation')
        ) {
            foreach ($old->members as $character) {
                $orgMember = new OrganisationMember();
                $orgMember->character_id = $character->id;
                $orgMember->organisation_id = $new->id;
                $orgMember->role = '';
                $orgMember->save();
                $old->members()->detach($character->id);
            }
        } else {
            // Remove members when they aren't characters
            /** @var Family $old */
            if (isset($old->members)) {
                foreach ($old->members as $member) {
                    // We make sure this isn't a character, because a family has members which are
                    // directly characters while orgs have members which are an in between entity.
                    if (!$member instanceof Character) {
                        $member->delete();
                    }
                }
            }
        }
        // Remove a character from conversations
        /** @var Character $old */
        if ($old->entityTypeId() === config('entities.ids.character')) {
            foreach ($old->conversationParticipants as $conPar) {
                $conPar->delete();
            }
        }

        $this->moveLocations($old, $new);

        // Update entity to its new type. We don't use a new entity to keep all mentions, attributes and
        // other related elements attached.
        $entity->type_id = $new->entityTypeID();
        $entity->entity_id = $new->id;
        $entity->cleanCache()->save();

        // Delete old, this will take care of pictures and stuff. We detach the
        // entity to avoid the softDelete affecting it and causing duplicate
        // entities in the db. ForceDelete the MiscModel for img cleanup.
        $old->entity = null;

        // Change the permission's misc_id to be the new one
        CampaignPermission::where('entity_id', $entity->id)
            ->where('misc_id', $old->id)
            ->update(['misc_id' => $new->id]);

        // Force delete the old entity to avoid it creating weird issues in the db by being soft deleted.
        $old->forceDelete();

        return $entity;
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
     * Get an entity object string based on the entity type
     * @param string $class
     * @return string|false
     */
    public function getName(string $class): string|false
    {
        $flipped = array_flip($this->entities);
        if (!Arr::has($flipped, $class)) {
            return false;
        }
        $name = Arr::get($flipped, $class);
        return Str::singular($name);
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
     * From a link to an entity, get the entity ID
     * @param string $url
     */
    /*public function extractEntityIdFromUrl(string $url): int
    {
        // Strip stuff we don't want based on known urls
        $url = Str::after($url, config('app.url') . '/');

        // Remove language
        $url = Str::after(trim($url, '/'), '/');

        // left with characters/123 or entities/13223
        if (Str::startsWith($url, 'entities')) {
            // Easy peasy-ish
        }
    }*/

    /**
     * Toggle the entity's template status
     * @param Entity $entity
     * @return Entity
     */
    public function toggleTemplate(Entity $entity): Entity
    {
        $entity->is_template = !$entity->is_template;
        $entity->save();
        return $entity;
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
        $model->name = $name;
        $model->slug = Str::slug($name, '');
        $model->is_private = $defaultPrivate;
        $model->campaign_id = $campaign->id;

        // If the modal is a tree, it needs to be placed in its own bounds
        if (method_exists($model, 'makeRoot')) {
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

    /**
     * For entities with multiple locations, they can sometimes be moved around
     * @param MiscModel $old
     * @param MiscModel $new
     * @return void
     */
    protected function moveLocations(MiscModel $old, MiscModel $new)
    {
        /** @var Race|Creature $old */
        /** @var Creature|Race $new */
        $raceID = config('entities.ids.race');
        $creatureID = config('entities.ids.creature');

        if (!in_array($old->entityTypeId(), [$raceID, $creatureID]) && in_array($new->entityTypeId(), [$raceID, $creatureID])) {
            if (!in_array('parent_location_id', $new->getFillable())) {
                $new->locations()->attach($old->parent_location_id);
            } else {
                $new->locations()->attach($old->location_id);
            }
            return false;
        }

        if (
            !in_array($old->entityTypeId(), [$raceID, $creatureID]) ||
            !in_array($new->entityTypeId(), [$raceID, $creatureID])
        ) {
            if (property_exists($old, 'locations')) {
                $old->locations()->sync([]);
            }
            return false;
        }

        foreach ($old->locations as $loc) {
            $new->locations()->attach($loc->id);
        }
        $old->locations()->sync([]);
    }

    public function popularEntityTypes(): array
    {
        return $this->popularEntityTypes;
    }

    /**
     * When transforming or moving an entity, we need to fix its tree
     * @param MiscModel $model
     * @return void
     */
    protected function fixTree(MiscModel $model): void
    {
        // When transforming to a nested model, we need to recalculate the tree bounds to
        // place it correctly in the overall campaign tree.
        if (!method_exists($model, 'recalculateTreeBounds')) {
            return;
        }
        $isLocationWithParent = in_array('parent_location_id', $model->getFillable()) && !empty($model->getParentId());
        // If it's not a location or the parent location is empty, force the parent to be properly empty
        if (!$isLocationWithParent) {
            $model->setParentId(null);
        }
        $model->{$model->getRgtName()} = 0;
        $model->{$model->getLftName()} = 0;
        if ($model->exists) {
            $model->exists = false;
            $model->recalculateTreeBounds();
            $model->exists = true;
        } else {
            $model->recalculateTreeBounds();
        }
        // For a location with a parent, place it inside the tree
        if ($isLocationWithParent) {
            $model->forcePendingAction();
        }
    }
}
