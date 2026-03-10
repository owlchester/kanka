<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Quest $model
 */
?>
<x-widgets.previews.head :widget="$widget" :campaign="$campaign" :entity="$entity">
    @if ($entity->child?->isOngoing())
        <x-icon class="fa-regular fa-hourglass" :title="__('quests.status.ongoing')" tooltip />
    @elseif ($entity->child?->isCompleted())
        <x-icon class="fa-regular fa-check-circle" :title="__('quests.status.completed')" tooltip />
    @elseif ($entity->child?->isAbandoned())
        <x-icon class="fa-regular fa-ban" :title="__('quests.status.abandoned')" tooltip />
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
