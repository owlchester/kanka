<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\AttributeTemplateFilter;
use App\Models\AttributeTemplate;
use App\Http\Requests\StoreAttributeTemplate;

class AttributeTemplateController extends CrudController
{
    protected string $view = 'attribute_templates';
    protected string $route = 'attribute_templates';
    protected string $module = 'entity_attributes';

    protected $model = \App\Models\AttributeTemplate::class;

    /** @var string */
    protected $filter = AttributeTemplateFilter::class;

    public function __construct()
    {
        parent::__construct();

        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/attribute-templates.html',
            '<i class="fa-solid fa-question-circle"></i aria-hidden="true"> <span class="hidden-xs">' . __('crud.actions.help') . '</span>',
            '',
            true
        );
    }

    /**
     */
    public function store(StoreAttributeTemplate $request)
    {
        return $this->crudStore($request, true);
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeTemplate $attributeTemplate)
    {
        return $this->crudShow($attributeTemplate);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeTemplate $attributeTemplate)
    {
        return $this->crudEdit($attributeTemplate);
    }

    /**
     */
    public function update(StoreAttributeTemplate $request, AttributeTemplate $attributeTemplate)
    {
        return $this->crudUpdate($request, $attributeTemplate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeTemplate $attributeTemplate)
    {
        return $this->crudDestroy($attributeTemplate);
    }
}
