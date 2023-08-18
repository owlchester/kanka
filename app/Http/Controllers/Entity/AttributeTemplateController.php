<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\AttributeService;

class AttributeTemplateController extends Controller
{
    protected AttributeService $service;

    public function __construct(AttributeService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->service = $service;
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
        $this->authorize('update', $entity->child);
        $this->authorize('attributes', $entity);

        $templates = $this->service->campaign($campaign)->templateList();


        return view('entities.pages.attribute-templates.apply', compact(
            'campaign',
            'entity',
            'templates'
        ));
    }

    public function process(ApplyAttributeTemplate $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $templateName = $this->service->apply($entity, $request->get('template_id'));
        if (!$templateName) {
            return redirect()->back()->with('error', __('entities/attributes.template.error'));
        }
        if ($request->has('submit-story')) {
            return redirect()
                ->to($entity->url())
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
