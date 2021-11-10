<?php /** @var \App\Models\Tag $model */?>

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
        @if (!empty($model->colour))
            <div class="element profile-colour">
                <div class="title">{{ __('crud.fields.colour') }}</div>
                {{ $model->colour }}
            </div>
        @endif


        @include('entities.components.profile._type')
    </div>
</div>
