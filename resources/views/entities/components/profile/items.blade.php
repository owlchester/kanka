<?php /** @var \App\Models\Item $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor-pointer text-lg user-select" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements grid my-1 collapse in" id="sidebar-profile-elements">

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
                {!! $model->character->tooltipedLink() !!}
            </div>
        @endif


        @include('entities.components.profile._type')
    </div>
</div>
