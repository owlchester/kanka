<?php

namespace App\Http\Controllers;

use App\Facades\Module;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StorePost;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\Race;
use App\Models\Tag;
use App\Services\Entity\PopularService;
use App\Services\Entity\TagService;
use App\Services\EntityService;
use App\Services\EntityTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EntityCreatorController extends Controller
{
    protected Campaign $campaign;

    protected Request $request;

    protected array $inputFields;

    public function __construct(
        protected EntityService $entityService,
        protected PopularService $popularService,
        protected EntityTypeService $entityTypeService,
    ) {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selection(Request $request, Campaign $campaign)
    {
        $this->campaign = $campaign;
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $campaign,
            'entityTypes' => $orderedEntityTypes,
            'popular' => $this->popularService->campaign($campaign)->user($request->user())->get(),
        ]);
    }

    public function form(Request $request, Campaign $campaign, EntityType $entityType)
    {
        return $this->renderForm($request, $campaign, $entityType);
    }

    public function post(Request $request, Campaign $campaign)
    {
        return $this->renderForm($request, $campaign);
    }

    public function store(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', [$entityType, $campaign]);
        $this->campaign = $campaign;
        $this->request = $request;

        $names = explode(PHP_EOL, str_replace("\r", '', $this->request->get('name')));
        $values = $this->request->all();

        // Prepare the data
        unset($values['names'], $values['_multi'], $values['_target']);

        // Remove target as we need that for something else

        if (! empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        } elseif ($entityType->id == config('entities.ids.note')) {
            $values['entry'] = '';
        }

        // Prepare the validator
        $requestValidator = '\App\Http\Requests\Store' . ucfirst(Str::camel($entityType->code));
        if ($entityType->isSpecial()) {
            $requestValidator = '\App\Http\Requests\StoreCustomEntity';
        }
        /** @var StoreCharacter $validator */
        $validator = new $requestValidator;

        // Now loop on each name and create entities
        $createdEntities = $links = [];

        // Handle dynamic elements
        $this->inputFields = $values;
        $this->dynamicTags()
            ->dynamicParent($entityType)
            ->dynamicLocations()
            ->dynamicLocation();
        if ($entityType->id == config('entities.ids.character')) {
            $this->dynamicFamilies()
                ->dynamicRaces();
        }

        $values = $this->inputFields;
        // To prevent observer from creating duplicate tags.
        request()->replace(['tags' => $values['tags']]);

        foreach ($names as $name) {
            if (empty($name)) {
                continue;
            }

            $values['name'] = $name;
            $this->validateEntity($values, $validator->rules());

            if ($entityType->isSpecial()) {
                /** @var Entity $new */
                $new = new Entity($values);
                $new->campaign_id = $this->campaign->id;
                $new->type_id = $entityType->id;
                $new->save();
                $createdEntities[] = $new;
                $links[] = '<a href="' . $new->url() . '">' . $new->name . '</a>';
            } else {
                /** @var MiscModel $new */
                $new = $entityType->getClass();
                $new->fill($values);
                $new->campaign_id = $this->campaign->id;
                $new->save();
                $new->crudSaved();
                if ($new->entity) {
                    $new->entity->crudSaved();
                }
                $createdEntities[] = $new;
                $links[] = '<a href="' . $new->entity->url() . '">' . $new->name . '</a>';
            }
        }

        // If no entity was created, we throw the standard error
        if (empty($createdEntities)) {
            $rules = $validator->rules();
            $this->validateEntity($values, $rules);
        }

        // Have a target? Return json for the js to handle it instead
        if ($this->request->has('_target')) {
            $first = $createdEntities[0];

            return response()->json([
                '_target' => $this->request->get('_target'),
                '_id' => $first->id,
                '_name' => $first->name,
                '_multi' => $this->request->get('_multi'),
            ]);
        }

        // Redirect the user to the edit form
        if ($this->request->get('action') === 'edit' && isset($new)) {
            $entity = $entityType->isSpecial() ? $createdEntities[0] : $createdEntities[0]->entity;
            $editUrl = route('entities.edit', [$campaign, $entity]);

            return response()->json([
                'redirect' => $editUrl,
            ]);
        }

        //        $successKey = $type !== 'posts' ? 'entities.creator.success_multiple' : 'entities.creator.success_multiple_posts';
        $successKey = 'entities.creator.success_multiple';
        $success = trans_choice(
            $successKey,
            count($links),
            ['link' => implode(', ', $links)]
        );

        // Continue creating more of the same kind
        if ($this->request->get('action') === 'more') {
            return $this->renderForm(new Request, $campaign, $entityType, $success);
        }
        // Content for the selector
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $this->campaign,
            'entityTypes' => $orderedEntityTypes,
            'new' => $success,
            'popular' => $this->popularService->campaign($campaign)->user($request->user())->get(),
        ]);
    }

    public function storePost(Request $request, Campaign $campaign)
    {
        // Make sure the user is allowed to create this kind of entity
        $class = null;
        $this->campaign = $campaign;
        $this->authorize('recover', $this->campaign);

        $this->request = $request;

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

        // Now loop on each name and create entities
        $createdEntities = $links = [];

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
            $createdEntities[] = $new;
            $links[] = '<a href="' . $new->entity->url() . '">' . $new->name . '</a>';
        }

        // If no entity was created, we throw the standard error
        if (empty($createdEntities)) {
            $rules = $validator->rules();
            $this->validateEntity($values, $rules);
        }

        // Have a target? Return json for the js to handle it instead
        if ($this->request->has('_target')) {
            $first = $createdEntities[0];

            return response()->json([
                '_target' => $this->request->get('_target'),
                '_id' => $first->id,
                '_name' => $first->name,
                '_multi' => $this->request->get('_multi'),
            ]);
        }

        // Redirect the user to the edit form
        if ($this->request->get('action') === 'edit' && isset($new)) {
            $editUrl = route('entities.posts.edit', [$this->campaign, $new->entity_id, $new->id]);

            return response()->json([
                'redirect' => $editUrl,
            ]);
        }

        $successKey = 'entities.creator.success_multiple_posts';
        $success = trans_choice(
            $successKey,
            count($links),
            ['link' => implode(', ', $links)]
        );

        // Continue creating more of the same kind
        if ($this->request->get('action') === 'more') {
            return $this->renderForm(new Request, $campaign, null, $success);
        }
        // Content for the selector
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $this->campaign,
            'entityTypes' => $orderedEntityTypes,
            'new' => $success,
            'popular' => new Collection, // $this->popularService->get(),
        ]);
    }

    /**
     * Validate an entity's request to make sure data doesn't contain erroneous info
     */
    protected function validateEntity(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make(
            $data,
            $rules,
            $messages,
            $customAttributes
        )->validate();
    }

    protected function renderForm(Request $request, Campaign $campaign, ?EntityType $entityType = null, ?string $success = null)
    {
        $this->campaign = $campaign;
        // Make sure the user is allowed to create this kind of entity
        $model = null;
        if (! isset($entityType)) {
            $this->authorize('recover', $campaign);
        } else {
            $this->authorize('create', [$entityType, $campaign]);
        }

        $origin = $request->get('origin');
        $target = $request->get('target');
        $multi = $request->get('multi');
        $mode = $request->get('mode');
        $source = $templates = null;
        $view = 'form';

        if ($mode === 'templates' && isset($entityType)) {
            $templates = Entity::select('id', 'name', 'entity_id')
                ->templates($entityType->id)
                ->get();
            $view = 'templates';
        }

        $orderedEntityTypes = $this->orderedEntityTypes();

        if (isset($entityType)) {
            $newLabel = __($entityType->pluralCode() . '.create.title');
            $singular = Module::singular($entityType->id);
            if ($entityType->isSpecial()) {
                $singular = $entityType->name();
            }
            if (! empty($singular)) {
                $newLabel = __('crud.titles.new', ['module' => $singular]);
            }
        } else {
            $newLabel = __('posts.create.title');
            $singular = __('entities.post');
        }

        return view('entities.creator.' . $view, compact(
            'campaign',
            'entityType',
            'entityType',
            'origin',
            'target',
            'multi',
            'mode',
            'source',
            'templates',
            'orderedEntityTypes',
            'success',
            'newLabel',
            'singular',
        ))
            ->with('campaign', $this->campaign);
    }

    /**
     * Ordered entity types alphabetically to the user's local
     */
    protected function orderedEntityTypes(): Collection
    {
        $types = $this->entityTypeService
            ->campaign($this->campaign)
            ->user(auth()->user())
            ->exclude([config('entities.ids.bookmark')])
            ->creatable()
            ->ordered();

        if (auth()->user()->can('recover', $this->campaign)) {
            $types->add(__('entities.posts'));
        }

        return $types;
    }

    protected function dynamicLocation(): self
    {
        if (! request()->has('location_id')) {
            return $this;
        }
        $canCreate = auth()->user()->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $this->campaign]);

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
        $canCreateTags = auth()->user()->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.tag'))->first(), $this->campaign]);

        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService
            ->user(auth()->user())
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
        $canCreate = auth()->user()->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $this->campaign]);

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
        $canCreate = auth()->user()->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.race'))->first(), $this->campaign]);

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
        $canCreate = auth()->user()->can('create', [$this->campaign->getEntityTypes()->where('id', config('entities.ids.family'))->first(), $this->campaign]);

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
}
