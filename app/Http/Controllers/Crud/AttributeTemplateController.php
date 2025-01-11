<?php

namespace App\Http\Controllers\Crud;

use App\Datagrids\Filters\AttributeTemplateFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\StoreAttributeTemplate;
use App\Models\AttributeTemplate;
use App\Models\Campaign;
use App\Models\EntityType;

class AttributeTemplateController extends CrudController
{
    protected string $view = 'attribute_templates';
    protected string $route = 'attribute_templates';
    protected string $module = 'entity_attributes';

    protected string $model = AttributeTemplate::class;

    protected string $filter = AttributeTemplateFilter::class;

    protected string $forceMode = 'table';

    protected function setNavActions(): CrudController
    {
        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/attribute-templates.html',
            '<i class="fa-solid fa-question-circle" aria-hidden="true"></i> <span class="hidden md:inline">' . __('crud.actions.help') . '</span>',
            '',
            true
        );
        return parent::setNavActions();
    }

    /**
     */
    public function store(StoreAttributeTemplate $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request, true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        return $this->campaign($campaign)->crudShow($attributeTemplate);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        return $this->campaign($campaign)->crudEdit($attributeTemplate);
    }

    /**
     */
    public function update(StoreAttributeTemplate $request, Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        return $this->campaign($campaign)->crudUpdate($request, $attributeTemplate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign, AttributeTemplate $attributeTemplate)
    {
        return $this->campaign($campaign)->crudDestroy($attributeTemplate);
    }

    protected function getEntityType(): EntityType
    {
        return EntityType::where('id', config('entities.ids.attribute_template'))->first();
    }
}
