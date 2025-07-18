<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomEntity;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\AttributeService;
use App\Services\MultiEditingService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EditController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(
        protected AttributeService $attributeService,
        protected MultiEditingService $multiEditingService
    ) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authorize('update', $entity);

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
        if ($entity->entityType->isStandard()) {
            $params['model'] = $entity->child;
        }

        return view('entities.forms.edit', $params);
    }

    public function save(Request $request, Campaign $campaign, Entity $entity)
    {
        // We need to validate the request
        if ($entity->entityType->isStandard()) {
            $validationClass = 'App\Http\Requests\Store' . Str::studly($entity->entityType->code);
            if (class_exists($validationClass)) {
                $validator = app()->make($validationClass);
                $this->validate($request, $validator->rules());
            }
        } else {
            $validator = app()->make(StoreCustomEntity::class);
            $this->validate($request, $validator->rules());
        }

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            // Sanitize the data
            $sanitizerClassName = 'App\Sanitizers\\' . Str::studly($entity->entityType->code) . 'Sanitizer';
            if (class_exists($sanitizerClassName)) {
                $sanitizer = app()->make($sanitizerClassName);
                $request->merge($sanitizer->request($request)->sanitize());
            }

            if ($entity->hasChild()) {
                $data = $this->prepareData($request, $entity->child);
                $entity->child->update($data);

                // Fire an event for the Entity Observer
                $entity->child->crudSaved();

                $entity->name = $entity->child->name;
                $entity->is_private = $entity->child->is_private;
                $entity->crudSaved();

                // If the child was changed but nothing changed on the entity, we still want to trigger an update
                if ($entity->child->wasChanged() && ! $entity->wasChanged()) {
                    $entity->touch();
                }
            } else {
                $preparedData = $this->fixRequestData($request, $entity);
                $entity->update($preparedData);
                $entity->crudSaved();
            }

            if (auth()->user()->can('attributes', $entity)) {
                $this->attributeService
                    ->campaign($campaign)
                    ->entity($entity)
                    ->save($request->get('attribute', []));
            }

            $link = '<a href="' . route(
                'entities.show',
                [$campaign, $entity]
            )
                . '">' . $entity->name . '</a>';
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
        }
    }

    protected function prepareData(Request $request, MiscModel $model): array
    {
        $data = $request->all();
        foreach ($model->nullableForeignKeys as $field) {
            if (! $request->has($field) && ! isset($data[$field])) {
                $data[$field] = null;
            }
        }

        return $data;
    }

    protected function fixRequestData(Request $request, Entity $entity): array
    {
        $data = $request->all();
        foreach (['parent_id'] as $field) {
            if (! $request->has($field) && ! isset($data[$field])) {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
