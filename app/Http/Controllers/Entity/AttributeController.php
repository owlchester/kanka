<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\Entity;
use App\Services\AttributeService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class AttributeController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /**
     * @var
     */
    protected $transKey;

    /**
     * @var
     */
    protected $viewPath;

    /** @var AttributeService */
    protected $service;

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
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
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

    public function save(Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }
        $this->authorize('attribute', [$entity->child, 'edit']);
        $this->authorize('attributes', $entity);

        $data = request()->only(
            'attr_name',
            'attr_value',
            'attr_is_private',
            'attr_is_star',
            'attr_type',
            'template_id'
        );
        $this->service->saveEntity($data, $entity);

        return redirect()->route('entities.attributes', $entity->id)
            ->with('success', __('entities/attributes.update.success', ['entity' => $entity->name]));
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function template(Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $this->authorize('attributes', $entity);

        $parentRoute = $entity->pluralType();
        $ajax = request()->ajax();
        $campaign = CampaignLocalization::getCampaign();
        $communityTemplates = $this->service->templates($campaign);


        return view('entities.pages.attributes.template', compact(
            'communityTemplates',
            'entity',
            'parentRoute',
            'ajax'
        ));
    }

    /**
     * @param ApplyAttributeTemplate $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function applyTemplate(ApplyAttributeTemplate $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $templateName = $this->service->apply($entity, $request->only(['template_id', 'template']));

        if (!$templateName) {
            return redirect()->back()->with('error', __('entities/attributes.template.error'));
        }

        return redirect()
            ->route('entities.attributes', $entity->id)
            ->with('success', __('entities/attributes.template.success', [
                'name' => $templateName, 'entity' => $entity->child->name
            ]));
    }
}
