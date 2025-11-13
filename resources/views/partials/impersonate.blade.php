<x-alert type="warning">
    <div class="grid md:flex justify-between gap-2">
        <div class="grow">
            <div class="m-0 p-0 text-lg">
                <i class="icon fa-regular fa-exclamation-triangle" aria-hidden="true"></i>
                {{ __('campaigns.members.impersonating.title', ['name' => auth()->user()->name]) }}
            </div>
            <p class="text-justify">
                {{ __('campaigns.members.impersonating.message', ['name' => auth()->user()->name, 'campaign' => $campaign->name]) }}
            </p>
        </div>
        <a href="{{ route('identity.back', $campaign) }}" class="btn2 btn-sm switch-back">
            <x-icon class="fa-solid fa-sign-out-alt" />
            {{ __('campaigns.members.actions.switch-back') }}
        </a>
    </div>
</x-alert>
