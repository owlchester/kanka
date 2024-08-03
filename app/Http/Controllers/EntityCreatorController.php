<?php

namespace App\Http\Controllers;

use App\Facades\Module;
use App\Http\Requests\StoreCharacter;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Models\Entity;
use App\Models\Tag;
use App\Models\Post;
use App\Services\Entity\PopularService;
use App\Services\Entity\TagService;
use App\Services\EntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EntityCreatorController extends Controller
{
    protected EntityService $entityService;
    protected Campaign $campaign;
    protected PopularService $popularService;

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
        $entities = $this->creatableEntities();
        $orderedEntityTypes = $this->orderedEntityTypes();
        return view('entities.creator.selection', [
            'campaign' => $campaign,
            'entities' => $entities,
            'types' => $orderedEntityTypes,
            'popular' => $this->popularService->get(),
        ]);
    }

    /**
     * @param string $type
     */
    public function form(Request $request, Campaign $campaign, $type)
    {
        return $this->renderForm($request, $campaign, $type);
    }

    /**
     *
     */
    public function store(Request $request, Campaign $campaign, $type)
    {
        // Make sure the user is allowed to create this kind of entity
        $class = null;
        $this->campaign = $campaign;
        if ($type == 'posts') {
            $this->authorize('recover', $this->campaign);
        } else {
            $class = $this->entityService->getClass($type);
            $this->authorize('create', $class);
        }

        $names = explode(PHP_EOL, str_replace("\r", '', $request->get('name')));
        $values = $request->all();

        // Prepare the data
        unset($values['names'], $values['_multi'], $values['_target']);

        // Remove target as we need that for something else

        if (!empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        } elseif ($values['entity'] == 'notes') {
            $values['entry'] = '';
        }

        // Prepare the validator
        $requestValidator = '\App\Http\Requests\Store' . ucfirst(Str::camel(Str::singular($type)));
        /** @var StoreCharacter $validator */
        $validator = new $requestValidator();

        // Now loop on each name and create entities
        $createdEntities = $links = [];

        //Prepare tags
        if (request()->has('tags') && request()->has('save-tags')) {
            $canCreateTags = auth()->user()->can('create', Tag::class);

            /** @var TagService $tagService */
            $tagService = app()->make(TagService::class);
            $tagService
                ->user(auth()->user())
                ->campaign($campaign);

            // Exclude existing tags to avoid adding a tag several times
            $tags = $values['tags'];
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
            $request->merge([
                'tags' => $tags,
            ]);
        }

        foreach ($names as $name) {
            if (empty($name)) {
                continue;
            }

            $values['name'] = $name;
            if ($type != 'posts') {
                $this->validateEntity($values, $validator->rules());

                /** @var MiscModel $new */
                $new = new $class($values);
                $new->campaign_id = $this->campaign->id;
                $new->save();
                $new->crudSaved();
                if ($new->entity) {
                    $new->entity->crudSaved();
                }
            } else {
                //If position = 0 the post's position is last, else the post's position is first.
                $this->validateEntity($values, $validator->rules());
                if ($values['position'] == 0) {
                    $new = Post::create($values);
                } else {
                    $entity = Entity::find($values['entity_id']);
                    $entity->posts()->increment('position');
                    $values['position'] = 1;
                    $new = Post::create($values);
                }
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
        if ($request->has('_target')) {
            $first = $createdEntities[0];
            return response()->json([
                '_target' => $request->get('_target'),
                '_id' => $first->id,
                '_name' => $first->name,
                '_multi' => $request->get('_multi'),
            ]);
        }

        // Redirect the user to the edit form
        if ($request->get('action') === 'edit' && isset($new)) {
            if ($new instanceof Post) {
                $editUrl = route('entities.posts.edit', [$this->campaign, $new->entity_id, $new->id]);
            } else {
                $editUrl = $createdEntities[0]->getLink('edit');
            }
            return response()->json([
                'redirect' => $editUrl
            ]);
        }

        $successKey = $type !== 'posts' ? 'entities.creator.success_multiple' : 'entities.creator.success_multiple_posts';
        $success = trans_choice(
            $successKey,
            count($links),
            ['link' => implode(', ', $links)]
        );


        // Continue creating more of the same kind
        if ($request->get('action') === 'more') {
            return $this->renderForm(new Request(), $campaign, $type, $success);
        }
        // Content for the selector
        $entities = $this->creatableEntities();
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $this->campaign,
            'entities' => $entities,
            'types' => $orderedEntityTypes,
            'new' => $success,
            'popular' => $this->popularService->get(),
        ]);
    }

    /**
     * Build a list of entities the user has permission to create
     */
    protected function creatableEntities(): array
    {
        $entities = [];

        // Loop through the entities, check those enabled in the campaign, and where the user has create access.
        $ignoredTypes = [
            'bookmarks'
        ];
        foreach ($this->entityService->exclude($ignoredTypes)->entities() as $name => $class) {
            if ($this->campaign->enabled($name)) {
                if (auth()->user()->can('create', $class)) {
                    $entities[$name] = $class;
                }
            }
        }

        if (auth()->user()->can('recover', $this->campaign)) {
            $entities['posts'] = 'App\Models\Post';
        }

        return $entities;
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
    protected function renderForm(Request $request, Campaign $campaign, string $type, ?string $success = null)
    {
        $this->campaign = $campaign;
        // Make sure the user is allowed to create this kind of entity
        $model = null;
        if ($type == 'posts') {
            $this->authorize('recover', $campaign);
        } else {
            $model = $this->entityService->getClass($type);
            $this->authorize('create', $model);
        }

        $origin = $request->get('origin');
        $target = $request->get('target');
        $multi = $request->get('multi');
        $mode = $request->get('mode');
        $singularType = Str::singular($type);
        $source = $templates = null;
        $view = 'form';

        if ($mode === 'templates' && $type !== 'posts') {
            /** @var MiscModel $modelClass */
            $modelClass = new $model();
            $templates = Entity::select('id', 'name', 'entity_id')
                ->templates($modelClass->entityTypeID())
                ->get();
            $view = 'templates';
        }

        $entityType = __('entities.' . $singularType);
        $entities = $this->creatableEntities();

        $orderedEntityTypes = $this->orderedEntityTypes();

        $newLabel = __($type . '.create.title');
        if ($type !== 'posts') {
            $singular = Module::singular($type);
            if (!empty($singular)) {
                $newLabel = __('crud.titles.new', ['module' => $singular]);
            }
        } else {
            $singular = __('entities.post');
        }

        return view('entities.creator.' . $view, compact(
            'campaign',
            'type',
            'singularType',
            'entityType',
            'origin',
            'target',
            'multi',
            'mode',
            'source',
            'templates',
            'entities',
            //'entityTypes',
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
        $types = config('entities.ids');
        foreach ($types as $singular => $id) {
            $plural = Str::plural($singular);
            $orderedTypes[$plural] = $this->campaign->hasModuleName($id) ? $this->campaign->moduleName($id) : __('entities.' . $singular);
        }

        if (auth()->user()->can('recover', $this->campaign)) {
            $orderedTypes['posts'] = __('entities.posts');
        }

        $collator = new \Collator(app()->getLocale());
        $collator->asort($orderedTypes);

        return $orderedTypes;
    }
}
