<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityAttribute;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\TemplateService;
use App\Services\AttributeService;
use App\Traits\GuestAuthTrait;
use Stevebauman\Purify\Facades\Purify;

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
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => link_to_route('campaign.modules', __('crud.fix-this-issue'), ['#entity_attributes']),
                ])
            );
        }
        $this->authEntityView($entity);

        if (!$entity->accessAttributes()) {
            abort(403);
        }

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
                    'fix' => link_to_route('campaign.modules', __('crud.fix-this-issue'), ['#entity_attributes']),
                ])
            );
        }
        $this->authEntityView($entity);

        if (!$entity->accessAttributes()) {
            abort(403);
        }

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
                    'fix' => link_to_route('campaign.modules', __('crud.fix-this-issue'), ['#entity_attributes']),
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
            'template_id'
        ];
        $data = request()->only($fields);

        $this->service
            ->entity($entity)
            ->updateVisibility(request()->get('is_attributes_private') === '1')
            ->save($data);

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

    public function liveSave(UpdateEntityAttribute $request, Campaign $campaign, Entity $entity, Attribute $attribute)
    {
        $this->authorize('update', $entity->child);

        if ($attribute->entity_id !== $entity->id) {
            abort(404);
        }

        $attribute->update([
            'value' => Purify::clean($request->get('value'))
        ]);
        $attributeValue = null;
        $result = $attribute->mappedValue();
        $attributeValue = $result;
        if ($attribute->isText()) {
            $result = nl2br($result);
            $attributeValue = $result;
        } elseif ($attribute->isCheckbox()) {
            $result = '<i class="fa-solid fa-' . ($attribute->value ? 'check' : 'times') . '"></i>';
            $attributeValue = $attribute->value ? 'true' : 'false';
        }
        return response()->json([
            'value' => $result,
            'attribute' => $attributeValue,
            'uid' => $request->get('uid'),
            'success' => __('entities/attributes.live.success', ['attribute' => $attribute->name()])
        ]);
    }
}
