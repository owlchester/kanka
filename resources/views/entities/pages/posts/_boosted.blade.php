<table class="mb-2">
    <tr>
        <td>
            <div class="booster-icon">
                <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
            </div>
        </td>
        <td class="pl-2">
            <p class="">{{ __('callouts.booster.limitation') }}</p>

            @subscriber()
            <a href="{{ route('settings.boost', ['campaign' => $campaignService->campaign()]) }}" class="btn bg-maroon btn-sm" target="_blank">
                {!! __('callouts.booster.actions.boost', ['campaign' => $campaignService->campaign()->name]) !!}
            </a>
            @else
                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon btn-sm">
                    {!! __('callouts.booster.learn-more') !!}
                </a>
            @endif
        </td>
    </tr>
</table>
