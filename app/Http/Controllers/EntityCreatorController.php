<?php

namespace App\Http\Controllers;

use App\Facades\Module;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StorePost;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Location;
use App\Models\MiscModel;
use App\Models\Entity;
use App\Models\Tag;
use App\Models\Post;
use App\Services\Entity\PopularService;
use App\Services\Entity\TagService;
use App\Services\EntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EntityCreatorController extends Controller
{
    protected EntityService $entityService;
    protected Campaign $campaign;
    protected PopularService $popularService;

    protected Request $request;

    protected array $inputFields;

    public function __construct(EntityService $entityService, PopularService $popularService)
    {
        $this->middleware('auth');
        $this->entityService = $entityService;
        $this->popularService = $popularService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selection(Campaign $campaign)
    {
        $this->campaign = $campaign;
        $orderedEntityTypes = $this->orderedEntityTypes();
        return view('entities.creator.selection', [
            'campaign' => $campaign,
            'entityTypes' => $orderedEntityTypes,
            'popular' => $this->popularService->get(),
        ]);
    }

    /**
     */
    public function form(Request $request, Campaign $campaign, EntityType $entityType)
    {
        return $this->renderForm($request, $campaign, $entityType);
    }
    public function post(Request $request, Campaign $campaign)
    {
        return $this->renderForm($request, $campaign);
    }

    /**
     *
     */
    public function store(Request $request, Campaign $campaign, EntityType $entityType)
    {
        // Make sure the user is allowed to create this kind of entity
        $this->campaign = $campaign;
        $this->authorize('create', [$entityType, $campaign]);

        $this->request = $request;

        $names = explode(PHP_EOL, str_replace("\r", '', $this->request->get('name')));
        $values = $this->request->all();

        // Prepare the data
        unset($values['names'], $values['_multi'], $values['_target']);

        // Remove target as we need that for something else

        if (!empty($values['entry'])) {
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
        $validator = new $requestValidator();

        // Now loop on each name and create entities
        $createdEntities = $links = [];


        // Handle dynamic elements
        $this->inputFields = $values;
        $this->dynamicTags()
            ->dynamicLocation();
        $values = $this->inputFields;


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
            $editUrl = $createdEntities[0]->getLink('edit');
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
            return $this->renderForm(new Request(), $campaign, $entityType, $success);
        }
        // Content for the selector
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $this->campaign,
            'entityTypes' => $orderedEntityTypes,
            'new' => $success,
            'popular' => [], //$this->popularService->get(),
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

        if (!empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        }

        // Prepare the validator
        $validator = new StorePost();

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
            //If position = 0 the post's position is last, else the post's position is first.
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
            return $this->renderForm(new Request(), $campaign, null, $success);
        }
        // Content for the selector
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $this->campaign,
            'entityTypes' => $orderedEntityTypes,
            'new' => $success,
            'popular' => [], //$this->popularService->get(),
        ]);
    }

    /**
     * Validate an entity's request to make sure data doesn't contain erroneous info
     * @return array
     * @throws \Illuminate\Validation\ValidationException
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

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function renderForm(Request $request, Campaign $campaign, ?EntityType $entityType = null, ?string $success = null)
    {
        $this->campaign = $campaign;
        // Make sure the user is allowed to create this kind of entity
        $model = null;
        if (!isset($entityType)) {
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
            /** @var MiscModel $modelClass */
            $modelClass = $entityType->getClass();
            $templates = Entity::select('id', 'name', 'entity_id')
                ->templates($modelClass->entityTypeID())
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
            if (!empty($singular)) {
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
    protected function orderedEntityTypes(): array
    {
        $orderedTypes = [];
        /** @var EntityType $entityType */
        foreach (EntityType::inCampaign($this->campaign)->enabled()->exclude([config('entities.ids.bookmark')])->get() as $entityType) {
            // If the user can create, and the module is available
            if ($entityType->isSpecial()) {
                // Custom permission
                $orderedTypes[$entityType->plural()] = $entityType;
                continue;
            }
            if (!$this->campaign->enabled($entityType->pluralCode())) {
                continue;
            }
            if (!auth()->user()->can('create', [$entityType, $this->campaign])) {
                continue;
            }
            $orderedTypes[$entityType->plural()] = $entityType;
        }
        //        $types = config('entities.ids');
        //        foreach ($types as $singular => $id) {
        //            $plural = Str::plural($singular);
        //            $orderedTypes[$plural] = $this->campaign->hasModuleName($id) ? $this->campaign->moduleName($id) : __('entities.' . $singular);
        //        }

        if (auth()->user()->can('recover', $this->campaign)) {
            $orderedTypes['posts'] = __('entities.posts');
        }

        $collator = new \Collator(app()->getLocale());
        $collator->asort($orderedTypes);

        return $orderedTypes;
    }

    protected function dynamicLocation(): self
    {
        if (!request()->has('location_id')) {
            return $this;
        }
        $canCreate = auth()->user()->can('create', Location::class);

        $location = $this->request->get('location_id');
        if (is_numeric($location)) {
            $location = (int) $location;
        } elseif (!is_numeric($location) && !empty(mb_trim($location)) && $canCreate) {
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
        if (!$this->request->has('tags') && !$this->request->has('save-tags')) {
            return $this;
        }
        $canCreateTags = auth()->user()->can('create', Tag::class);

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
            } elseif (empty($tag) && !$canCreateTags) {
                unset($tags[$number]);
            }
        }
        $this->inputFields['tags'] = $tags;
        return $this;
    }
}
