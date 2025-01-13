<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Sanitizers\MiscSanitizer;
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
    ) {
    }

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

        dd('heint');
        $hasTabs = $this->hasTabs($entity->type_id);

        $params = [
            'campaign' => $this->campaign,
            'entity' => $entity,
            'name' => $entity->entityType->pluralCode(),
            'tabPermissions' => $hasTabs && auth()->user()->can('permission', $entity),
            'tabAttributes' => $hasTabs && auth()->user()->can('attributes', $entity) && $this->campaign->enabled('entity_attributes'),
            'tabBoosted' => $hasTabs,
            'tabCopy' => $hasTabs,
            'entityType' => $entity->entityType,
            'editingUsers' => $editingUsers,
        ];

        return view('cruds.forms.edit', $params);
    }

    public function save(Request $request, Campaign $campaign, Entity $entity)
    {
        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            // Sanitize the data
            $sanitizerClassName = 'App\Sanitizers\\' . Str::kebab($entity->entityType->code) . 'Sanitizer';
            $sanitizer = app()->make($sanitizerClassName);
            if ($sanitizer) {
                $request->merge($sanitizer->request($request)->sanitize());
            }

            if (!$entity->entityType->isSpecial()) {
                /** @var MiscModel $model */
                $data = $this->prepareData($request, $entity->child);
                $entity->child->update($data);

                // Fire an event for the Entity Observer
                $entity->child->crudSaved();
            }

            $entity->name = $model->name;
            $entity->is_private = $model->is_private;
            $entity->crudSaved();
            // If the child was changed but nothing changed on the entity, we still want to trigger an update
            if ($entity->child->wasChanged() && !$entity->wasChanged()) {
                $entity->touch();
            }

            if (auth()->user()->can('attributes', $entity)) {
                $this->attributeService
                    ->campaign($this->campaign)
                    ->entity($entity)
                    ->save($request->get('attribute', []));
            }

            $link = '<a href="' . route(
                    'entities.show',
                    [$this->campaign, $entity]
                )
                . '">' . $entity->name . '</a>';
            $success = __('general.success.updated', [
                'name' => $link
            ]);

            $this->multiEditingService->model($model->entity)
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

            $route = route('entities.show', $options + [$this->campaign, $entity]);

            if ($request->has('submit-new')) {
                $route = route('entities.create', [$campaign, $entity->entityType);
            } elseif ($request->has('submit-update')) {
                $route = route('entities.edit', [$campaign, $entity]);
            } elseif ($request->has('submit-close')) {
                $route = route('entities.index', [$campaign, $entity->entityType]);
            } elseif ($request->has('submit-copy')) {
                $route = route('entities.index', [$this->campaign, $entity->entityType, 'copy' => $entity]);
                return response()->redirectTo($route);
            }
            return response()->redirectTo($route);
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', mb_strtolower(mb_rtrim($exception->getMessage(), '.')));
            return redirect()->back()->withInput()->with('error', __('crud.errors.' . $error));
        }
    }

    protected function hasTabs(int $type): bool
    {
        return !in_array($type, [
            config('entities.ids.bookmark'),
            config('entities.ids.relation')
        ]);
    }
}
