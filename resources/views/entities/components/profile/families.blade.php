<?php /** @var \App\Models\Family $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
        @if (!empty($model->parent))
        <div class="element profile-family">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.family')) !!}
            </div>
            <x-entity-link
                :entity="$model->parent->entity"
                :campaign="$campaign" />
        </div>
    @endif

    @include('entities.components.profile._type')
    @include('entities.components.profile._events')
</x-sidebar.profile>
