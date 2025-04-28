<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreAttributeTemplate as Request;
use App\Http\Resources\AttributeTemplateResource as Resource;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\AttributeService;

class AttributeTemplateApiController extends ApiController
{

    protected AttributeService $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->attributeTemplates()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $attributeTemplate->entity);

        return new Resource($attributeTemplate);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.attribute_template')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = AttributeTemplate::create($data);
        $this->crudSave($model);
    
        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $attributeTemplate->entity);
        $attributeTemplate->update($request->all());
        $this->crudSave($attributeTemplate);

        return new Resource($attributeTemplate);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $attributeTemplate->entity);
        $attributeTemplate->delete();

        return response()->json(null, 204);
    }
}
