
@if ($limit >= config('limits.campaigns.modules.elemental'))
    <p class="p-5">{!! __('campaigns/modules.errors.limit', ['max' => '<code>' . $limit . '</code>']) !!}</p>
@else
    <x-dialog.header>
        {{ __('campaigns/modules.errors.limit-title') }}
    </x-dialog.header>
    <x-dialog.article class="max-w-3xl">
        <x-helper>
            <p>{{ __('campaigns/modules.errors.subscription-limit') }}</p>
        </x-helper>
    </x-dialog.article>
@endif