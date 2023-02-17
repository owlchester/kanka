<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\AttributeTemplateFilter;
use App\Models\AttributeTemplate;
use App\Http\Requests\StoreAttributeTemplate;
use App\Models\Campaign;

class AttributeTemplateController extends CrudController
{
    /**
     * @var string
     */
    protected string $view = 'attribute_templates';
    protected string $route = 'attribute_templates';

    /**
     * @var string
     */
    protected $model = \App\Models\AttributeTemplate::class;

    /** @var string */
    protected $filter = AttributeTemplateFilter::class;

    public function __construct()
    {
        parent::__construct();

        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/attribute-templates.html',
            '<i class="fa-solid fa-question-circle"></i> <span class="hidden-xs">' . __('crud.actions.help') . '</span>',
            'default',
            true
        );
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
}
