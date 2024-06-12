<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
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
        $model = $entity->child;

        $layout = $entity->attributes()->where(['name' => '_layout'])->first();
        if (!empty($layout)) {
            $template = $this->templateService->communityTemplate($layout->value);
            $marketplaceTemplate = $this->templateService->campaign($campaign)->marketplaceTemplate($layout->value);
        }


        return view('entities.pages.attributes.index', compact(
            'entity',
            'model',
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
        $model = $entity->child;

        $layout = $entity->attributes()->where(['name' => '_layout'])->first();
        if ($layout) {
            $template = $this->templateService->communityTemplate($layout->value);
            $marketplaceTemplate = $this->templateService->campaign($campaign)->marketplaceTemplate($layout->value);
        }

        return view('entities.pages.attributes.dashboard', compact(
            'entity',
            'model',
            'marketplaceTemplate',
            'template',
            'campaign'
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
        if (empty($entity->child)) {
            abort(404);
        }
        $this->authorize('attribute', [$entity->child, 'edit']);
        $this->authorize('attributes', $entity);

        $parentRoute = $entity->pluralType();

        return view('entities.pages.attributes.edit', compact(
            'campaign',
            'entity',
            'parentRoute'
        ));
    }

    public function save(Campaign $campaign, Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }
        $this->authorize('attribute', [$entity->child, 'edit']);
        $this->authorize('attributes', $entity);

        $fields = [
            'attr_name',
            'attr_value',
            'attr_is_private',
            'attr_is_pinned',
            'attr_type',
            'template_id',
            'delete-all-attributes'
        ];
        $data = request()->only($fields);

        $this->service
            ->entity($entity)
            ->updateVisibility(request()->get('is_attributes_private') === '1')
            ->save($data)
            ->touch();

        return redirect()->route('entities.attributes', [$campaign, $entity->id])
            ->with('success', __('entities/attributes.update.success', ['entity' => $entity->name]));
    }

    public function liveEdit(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

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
