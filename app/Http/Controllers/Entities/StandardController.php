<?php

namespace App\Http\Controllers\Entities;

use App\Facades\FormCopy;
use App\Facades\Module;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Map;
use App\Models\MiscModel;
use App\Sanitizers\CalendarSanitizer;
use App\Services\Attributes\EntitySheetService;
use App\Services\AttributeService;
use App\Services\Entity\AliasService;
use App\Services\Entity\CopyService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use App\Services\Entity\StandardEntityCreationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use LogicException;

class StandardController extends Controller
{
    public function __construct(
        protected StandardEntityCreationService $creationService,
        protected EntitySaveService $entitySaveService,
        protected EntityRelationsServiceFactory $relationsFactory,
        protected CopyService $copyService,
        protected AttributeService $attributeService,
        protected EntitySheetService $sheetService,
        protected AliasService $aliasService,
    ) {}

    public function index(Request $request, Campaign $campaign)
    {
        $type = $this->type($request);
        $module = $type->code === 'attribute_template' ? 'entity_attributes' : $type->pluralCode();

        if (! $campaign->enabled($module)) {
            return redirect()->route('dashboard', $campaign)->with('error_raw', __('campaigns/modules.errors.disabled', [
                'name' => $module,
                'fix' => '<a href="' . route('campaign.modules', [$campaign, '#' . $module]) . '" class="text-link">'
                    . __('crud.fix-this-issue') . '</a>',
            ]));
        }

        return redirect()->route('entities.index', [$campaign, $type] + Arr::except($request->query(), ['campaign', 'entityType']));
    }

    public function create(Request $request, Campaign $campaign)
    {
        $type = $this->type($request);
        $this->authorize('create', [$type, $campaign]);
        $source = null;
        if ($request->filled('copy')) {
            $source = Entity::inTypes([$type->id])
                ->where('campaign_id', $campaign->id)
                ->findOrFail($request->input('copy'));
            abort_if($source->isMissingChild(), 404);
        }

        return $this->form($campaign, $type, $source);
    }

    public function form(Campaign $campaign, EntityType $entityType, ?Entity $source = null)
    {
        $this->authorize('create', [$entityType, $campaign]);
        if ($this->whiteboardRestricted($campaign, $entityType)) {
            return view('whiteboards.cta', ['campaign' => $campaign]);
        }

        FormCopy::request(request());
        if ($source) {
            FormCopy::source($source);
        }

        $name = $entityType->pluralCode();
        $singular = Module::singular($entityType->id);
        $view = $name . '.forms.create';

        return view(view()->exists($view) ? $view : 'cruds.forms.create', [
            'name' => $name,
            'campaign' => $campaign,
            'entityType' => $entityType,
            'entityTypeId' => $entityType->id,
            'source' => $source,
            'tabAttributes' => $campaign->enabled('entity_attributes'),
            'tabPermissions' => auth()->user()->can('permissions', $entityType),
            'tabCopy' => true,
            'tabBoosted' => true,
            'title' => empty($singular) ? __($name . '.create.title') : __('crud.titles.new', ['module' => $singular]),
            'plural' => Module::plural($entityType->id, __('entities.' . $name)),
        ]);
    }

    public function store(Request $request, Campaign $campaign)
    {
        return $this->persist($campaign, $this->type($request));
    }

