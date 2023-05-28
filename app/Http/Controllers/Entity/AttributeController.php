<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEntityAttribute;
use App\Models\Attribute;
use App\Models\Entity;
use App\Services\AttributeService;
use App\Traits\GuestAuthTrait;
use Stevebauman\Purify\Facades\Purify;

/**
 * Attribute Controller
 */
class AttributeController extends Controller
{
    use GuestAuthTrait;

    /** @var AttributeService */
    protected AttributeService $service;

    /**
     * AttributeController constructor.
     * @param AttributeService $attributeService
     */
    public function __construct(AttributeService $attributeService)
    {
        $this->service = $attributeService;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard')->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    // @phpstan-ignore-next-line
                    'fix' => link_to_route('campaign.modules', __('crud.fix-this-issue'), ['#entity_attributes']),
                ])
            );
        }
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        if (!$entity->accessAttributes()) {
            abort(403);
        }

        $ajax = request()->ajax();
        $campaign = CampaignLocalization::getCampaign();
        $template = null;
        $marketplaceTemplate = null;
        $model = $entity->child;

        $layout = $entity->attributes()->where(['name' => '_layout'])->first();
        if ($layout) {
            $template = $this->service->communityTemplate($layout->value);
            $marketplaceTemplate = $this->service->marketplaceTemplate($layout->value, $campaign);
        }


        return view('entities.pages.attributes.index', compact(
            'ajax',
            'entity',
            'model',
            'marketplaceTemplate',
            'template'
        ));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Entity $entity)
    {
        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard')->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    // @phpstan-ignore-next-line
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
            'entity',
            'parentRoute'
        ));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function save(Entity $entity)
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
            'attr_is_star',
            'attr_type',
            'template_id'
        ];
        $data = request()->only($fields);

        $this->service
            ->entity($entity)
            ->updateVisibility(request()->get('is_attributes_private') === '1')
            ->save($data);

        return redirect()->route('entities.attributes', $entity->id)
            ->with('success', __('entities/attributes.update.success', ['entity' => $entity->name]));
    }

    /**
     */
    public function liveEdit(Entity $entity)
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

        return response()->view('entities.pages.attributes.live.edit', compact('attribute', 'entity', 'uid'));
    }

    /**
     * @param UpdateEntityAttribute $request
     * @param Entity $entity
     * @param Attribute $attribute
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function liveSave(UpdateEntityAttribute $request, Entity $entity, Attribute $attribute)
    {
        $this->authorize('update', $entity->child);

        if ($attribute->entity_id !== $entity->id) {
            abort(404);
        }

        $attribute->update([
            'value' => Purify::clean($request->get('value'))
        ]);

        $result = $attribute->mappedValue();
        if ($attribute->isText()) {
            $result = nl2br($result);
        } elseif ($attribute->isCheckbox()) {
            $result = '<i class="fa-solid fa-' . ($attribute->value ? 'check' : 'times') . '"></i>';
        }
        return response()->json([
            'value' => $result,
            'uid' => $request->get('uid'),
            'success' => __('entities/attributes.live.success', ['attribute' => $attribute->name()])
        ]);
    }
}
