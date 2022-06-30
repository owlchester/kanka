<?php

namespace App\Datagrids\Filters;

use App\Models\Quest;

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
            ->isPrivate()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}
