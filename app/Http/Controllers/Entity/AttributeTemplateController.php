<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\TemplateService;
use App\Services\AttributeService;

class AttributeTemplateController extends Controller
{
    protected AttributeService $service;

    protected TemplateService $templateService;

    public function __construct(AttributeService $service, TemplateService $templateService)
    {
        $this->middleware('auth');

        $this->service = $service;
        $this->templateService = $templateService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        if (! $campaign->enabled('entity_attributes')) {
            return redirect()->route('dashboard', $campaign)->with(
                'error_raw',
                __('campaigns.settings.errors.module-disabled', [
                    'fix' => '<a href="' . route('campaign.modules', [$campaign, '#entity_attributes']) . '">' . __('crud.fix-this-issue') . '</a>',
                ])
            );
        }
        $this->authorize('update', $entity);
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
        $this->authorize('update', $entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $success = $this->templateService
            ->entity($entity)
            ->apply($request->get('template_id'));
        if (! $success) {
            return redirect()->back()->with('error', __('entities/attributes.template.error'));
        }
        $templateName = $this->templateService->templateName();
        if ($request->has('submit-story')) {
            return redirect()
                ->to($entity->url())
                ->with('success', __('entities/attributes.template.success', [
                    'name' => $templateName, 'entity' => $entity->child->name,
                ]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('entities.attributes.edit', [$campaign, $entity])
                ->with('success', __('entities/attributes.template.success', [
                    'name' => $templateName, 'entity' => $entity->child->name,
                ]));
        }

        return redirect()
            ->route('entities.attributes', [$campaign, $entity])
            ->with('success', __('entities/attributes.template.success', [
                'name' => $templateName, 'entity' => $entity->child->name,
            ]));
    }
}
