<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Quest $model
 */
?>
<x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity">
    @if ($entity->child?->is_completed)
        <x-icon class="fa-solid fa-check-circle" :title="__('quests.fields.is_completed')" tooltip />
    @endif
</x-widgets.previews.head>
<x-widgets.previews.body  :widget="$widget" :campaign="$campaign" :entity="$entity">
    @if (!empty($entity->child?->instigator))
        <dl class="dl-horizontal">
            <dt>{{ __('quests.fields.instigator') }}</dt>
            <dd>
                <x-entity-link
                    :entity="$entity->child->instigator"
                    :campaign="$campaign" />
            </dd>
        </dl>
    @endif
</x-widgets.previews.body>
