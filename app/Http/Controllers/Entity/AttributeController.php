<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveAttributes;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\TemplateService;
use App\Services\AttributeService;
use App\Traits\GuestAuthTrait;

/**
 * Attribute Controller
 */
class AttributeController extends Controller
{
    use GuestAuthTrait;

    protected AttributeService $service;
    protected TemplateService $templateService;

    public function __construct(AttributeService $attributeService, TemplateService $templateService)
    {
        $this->service = $attributeService;
        $this->templateService = $templateService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        if (!$campaign->enabled('entity_attributes')) {
            return redirect()->route('entities.show', [$campaign, $entity])->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '">' . __('crud.fix-this-issue') . '</a>'
                ])
            );
        }

        $this->authEntityView($entity);
        $this->authorize('view-attributes', [$entity, $campaign]);

        $template = null;
        $marketplaceTemplate = null;

        $layout = $entity->attributes()->where(['name' => '_layout'])->first();
        if (!empty($layout)) {
            $template = $this->templateService->communityTemplate($layout->value);
            $marketplaceTemplate = $this->templateService->campaign($campaign)->marketplaceTemplate($layout->value);
        }


        return view('entities.pages.attributes.index', compact(
            'entity',
            'marketplaceTemplate',
            'template',
            'campaign'
        ));
    }

    public function dashboard(Campaign $campaign, Entity $entity)
    {
        if (!$campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '">' . __('crud.fix-this-issue') . '</a>'
                ])
            );
        }
        $this->authEntityView($entity);
        $this->authorize('view-attributes', [$entity, $campaign]);

        $template = null;
        $marketplaceTemplate = null;
        $fromDashboard = true;

        $layout = $entity->attributes()->where(['name' => '_layout'])->first();
        if ($layout) {
            $template = $this->templateService->communityTemplate($layout->value);
            $marketplaceTemplate = $this->templateService->campaign($campaign)->marketplaceTemplate($layout->value);
        }

        return view('entities.pages.attributes.dashboard', compact(
            'entity',
            'marketplaceTemplate',
            'template',
            'campaign',
            'fromDashboard'
        ));
    }

    public function edit(Campaign $campaign, Entity $entity)
    {
        if (!$campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '">' . __('crud.fix-this-issue') . '</a>'
                ])
            );
        }
        if ($entity->isMissingChild()) {
            abort(404);
        }
        $this->authorize('attributes', $entity);

        return view('entities.pages.attributes.edit', compact(
            'campaign',
            'entity',
        ));
    }

    public function save(SaveAttributes $request, Campaign $campaign, Entity $entity)
    {
        if ($entity->isMissingChild()) {
            abort(404);
        }
        $this->authorize('attributes', $entity);

        $attributes = $request->get('attribute', []);
        $this->service
            ->entity($entity)
            ->updateVisibility(request()->get('is_attributes_private') === '1')
            ->save($attributes)
            ->touch();

        return redirect()->route('entities.attributes', [$campaign, $entity->id])
            ->with('success', __('entities/attributes.update.success', ['entity' => $entity->name]));
    }

    public function liveEdit(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity);

        $id = request()->get('id');
        $uid = request()->get('uid');
        if (!is_numeric($uid)) {
            abort(421);
        }

        $attribute = $entity->attributes()->where('id', $id)->first();
        if (!$id || !$attribute) {
            return abort(421);
        }

        return response()->view('entities.pages.attributes.live.edit', compact('campaign', 'attribute', 'entity', 'uid'));
    }
}
