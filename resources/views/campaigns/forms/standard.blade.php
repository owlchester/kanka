<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
 */ ?>
@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}

<div class="nav-tabs-custom">
    @include('campaigns.forms._tabs')

    <div class="tab-content">
        @include('campaigns.forms.panes.entry')
        @include('campaigns.forms.panes.dashboard')
        @include('campaigns.forms.panes.permission')
        @include('campaigns.forms.panes.public')
    </div>
</div>