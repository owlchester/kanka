<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
 */ ?>
@inject('languages', 'App\Services\LanguageService')
<div class="nav-tabs-custom bg-base-100 p-4 rounded-xl flex flex-col gap-6">
    @include('campaigns.forms._tabs')

    <div class="tab-content">
        @include('campaigns.forms.panes.entry')
        @include('campaigns.forms.panes.dashboard')
        @include('campaigns.forms.panes.public')
        @include('campaigns.forms.panes.ui')
    </div>
</div>
