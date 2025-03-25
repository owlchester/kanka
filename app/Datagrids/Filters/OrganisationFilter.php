<?php

namespace App\Datagrids\Filters;

use App\Facades\Module;
use App\Models\Organisation;

class OrganisationFilter extends DatagridFilter
{
    /**
     * Filters available for organisations
     */
    public function build()
    {
        $name = Module::singular(config('entities.ids.timeline'));
        $this
            ->add('name')
            ->add('type')
            ->location()
            ->add([
                'field' => 'organisation_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('search-list', [$this->campaign, config('entities.ids.organisation')]),
                'placeholder' => __('crud.placeholders.parent'),
                'model' => Organisation::class,
            ])
            ->character('member_id')
            ->add('is_defunct')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
            ->connections();
    }
}
