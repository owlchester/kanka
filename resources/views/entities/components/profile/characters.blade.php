<?php /** @var \App\Models\Character $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

@php
//$appearances = $model->characterTraits()->appearance()->orderBy('default_order')->get();
//$traits = $model->characterTraits()->personality()->orderBy('default_order')->get();

@endphp
<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa fa-chevron-right" style="display: none"></i>
        <i class="fa fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements collapse in" id="sidebar-profile-elements">
        @if ($campaign->enabled('families') && !empty($model->family))
            <div class="element profile-family">
                <div class="title">{{ __('characters.fields.family') }}</div>
                {!! $model->family->tooltipedLink() !!}
            </div>
        @endif

        @if (!empty($model->race) || $model->hasAge())
            @if (!empty($model->race) && !$model->hasAge())
            <div class="element profile-race">
                <div class="title">{{ __('characters.fields.race') }}</div>
                {!! $model->race->tooltipedLink() !!}
            </div>
            @elseif (empty($model->race) && $model->hasAge())
            <div class="element profile-age">
                <div class="title">{{ __('characters.fields.age') }}</div>
                {{ $model->age }}
            </div>
            @else
            <div class="element profile-race-age">
                <div class="title">{{ __('characters.fields.race') }}, {{ __('characters.fields.age') }}</div>
                {!! $model->race->tooltipedLink() !!}, {{ $model->age }}
            </div>
            @endif
        @endif


        @if (!empty($model->sex) || !empty($model->pronouns))
            @if (!empty($model->sex) && empty($model->pronouns))
                <div class="element profile-gender">
                    <div class="title">{{ __('characters.fields.sex') }}</div>
                    {{ $model->sex }}
                </div>
            @elseif (empty($model->sex) && !empty($model->pronouns))
                <div class="element profile-pronouns">
                    <div class="title">{{ __('characters.fields.pronouns') }}</div>
                    {{ $model->pronouns }}
                </div>
            @else
                <div class="element profile-gender-pronouns">
                    <div class="title">{{ __('characters.fields.sex') }}, {{ __('characters.fields.pronouns') }}</div>
                    {{ $model->sex }}, {{ $model->pronouns }}
                </div>
            @endif
        @endif

        @include('entities.components.profile._type')

    </div>
</div>
