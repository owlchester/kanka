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
        $communityTemplates = $this->service->templates($campaign);
        $templates = $this->service->campaign($campaign)->templateList();


        return view('entities.pages.attribute-templates.apply', compact(
            'communityTemplates',
            'entity',
            'templates'
        ));
    }

    public function applyTemplate(ApplyAttributeTemplate $request, Entity $entity)
    {
        $this->authorize('update', $entity->child);
        $templateName = $this->service->apply($entity, $request->get('template_id'));

        if (!$templateName) {
            return redirect()->back()->with('error', __('entities/attributes.template.error'));
        }

        return redirect()
            ->route('entities.attributes', $entity)
            ->with('success', __('entities/attributes.template.success', [
                'name' => $templateName, 'entity' => $entity->child->name
            ]));
    }
}
