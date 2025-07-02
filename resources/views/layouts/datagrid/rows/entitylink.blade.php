@if ($model instanceof \App\Models\Entity)
    @if ($model->is_private)
        <x-icon class="lock" :title="__('crud.is_private')" tooltip />
    @endif
    <x-entity-link
        :entity="$model"
        :campaign="$campaign" />
@elseif (!empty($with))
    @if ($model->{$with} instanceof \App\Models\Entity)
        @if ($model->{$with}->is_private)
            <x-icon class="lock" :title="__('crud.is_private')" tooltip />
        @endif
        <x-entity-link
            :entity="$model->{$with}"
            :campaign="$campaign" />
    @elseif (!empty($model->{$with}) && $model->{$with} && $model->{$with}->entity)
        @if ($model->{$with}->entity->is_private)
            <x-icon class="lock" :title="__('crud.is_private')" tooltip />
        @endif
        <x-entity-link
            :entity="$model->{$with}->entity"
            :campaign="$campaign" />
    @endif
@elseif($model instanceof \App\Models\Post)
    @if ($model->entity->is_private)
        <x-icon class="lock" :title="__('crud.is_private')" tooltip />
    @endif
    <x-entity-link
        :post="$model->id"
        :entity="$model->entity"
        :campaign="$campaign">
        {!! $model->name !!} ({!! $model->entity->name !!})
    </x-entity-link>
@elseif($model->entity)
    @if ($model->entity->is_private)
        <x-icon class="lock" :title="__('crud.is_private')" tooltip />
    @endif
    <x-entity-link
        :entity="$model->entity"
        :campaign="$campaign" />
@elseif($model->remindable)
    @if ($model->remindable->is_private)
        <x-icon class="lock" :title="__('crud.is_private')" tooltip />
    @endif


    @if ($model instanceof \App\Models\Reminder && $model->isPost())
        <x-entity-link
        :entity="$model->remindable->entity"
        :post="$model->remindable->id"
        :campaign="$campaign">
            {!! $model->remindable->name !!} ({!! $model->remindable->entity->name !!})
        </x-entity-link>
    @else
        <x-entity-link
        :entity="$model->remindable"
        :campaign="$campaign" />
    @endif

@endif
