<?php /** @var \App\Models\Ability $model */?>

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
        @if (!empty($model->charges))
            <div class="element profile-charges">
                <div class="title">{{ __('abilities.fields.charges') }}</div>
                {{ $model->charges }}
            </div>
        @endif


        @include('entities.components.profile._type')
    </div>
</div>
