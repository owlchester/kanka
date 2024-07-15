<?php /** @var \App\Models\Item $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if ($model->price)
        <div class="element profile-price">
            <div class="title text-uppercase text-xs">{{ __('items.fields.price') }}</div>
            {{ $model->price }}
        </div>
    @endif
    @if ($model->size)
        <div class="element profile-size">
            <div class="title text-uppercase text-xs">{{ __('items.fields.size') }}</div>
            {{ $model->size }}
        </div>
    @endif

    @include('entities.components.profile._location')

    @if ($model->character)
        <div class="element profile-character">
            <div class="title text-uppercase text-xs">{{ __('items.fields.character') }}</div>
            <x-entity-link
                :entity="$model->character->entity"
                :campaign="$campaign" />
        </div>
    @endif


    @include('entities.components.profile._type')
</x-sidebar.profile>
