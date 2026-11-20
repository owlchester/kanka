<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomEntity;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Map;
use App\Models\MiscModel;
use App\Services\Attributes\EntitySheetService;
use App\Services\AttributeService;
use App\Services\Entity\AliasService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\PreserveLastUpdatedService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use App\Services\Entity\Relations\LocationRelationsService;
use App\Services\MultiEditingService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EditController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(
        protected AttributeService $attributeService,
        protected EntitySheetService $entitySheetService,
        protected AliasService $aliasService,
        protected MultiEditingService $multiEditingService,
        protected EntitySaveService $entitySaveService,
        protected PreserveLastUpdatedService $preserveLastUpdatedService,
        protected EntityRelationsServiceFactory $relationsFactory,
        protected LocationRelationsService $locationRelationsService
    ) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authorize('update', $entity);

        if ($entity->isMap() && $entity->child instanceof Map && $entity->child->tilingRunning()) {
            return redirect()
                ->route('entities.show', [$campaign, $entity])
                ->with('error', __('maps.errors.tiling.running.edit') . ' ' . __('maps.errors.tiling.running.time'));
        }

        $editingUsers = null;

        if ($this->campaign->hasEditingWarning()) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($entity)->user(auth()->user())->users();
            // If no one is editing the entity, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        $params = [
            'campaign' => $this->campaign,
            'entity' => $entity,
            'name' => $entity->entityType->pluralCode(),
            'tabPermissions' => auth()->user()->can('permissions', $entity),
            'tabAttributes' => auth()->user()->can('attributes', $entity) && $this->campaign->enabled('entity_attributes'),
            'entityType' => $entity->entityType,
            'editingUsers' => $editingUsers,
        ];
        $params['model'] = $entity->hasChild() ? $entity->child : $entity;

        return view('entities.forms.edit', $params);
    }

    public function save(Request $request, Campaign $campaign, Entity $entity, bool $legacy = false)
    {
        abort_unless($entity->campaign_id === $campaign->id, 404);
        $this->campaign($campaign)->authorize('update', $entity);

        if (! $request instanceof FormRequest) {
            $validationClass = $entity->entityType->isStandard()
                ? 'App\Http\Requests\Store' . Str::studly($entity->entityType->code)
                : StoreCustomEntity::class;
            $request = app($validationClass);
        }
        $validated = $request->validated();

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $stealth = $request->boolean('stealth');
        $request->request->remove('stealth');
        $lastUpdated = $stealth ? $this->preserveLastUpdatedService->snapshot($entity) : null;

        try {
            // Sanitize the data
            $sanitizerClassName = 'App\Sanitizers\\' . Str::studly($entity->entityType->code) . 'Sanitizer';
            if (class_exists($sanitizerClassName)) {
                $sanitizer = app()->make($sanitizerClassName);
                $sanitized = $sanitizer->request($request)->sanitize();
                $request->merge($sanitized);
                $validated = array_replace($validated, $sanitized);
            }

            if ($entity->hasChild()) {
                $data = $this->prepareData($request, $entity->child, $validated);
                $entity->child->update($data);

                // The legacy map form invalidated cached dimensions on save.
                if ($legacy && $entity->child instanceof Map) {
                    $entity->child->height = null;
                    $entity->child->width = null;
                    $entity->child->save();
                }

                // Fire an event for the Entity Observer
                $this->relationsFactory->for($entity)?->save($entity->child, $data);

                // Sync parent_id from the request for all entity types
                // $entity->parent_id = $request->has('parent_id') ? $request->get('parent_id') : null;
                $this->entitySaveService->campaign($campaign)->entity($entity)->save($data, $request);

                // If the child was changed but nothing changed on the entity, we still want to trigger an update
                if ($entity->child->wasChanged() && ! $entity->wasChanged()) {
                    $entity->touch();
                }
            } else {
                $preparedData = $this->fixRequestData($request, $entity, $validated);
                $entity->update($preparedData);
                $this->entitySaveService->campaign($campaign)->entity($entity)->save($preparedData, $request);
                $this->locationRelationsService->entity($entity)->process($preparedData);
            }

            $this->aliasService->entity($entity)->request($request)->save();

            if (auth()->user()->can('attributes', $entity)) {
                if ($request->hasAny(['sheets_present', 'sheets'])) {
                    $this->entitySheetService
                        ->campaign($campaign)
                        ->entity($entity)
                        ->sync($request->input('sheets', []));
                }

                $this->attributeService
                    ->campaign($campaign)
                    ->entity($entity)
                    ->save($request->get('attribute', []))
                    ->touch();
            }

            $link = '<a href="' . route(
                'entities.show',
                [$campaign, $entity]
            )
                . '" class="text-link">' . $entity->name . '</a>';
            $success = __('general.success.updated', [
                'name' => $link,
            ]);

            $this->multiEditingService->model($entity)
                ->user($request->user())
                ->finish();

            session()->flash('success_raw', $success);

            $options = [];
            if (request()->has('redirect')) {
                $redirect = explode('&', request()->get('redirect'));
                foreach ($redirect as $option) {
                    $vals = explode('=', $option);
                    $options[$vals[0]] = $vals[1];
                }
            }

            $route = route('entities.show', $options + [$campaign, $entity]);

            if ($request->has('submit-new')) {
                $route = route('entities.create', [$campaign, $entity->entityType]);
            } elseif ($request->has('submit-update')) {
                $route = route('entities.edit', [$campaign, $entity]);
            } elseif ($request->has('submit-close')) {
                $route = route('entities.index', [$campaign, $entity->entityType]);
            } elseif ($request->has('submit-copy')) {
                $route = route('entities.create', [$campaign, $entity->entityType, 'copy' => $entity]);

                return response()->redirectTo($route);
            }

            return response()->redirectTo($route);
        } catch (\LogicException $exception) {
            $error = str_replace(' ', '_', mb_strtolower(mb_rtrim($exception->getMessage(), '.')));

            return redirect()->back()->withInput()->with('error', __('crud.errors.' . $error));
        } finally {
            if ($lastUpdated !== null) {
                $this->preserveLastUpdatedService->restore($entity, $lastUpdated);
            }
        }
    }

    protected function prepareData(Request $request, MiscModel $model, array $data): array
    {
        foreach ($model->nullableForeignKeys as $field) {
            if (! $request->has($field) && ! isset($data[$field])) {
                $data[$field] = null;
            }
        }

        return $data;
    }

    protected function fixRequestData(Request $request, Entity $entity, array $data): array
    {
        foreach (['parent_id'] as $field) {
            if (! $request->has($field) && ! isset($data[$field])) {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
