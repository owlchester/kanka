<?php

namespace App\Datagrids\Filters;

class ConversationFilter extends DatagridFilter
{
    /**
     * Filters available for conversations
     */
    public function build()
    {
        $this
            ->add('name')
            ->add('type')
//            ->add([
//                'field' => 'target',
//                'label' => __('conversations.fields.target'),
//                'valueKey' => 'conversations.targets.',
//                'type' => 'select',
//                'placeholder' =>  __('conversations.placeholders.target'),
//                'data' => __('conversations.targets')
//            ])
            ->add('is_closed')
            ->isPrivate()
            ->tags();
    }
}
