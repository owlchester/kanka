
@can('leave', $campaign)
    <x-form :action="['campaign.leave-process', $campaign, $campaign->id]">
        @include('partials.forms._dialog', [
            'mode' => 'edit',
            'title' => __('campaigns.leave.title'),
            'content' => 'campaigns.leave._body',
            'actions' => 'campaigns.leave._actions'
        ])
    </x-form>
@else
    <x-dialog.header>
        {{ __('campaigns.leave.title') }}
    </x-dialog.header>

    <article class="max-w-xl p-4 md:px-6">
        <p class="">{{ __('campaigns.leave.no-admin-left') }}</p>
        <a href="{{ route('campaign_users.index', $campaign) }}" class="btn2 btn-outline">
            <x-icon class="arrow" />
            {{ __('campaigns.leave.fix') }}
        </a>
    </article>
@endcan
