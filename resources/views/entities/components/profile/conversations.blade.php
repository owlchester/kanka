<?php /** @var \App\Models\Conversation $model */?>

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

        <div class="element profile-target">
                <div class="title">{{ __('conversations.fields.target') }}</div>
                {{ __('conversations.targets.' . ($model->forCharacters() ? 'characters' : 'members')) }}
            </div>


        @include('entities.components.profile._type')
    </div>
</div>
