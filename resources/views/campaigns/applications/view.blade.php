<?php /** @var \App\Models\Application $application */ ?>
<x-dialog.header>
    {{ __('campaigns/applications.fields.new_application') }}
</x-dialog.header>
<x-dialog.article>
    @include('campaigns.applications._view')
</x-dialog.article>

