<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreAttributeTemplate as Request;
use App\Http\Resources\AttributeTemplateResource as Resource;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\AttributeService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AttributeTemplateApiController extends ApiController
{
    protected AttributeService $attributeService;

    public function __construct(
        EntitySaveService $entitySaveService,
        EntityRelationsServiceFactory $relationsFactory,
        AttributeService $attributeService,
    ) {
        parent::__construct($entitySaveService, $relationsFactory);
        $this->attributeService = $attributeService;
    }

    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.attribute_template')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = AttributeTemplate::create($data);
        $this->crudSave($model, $request->validated());

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
        $this->crudSave($attributeTemplate, $request->validated());

        return new Resource($attributeTemplate);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $attributeTemplate->entity);
        $attributeTemplate->delete();

        return response()->json(null, 204);
    }
}
