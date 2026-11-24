<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreAttributeTemplate;
use App\Http\Resources\AttributeTemplateResource;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AttributeTemplateApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->attributeTemplates(), AttributeTemplateResource::class);
    }

    public function show(Campaign $campaign, AttributeTemplate $attributeTemplate): AttributeTemplateResource
    {
        return new AttributeTemplateResource($this->viewModel($campaign, $attributeTemplate));
    }

    public function store(StoreAttributeTemplate $request, Campaign $campaign): AttributeTemplateResource
    {
        return new AttributeTemplateResource($this->storeModel($request, $campaign, config('entities.ids.attribute_template')));
    }

    public function update(StoreAttributeTemplate $request, Campaign $campaign, AttributeTemplate $attributeTemplate): AttributeTemplateResource
    {
        return new AttributeTemplateResource($this->updateModel($request, $campaign, $attributeTemplate));
    }

    public function destroy(Campaign $campaign, AttributeTemplate $attributeTemplate): JsonResponse
    {
        return $this->deleteModel($campaign, $attributeTemplate);
    }
}
