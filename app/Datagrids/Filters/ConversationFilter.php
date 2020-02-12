<?php

namespace App\Datagrids\Filters;

class ConversationFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
//            ->add([
//                'field' => 'target',
//                'label' => trans('conversations.fields.target'),
//                'valueKey' => 'conversations.targets.',
//                'type' => 'select',
//                'placeholder' =>  trans('conversations.placeholders.target'),
//                'data' => trans('conversations.targets')
//            ])
            ->isPrivate()
            ->tags()
        ;
    }
}
