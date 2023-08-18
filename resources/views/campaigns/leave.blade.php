<x-dialog.header>
    {{ __('campaigns.leave.title') }}
</x-dialog.header>

<article class="max-w-xl">
    @if(auth()->user()->can('leave', $campaign))
        <p class="">
            {!! __('campaigns.leave.confirm', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}
        </p>
        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>
            {!! Form::open(['method' => 'POST', 'route' => ['campaigns.leave-process', [$campaign, $campaign->id]], 'class' => 'w-full']) !!}
            <x-buttons.confirm type="danger" outline="true" full="true">
                <i class="fa-solid fa-sign-out-alt" aria-hidden="true"></i>
                {{ __('campaigns.leave.confirm-button') }}
            </x-buttons.confirm>
            {!! Form::close() !!}
        </div>
    @else
        <p class="mt-5">{{ __('campaigns.leave.no-admin-left') }}</p>
        <a href="{{ route('campaign_users.index', $campaign) }}" class="btn2">
            {{ __('campaigns.leave.fix') }}
        </a>
    @endif
</article>
