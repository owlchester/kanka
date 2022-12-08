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
            ->character()
            ->add([
                'field' => 'quest_id',
                'label' => __('quests.fields.quest'),
                'type' => 'select2',
                'route' => route('quests.find'),
                'placeholder' =>  __('quests.placeholders.quest'),
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
