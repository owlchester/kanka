<?php

namespace App\Http\Controllers;

use App\Facades\Module;
use App\Http\Requests\QuickCreator\StoreEntity;
use App\Http\Requests\QuickCreator\StorePost;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Post;
use App\Services\Entity\PopularService;
use App\Services\EntityService;
use App\Services\EntityTypeService;
use App\Services\QuickCreator\ProcessService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EntityCreatorController extends Controller
{
    protected Campaign $campaign;

    public function __construct(
        protected EntityService $entityService,
        protected PopularService $popularService,
        protected EntityTypeService $entityTypeService,
        protected ProcessService $processService,
    ) {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selection(Request $request, Campaign $campaign)
    {
        $this->campaign = $campaign;

        return $this->renderSelection(null);
    }

    public function form(Request $request, Campaign $campaign, EntityType $entityType)
    {
        return $this->renderForm($request, $campaign, $entityType);
    }

    public function post(Request $request, Campaign $campaign)
    {
        return $this->renderForm($request, $campaign);
    }

    public function store(StoreEntity $request, Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', [$entityType, $campaign]);
        $this->campaign = $campaign;

        $this->processService
            ->campaign($campaign)
            ->entityType($entityType)
            ->request($request)
            ->entity();

        // Have a target? Return json for the js to handle it instead
        $first = $this->processService->first();
        if ($request->has('_target')) {
            return response()->json([
                '_target' => $request->get('_target'),
                '_id' => $first->id,
                '_name' => $first->name,
                '_multi' => $request->get('_multi'),
            ]);
        }

        // Redirect the user to the edit form
        if ($request->get('action') == 'edit') {
            $entity = $first instanceof Post ? $first->entity : $first;
            $editUrl = route('entities.edit', [$campaign, $entity]);

            return response()->json([
                'redirect' => $editUrl,
            ]);
        }

        $successKey = 'entities.creator.success_multiple';
        $success = trans_choice(
            $successKey,
            $this->processService->count(),
            ['link' => implode(', ', $this->processService->links())]
        );

        // Continue creating more of the same kind
        if ($request->get('action') == 'more') {
            return $this->renderForm(new Request, $campaign, $entityType, $success);
        }

        return $this->renderSelection($success);
    }

    public function storePost(StorePost $request, Campaign $campaign)
    {
        // Make sure the user is allowed to create this kind of entity
        $this->campaign = $campaign;
        $this->authorize('recover', $this->campaign);

        $this->processService
            ->campaign($campaign)
            ->request($request)
            ->post();

        // Have a target? Return json for the js to handle it instead
        $first = $this->processService->first();
        if ($request->has('_target')) {
            return response()->json([
                '_target' => $request->get('_target'),
                '_id' => $first->id,
                '_name' => $first->name,
                '_multi' => $request->get('_multi'),
            ]);
        }

        // Redirect the user to the edit form
        if ($request->get('action') == 'edit') {
            $editUrl = route('entities.posts.edit', [$campaign, $first->entity_id, $first->id]);

            return response()->json([
                'redirect' => $editUrl,
            ]);
        }

        $successKey = 'entities.creator.success_multiple_posts';
        $success = trans_choice(
            $successKey,
            $this->processService->count(),
            ['link' => implode(', ', $this->processService->links())]
        );

        // Continue creating more of the same kind
        if ($request->get('action') == 'more') {
            return $this->renderForm(new Request, $campaign, null, $success);
        }

        return $this->renderSelection($success);
    }

    protected function renderSelection(?string $success)
    {
        // Content for the selector
        $orderedEntityTypes = $this->orderedEntityTypes();

        return view('entities.creator.selection', [
            'campaign' => $this->campaign,
            'entityTypes' => $orderedEntityTypes,
            'new' => $success,
            'popular' => $this->popularService->campaign($this->campaign)->user(auth()->user())->get(),
        ]);
    }

    protected function renderForm(Request $request, Campaign $campaign, ?EntityType $entityType = null, ?string $success = null)
    {
        $this->campaign = $campaign;
        // Make sure the user is allowed to create this kind of entity
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
            if ($entityType->isCustom()) {
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
}
