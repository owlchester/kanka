<?php


namespace App\Http\Controllers\Entity;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyAttributeTemplate;
use App\Models\Entity;
use App\Services\AttributeService;

class AttributeTemplateController extends Controller
{
    /** @var AttributeService */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AttributeService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->service = $service;
    }

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apply(Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $this->authorize('attributes', $entity);

        $campaign = CampaignLocalization::getCampaign();
        $templates = $this->service->campaign($campaign)->templateList();


        return view('entities.pages.attribute-templates.apply', compact(
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
    public function applyTemplate(ApplyAttributeTemplate $request, Entity $entity)
    {
        dd($request);
        $this->authorize('update', $entity->child);
        $templateName = $this->service->apply($entity, $request->get('template_id'));

        if (!$templateName) {
            return redirect()->back()->with('error', __('entities/attributes.template.error'));
        }


        if ($request->has('submit-story')) {
            return redirect()
                ->route('entities.show', $entity)
                ->with('success', __('entities/attributes.template.success', [
                    'name' => $templateName, 'entity' => $entity->child->name
                ]));
        } elseif ($request->has('submit-update')) {
            return redirect()
                ->route('entities.attributes.edit', $entity)
                ->with('success', __('entities/attributes.template.success', [
                    'name' => $templateName, 'entity' => $entity->child->name
                ]));
        }

        return redirect()
            ->route('entities.attributes', $entity)
            ->with('success', __('entities/attributes.template.success', [
                'name' => $templateName, 'entity' => $entity->child->name
            ]));
    }
}
