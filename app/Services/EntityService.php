<?php

namespace App\Services;

use App\Models\Ability;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterTrait;
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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use Illuminate\Support\Str;

class EntityService
{
    /**
     * @var array
     */
    protected $entities = [];

    protected $copied = false;

    protected $campaign;

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

    /** @var bool|array */
    protected $cachedNewEntityTypes = false;

    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * Get the entities
     *
     * @return array
     */
    public function entities($excluded = null)
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

    public function copied(): bool
    {
        return $this->copied;
    }

    /**
     * Get labelled entities
     *
     * @param bool $singular
     * @param array $ignore
     * @return array
     */
    public function labelledEntities($singular = true, array $ignore = [], $includeNull = false)
    {
        $labels = [];
        if ($includeNull) {
            $labels = ['' => ''];
        }

        foreach ($this->entities() as $entity => $class) {
            if (auth()->check() && auth()->user()->can('create', $class)) {
                if ($singular) {
                    $labels[$entity] = __('entities.' . $this->singular($entity));
                } else {
                    $labels[$entity] = __('entities.' . $entity);
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
     * @param $entity
     * @return string
     */
    public function singular($entity)
    {
        $singular = rtrim($entity, 's');
        if ($entity == 'families') {
            $singular = 'family';
        }
        elseif ($entity == 'abilities') {
            $singular = 'ability';
        }
        return $singular;
    }

    /**
     * Move an entity to another type or campaign
     *
     * @param Entity $entity
     * @param String $target
     * @return Entity
     */
    public function move(Entity $entity, $request)
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
    protected function moveCampaign(Entity $entity, int $campaignId, bool $copy)
    {
        // First we make sure we have access to the new campaign.
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
            // Made it so far, we can move the entity's campaign_id. We first need to remove all the relations and, since
            // they won't make sense on the new campaign.
            $entity->relationships()->delete();
            $entity->targetRelationships()->delete();

            // Get the child of the entity (the actual Location, Character etc) and remove the permissions, since they
            // won't make sense on the new campaign either.
            /* @var MiscModel $child */
            $child = $entity->child;
            $child->permissions()->delete();

            // Detach is a custom function on a child to remove itself from where it is parent to other entities.
            $child->detach();

            // Update Entity first, as there are no hooks on the Entity model.
            CampaignLocalization::forceCampaign($campaign);
            $entity->campaign_id = $campaign->id;
            $entity->save();

            // Finally, we can change and save the child. Should be all good. But tell the app not to create the entity to
            // avoid silly duplicates and new entities.
            $child->savingObserver = false;

            // Update child second. We do this otherwise we'll have an old entity and a new one
            $child->campaign_id = $campaign->id; // Technically don't need this since it's in MiscObserver::saving()
            $child->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
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

        DB::beginTransaction();
        try {
            $newModel = $entity->child->replicate();
            // Remove any foreign keys that wouldn't make any sense in the new campaign
            foreach ($newModel->getAttributes() as $attribute) {
                if (strpos($attribute, '_id') !== false) {
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

            // Remove map stuff from locations
            if ($newModel instanceof Location) {
                $newModel->map = null;
            }

            // The model is ready to be saved.
            $newModel->savingObserver = false;
            $newModel->saveObserver = false;
            $newModel->save();
            $newModel->createEntity();

            // Copy entity notes over
            foreach ($entity->notes as $note) {
                /** @var EntityNote $newNote */
                $newNote = $note->replicate();
                $newNote->entity_id = $newModel->entity->id;
                $newNote->savedObserver = false;
                $newNote->save();
            }

            // Attributes please
            foreach ($entity->attributes as $attribute) {
                /** @var EntityNote $newNote */
                $newAttribute = $attribute->replicate();
                $newAttribute->entity_id = $newModel->entity->id;
                $newAttribute->save();
            }

            // Characters: copy traits
            if ($entity->child instanceof Character) {
                /** @var CharacterTrait $trait */
                foreach ($entity->child->characterTraits as $trait) {
                    $newTrait = $trait->replicate();
                    $newTrait->character_id = $newModel->id;
                    $newTrait->save();
                }
            }

            // Timeline: copy eras
            if($entity->child instanceof Timeline) {
                /** @var TimelineEra $newEra **/
                foreach ($entity->child->eras as $era) {
                    $newEra = $era->replicate();
                    $newEra->timeline_id = $newModel->id;
                    $newEra->save();
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
     * @param $target
     * @return Entity
     * @throws \Exception
     */
    protected function moveType(Entity $entity, $target, MiscModel $misc = null)
    {
        // Create new model
        if (!isset($this->entities[$target])) {
            throw new \Exception("Unknown target '$target' for transforming entity");
        }
        /**
         * @var $new MiscModel
         */
        $new = new $this->entities[$target]();
        $old = null;
        if (!empty($misc)) {
            $old = $misc;
        } else {
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
        if (in_array('location_id', $fillable) && empty($new->location_id) && !empty($old->parent_location_id)) {
            $new->location_id = $old->parent_location_id;
        }
        if (in_array('parent_location_id', $fillable) && empty($new->parent_location_id) && !empty($old->location_id)) {
            $new->parent_location_id = $old->location_id;
        }

        // Copy file
        if (!empty($new->image)) {
            $newPath = str_replace($old->getTable(), $new->getTable(), $old->image);
            $new->image = $newPath;
            if (!Storage::exists($newPath)) {
                Storage::copy($old->image, $newPath);
            }
        }

        // Finally, we can save. Should be all good. But tell the app not to create the entity
        $new->savingObserver = false;
        $new->forceSavedObserver = false;
        $new->save();

        // If switching from an organisation to a family, we need to move the members?
        if ($old->getEntityType() == 'organisation' && $new->getEntityType() == 'family') {
            foreach ($old->members as $member) {
                if (empty($member->character->family_id)) {
                    $member->character->family_id = $new->id;
                    $member->character->save();
                }
                $member->delete();
            }
        } elseif ($old->getEntityType() == 'family' && $new->getEntityType() == 'organisation') {
            $characters = Character::where('family_id', $old->id)->get();
            foreach ($characters as $character) {
                $orgMember = new OrganisationMember();
                $orgMember->character_id = $character->id;
                $orgMember->organisation_id = $new->id;
                $orgMember->role = '';
                $orgMember->save();

                $character->family_id = null;
                $character->save();
            }
        } else {
            // Remove members when they aren't characters
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
        if ($old->getEntityType() == 'character') {
            foreach ($old->conversationParticipants as $conPar) {
                $conPar->delete();
            }
        }

        // Update entity
        $entity->type_id = $new->entityTypeID();
        $entity->entity_id = $new->id;
        $entity->cleanCache()->save();

        // Delete old, this will take care of pictures and stuff. We detach the
        // entity to avoid the softDelete affecting it and causing duplicate
        // entities in the db. ForceDelete the MiscModel for img cleanup.
        $old->entity = null;

        // Actually, don't force delete until the tree bug isn't fixed. This could cause deeper issues by deleting entities.
        $old->forceDelete();

        return $entity;
    }

    /**
     * @param $name
     * @param $target
     * @return MiscModel
     * @throws \Exception
     */
    public function create($name, $target)
    {
        // Create new model
        if (!isset($this->entities[$target])) {
            throw new \Exception("Unknown entity type '$target' for creating entity");
        }

        /**
         * @var $new MiscModel
         */
        $new = new $this->entities[$target]();
        $new->name = $name;
        $new->is_private = Auth::user()->isAdmin() ? CampaignLocalization::getCampaign()->entity_visibility : false;
        $new->save();
        return $new;
    }

    /**
     * Get an entity object string based on the entity type
     * @param $entity
     * @return mixed
     */
    public function getClass($entity)
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
        $model->savingObserver = false;
        $model->forceSavedObserver = true;
        $model->is_private = $defaultPrivate;
        $model->save();

        return $model;
    }
}
