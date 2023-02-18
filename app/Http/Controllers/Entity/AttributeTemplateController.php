<?php

namespace App\Http\Controllers\Entity;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\AttributeService;

class AttributeTemplateController extends Controller
{
    protected AttributeService $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AttributeService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $this->authorize('attributes', $entity);

        $templates = $this->service->campaign($campaign)->templateList();


        return view('entities.pages.attribute-templates.apply', compact(
            'campaign',
            'entity',
            'templates'
        ));
    }

    /**
     * @param ApplyAttributeTemplate $request
     * @param Entity $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function applyTemplate(ApplyAttributeTemplate $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $templateName = $this->service->apply($entity, $request->get('template_id'));

        if (!$templateName) {
            return redirect()->back()->with('error', __('entities/attributes.template.error'));
        }
        if ($request->has('submit-story')) {
            return redirect()
                ->route($entity->pluralType() . '.show', $entity->child)
                ->with('success', __('entities/attributes.template.success', [
                    'name' => $templateName, 'entity' => $entity->child->name
                ]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('entities.attributes.edit', [$campaign, $entity])
                ->with('success', __('entities/attributes.template.success', [
                    'name' => $templateName, 'entity' => $entity->child->name
                ]));
        }
        return redirect()
            ->route('entities.attributes', [$campaign, $entity])
            ->with('success', __('entities/attributes.template.success', [
                'name' => $templateName, 'entity' => $entity->child->name
            ]));
    }
}