    public function persist(Campaign $campaign, EntityType $entityType)
    {
        $this->authorize('create', [$entityType, $campaign]);
        if ($this->whiteboardRestricted($campaign, $entityType)) {
            return view('whiteboards.cta', ['campaign' => $campaign]);
        }

        /** @var FormRequest $request */
        $request = app('App\Http\Requests\Store' . Str::studly($entityType->code));
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            $data = $request->validated();
            if ($entityType->code === 'calendar') {
                $sanitized = app(CalendarSanitizer::class)->request($request)->sanitize();
                $request->merge($sanitized);
                $data = array_replace($data, $sanitized);
            }

            $entity = $this->createEntity($campaign, $entityType, $request, $data);
            $link = '<a href="' . route('entities.show', [$campaign, $entity]) . '" class="text-link">' . e($entity->name) . '</a>';
            session()->flash('success_raw', __('general.success.created', ['name' => $link]));

            return match (true) {
                $request->has('submit-new') => redirect()->route('entities.create', [$campaign, $entityType]),
                $request->has('submit-update') => redirect()->route('entities.edit', [$campaign, $entity]),
                $request->has('submit-view') => redirect()->route('entities.show', [$campaign, $entity]),
                $request->has('submit-copy') => redirect()->route('entities.create', [$campaign, $entityType, 'copy' => $entity->id]),
                default => redirect()->route('entities.show', [$campaign, $entity]),
            };
        } catch (LogicException $exception) {
            if (config('app.debug')) {
                throw $exception;
            }
            $error = str_replace(' ', '_', mb_strtolower($exception->getMessage()));

            return redirect()->back()->withInput()->with('error', __('crud.errors.' . $error));
        }
    }

    private function createEntity(Campaign $campaign, EntityType $type, FormRequest $request, array $data): Entity
    {
        $entity = DB::transaction(function () use ($campaign, $type, $data, $request): Entity {
            $child = $this->creationService->campaign($campaign)->entityType($type)->create($data);
            $entity = $child->entity;
            if ($child instanceof Map) {
                $child->height = null;
                $child->width = null;
                $child->save();
            }

            $this->relationsFactory->for($entity)?->save($child, $data);
            $save = $this->entitySaveService->campaign($campaign)->entity($entity);
            $save->save(Arr::except($data, ['entry_dates']));
            $this->copyService->entity($entity)->request($request)->fromId()->copy();
            $save->saveEntryDates($data['entry_dates'] ?? []);

            return $entity;
        });

        if (auth()->user()->can('attributes', $entity)) {
            if ($request->hasAny(['sheets_present', 'sheets'])) {
                $source = $request->filled('copy_source_id')
                    ? Entity::where('campaign_id', $campaign->id)->find((int) $request->input('copy_source_id'))
                    : null;
                $this->sheetService->campaign($campaign)->entity($entity)->copySource($source)->sync($request->input('sheets', []));
            }

            $this->attributeService->campaign($campaign)->entity($entity)->save($request->input('attribute', []));
            if ($request->has('replace_mentions') && $request->filled('copy_source_id') && $entity->isFillable('entry')) {
                $this->attributeService->replaceMentions((int) $request->input('copy_source_id'));
            }
        }

        $this->aliasService->entity($entity)->request($request)->save();

        return $entity;
    }

    public function show(Request $request, Campaign $campaign)
    {
        return redirect()->route('entities.show', [$campaign, $this->child($request, $campaign)->entity]
            + Arr::except($request->query(), ['campaign', 'entity', 'slug']));
    }

    public function edit(Request $request, Campaign $campaign)
    {
        $child = $this->child($request, $campaign);
        $this->authorize('update', $child->entity);
        if ($child instanceof Map && $child->tilingRunning()) {
            return redirect()
                ->route('entities.show', [$campaign, $child->entity])
                ->with('error', __('maps.errors.tiling.running.edit') . ' ' . __('maps.errors.tiling.running.time'));
        }

        return redirect()->route('entities.edit', [$campaign, $child->entity] + Arr::except($request->query(), ['campaign', 'entity']));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $child = $this->child($request, $campaign);
        $entity = $child->entity;
        abort_if($entity === null, 404);

        $request->route()->setParameter($entity->entityType->code, $child);
        $request->route()->setParameter('entity', $entity);

        return app(EditController::class)->save($request, $campaign, $entity, legacy: true);
    }

    public function destroy(): never
    {
        abort(404);
    }

    private function type(Request $request): EntityType
    {
        return EntityType::findOrFail(
            config('entities.ids.' . Str::singular(Str::before($request->route()->getName(), '.')))
        );
    }

    private function whiteboardRestricted(Campaign $campaign, EntityType $type): bool
    {
        return $type->code === 'whiteboard' && ! auth()->user()->can('whiteboards', $campaign);
    }

    private function child(Request $request, Campaign $campaign): MiscModel
    {
        $type = $this->type($request);

        return $type->getMiscClass()->newQuery()
            ->where('campaign_id', $campaign->id)
            ->withWhereHas('entity')
            ->findOrFail($request->route($type->code));
    }
}
