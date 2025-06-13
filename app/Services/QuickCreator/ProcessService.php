<?php

namespace App\Services\QuickCreator;

use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StorePost;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\Race;
use App\Models\Tag;
use App\Services\Entity\CopyService;
use App\Services\Entity\TagService;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProcessService
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;
    use UserAware;

    /** @var Entity[]|Post[] */
    protected array $new = [];

    /** Fields as processed after creating dynamic elements */
    protected array $inputFields;

    protected Entity $template;

    protected Entity $entity;

    public function __construct(protected CopyService $copyService) {}

    public function entity()
    {
        $names = explode(PHP_EOL, str_replace("\r", '', $this->request->get('name')));
        $values = $this->request->all();

        // Prepare the data
        unset($values['names'], $values['_multi'], $values['_target']);

        // Remove target as we need that for something else
        if (! empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        } elseif ($this->entityType->id == config('entities.ids.note')) {
            $values['entry'] = '';
        }

        // Prepare the validator
        $requestValidator = '\App\Http\Requests\Store' . ucfirst(Str::camel($this->entityType->code));
        if ($this->entityType->isCustom()) {
            $requestValidator = \App\Http\Requests\StoreCustomEntity::class;
        }

        /** @var StoreCharacter $validator */
        $validator = new $requestValidator;

        // Handle dynamic elements
        $this->inputFields = $values;

        $this->dynamicTags()
            ->dynamicParent($this->entityType)
            ->dynamicLocations()
            ->dynamicLocation();
        if ($this->entityType->id === config('entities.ids.character')) {
            $this->dynamicFamilies()
                ->dynamicRaces();
        }

        $this->loadTemplate();

        $values = $this->inputFields;
        // To prevent observer from creating duplicate tags.
        if (Arr::has($values, 'tags')) {
            $this->request->merge(['tags' => $values['tags']]);
        }

        foreach ($names as $name) {
            if (empty($name)) {
                continue;
            }

            $values['name'] = $name;
            $this->validateEntity($values, $validator->rules());

            if ($this->entityType->isCustom()) {
                $this->entity = new Entity($values);
                $this->entity->campaign_id = $this->campaign->id;
                $this->entity->type_id = $this->entityType->id;
                $this->entity->save();
                $this->new[] = $this->entity;
                $this->copyTemplateRelations();
            } else {
                /** @var MiscModel $new */
                $new = $this->entityType->getClass();
                $new->fill($values);
                $new->campaign_id = $this->campaign->id;
                $new->save();
                $new->crudSaved();
                $new->entity->crudSaved();

                // Fill entity when using a template
                if (isset($this->template)) {
                    $new->entity->entry = Arr::get($values, 'entry');
                    $new->entity->type = Arr::get($values, 'type');
                    $new->entity->image_uuid = Arr::get($values, 'image_uuid');
                    $new->entity->header_uuid = Arr::get($values, 'header_uuid');
                    $new->entity->tooltip = Arr::get($values, 'tooltip');
                    $new->entity->saveQuietly();
                }

                $this->new[] = $new->entity;
                $this->entity = $new->entity;
                $this->copyTemplateRelations();
            }
        }

        // If no entity was created, we throw the standard error
        if (empty($this->new)) {
            $rules = $validator->rules();
            $this->validateEntity($values, $rules);
        }
    }

    public function post(): self
    {
        $names = explode(PHP_EOL, str_replace("\r", '', $this->request->get('name')));
        $values = $this->request->all();

        // Prepare the data
        unset($values['names'], $values['_multi'], $values['_target']);

        // Remove target as we need that for something else

        if (! empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        }

        // Prepare the validator
        $validator = new StorePost;

        // Handle dynamic elements
        $this->inputFields = $values;
        $values = $this->inputFields;

        foreach ($names as $name) {
            if (empty($name)) {
                continue;
            }

            $values['name'] = $name;
            // If position = 0 the post's position is last, else the post's position is first.
            $rules = $validator->rules();
            $rules['entity_id'] = 'required|integer|exists:entities,id';
            $this->validateEntity($values, $rules);
            if ($values['position'] == 0) {
                $new = Post::create($values);
            } else {
                $entity = Entity::find($values['entity_id']);
                $entity->posts()->increment('position');
                $values['position'] = 1;
                $new = Post::create($values);
            }
            $this->new[] = $new;
        }

        // If no entity was created, we throw the standard error
        if (empty($this->new)) {
            $rules = $validator->rules();
            $this->validateEntity($values, $rules);
        }

        return $this;
    }

    public function first(): Post|Entity
    {
        return $this->new[0];
    }

    public function count(): int
    {
        return count($this->new);
    }

    public function links(): array
    {
        $links = [];
        foreach ($this->new as $new) {
            if ($new instanceof Post) {
                $links[] = '<a href="' . $new->entity->url() . '">' . $new->name . '</a>';
            } else {
                $links[] = '<a href="' . $new->url() . '">' . $new->name . '</a>';
            }
        }

        return $links;
    }

    /**
     * Validate an entity's request to make sure data doesn't contain erroneous info
     */
    protected function validateEntity(array $data, array $rules)
    {
        return Validator::make(
            $data,
            $rules,
        );
    }

    protected function dynamicLocation(): self
    {
        if (! request()->has('location_id')) {
            return $this;
        }
        $canCreate = $this->user->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $this->campaign]);

        $location = $this->request->get('location_id');
        if (is_numeric($location)) {
            $location = (int) $location;
        } elseif (! is_numeric($location) && ! empty(mb_trim($location)) && $canCreate) {
            $model = Location::create(['name' => $location, 'campaign_id' => $this->campaign->id]);
            $location = (int) $model->id;
        } else {
            $location = null;
        }

        $this->inputFields['location_id'] = $location;

        return $this;
    }

    protected function dynamicTags(): self
    {
        if (! $this->request->has('tags') && ! $this->request->has('save-tags')) {
            return $this;
        }
        $canCreateTags = $this->user->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.tag'))->first(), $this->campaign]);

        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService
            ->user($this->user)
            ->campaign($this->campaign);

        // Exclude existing tags to avoid adding a tag several times
        $tags = $this->request->get('tags', []);
        foreach ($tags as $number => $id) {
            /** @var ?Tag $tag */
            $tag = Tag::find($id);
            // Create the tag if the user has permission to do so
            if (empty($tag) && $tagService->isAllowed()) {
                $tag = $tagService->create($id);
                $tags[$number] = (int) $tag->id;
            } elseif (empty($tag) && ! $canCreateTags) {
                unset($tags[$number]);
            }
        }

        $this->inputFields['tags'] = $tags;

        return $this;
    }

    protected function dynamicLocations(): self
    {
        if (! $this->request->has('locations') && ! $this->request->has('save_locations')) {
            return $this;
        }
        $canCreate = $this->user->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $this->campaign]);

        // Exclude existing locations to avoid adding a location several times
        $locations = $this->request->get('locations', []);
        foreach ($locations as $number => $id) {
            // Create the location if the user has permission to do so
            if (! is_numeric($id) && ! empty(mb_trim($id))) {
                if ($canCreate) {
                    $model = Location::create(['name' => $id, 'campaign_id' => $this->campaign->id]);
                    $location = (int) $model->id;
                    $locations[$number] = $location;
                } else {
                    unset($locations[$number]);
                }
            }
        }
        $this->inputFields['locations'] = $locations;

        return $this;
    }

    protected function dynamicRaces(): self
    {
        if (! $this->request->has('races') && ! $this->request->has('save_races')) {
            return $this;
        }
        $canCreate = $this->user->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.race'))->first(), $this->campaign]);

        // Exclude existing races to avoid adding a race several times
        $races = $this->request->get('races', []);
        foreach ($races as $number => $id) {
            // Create the race if the user has permission to do so
            if (! is_numeric($id) && ! empty(mb_trim($id))) {
                if ($canCreate) {
                    $model = Race::create(['name' => $id, 'campaign_id' => $this->campaign->id]);
                    $race = (string) $model->id;
                    $races[$number] = $race;
                } else {
                    unset($races[$number]);
                }
            }
        }
        $this->inputFields['races'] = $races;

        return $this;
    }

    protected function dynamicFamilies(): self
    {
        if (! $this->request->has('families') && ! $this->request->has('save_families')) {
            return $this;
        }
        $canCreate = $this->user->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.family'))->first(), $this->campaign]);

        // Exclude existing families to avoid adding a family several times
        $families = $this->request->get('families', []);
        foreach ($families as $number => $id) {
            // Create the family if the user has permission to do so
            if (! is_numeric($id) && ! empty(mb_trim($id))) {
                if ($canCreate) {
                    $model = Family::create(['name' => $id, 'campaign_id' => $this->campaign->id]);
                    $family = (string) $model->id;
                    $families[$number] = $family;
                } else {
                    unset($families[$number]);
                }
            }
        }
        $this->inputFields['families'] = $families;

        return $this;
    }

    protected function dynamicParent(EntityType $entityType): self
    {
        if (! $this->request->has($entityType->code . '_id')) {
            return $this;
        }

        $value = $this->request->get($entityType->code . '_id', null);
        // Handle parent.
        if (! is_numeric($value)) {
            /** @var MiscModel $new */
            $new = $entityType->getClass();
            $new->name = $value;
            $new->campaign_id = $this->campaign->id;
            $new->save();
            $new->crudSaved();
            if ($new->entity) {
                $new->entity->crudSaved();
            }
            $this->inputFields[$entityType->code . '_id'] = $new->id;
        }

        return $this;
    }

    protected function loadTemplate(): self
    {
        if (! $this->request->has('template_id')) {
            return $this;
        }
        unset($this->inputFields['template_id']);

        /** @var Entity $template */
        $template = Entity::template()->find($this->request->get('template_id'));
        if (empty($template)) {
            return $this;
        }

        if ($template->type_id !== $this->entityType->id) {
            return $this;
        }
        if ($this->entityType->isStandard() && $template->isMissingChild()) {
            return $this;
        }

        $this->template = $template;

        $entityFields = [
            'type', 'parent_id', 'entry', 'image_uuid', 'header_uuid', 'focus_x', 'focus_y', 'tooltip',
        ];
        foreach ($entityFields as $field) {
            if (empty($template->{$field})) {
                continue;
            }
            if (! empty($this->inputFields[$field])) {
                continue;
            }
            $this->inputFields[$field] = $template->{$field};
        }

        if ($this->entityType->isStandard()) {
            $this->loadTemplateChild();
        }

        return $this;
    }

    protected function loadTemplateChild(): self
    {
        // Do we do a if/else per entity type? Or try and play it by fillable?
        $fillable = $this->template->child->getFillable();
        foreach ($fillable as $field) {
            if (empty($this->template->child->{$field}) || ! empty($this->inputFields[$field])) {
                continue;
            }
            $this->inputFields[$field] = $this->template->child->{$field};
        }

        return $this;
    }

    protected function copyTemplateRelations(): self
    {
        if (! isset($this->template)) {
            return $this;
        }

        $this->copyService
            ->source($this->template)
            ->entity($this->entity)
            ->force()
            ->copy();

        $this->copyService
            ->attributes();
        if ($this->template->isCharacter()) {
            $this->copyService->character();
        }

        return $this;
    }
}
