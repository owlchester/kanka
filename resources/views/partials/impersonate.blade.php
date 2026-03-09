<x-alert type="warning">
    <div class="flex flex-col gap-2">
        <div class="m-0 p-0 text-lg">
            <i class="icon fa-regular fa-exclamation-triangle" aria-hidden="true"></i>
            {{ __('campaigns.members.impersonating.title', ['name' => auth()->user()->name]) }}
        </div>
        <p class="text-justify">
            {{ __('campaigns.members.impersonating.message', ['name' => auth()->user()->name, 'campaign' => $campaign->name]) }}
        </p>

        <a href="{{ route('identity.back', $campaign) }}" class="btn2 btn-sm switch-back decoration-none">
            <x-icon class="fa-solid fa-sign-out-alt" />
            {{ __('campaigns.members.actions.switch-back') }}
        </a>
    </div>
</x-alert>
