<?php

namespace App\Datagrids\Filters;


use App\Models\Quest;

class QuestFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add('date')
            ->add('is_completed')
            ->character()
            ->add([
                'field' => 'quest_id',
                'label' => trans('quests.fields.quest'),
                'type' => 'select2',
                'route' => route('quests.find'),
                'placeholder' =>  trans('quests.placeholders.quest'),
                'model' => Quest::class,
            ])
            ->isPrivate()
            ->date()
            ->hasImage()
            ->tags()
        ;
    }
}
