<?php

namespace App\Datagrids\Filters;

use App\Models\Quest;
use App\Models\Entity;

class QuestFilter extends DatagridFilter
{
    /**
     * Filters available for quests
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->dateRange()
            ->add('is_completed')
            ->add([
                'field' => 'instigator_id',
                'label' => __('quests.fields.instigator'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations'),
                'placeholder' =>  __('crud.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add([
                'field' => 'quest_id',
                'label' => __('crud.fields.parent'),
                'type' => 'select2',
                'route' => route('quests.find'),
                'placeholder' =>  __('crud.placeholders.parent'),
                'model' => Quest::class,
            ])
            ->add([
                'field' => 'quest_element_id',
                'label' => __('crud.fields.entity'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations'),
                'placeholder' =>  __('quests.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add('element_role')
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
