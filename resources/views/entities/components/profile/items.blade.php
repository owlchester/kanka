<?php /** @var \App\Models\Item $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa fa-chevron-right" style="display: none"></i>
        <i class="fa fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements collapse in" id="sidebar-profile-elements">

        @if ($model->price)
            <div class="element profile-price">
                <div class="title">{{ __('items.fields.price') }}</div>
                {{ $model->price }}
            </div>
        @endif
        @if ($model->size)
            <div class="element profile-size">
                <div class="title">{{ __('items.fields.size') }}</div>
                {{ $model->size }}
            </div>
        @endif

        @include('entities.components.profile._location')

        @if ($model->character)
            <div class="element profile-character">
                <div class="title">{{ __('items.fields.character') }}</div>
                {!! $model->character->tooltipedLink() !!}
            </div>
        @endif


        @include('entities.components.profile._type')
    </div>
</div>
